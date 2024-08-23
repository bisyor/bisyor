<?php

namespace App\Imports;

use App\Models\Crm\Services;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ServicesImport implements ToModel, WithValidation, WithStartRow, WithChunkReading, ShouldQueue
{
    protected int $shop;

    public function __construct(int $shop_id)
    {
        $this->shop = $shop_id;
    }

    /**
     * @param array $row
     * @return Services
     */
    public function model(array $row)
    {
        return new Services([
            'name' => $row[0],
            'price' => $row[1],
            'shop_id' => $this->shop
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.0' => 'required|string|unique:crm_services,name',
            '*.1' => 'required|numeric'
        ];
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
