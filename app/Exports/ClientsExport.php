<?php

namespace App\Exports;

use App\Models\Crm\Clients;
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

class ClientsExport implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, WithColumnWidths, WithStyles
{
    use Exportable;

    /**
     * Shop id
     *
     * @var int
     */
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
     * Header row excel file for export
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            ['Пример для заполнения клиентской базы с помощью таблиц Excel. Обратите внимание на правила при заполнении таблицы!'],
            [
                'Тип клиента 1 <=> Юридическое лицо  2 <=> Физическое лицо (обязательный)',
                'Фамилия Имя Отчество (обязательный)',
                'Название компании (Обязательно только для юридических лиц)',
                'Телефонный номер (обязательный)',
                'ИНН номер',
                'Адрес',
                'Адрес электронной почты',
            ]
        ];
    }

    /**
     * Mapping for excel file
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->type,
            $row->fio,
            $row->company_name,
            $row->phone,
            $row->inn,
            $row->address,
            $row->email,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Clients::query()->where('shop_id', $this->shop);
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 75,
            'B' => 40,
            'C' => 40,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 30,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(40);
        $sheet->getRowDimension(2)->setRowHeight(40);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()
            ->setARGB('ffd966');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A2:G2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()
            ->setARGB('ddebf7');

        $sheet->getStyle('A1:G1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A2:G2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        return [
            1    => ['font' => ['bold' => true, 'size' => 14]],
            'A2' => ['font' => ['bold' => true]],
            'B2' => ['font' => ['bold' => true]],
            'C2' => ['font' => ['bold' => true]],
            'D2' => ['font' => ['bold' => true]],
            'E2' => ['font' => ['bold' => true]],
            'F2' => ['font' => ['bold' => true]],
            'G2' => ['font' => ['bold' => true]],
        ];
    }
}
