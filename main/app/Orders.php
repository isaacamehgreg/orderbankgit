<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Orders extends Model
{
    protected $fillable = [
    	'creator_id', 'courier_id',
    	'waybill_code', 'sender',
    	'recipient_id', 'shipping_fee',
    	'date_of_shipment', 'reference_number',
    	'packages_count', 'packages_item_name',
    	'packages_item_qty', 'packages_item_unit_price',
    	'packages_item_total_price', 'packages_weight', 'payment_method',
    	'shipment_type', 'delivery_status'
    ];

    public function recipient() {
        return $this->belongsTo('App\Recipients', 'foreign_key', 'recipient_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone('Africa/Lagos')
            ->toDateTimeString()
        ;
    }
}
