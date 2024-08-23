<?php


namespace App\Http\Filters;



use Illuminate\Database\Eloquent\Builder;

class ClientsFilter extends QueryFilter
{
    /**
     * @param string $type
     */
    public function type(string $type)
    {
        $this->builder->where('type', $type);
    }

    /**
     * @param string $company_name
     */
    public function companyName(string $company_name)
    {

        $words = array_filter(explode(' ', $company_name));

        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('company_name', 'ilike', "%$word%");
            }
        });

    }

    /**
     * @param string $fio
     */
    public function fio(string $fio)
    {
        $words = array_filter(explode(' ', $fio));

        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('fio', 'ilike', "%$word%");
            }
        });
    }

    /**
     * @param string $phone
     */
    public function phone(string $phone)
    {
        $words = array_filter(explode(' ', $phone));

        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('phone', 'ilike', "%$word%");
            }
        });
    }
}
