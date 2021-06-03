<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $table = 'wallet_histories';

    protected $fillable = [
        'user_id', 'reference', 'type', 'amount', 'status', 'gateway'
    ];

    public function userw()
    {
        return $this->belongsTo('App\User');
    }
}
