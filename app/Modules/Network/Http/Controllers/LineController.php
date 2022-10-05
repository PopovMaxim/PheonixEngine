<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class LineController extends Controller
{
    public function index(Request $request, $level_depth = 1)
    {
        $subscribe = $request->user()->getCurrentSubscribe();

        $lines = $subscribe['details']['marketing_limit'] ?? 0;

        if ($level_depth > $lines) {
            $level_depth = 1;
        }

        if ($level_depth > 10)
        {
            $level_depth = 10;
        }

        $partners = $request
            ->user()
            ->partners;

        $total_partners = $request
            ->user()
            ->partners
            ->count();

        $total_activated_partners = $request
            ->user()
            ->partners
            ->whereNotNull('activated_at')
            ->count();

        $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);

        switch ($level_depth)
        {
            case 2;
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $total_partners = $partners->count();

                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();

                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;

            case 3:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);

                $total_partners = $partners->count();

                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;

            case 4:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $total_partners = $partners->count();
                
                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
            
            case 5:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $level_4_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_4_partners_ids);

                $total_partners = $partners->count();
                
                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
            
            case 6:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $level_4_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_4_partners_ids);

                $level_5_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_5_partners_ids);

                $total_partners = $partners->count();
                
                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
            
            case 7:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $level_4_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_4_partners_ids);

                $level_5_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_5_partners_ids);
                
                $level_6_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_6_partners_ids);

                $total_partners = $partners->count();
                
                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
            
            case 8:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $level_4_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_4_partners_ids);

                $level_5_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_5_partners_ids);
                
                $level_6_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_6_partners_ids);
                
                $level_7_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_7_partners_ids);

                $total_partners = $partners->count();
                
                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
            
            case 9:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $level_4_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_4_partners_ids);

                $level_5_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_5_partners_ids);
                
                $level_6_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_6_partners_ids);
                
                $level_7_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_7_partners_ids);
                
                $level_8_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_8_partners_ids);

                $total_partners = $partners->count();
                
                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
            
            case 10:
                $level_1_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_1_partners_ids);

                $level_2_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_2_partners_ids);
                
                $level_3_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_3_partners_ids);

                $level_4_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_4_partners_ids);

                $level_5_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_5_partners_ids);
                
                $level_6_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_6_partners_ids);
                
                $level_7_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_7_partners_ids);
                
                $level_8_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_8_partners_ids);
                
                $level_9_partners_ids = clone $partners
                    ->get()
                    ->pluck('id');

                $partners = User::query()
                    ->whereIn('sponsor_id', $level_9_partners_ids);

                $total_partners = $partners->count();

                $total_activated_partners = $partners
                    ->whereNotNull('activated_at')
                    ->count();
                    
                $partners_activation_percentage = $this->getPartnersActivationPercentage($total_partners, clone $partners);
            break;
        }

        return view('network::line.index')
            ->with([
                'partners' => $partners->paginate(10),
                'total_partners' => $total_partners,
                'total_activated_partners' => $total_activated_partners,
                'partners_activation_percentage' => $partners_activation_percentage,
                'level' => $level_depth,
                'subscribe' => $subscribe,
                'lines' => $lines,
                'chart' => $this->getChartData($partners->get())
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

    private function getPartnersActivationPercentage($total_partners, $partners)
    {
        if (!$total_partners) {
            return sprintf("%.2f", 0);
        }

        $activated_partners = $partners
            ->whereNotNull('activated_at')
            ->count();

        $diff = $activated_partners / $total_partners;

        return sprintf("%.2f", $diff * 100);
    }
}
