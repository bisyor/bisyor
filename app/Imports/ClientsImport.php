<?php

namespace App\Imports;

use App\Models\Crm\Clients;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClientsImport implements ToModel, WithStartRow, WithValidation, WithChunkReading, ShouldQueue
{
    protected int $shop;

    public function __construct($shop_id)
    {
        $this->shop = $shop_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Clients([
            'type'     => $row['0'],
            'fio'     => $row['1'],
            'company_name'     => $row['2'],
            'phone'     => $row['3'],
            'inn'     => $row['4'],
            'address'     => $row['5'],
            'email'     => $row['6'],
            'shop_id' => $this->shop,
        ]);
    }


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
            '*.0' => [
                'required',
                Rule::in(['1', '2'])
            ],
            '*.1' => 'required|string|unique:crm_clients,fio',
            '*.2' => 'exclude_if:*.1,1|required|string',
            '*.3' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:crm_clients,phone',
            '*.4' => 'sometimes|nullable|integer',
            '*.5' => 'sometimes|nullable|string',
            '*.6' => 'sometimes|nullable|email|unique:crm_clients,email',
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
