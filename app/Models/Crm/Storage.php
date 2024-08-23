<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'crm_storage';
    protected $fillable = ['name', 'shop_id', 'is_main'];

}
