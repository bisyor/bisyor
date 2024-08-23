<?php

namespace App\Exports;

use App\Models\Crm\Available;
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

class AvailableExport implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, WithColumnWidths, WithStyles
{

    use Exportable;

    /**
     * Shop id
     *
     * @var int
     */
    protected int $shop;


    public function __construct(int $shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Available::query()->with('good')->where('shop_id', $this->shop);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['Пример ввода данных через электронную таблицу Excel Обратите внимание на правила при заполнении таблицы!'],
            [
                'Продукт (обязательный)',
                'Тип продукта 1 <=> новый 2 <=> Б / У',
                'Количество (обязательный)',
                'Цена (обязательный)',
                'Минимальная количество',
                'Примечание',
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
            $row->good->name,
            $row->type_parts_by,
            $row->count,
            $row->price,
            $row->residue,
            $row->comment,
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 10,
            'C' => 40,
            'D' => 20,
            'E' => 20,
            'F' => 50,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return mixed
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(40);
        $sheet->getRowDimension(2)->setRowHeight(50);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()
            ->setARGB('ffd966');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A2:F2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()
            ->setARGB('ddebf7');

        $sheet->getStyle('A1:F1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:F2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            'A2' => ['font' => ['bold' => true]],
            'B2' => ['font' => ['bold' => true]],
            'C2' => ['font' => ['bold' => true]],
            'D2' => ['font' => ['bold' => true]],
            'E2' => ['font' => ['bold' => true]],
            'F2' => ['font' => ['bold' => true]],
        ];
    }
}
