<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class TeamGrowthChart extends Component
{
    public function render(Request $request)
    {
        $chart_data = $request
            ->user()
            ->partners
            ->get();

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

        return view('livewire.team-growth-chart')
            ->with([
                'chart' => json_encode([
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
                ])
            ]);
    }
}
