<?php


namespace App\Services;


use App\Models\Shops\Shops;

class AvailableServices
{
    /**
     * PARTS TYPE vars
     */
    const PARTS_NEW = '1';
    const PARTS_BU = 2;

    /**
     * Filterni o'rnatish
     *
     * @var
     */
    protected $filter;

    public function setFilter($filter){
        $this->filter = $filter;
        return $this;
    }

    /**
     * Returned type parts list
     *
     * @return array
     */
    public function getTypePartsBy(){
        return [
            self::PARTS_NEW => trans('messages.New'),
            self::PARTS_BU => trans('messages.B/U')
        ];
    }

    /**
     * @param string $good_id
     * @param Shops $shop
     * @param $price
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getGoodByShopAndId(string $good_id, Shops $shop, $price)
    {
        return $shop->good()
            ->firstOrCreate(['id' => is_numeric($good_id) ? $good_id : null],
            ['cost' => $price, 'name' => $good_id]);
    }

    public function getShop(string $keyword){
        return auth()->user()->shop()->whereKeyword($keyword)->firstOrFail();
    }

    /**
     * @param $shop
     * @return mixed
     */
    public function getReserveAvailable($shop){
        return $shop->available()
            ->whereRaw('count > residue')
            ->filter($this->filter)
            ->with('good')
            ->simplePaginate(15);
    }

    /**
     * @param $shop
     * @return mixed
     */
    public function  getNeedAvailable($shop){
        return $shop->available()
            ->whereRaw('count < residue')
            ->filter($this->filter)
            ->with('good')
            ->simplePaginate(15);
    }
}
