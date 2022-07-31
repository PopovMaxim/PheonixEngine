<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\BinaryTree;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash',
        'rank',
        'email',
        'balance',
        'password',
        'nickname',
        'lastname',
        'firstname',
        'patronymic',
        'sponsor_id',
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
        'email_verified_at' => 'datetime',
    ];

    public function getReferralLinkAttribute()
    {
        return env('APP_URL') . '/register/' . $this->hash;
    }

    function getObfuscatedEmailAttribute()
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

    /*
    * Rank
    */
    public function getCurrentRankAttribute()
    {
        return match($this->rank) {
            null => 'Нет',
            'silver' => 'Silver',
            'gold' => 'Gold',
            'Platinum' => 'Platinum',
            'Diamond' => 'Diamond'
        };
    }

    /*
    * Balance
    */
    public function getRawBalanceAttribute()
    {
        return $this->balance;
    }

    public function getFormattedBalanceAttribute()
    {
        return number_format($this->balance / 100, 2) . ' ₽';
    }

    public function getTotalValueAttribute()
    {
        return number_format($this->node['total_value'] / 100, 2);
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

    // Нужно перенести в отдельную модель бинарного дерева
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
}
