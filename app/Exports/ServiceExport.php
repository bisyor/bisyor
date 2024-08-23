<?php

namespace App\Exports;

use App\Models\Crm\Services;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceExport implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, WithColumnWidths, WithStyles
{
    use Exportable;

    protected int $shop;

    /**
     * For getting shop id in controller
     *
     * @param int $shop
     * @return $this
     */
    public function forShop(int $shop)
    {
        $this->shop = $shop;

        return $this;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Services::query()->where('shop_id', $this->shop);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['Образец файла Excel для заполнения базы данных услуг.'],
            [
                'Название сервиса (обязательно)',
                'Плата за обслуживание (обязательно, Только числа)',
            ]
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->price,
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 40,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(40);
        $sheet->getRowDimension(2)->setRowHeight(30);
        $sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()
            ->setARGB('ffd966');
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A2:B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()
            ->setARGB('ddebf7');

        $sheet->getStyle('A1:B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:B2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            'A2' => ['font' => ['bold' => true]],
            'B2' => ['font' => ['bold' => true]],
        ];
    }
}
