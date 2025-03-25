<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;

class WorkOrderDashboardController extends Controller
{
    public function getDashboardData(Request $request)
    {
        $year = $request->input('year', now()->year); // Default ke tahun ini

        $total = WorkOrder::whereYear('tanggal_pembuatan', $year)->count();
        $open = WorkOrder::whereYear('tanggal_pembuatan', $year)
                        ->whereIn('status', ['Open', 'Pending', 'Proses'])
                        ->count();
        $close = WorkOrder::whereYear('tanggal_pembuatan', $year)
                          ->where('status', 'Close')
                          ->count();

        return response()->json([
            'total' => $total,
            'open' => $open,
            'close' => $close,
        ]);
    }


    public function getMonthlyWorkOrderData(Request $request)
    {
        $year = $request->input('year', now()->year);

        $statuses = [
            'total' => [],
            'open' => [],
            'close' => []
        ];

        for ($i = 1; $i <= 12; $i++) {
            $statuses['total'][$i] = WorkOrder::whereYear('tanggal_pembuatan', $year)
                ->whereMonth('tanggal_pembuatan', $i)
                ->count();

            $statuses['open'][$i] = WorkOrder::whereYear('tanggal_pembuatan', $year)
                ->whereMonth('tanggal_pembuatan', $i)
                ->whereIn('status', ['Open', 'Pending', 'Proses'])
                ->count();

            $statuses['close'][$i] = WorkOrder::whereYear('tanggal_pembuatan', $year)
                ->whereMonth('tanggal_pembuatan', $i)
                ->where('status', 'Close')
                ->count();
        }

        return response()->json($statuses);
    }

    public function getPieChartData(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Data Departemen
        $departments = WorkOrder::whereYear('tanggal_pembuatan', $year)
            ->selectRaw('departemen, COUNT(*) as jumlah')
            ->groupBy('departemen')
            ->pluck('jumlah', 'departemen')
            ->toArray();

        // Data Jenis Pekerjaan
        $jobTypes = WorkOrder::whereYear('tanggal_pembuatan', $year)
            ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(jenis_pekerjaan, "$[*]")) as pekerjaan, COUNT(*) as jumlah')
            ->groupBy('pekerjaan')
            ->pluck('jumlah', 'pekerjaan')
            ->toArray();

        return response()->json([
            'departments' => $departments,
            'jobTypes' => $jobTypes,
        ]);
    }



}
