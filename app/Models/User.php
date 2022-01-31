<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
// require 'Ethereum/ethereum.php';
use App\Models\Ethereum\Ethereum;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'private',
        'rol',
        'refer_id',
        'slam_name',
        'tg_name',
        'email_token',
        'memo',
        'place',
        'country',
        'gender',
        'birthday',
        'termsCond',
        'email_verified_at',
        'email_verify_toggle'
    ];

    protected $appends = [
        'bnbBalance', 'ethBalance'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function refer($id){
        $refer = Refer::where('user_id', $id)->get()->count();
        return $refer;
    }
    
    public function exchange($id){
        $trans = History::where('user_id', $id)->get()->toArray();
        $slam = 0;
        foreach($trans as $temp){
            $slam = $slam+$temp['slam'];
        }
        return $slam;
    }

    public function totalAffiliation($user_id) {
        $totalAffiliation = array_sum(History::where('user_id', $user_id)->where('bnb', 'AFFILIATION')->pluck('slam')->toArray());
        return $totalAffiliation;
    }
    
    public function referer($user_id) {
        $user_data = Refer::where('refer_id', $user_id)->first();
        if($user_data) {
            $user = User::find($user_data->user_id);
            return $user;
        }

        return null;
    }

    public function getBnbBalanceAttribute() {
        $ethereum = new Ethereum('https://bsc-dataseed.binance.org/', 443);
        // return "ok";
        return (hexdec($ethereum->eth_getBalance($this->address))/pow(10, 18));
    }

    public function getEthBalanceAttribute() {
        $ethereum = new Ethereum('https://mainnet.infura.io/v3/54fbd839e1614edb89bc979aaf1a069f', 443);
        // return "ok";
        return (hexdec($ethereum->eth_getBalance($this->address))/pow(10, 18));
    }
}
