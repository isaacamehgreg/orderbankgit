<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrdersTracking extends Model
{
    //

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone('Africa/Lagos')
            ->toDateTimeString()
        ;
    }
}
