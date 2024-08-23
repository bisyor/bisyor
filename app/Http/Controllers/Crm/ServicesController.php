<?php

namespace App\Http\Controllers\Crm;

use App\Exports\ServiceExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\ServicesFilter;
use App\Http\Requests\ServicesRequest;
use App\Imports\ServicesImport;
use App\Models\Crm\Services;
use App\Services\AvailableServices;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, ServicesFilter $servicesFilter)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        return view('crm.services.index', [
            'shop' => $shop,
            'services' => Services::where('shop_id', $shop->id)->filter($servicesFilter)->simplePaginate(15),
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
        return view('crm.services.create', [
            'shop' => $shop,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        Services::create($request->validate([
            'name' => 'required|string',
            'price' => 'required|integer'
        ]) + ['shop_id' => $shop->id]);

        return redirect()->route('services.index', $shop->keyword);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $keyword
     * @param Services $service
     * @return \Illuminate\View\View
     */
    public function edit($keyword, Services $service)
    {
        $shop = (new AvailableServices)->getShop($keyword);
        return view('crm.services.edit', [
            'shop' => $shop,
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ServicesRequest $request
     * @param $keyword
     * @param \App\Models\Crm\Services $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServicesRequest $request, $keyword, Services $service)
    {
        $shop = (new AvailableServices)->getShop($keyword);
        $service->update($request->validated());
        return redirect()->route('services.index', $shop->keyword);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $keyword
     * @param \App\Models\Crm\Services $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($keyword, Services $service)
    {
        $shop = (new AvailableServices)->getShop($keyword);
        $service->delete();
        return redirect()->route('services.index', $shop->keyword);
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
        Excel::import(new ServicesImport($shop->id),request()->file('file'));
        return back()->with('success-changed', trans('messages.Successfully imported'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $shop = (new AvailableServices)->getShop($request->keyword);
        return (new ServiceExport())->forShop($shop->id)->download('services.xlsx');
    }

    /**
     * Download example sheet file for import available table
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadExampleSheet()
    {
        $file = public_path() . "/shop_services.xlsx";
        return response()->download($file, 'services.xlsx',
            ['Content-Type: application/xlsx']);
    }
}
