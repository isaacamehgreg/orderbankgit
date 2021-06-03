<?php
namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'user_id', 'referrer_id'
    ];

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function referred() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
