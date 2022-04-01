<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function reportPdf(int $userId, string $fromDate = null, string $toDate = null)
    {
        $sales = [];

        if (!$fromDate && strlen($fromDate)) {
            $fromDate = Carbon::now();
        }

        if (!$toDate && strlen($toDate)) {
            $toDate = Carbon::now();
        }

        $from = Carbon::parse($fromDate)->startOfDay();
        $to   = Carbon::parse($toDate)->endOfDay();
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
}
