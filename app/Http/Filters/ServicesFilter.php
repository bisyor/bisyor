<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class ServicesFilter extends QueryFilter
{

    /**
     * @param $price
     */
    public function price($price){
        $this->builder->where('price', preg_replace('/\D/', '', $price));
    }

    /**
     * @param string $name
     */
    public function name(string $name)
    {

        $words = array_filter(explode(' ', $name));
        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('name', 'ilike', "%$word%");
            }
        });

    }

}
