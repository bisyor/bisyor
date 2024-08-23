<?php

namespace App\Http\Controllers\Crm;

use App\Exports\AvailableExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\AvailableFilter;
use App\Http\Requests\AvailableCreate;
use App\Imports\AvailableImport;
use App\Models\Crm\Available;
use App\Services\AvailableServices;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AvailableController extends Controller
{
    protected AvailableServices $service;

    public function __construct(AvailableServices $availableServices)
    {
        $this->service = $availableServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request, AvailableFilter $availableFilter)
    {
        $shop = $this->service->getShop($request->keyword);
        $this->service->setFilter($availableFilter);
        return view('crm.available.index', [
            'shop' => $shop,
            'available_types' => $this->service->getTypePartsBy(),
            'available' => $this->service->getReserveAvailable($shop),
            'need_available' => $this->service->getNeedAvailable($shop),
            'type_parts' => $this->service->getTypePartsBy()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $shop = $this->service->getShop($request->keyword);
        $goods = $shop->good()->get(['name', 'id'])->toArray();
        $available = Available::with('good')
            ->whereShopId($shop->id)
            ->where('number', $request->id ?? 0)->get();
        return view('crm.available.create', [
            'shop' => $shop,
            'available' => $available,
            'goods' => $goods,
            'type_parts' => $this->service->getTypePartsBy()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AvailableCreate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AvailableCreate $request)
    {
        $shop = $this->service->getShop($request->keyword);
        $validated = $request->validated();
        $good = $this->service->getGoodByShopAndId($request->good_id, $shop, $request->price);
        $available = Available::whereShopId($shop->id)
            ->where('good_id', $good->id)
            ->where('type_parts_by', $request->type_parts_by)
            ->wherePrice($request->price)->first();

        $number = $request->id ?? (Available::orderBy('created_at', 'desc')->first()->id + 1 ?? 1);
        if (!$available) {
            $validated['good_id'] = $good->id;
            Available::create($validated + [
                'shop_id' => $shop->id,
                    'number' => $request->id ?? $number
                ]);
        } else {
            $available->count += $request->count;
            $available->number = $number;
            if ($request->comment) {
                $available->comment = $request->comment;
            }
            if ($request->residue) {
                $available->residue = $request->residue;
            }
            $available->save();
        }
        return redirect()->route('available.create', ['id' => $number, 'keyword' => $shop->keyword]);
    }

    /**
     * Display the specified resource.
     *
     * @param $keyword
     * @param Available $available
     * @return \Illuminate\View\View
     */
    public function show($keyword, Available $available)
    {
        $shop = $this->service->getShop($keyword);
        $available_types = $this->service->getTypePartsBy();
        return view('crm.available.show', compact('shop', 'available', 'available_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $keyword
     * @param Available $available
     * @return \Illuminate\View\View
     */
    public function edit($keyword, Available $available)
    {
        $shop = $this->service->getShop($keyword);
        $goods = $shop->good()->get(['name', 'id'])->toArray();
        $type_parts = (new AvailableServices)->getTypePartsBy();
        return view('crm.available.edit', compact('shop', 'type_parts', 'goods', 'available'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AvailableCreate $request
     * @param $keyword
     * @param Available $available
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AvailableCreate $request, $keyword, Available $available)
    {
        $shop = $this->service->getShop($keyword);
        $validated = $request->validated();
        $good = $this->service->getGoodByShopAndId($request->good_id, $shop, $request->price);
        $validated['good_id'] = $good->id;
        $available->update($validated);
        return redirect()->route('available.index', $shop->keyword);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $keyword
     * @param Available $available
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($keyword, Available $available)
    {
        $shop = $this->service->getShop($keyword);
        $available->delete();
        return redirect()->route('available.index', $shop->keyword);
    }

    /**
     * Tovar ma'lumotini chop etish uchun ajax zaprosni qabul qilish
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function goodInfo(Request $request)
    {
        $shop = $this->service->getShop($request->keyword);
        return $shop->good()->whereId($request->id)->first();
    }

    /**
     * Import to base in excel sheets
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function import(Request $request)
    {
        $shop = $this->service->getShop($request->keyword);
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx,csv|max:10240', //max 10Mb
        ]);
        Excel::import(new AvailableImport($shop->id), request()->file('file'));
        return back();
    }

    /**
     * Export Available table
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        return (new AvailableExport($this->service->getShop($request->keyword)->id))
            ->download('available.xlsx');
    }

    /**
     * Download example sheet file for import available table
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadExampleSheet()
    {
        $file = public_path() . "/shop_available.xlsx";
        return response()->download($file, 'available.xlsx',
            ['Content-Type: application/xlsx']);
    }

}
