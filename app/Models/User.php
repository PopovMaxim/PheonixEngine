<?php

namespace App\Models;

use App\Modules\Tariffs\Entities\Tariff;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\BinaryTree;
use App\Modules\Network\Entities\LeaderPull;
use App\Modules\Profile\Entities\Activity;
use App\Modules\Transactions\Entities\Transaction;
use Illuminate\Notifications\Action;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash',
        'rank',
        'email',
        'city',
        'country',
        'balance',
        'password',
        'nickname',
        'lastname',
        'firstname',
        'patronymic',
        'sponsor_id',
        'telegram_id',
        'activated_at',
        'account_number',
        'last_active_at',
        'partners_register_side',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activated_at' => 'datetime',
        'last_active_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function getReferralLinkAttribute()
    {
        return env('APP_URL') . '/register/' . $this->hash;
    }

    public function getObfuscatedEmailAttribute()
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            list($first, $last) = explode('@', $this->email);
            $first = str_replace(substr($first, '2'), str_repeat('*', strlen($first)-3), $first);
            $last = explode('.', $last);
            $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0'])-1), $last['0']);
            return $first.'@'.$last_domain.'.'.$last['1'];
        }
    }

    public function getFullNameAttribute()
    {
        $result = "{$this->lastname} {$this->firstname} {$this->patronymic}";

        if (empty(trim($result)))
        {
            return "???? ??????????????";
        }

        return $result;
    }

    /*
    * Rank
    */
    public function getCurrentRankAttribute()
    {
        return match($this->rank) {
            null => '??????',
            'silver' => 'Silver',
            'gold' => 'Gold',
            'Platinum' => 'Platinum',
            'Diamond' => 'Diamond'
        };
    }

    /*
    * Transactions
    */
    public function transactions()
    {
        return $this->belongsTo('App\Modules\Transactions\Entities\Transaction', 'id', 'user_id');
    }

    /*
    * Total Earned
    */
    public function getTotalEarnedAttribute()
    {
        $transactions = $this->transactions()
            ->where('user_id', $this->id)
            ->whereIn('type', ['line_bonus'])
            ->get()
            ->sum('amount');

        return number_format($transactions / 100, 2);
    }

    /*
    * Balance
    */
    private function calcBalance()
    {
        $transactions = $this->transactions()
            ->where('user_id', $this->id)
            ->get();

        $balance = 0;

        if ($transactions)
        {
            foreach ($transactions as $transaction)
            {
                if ($transaction['status'] == 'completed') {
                    if ($transaction['direction'] == 'inner') {
                        $balance += $transaction['amount'];
                    } else {
                        $balance -= $transaction['amount'];
                    }
                } else if ($transaction['status'] == 'pending') {
                    if ($transaction['type'] == 'withdrawal') {
                        $balance -= $transaction['amount'];
                    }
                }
            }
        }

        return $balance;
    }

    public function getRawBalanceAttribute()
    {
        return $this->calcBalance();
    }

    public function getFormattedBalanceAttribute()
    {
        return number_format($this->calcBalance() / 100, 2) . ' ' . config('app.internal-currency');
    }

    /*
    * Mlm data
    */
    public function getTotalValueAttribute()
    {
        return number_format($this->node?->total_value / 100, 2);
    }

    /*
    * Sponsor
    */
    public function sponsor()
    {
        return $this->belongsTo(get_class($this), 'sponsor_id', 'id');
    }

    public function getSponsorLegAttribute()
    {
        return $this->sponsor->sponsor_node?->side;
    }

    /*
    * Partners
    */
    public function getPartnersAttribute()
    {
        return $this->belongsTo(get_class($this), 'id', 'sponsor_id');
    }
    
    public function getPartnersCountAttribute()
    {
        return $this->partners->count();
    }

    public function getPartnersActivationCountAttribute()
    {
        return $this->partners
            ->whereNotNull('activated_at')
            ->count();
    }

    public function getPartnersActivationPercentageAttribute()
    {
        $total_partners = $this->partners_count;

        if (!$total_partners) {
            return sprintf("%.2f", 0);
        }

        $activated_partners = $this->partners
            ->whereNotNull('activated_at')
            ->count();

        $diff = $activated_partners / $total_partners;

        return sprintf("%.2f", $diff * 100);
        
    }
    
    /*
    * Binary Tree
    */
    public function node()
    {
        return $this->belongsTo('App\Models\BinaryTree', 'id', 'user_id');
    }

    // ?????????? ?????????????????? ?? ?????????????????? ???????????? ?????????????????? ????????????
    public function addToBinaryTree($leg = null)
    {
        $my_node = \DB::table('binary_tree')
            ->where('user_id', $this->id)
            ->first();
        
        if (!$my_node) {
            $sponsor_node = \DB::table('binary_tree')
                ->where('user_id', $this->sponsor_id)
                ->first();

            if ($sponsor_node) {
                $latest = $sponsor_node;

                $register_side = $this->sponsor['partners_register_side'];

                if (!is_null($leg)) {
                    $register_side = $leg;
                }

                if (is_null($register_side)) {
                    $register_side = $sponsor_node->side;
                }

                $create_node = BinaryTree::create([
                    'user_id' => $this->id,
                    'side' => $register_side
                ]);

                if ($register_side == 'right') {
                    while ($latest) {
                        $q = \DB::table('binary_tree')
                            ->where('id', intval($latest->right))
                            ->first();
    
                        if (is_null($q)) {
                            break;
                        }
    
                        $latest = $q;
                    }
                    
                    BinaryTree::query()
                        ->where('id', $latest->id)
                        ->update([
                            'right' => $create_node['id']
                        ]);
    
                } else {
                    while ($latest) {
                        $q = \DB::table('binary_tree')
                            ->where('id', intval($latest->left))
                            ->first();
    
                        if (is_null($q)) {
                            break;
                        }
    
                        $latest = $q;
                    }
    
                    BinaryTree::query()
                        ->where('id', $latest->id)
                        ->update([
                            'left' => $create_node['id']
                        ]);
                }

                BinaryTree::query()
                    ->where('id', $create_node['id'])
                    ->update([
                        'sponsor_id' => $latest->id,
                        'path' => $latest->path . '-' . $create_node['id']
                    ]);
                
            }
        }
    }

    public function updateRegisterSide($side, $request, $user_id = null, $ip = null)
    {
        if (empty($side) || $side == 'sponsor') {
            $side = null;
        }
        
        self::update([
            'partners_register_side' => $side
        ]);

        if ($side == '' || is_null($side)) {
            $side = 'sponsor';
        }

        if (is_null($request))
        {
            Activity::storeActionByUserId('update_partners_register_side_' . $side, $user_id, $ip);
        }
        else
        {
            Activity::storeAction('update_partners_register_side_' . $side, $request);
        }
    }

    public function calcLineMarketing($tariff, $tx)
    {
        $percents = [
            0 => 20,
            1 => 10,
            2 => 5,
            3 => 4,
            4 => 3,
            5 => 2,
            6 => 2,
            7 => 2,
            8 => 1,
            9 => 1
        ];

        $level_depth = 10;

        $sponsor_id = $this->sponsor_id;

        $users = self::query()
            ->orderBy('id', 'desc')
            ->get()
            ->pluck('sponsor_id', 'id')
            ->toArray();

        $recur = function ($sponsor_id, $levels = [], $current_level = 0) use (&$recur, $users, $level_depth) {
            foreach ($users as $key => $value) {
                if ($key == $sponsor_id)
                {
                    $levels[$current_level] = $key;

                    $current_level++;

                    return $recur($value, $levels, $current_level);
                }

                if ($current_level == $level_depth) {
                    return $levels;
                }
            }

            return $levels;
        };

        $levels = $recur($sponsor_id);

        $i = 1;

        foreach ($levels as $level => $user_id)
        {
            $user = User::find($user_id);
            $subscribes = $user->getSubscribes();
            $tariff_line_subscribes = $subscribes[$tariff['tariff_line']] ?? [];

            if (count($tariff_line_subscribes)) {
                usort($tariff_line_subscribes, function ($a, $b) {
                    return $b['priority'] - $a['priority'];
                });

                $priority = $tariff_line_subscribes[0];

                if (isset($priority) && !is_null($priority) && isset($priority['details']['marketing_limit']) && $priority['details']['marketing_limit'] > $level) {
                    Transaction::create([
                        'type' => 'line_bonus',
                        'status' => 'completed',
                        'amount' => ($tx['amount'] * $percents[$level]) / 100,
                        'user_id' => $user_id,
                        'direction' => 'inner',
                        'details' => [
                            'level' => $i,
                            'tx_id' => $tx['id'],
                            'price' => $tariff['price'],
                            'tariff' => $tariff['id'],
                            'user_id' => request()->user()->id
                        ]
                    ]);
                }
            }

            $i++;
        }
    }

    public function getCurrentLeaderPullSum()
    {
        $leader_pull = LeaderPull::query()
            ->where('current_activity', true)
            ->orderBy('id', 'desc')
            ->first();

        if (is_null($leader_pull)) {
            return 0;
        }

        $my_partners = $this->partners->get();

        $current_amount = 0;

        foreach ($my_partners as $partner)
        {
            $current_amount += $partner->transactions()
                ->where([
                    'type' => 'subscribe',
                    'status' => 'completed'
                ])
                ->where('created_at', '>=', $leader_pull['started_at'])
                ->sum('amount');
        }

        return $current_amount;
    }

    public function getLeaderPull()
    {
        $pull = [
            [
                'pull' => 1,
                'percent' => 0.01,
                'level_1_sum' => $this->getCurrentLeaderPullSum(),
                'level_2_sum' => 0,
                'level_1_percent' => 0.00,
                'level_2_percent' => 0.00,
                'status' => 'processed',
                'color' => 'muted'
            ],
            [
                'pull' => 2,
                'percent' => 0.02,
                'count' => 0,
                'percent' => 0.00,
                'status' => 'processed',
                'color' => 'muted'
            ],
            [
                'pull' => 3,
                'percent' => 0.03,
                'count' => 0,
                'percent' => 0.00,
                'status' => 'processed',
                'color' => 'muted'
            ]
        ];

        $level_2_partners = [];
        
        foreach ($this->partners->get() as $partner)
        {
            $level_2_partners[] = $partner;
    
            $pull[0]['level_2_sum'] += $partner->getCurrentLeaderPullSum();
        }

        $pull[0]['level_1_percent'] =  number_format(($pull[0]['level_1_sum'] / config('marketing.leader_pull.level_1_sum')) * 100, 2);
        $pull[0]['level_2_percent'] =  number_format((($pull[0]['level_1_sum'] + $pull[0]['level_2_sum']) / config('marketing.leader_pull.level_2_sum')) * 100, 2);

        if ($pull[0]['level_1_percent'] >= 100 && $pull[0]['level_2_percent'] >= 100)
        {
            $pull[0]['status'] = 'completed';
            $pull[0]['color'] = 'primary';
        }

        foreach ($this->partners->get() as $partner)
        {
            //$partner_pull = $partner->getLeaderPull();

            if ($pull[0]['status'] == 'completed')
            {
                $pull[1]['count']++;
            }
        }

        foreach ($level_2_partners as $partner)
        {
            ///$partner_pull = $partner->getLeaderPull();

            if ($pull[1]['count'] >= 3) {
                $pull[2]['count']++;
            }
        }

        $pull[1]['percent'] = number_format($pull[1]['count'] / 3 * 100, 2);
        $pull[2]['percent'] = number_format($pull[2]['count'] / 3 * 100, 2);

        if ($pull[0]['level_1_percent'] >= 100 && $pull[1]['count'] >= 3)
        {
            $pull[1]['status'] = 'completed';
            $pull[1]['color'] = 'primary';
        }

        if ($pull[0]['level_1_percent'] >= 100 && $pull[2]['count'] >= 3)
        {
            $pull[2]['status'] = 'completed';
            $pull[2]['color'] = 'primary';
        }

        return $pull;
    }

    public function getCurrentLeaderPull()
    {
        $current_pull = null;

        foreach ($this->getLeaderPull() as $pull)
        {
            if ($pull['status'] != 'completed')
            {
                continue;
            }

            $current_pull = $pull;
        }

        return $current_pull;
    }

    public function getCurrentSubscribe()
    {
        $subscribes = $this->transactions()->whereType('subscribe')->get();

        if (!count($subscribes))
        {
            return [];
        }

        $tariffs = Tariff::query()->withTrashed()->get()->keyBy('id')->toArray();

        $list = [];
        $priority = [];

        foreach ($subscribes as $subscribe)
        {
            $tariff = $tariffs[$subscribe['details']['tariff']];
            $expired_at = now()->parse($subscribe['details']['expired_at']);

            if ($expired_at->timestamp <= now()->timestamp)
            {
                continue;
            }

            $list[$subscribe['id']] = $subscribe;
            $priority[$subscribe['id']] = $tariff['priority'];
        }

        if (!count($list))
        {
            return [];
        }

        $priority_id = array_keys($priority, min($priority));
        $current_subscribe = $list[$priority_id[0]];

        return $tariffs[$current_subscribe['details']['tariff']];
    }

    public function getSubscribes()
    {
        $subscribes = $this->transactions()->whereType('subscribe')->get();

        if (!count($subscribes))
        {
            return [];
        }

        $tariffs = Tariff::query()->withTrashed()->get()->keyBy('id')->toArray();

        $list = [];

        foreach ($subscribes as $subscribe)
        {
            $tariff = $tariffs[$subscribe['details']['tariff']] ?? null;

            if (is_null($tariff)) {
                continue;
            }

            $expired_at = now()->parse($subscribe['details']['expired_at']);

            if ($expired_at->timestamp <= now()->timestamp)
            {
                continue;
            }

            $list[$tariff['tariff_line']][] = $tariff;
        }

        return $list;
    }

    public function subscribes()
    {
        $subscribes = $this->transactions()->whereType('subscribe')->get();

        if (!count($subscribes))
        {
            return [];
        }

        $tariffs = Tariff::query()->get()->keyBy('id')->toArray();

        $list = [];

        foreach ($subscribes as $subscribe)
        {
            $tariff = $tariffs[$subscribe['details']['tariff']];
            $expired_at = now()->parse($subscribe['details']['expired_at']);

            if ($expired_at->timestamp <= now()->timestamp)
            {
                continue;
            }

            $list[] = [
                'tariff_key' => $tariff['key'],
                'tariff_title' => $tariff['title'],
                'created_at' => $subscribe['created_at'],
                'expired_at' => $expired_at
            ];
        }

        return $list;
    }

    public function getCurrentSubscribeTitleAttribute()
    {
        $subscribe = $this->getCurrentSubscribe();

        return $subscribe['title'] ?? '??????';
    }

    public static function generateAccountNumber($prefix = 'PX')
    {
        $generate = function ($number) use (&$generate, $prefix)
        {
            $search = \DB::table('users')
                ->whereAccountNumber($number)
                ->count();

            if ($search)
            {
                return $generate($prefix . '-' . rand(111, 999) . '-' . rand(111, 999));
            }

            return $number;
        };

        return $generate($prefix . '-' . rand(111, 999) . '-' . rand(111, 999));
    }

    public static function generateHash($length = 8)
    {
        $hash = self::generateRandomString($length);

        $generate = function ($hash) use (&$generate, $length)
        {
            $search = \DB::table('users')
                ->whereHash($hash)
                ->count();

            if ($search)
            {
                $hash = self::generateRandomString($length);

                return $generate($hash);
            }

            return $hash;
        };

        return $generate($hash);
    }

    public function getQuickBonusAcceptedAttribute()
    {
        $bonus = $this->transactions()
            ->whereType('quick_bonus')
            ->whereStatus('completed')
            ->first();

        if ($bonus) {
            return true;
        }

        return false;
    }

    private static function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function acceptQuickBonus() {
        if (!$this->quick_bonus_accepted) {
            $this->transactions()->create([
                'id' => \Str::uuid(),
                'user_id' => $this->id,
                'type' => 'quick_bonus',
                'status' => 'completed',
                'amount' => 160000,
                'direction' => 'inner',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
