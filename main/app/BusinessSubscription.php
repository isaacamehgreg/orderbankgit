<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessSubscription extends Model
{
    const BASIC_PLAN_ID = 3;
    const STANDARD_PLAN_ID = 4;
    const PREMIUM_PLAN_ID = 7;
    
    protected $fillable = [
    	'business_id',
        'user_id',
        'subscription_id',
        'start_at',
        'end_at',
        'payload'
    ];
}
