<?php

namespace App\Exports;

use App\Models\Sale;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class SalesExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    protected int $userId;
    protected Carbon $fromDate;
    protected Carbon $toDate;

    public function __construct(int $userId, Carbon $fromDate, Carbon $toDate)
    {
        $this->userId   = $userId;
        $this->fromDate = $fromDate;
        $this->toDate   = $toDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Sale::whereBetween('created_at', [$this->fromDate, $this->toDate]);

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        return $query->get();
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            2 => [
                'font' => ['bold' => true]
            ],
            'A:F' => [
                'alignment' => [
                    'horizontal' => 'center'
                ]
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'FOLIO',
            'IMPORTE',
            'ITEMS',
            'ESTADO',
            'USUARIO',
            'FECHA'
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Reporte de Ventas';
    }

    public function map($sale): array
    {
        return [
            $sale->id,
            $sale->total,
            $sale->items,
            $sale->status,
            $sale->user->name,
            Date::dateTimeToExcel($sale->created_at),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'F' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
