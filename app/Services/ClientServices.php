<?php


namespace App\Services;


use App\Models\Crm\Clients;
use Illuminate\Database\Eloquent\Collection;

class ClientServices
{
    /**
     * Client type list
     */
    const NATURAL_PERSON = 1;
    const ENTITY = 2;


    /**
     * This function returned Clients type list
     *
     * @return array
     */
    public function getClientTypes()
    {
        return [
            self::NATURAL_PERSON => trans('messages.Natural person'),
            self::ENTITY => trans('messages.Entity')
        ];
    }

    /**
     * @param int $shop_id
     * @param $request
     * @return Collection
     */
    public function search(int $shop_id, $request){
        $clients = Clients::whereShopId($shop_id);

        return $clients->orWhere(function($q) use($request){
            $q->orWhere('type', $request->type)
                ->where('company_name', 'ilike', "%$request->company_name%")
                ->where('fio', 'ilike', "%$request->fio%")
                ->where('phone', 'ilike', "%$request->phone%");
        })->simplePaginate(15);
    }
}
