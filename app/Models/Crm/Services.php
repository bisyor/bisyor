<?php

namespace App\Models\Crm;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use Filterable;

    protected $table = 'crm_services';
    protected $fillable = ['shop_id', 'name', 'price'];
}
