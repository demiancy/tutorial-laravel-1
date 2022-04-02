<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;

class ExportController extends Controller
{
    public function reportPdf(int $userId, string $fromDate = null, string $toDate = null)
    {
        $sales = [];

        $from = $this->stringToCarbon($fromDate)->startOfDay();
        $to   = $this->stringToCarbon($toDate)->endOfDay();
        $user = 'Todos';
        
        $query = Sale::whereBetween('created_at', [$from, $to]);

        if ($userId) {
            $query->where('user_id', $userId);
            $user = User::find($userId)->name;
        }

        $sales = $query->get();

        $pdf = Pdf::loadView(
            'pdf.report', 
            compact('sales', 'user', 'from', 'to')
        )->setOptions([
            'defaultFont'     => 'sans-serif',
            'isRemoteEnabled' => true,
            'chroot'          => realpath(base_path())
        ]);
        
        return $pdf->stream('salesReport.pdf');
    }

    public function reportExcel(int $userId, ?string $fromDate = null, ?string $toDate = null)
    {
        $from = $this->stringToCarbon($fromDate)->startOfDay();
        $to   = $this->stringToCarbon($toDate)->endOfDay();

        return Excel::download(
            new SalesExport($userId, $from, $to), 
            'sales.xlsx'
        );
    }

    protected function stringToCarbon(?string $date = null) 
    {
        if (!$date && strlen($date)) {
            return Carbon::now();
        }

        return Carbon::parse($date);
    }
}
