<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';
    protected $fillable=['firstname','lastname','business_name','business_address','business_email','business_phone_number'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
