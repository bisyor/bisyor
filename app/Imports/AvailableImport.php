<?php

namespace App\Imports;

use App\Models\Crm\Available;
use App\Models\Crm\Goods;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class AvailableImport implements OnEachRow, WithStartRow, WithValidation, WithChunkReading, ShouldQueue
{
    protected int $shop;

    public function __construct($shop_id)
    {
        $this->shop = $shop_id;
    }

    /**
     * @param Row $row
     * @return mixed
     */
    public function onRow(Row $row)
    {
        $row = $row->toArray();
        $good = Goods::firstOrCreate(['name' => $row['0'], 'shop_id' => $this->shop],
            ['cost' => $row['3']]);
        $available = Available::whereShopId($this->shop)->where('good_id', $good->id)
            ->wherePrice($row[3])->where('type_parts_by', $row['1'])->first();
        if ($available) {
            return $available->update(['count' => $available->count + $row[2]]);
        }

        return Available::create([
            'good_id' => $good->id,
            'type_parts_by' => $row['1'],
            'count' => $row['2'],
            'price' => $row['3'],
            'residue' => $row['4'],
            'comment' => $row['5'],
            'shop_id' => $this->shop,
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.0' => 'required|string',
            '*.1' => 'integer',
            '*.2' => 'required|integer',
            '*.3' => 'required|integer',
            '*.4' => 'integer',
            '*.5' => 'string',
        ];
    }


    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
