<?php

namespace App\Models\Crm;

use App\Http\Filters\Filterable;
use App\Services\ClientServices;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use Filterable;

    protected $table = 'crm_clients';
    protected $fillable = [
        'shop_id',
        'type',
        'phone',
        'inn',
        'fio',
        'company_name',
        'address', 'email',
        'telegram_id',
        'gender'
    ];

    /**
     * Chek this type and returned
     *
     * @return mixed
     */
    public function getClientType(){
        return (new \App\Services\ClientServices)->getClientTypes()[$this->type];
    }

}
