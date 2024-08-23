<?php


namespace App\Http\Filters;


class AvailableFilter extends QueryFilter
{
    /**
     * @param string $name
     */
    public function product(string $name)
    {
        $this->builder->leftJoin('crm_goods', 'crm_available.good_id', '=', 'crm_available.id')
            ->where('crm_goods.name', 'ilike', $name);
    }

    /**
     * @param $count
     */
    public function count($count)
    {
        $this->builder->where('count', preg_replace('/\D/', '', $count));
    }

    /**
     * @param $price
     */
    public function price($price)
    {
        $this->builder->where('price', preg_replace('/\D/', '', $price));
    }

    /**
     * @param string $type
     */
    public function type(string $type)
    {
        $this->builder->where('type_parts_by', $type);
    }

}
