<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaystackTransfer extends Model
{
    protected $table = "paystack_transfers";

    protected $fillable = [
        'user_id',
        'wallet_usage_id',
        'reference',
        'status',
        'transfer_code'
    ];
}
