<?php

namespace App\Http\Controllers\Crm;

use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\ClientsFilter;
use App\Http\Requests\ClientsCreate;
use App\Imports\ClientsImport;
use App\Models\Crm\Clients;
use App\Models\References\Additional;
use App\Services\AvailableServices;
use App\Services\ClientServices;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, ClientsFilter $clientsFilter)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        $service = new ClientServices;
        return view('crm.clients.index', [
            'clients' => Clients::whereShopId($shop->id)->filter($clientsFilter)->simplePaginate(15),
            'shop' => $shop,
            'client_types' => $service->getClientTypes(),
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
        $service = new ClientServices();
        return view('crm.clients.create', [
            'client_types' => $service->getClientTypes(),
            'shop' => $shop,
            'genders' => Additional::getGenders()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientsCreate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ClientsCreate $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        Clients::create($request->validated() + ['shop_id' => $shop->id]);
        return redirect()->route('clients.index', $shop->keyword);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $keyword
     * @param \App\Models\Crm\Clients $client
     * @return \Illuminate\view\view
     */
    public function edit($keyword, Clients $client)
    {
        $shop = (new AvailableServices)->getShop($keyword);
        $service = new ClientServices();
        return view('crm.clients.edit', [
            'client_types' => $service->getClientTypes(),
            'shop' => $shop,
            'genders' => Additional::getGenders(),
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientsCreate $request
     * @param $keyword
     * @param Clients $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ClientsCreate $request, $keyword, Clients $client)
    {
        $shop = (new AvailableServices)->getShop($keyword);
        $client->update($request->validated() + ['shop_id' => $shop->id]);
        return redirect()->route('clients.index', $shop->keyword);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $keyword
     * @param Clients $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($keyword, Clients $client)
    {
        $shop = (new AvailableServices)->getShop($keyword);
        $client->delete();
        return redirect()->route('clients.index', $shop->keyword);
    }

    /**
     * Import to base in excel sheets
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function import(Request $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx,csv|max:10240', //max 10Mb
        ]);
        Excel::import(new ClientsImport($shop->id),request()->file('file'));
        return back()->with('success-changed', trans('messages.Successfully imported'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        return (new ClientsExport)->forShop($shop->id)->download('clients.xlsx');
    }

    /**
     * Download example sheet file for import clients table
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadExampleSheet(){
        $file = public_path()."/shop_clients.xlsx";
        return response()->download($file, 'clients.xlsx',
            ['Content-Type: application/xlsx']);
    }
}
