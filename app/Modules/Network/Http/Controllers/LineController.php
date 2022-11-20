<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Modules\Tariffs\Entities\TariffLines;

class LineController extends Controller
{
    public function index(Request $request, $level_depth = 1, $tariff_line = null)
    {
        $subscribes = $request->user()->getSubscribes();

        $tariff_lines = TariffLines::query()
            ->whereIn('id', array_keys($subscribes))
            ->get()
            ->keyBy('id');

        if (is_null($tariff_line)) {
            $tariff_line = array_key_first($subscribes);
        }

        $current_tariff_line = $tariff_lines->get($tariff_line);

        usort($subscribes[$tariff_line], function ($a, $b) {
            return $b['priority'] - $a['priority'];
        });

        $subscribe = $subscribes[$tariff_line][0];

        $lines = $subscribe['details']['marketing_limit'] ?? 0;

        if ($level_depth > $lines) {
            $level_depth = 1;
        }

        if ($level_depth > 10) {
            $level_depth = 10;
        }

        $recur = function ($sponsor_ids, $current_level = 1) use (&$recur, $level_depth, $current_tariff_line) {
            $partners = User::query()
                ->whereIn('sponsor_id', $sponsor_ids)
                ->whereHas('transactions', function ($query) use ($current_tariff_line) {
                    return $query->whereIn('details->tariff', $current_tariff_line['tariffs']->pluck('id'));
                })->get();

            $partners_with_paginate = User::query()
                ->whereIn('sponsor_id', $sponsor_ids)
                ->whereHas('transactions', function ($query) use ($current_tariff_line) {
                    return $query->whereIn('details->tariff', $current_tariff_line['tariffs']->pluck('id'));
                })->paginate(10);

            if ($level_depth > $current_level) {
                $current_level++;
                return $recur($partners->pluck('id'), $current_level);
            }

            $total = User::query()->whereIn('sponsor_id', $sponsor_ids)->count();
            $activated = $partners->count();
            $activated_percent = $this->getPartnersActivationPercentage($total, $activated);
            
            return [
                'partners' => $partners,
                'partners_with_paginate' => $partners_with_paginate,
                'total' => $total,
                'activated' => $activated,
                'activated_percent' => $activated_percent
            ];
        };

        $data = $recur([$request->user()->id]);

        return view('network::line.index')
            ->with([
                'chart' => $this->getChartData($data['partners']),
                'lines' => $lines,
                'level' => $level_depth,
                'subscribe' => $subscribe,
                'partners' => $data['partners_with_paginate'],
                'total_partners' => $data['total'] ?? 0,
                'total_activated_partners' => $data['activated'] ?? 0,
                'partners_activation_percentage' => $data['activated_percent'] ?? 0.00,
                'tariff_line' => $tariff_line,
                'tariff_lines' => $tariff_lines,
                'current_tariff_line' => $current_tariff_line
            ]);
    }

    private function getChartData($chart_data)
    {
        $activation = [];
        $registration = [];

        foreach ($chart_data as $data) {
            $created_at = $data['created_at']->format('d-m');
            $registration[$created_at][] = $data['id'];

            if (!is_null($data['activated_at'])) {
                $activated_at = now()->parse($data['activated_at'])->format('d-m');
                $activation[$activated_at][] = $data['id'];
            }
        }

        ksort($activation);
        ksort($registration);

        $activation_result = [];
        $registration_result = [];

        $current_month = now()->format('m');
        $current_year = now()->format('y');
        $current_month_length = now()->endOfMonth()->format('d');

        for ($i = 1; $i <= $current_month_length; $i++) {
            $lead_zero = true;
            
            if ($i > 9) {
                $lead_zero = false;
            }

            $d = $lead_zero ? "0{$i}" : "{$i}";

            $activation_result["{$d}-{$current_month}"] = 0;
            $registration_result["{$d}-{$current_month}"] = 0;
        }

        foreach ($activation as $key => $value) {
            $activation_result[$key] = count($activation[$key]);
        }

        foreach ($registration as $key => $value) {
            $registration_result[$key] = count($registration[$key]);
        }

        return json_encode([
            'activation' => [
                'dates' => array_keys($activation_result),
                'values' => array_values($activation_result),
                'max' => max(array_values($activation_result))
            ],
            'registration' => [
                'dates' => array_keys($registration_result),
                'values' => array_values($registration_result),
                'max' => max(array_values($registration_result))
            ],
        ]);
    }

    private function getPartnersActivationPercentage($total_partners, $activated_partners)
    {
        if (!$total_partners) {
            return sprintf("%.2f", 0);
        }

        $diff = $activated_partners / $total_partners;

        return sprintf("%.2f", $diff * 100);
    }
}
