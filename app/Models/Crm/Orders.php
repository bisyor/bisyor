<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'crm_order';
    protected $fillable = ['shop_id', 'type_order_by', 'client_id', 'phone', 'comment', 'price', 'prepay',
        'marketing_id', 'discount_order', 'status_order', 'quick', 'type_client', 'address', 'company_name',
        'office_id', 'vin', 'govern_number', 'warranty', 'return_date'];

    public function status_order(){
        return $this->belongsTo(StatusOrder::class, 'status_order');
    }
}
