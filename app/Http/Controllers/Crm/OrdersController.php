<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Clients;
use App\Models\Crm\Orders;
use App\Models\References\Additional;
use App\Services\AvailableServices;
use App\Services\ClientServices;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        $orders = Orders::whereShopId($shop->id)->simplePaginate(15);
        return view('crm.orders.index', [
            'shop' => $shop,
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        return view('crm.orders.create', [
            'shop' => $shop,
            'genders' => Additional::getGenders(),
            'client_types' => (new ClientServices)->getClientTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Orders $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function clientsByType(Request $request){
        $shop = (new AvailableServices)->getShop($request->keyword);
        return $shop->clients()->where('type', $request->type)->get();
    }
}
