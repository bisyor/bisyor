<?php

namespace App\Models\Crm;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Available extends Model
{
    use Filterable;

    protected $table = 'crm_available';
    protected $fillable = ['shop_id', 'count', 'type_parts_by', 'comment', 'storage_id', 'good_id',
        'number', 'price', 'residue'];


    public function good()
    {
        return $this->belongsTo(Goods::class);
    }

}
