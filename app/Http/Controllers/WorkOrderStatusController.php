<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use Barryvdh\DomPDF\Facade\Pdf;


class WorkOrderStatusController extends Controller
{
    public function index()
{
    $workOrders = WorkOrder::latest()->get()->map(function ($wo) {
        $wo->jenis_pekerjaan = is_string($wo->jenis_pekerjaan) ? json_decode($wo->jenis_pekerjaan, true) : $wo->jenis_pekerjaan;
        $wo->jenis_pekerjaan = is_array($wo->jenis_pekerjaan) ? implode(', ', $wo->jenis_pekerjaan) : $wo->jenis_pekerjaan;
       
        return $wo;
    });

    // Ambil daftar departemen unik
    $departemen = WorkOrder::select('departemen')->distinct()->pluck('departemen')->toArray();

    // Ambil daftar jenis pekerjaan unik
   $jenisPekerjaan = WorkOrder::select('jenis_pekerjaan')
    ->distinct()
    ->get()
    ->pluck('jenis_pekerjaan')
    ->map(function ($jenis) {
        return is_string($jenis) ? json_decode($jenis, true) : $jenis;
    })
    ->flatten()
    ->unique()
    ->toArray();

    // dd($jenisPekerjaan);


    return view('workorder.status', compact('workOrders', 'departemen', 'jenisPekerjaan'));
}



    public function download($nomor_wo)
{
    $wo = WorkOrder::where('nomor_wo', $nomor_wo)->firstOrFail();

    // Ambil data dari tabel relasi
    $updates = $wo->updates()->first();
    $items = $wo->items()->get();

    // Cek departemen dan jenis pekerjaan jika "Others"
    $departemen = ($wo->departemen === 'Others') ? "Others: " . $wo->departemen_lainnya : $wo->departemen;

    // Jika jenis pekerjaan berupa array, ubah ke string
    if (is_array($wo->jenis_pekerjaan)) {
        $jenis_pekerjaan = implode(', ', array_map(function ($jenis) use ($wo) {
            return ($jenis === 'Others') ? "Others: " . $wo->jenis_pekerjaan_lainnya : $jenis;
        }, $wo->jenis_pekerjaan));
    } else {
        $jenis_pekerjaan = ($wo->jenis_pekerjaan === 'Others') ? "Others: " . $wo->jenis_pekerjaan_lainnya : $wo->jenis_pekerjaan;
    }

    // Format data untuk PDF
    $data = [
        'Nomor WO' => $wo->nomor_wo,
        'Tanggal Order' => $wo->tanggal_pembuatan,
        'Target Selesai' => $wo->target_selesai,
        'Tanggal Selesai' => $updates ? $updates->tanggal_selesai : null,
        'Tanggal Pengerjaan' => $updates ? $updates->tanggal_pengerjaan : null,
        'Nama Pemohon' => $wo->nama_pemohon,
        'Departemen' => $departemen,
        'Jenis Pekerjaan' => $jenis_pekerjaan,
        'Deskripsi' => $wo->deskripsi,
        'Tindakan' => $updates ? $updates->tindakan : '-',
        'Saran' => $updates ? $updates->saran : '-',
        'Materials' => $items->map(function ($item) {
            return [
                'Nama Barang' => $item->nama_barang,
                'QTY' => $item->qty,
                'Unit' => $item->unit,
                'Nomor PR' => $item->nomor_pr,
            ];
        })->toArray(),
    ];

    $pdf = Pdf::loadView('workorder.pdf', compact('data'));

    $pdf->setPaper('A4', 'portrait');

    $pdf->setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'sans-serif',
    ]);

    $css = file_get_contents(public_path('css/workorder_pdf.css'));
    $pdf->getDomPDF()->getOptions()->setChroot(public_path());
    $pdf->getDomPDF()->loadHtml('<style>' . $css . '</style>' . $pdf->getDomPDF()->outputHtml());

    return $pdf->stream("WO_{$nomor_wo}.pdf");
}

}
