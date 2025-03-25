<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\WorkOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class WorkOrderExportController extends Controller
{
    public function export(Request $request)
    {
        // Ambil data filter dari request
        $orderStartDate = $request->query('orderStartDate', null);
        $orderEndDate = $request->query('orderEndDate', null);
        $doneStartDate = $request->query('doneStartDate', null);
        $doneEndDate = $request->query('doneEndDate', null);
        $status = $request->query('status', null);
        $departemen = $request->query('departemen', null);

        // Export ke Excel
        return Excel::download(new WorkOrderExport(
            $orderStartDate,
            $orderEndDate,
            $doneStartDate,
            $doneEndDate,
            $status,
            $departemen
        ), 'work_orders.xlsx');
    }
}
