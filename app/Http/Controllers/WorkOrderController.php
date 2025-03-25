<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderUpdate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WorkOrderController extends Controller
{
    // Menampilkan halaman pembuatan WO
    public function create()
    {
        return view('workorder.create');
    }

    // Menyimpan data WO baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'departemen_lainnya' => 'nullable|string|max:20',
            'tanggal_pembuatan' => 'required|date',
            'target_selesai' => 'required|date',
            'jenis_pekerjaan' => 'required|array',
            'jenis_pekerjaan_lainnya' => 'nullable|string|max:30',
            'deskripsi' => 'required|string',
        ]);

        // Menentukan departemen
        $departemen_lainnya = null;
        if ($request->departemen === 'Others') {
            $departemen_lainnya = $request->departemen_lainnya;
            $departemen = 'Others';
        } else {
            $departemen = $request->departemen;
        }

        // Menentukan jenis pekerjaan
        $jenis_pekerjaan_lainnya = null;
        $jenis_pekerjaan = $request->jenis_pekerjaan; // Ambil semua yang dipilih

        if (in_array('Others', $jenis_pekerjaan)) {
            $jenis_pekerjaan_lainnya = $request->jenis_pekerjaan_lainnya;
            // Biarkan "Others" tetap ada, jangan ganti arraynya
        }

        // Ensure jenis_pekerjaan is a simple array
        $jenis_pekerjaan = array_values($jenis_pekerjaan);

        // Generate nomor WO otomatis
        $bulan = Carbon::parse($request->tanggal_pembuatan)->format('m');
        $tahun = Carbon::parse($request->tanggal_pembuatan)->format('y');

        // Jika departemen adalah "Others" atau departemen lainnya, inisialnya "OTH"
        $inisialDepartemen = strtoupper(substr($departemen, 0, 3));
        if ($request->departemen === 'Others' || $departemen === $request->departemen_lainnya) {
            $inisialDepartemen = 'OTH';
        }

        // Ambil jumlah WO yang sudah ada di bulan & tahun yang sama
        $count = WorkOrder::whereYear('tanggal_pembuatan', Carbon::parse($request->tanggal_pembuatan)->year)
            ->whereMonth('tanggal_pembuatan', Carbon::parse($request->tanggal_pembuatan)->month)
            ->count() + 1;

        $nomor_wo = sprintf('%02d-%02d-%s-%03d', $bulan, $tahun, $inisialDepartemen, $count);

        // Simpan ke database
        WorkOrder::create([
            'nomor_wo' => $nomor_wo,
            'nama_pemohon' => $request->nama_pemohon,
            'departemen' => $departemen,
            'departemen_lainnya' => $departemen_lainnya,
            'tanggal_pembuatan' => $request->tanggal_pembuatan,
            'target_selesai' => $request->target_selesai,
            'jenis_pekerjaan' => $jenis_pekerjaan,
            'jenis_pekerjaan_lainnya' => $jenis_pekerjaan_lainnya,
            'deskripsi' => $request->deskripsi,
            'status' => 'Open',
        ]);

        return redirect()->route('workorder.create')->with('success', "Work Order berhasil dibuat dengan nomor: $nomor_wo");
    }

    // Menampilkan halaman Update WO
    public function edit()
    {
        return view('workorder.update');
    }

    // Fungsi untuk pencarian WO via AJAX
    public function find(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required|string',
        ]);

        $workOrder = WorkOrder::where('nomor_wo', $request->nomor_wo)->first();

        if (!$workOrder) {
            return response()->json(['error' => 'Nomor WO tidak ditemukan'], 404);
        }

        $workOrderUpdate = WorkOrderUpdate::where('work_order_id', $workOrder->id)->latest()->first();
        $workOrderItems = WorkOrderItem::where('work_order_id', $workOrder->id)->get();

        // Daftar departemen yang sudah ditentukan
        $departemenList = ['Engineering', 'CPP', 'Metalize', 'Slitting', 'Warehouse & PPIC', 'Laboratorium', 'Direksi'];
        $departemen = in_array($workOrder->departemen, $departemenList) ? $workOrder->departemen : 'Others';
        $departemen_lainnya = $departemen === 'Others' ? $workOrder->departemen_lainnya : '';

        // Daftar jenis pekerjaan yang sudah ditentukan
        $jenisPekerjaanList = ['Maintenance Building', 'Project', 'Cleaning', 'Crafting', 'Ekspedisi'];

        // Pisahkan pekerjaan yang termasuk dalam daftar dan yang tidak
        $jenis_pekerjaan = array_intersect($workOrder->jenis_pekerjaan, $jenisPekerjaanList);
        $jenis_pekerjaan_diff = array_diff($workOrder->jenis_pekerjaan, $jenisPekerjaanList);

        // Ubah "Others" menjadi nilai dari jenis_pekerjaan_lainnya
        $jenis_pekerjaan_lainnya = array_map(function ($pekerjaan) use ($workOrder) {
            return $pekerjaan === "Others" ? $workOrder->jenis_pekerjaan_lainnya : $pekerjaan;
        }, $jenis_pekerjaan_diff);

        return response()->json([
            'nomor_wo' => $workOrder->nomor_wo,
            'nama_pemohon' => $workOrder->nama_pemohon,
            'departemen' => $departemen,
            'departemen_lainnya' => $departemen_lainnya,
            'tanggal_pembuatan' => Carbon::parse($workOrder->tanggal_pembuatan)->format('Y-m-d'),
            'target_selesai' => Carbon::parse($workOrder->target_selesai)->format('Y-m-d'),
            'deskripsi' => $workOrder->deskripsi,
            'status' => $workOrder->status,
            'tanggal_pengerjaan' => !empty($workOrderUpdate->tanggal_pengerjaan) 
                ? Carbon::parse($workOrderUpdate->tanggal_pengerjaan)->format('Y-m-d') 
                : '',
            'tanggal_selesai' => !empty($workOrderUpdate->tanggal_selesai) 
                ? Carbon::parse($workOrderUpdate->tanggal_selesai)->format('Y-m-d') 
                : '',
            'tindakan' => optional($workOrderUpdate)->tindakan ?? '',
            'saran' => optional($workOrderUpdate)->saran ?? '',
            'jenis_pekerjaan' => $jenis_pekerjaan,
            'jenis_pekerjaan_lainnya' => array_values($jenis_pekerjaan_lainnya),
            'items' => $workOrderItems,
        ]);
    }

    // Memproses update data WO
    public function update(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required|exists:work_orders,nomor_wo',
            'status' => 'required',
            'tindakan' => 'required|string',
            'saran' => 'nullable|string',
            'items' => 'nullable|array',  
            'items.*.nama_barang' => 'sometimes|required|string',
            'items.*.qty' => 'sometimes|required|integer',
            'items.*.unit' => 'sometimes|required|string',
            'items.*.nomor_pr' => 'nullable|string',
            'nama_pemohon' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'departemen_lainnya' => 'nullable|string|max:20',
            'tanggal_pembuatan' => 'required|date',
            'target_selesai' => 'required|date',
            'tanggal_pengerjaan' => 'nullable|date', // Pastikan ini tidak tertukar
            'tanggal_selesai' => 'nullable|date',
            'jenis_pekerjaan' => 'required|array',
            'jenis_pekerjaan_lainnya' => 'nullable|string|max:30',
            'deskripsi' => 'required|string',
        ]);

        $workOrder = WorkOrder::where('nomor_wo', $request->nomor_wo)->firstOrFail();

        // Handle "Other" untuk departemen
        $departemen = $request->departemen;
        if ($departemen === 'Others') {
            $departemen = $request->departemen_lainnya;
        }

        // Handle "Other" untuk jenis_pekerjaan
        $jenis_pekerjaan = $request->jenis_pekerjaan;

        if (in_array('Others', $jenis_pekerjaan)) {
            
            if ($request->has('jenis_pekerjaan_lainnya') && !empty($request->jenis_pekerjaan_lainnya)) {
                
                // Do not replace "Others" with jenis_pekerjaan_lainnya
            } else {
                
            }
        } else {
            
        }
        $jenis_pekerjaan = array_values($jenis_pekerjaan);
     

        // Update data utama WO
        $workOrder->update([
            'status' => $request->status,
            'nama_pemohon' => $request->nama_pemohon,
            'departemen' => $departemen,
            'tanggal_pembuatan' => $request->tanggal_pembuatan,
            'target_selesai' => $request->target_selesai,
            'jenis_pekerjaan' => $jenis_pekerjaan,
            'jenis_pekerjaan_lainnya' => $request->jenis_pekerjaan_lainnya,
            'deskripsi' => $request->deskripsi,
        ]);

        // Update atau buat WorkOrderUpdate (tanpa menghapus data lama)
        WorkOrderUpdate::updateOrCreate(
            ['work_order_id' => $workOrder->id], // Cek berdasarkan work_order_id
            [
                'tanggal_pengerjaan' => $request->tanggal_pengerjaan, // Gunakan field yang benar
                'tanggal_selesai' => $request->tanggal_selesai, // Gunakan field yang benar
                'tindakan' => $request->tindakan,
                'saran' => $request->saran,
            ]
        );

        // Hapus item lama lalu insert baru
        WorkOrderItem::where('work_order_id', $workOrder->id)->delete();

        if (!empty($request->items)) {
            foreach ($request->items as $index => $item) {
                WorkOrderItem::create([
                    'work_order_id' => $workOrder->id,
                    'nama_barang' => $item['nama_barang'],
                    'qty' => $item['qty'],
                    'unit' => $item['unit'],
                    'nomor_pr' => $item['nomor_pr'] ?? null,
                ]);
            }
        }

        return redirect()->route('workorder.edit')->with('success', 'WO berhasil diperbarui!');
    }

    // TOmbol hapus
    public function delete(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required|string',
        ]);

        $workOrder = WorkOrder::where('nomor_wo', $request->nomor_wo)->first();

        if (!$workOrder) {
            return response()->json(['error' => 'Work Order tidak ditemukan!'], 404);
        }

        $workOrder->delete();

        return response()->json(['success' => 'Work Order berhasil dihapus!']);
    }

}
