<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'crm_goods';
    public $timestamps = false;
    protected $fillable = [
        'name', 'shop_id', 'cost'
    ];
}
