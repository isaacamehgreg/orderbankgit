<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    protected $table = "bank_details";

    protected $fillable = [
        'user_id',
        'nuban',
        'account_name',
        'bank_code',
        'recipient_code'
    ];
}
