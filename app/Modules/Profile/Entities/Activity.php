<?php

namespace App\Modules\Profile\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use hisorange\BrowserDetect\Parser;

class Activity extends Model
{
    use HasFactory;

    public $table = 'users_logs';

    protected $guarded = [];

    protected $casts = [
        'session_details' => 'json'
    ];
    
    protected static function newFactory()
    {
        return \App\Modules\Profile\Database\factories\ActivityFactory::new();
    }

    public static function storeAction($action, $request)
    {
        $detector = new Parser(null, null);
        $agentString = $_GET['agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'Missing';
        $result = $detector->parse($agentString);

        Activity::create([
            'user_id' => $request->user()->id,
            'action' => $action,
            'session_details' => [
                'device' => $result->deviceType(),
                'browser' => $result->browserName(),
                'platform' => $result->platformName() ? $result->platformName() : 'Unknown',
                'user_agent' => $result->userAgent(),
                'ip' => $request->ip(),
            ]
        ]);
    }

    public static function storeActionByUserId($action, $user_id, $ip)
    {
        $detector = new Parser(null, null);
        $agentString = $_GET['agent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'Missing';
        $result = $detector->parse($agentString);

        Activity::create([
            'user_id' => $user_id,
            'action' => $action,
            'session_details' => [
                'device' => $result->deviceType(),
                'browser' => $result->browserName(),
                'platform' => $result->platformName() ? $result->platformName() : 'Unknown',
                'user_agent' => $result->userAgent(),
                'ip' => $ip,
            ]
        ]);
    }

    public function getTranslateActionAttribute()
    {
        return $this->trans($this->action);
    }

    private function trans($action)
    {
        return match($action) {
            'subscription_tariff_1' => 'Подписка на тариф Start',
            'subscription_tariff_2' => 'Подписка на тариф Medium',
            'subscription_tariff_3' => 'Подписка на тариф Business',
            'auth' => 'Авторизация',
            'transfer' => 'Выполнен перевод средств другому участнику',
            'buy_expert' => 'Покупка торгового советника',
            'withdrawal' => 'Запрошен вывод средств с баланса личного кабинета',
            'update_password' => 'Изменён пароль',
            'update_profile_settings' => 'Изменены данные профиля',
            'update_partners_register_side_sponsor' => 'Изменена сторона регистрации партнёров на спонсорскую ногу',
            'update_partners_register_side_left' => 'Изменена сторона регистрации партнёров на левую ногу',
            'update_partners_register_side_right' => 'Изменена сторона регистрации партнёров на правую ногу',
        };
    }
}
