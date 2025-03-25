<?php

namespace App\Exports;

use App\Models\WorkOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkOrderExport implements FromCollection, WithHeadings, WithMapping
{
    protected $orderStartDate, $orderEndDate, $doneStartDate, $doneEndDate, $status, $departemen;

    public function __construct($orderStartDate, $orderEndDate, $doneStartDate, $doneEndDate, $status, $departemen)
    {
        $this->orderStartDate = $orderStartDate;
        $this->orderEndDate = $orderEndDate;
        $this->doneStartDate = $doneStartDate;
        $this->doneEndDate = $doneEndDate;
        $this->status = $status;
        $this->departemen = $departemen;
    }

    public function collection()
    {
        $query = WorkOrder::with(['updates', 'items']);

        // Filter Tanggal Order
        if (!empty($this->orderStartDate) && !empty($this->orderEndDate)) {
            $query->whereBetween('tanggal_pembuatan', [$this->orderStartDate, $this->orderEndDate]);
        }

        // Filter Tanggal Selesai
        if (!empty($this->doneStartDate) && !empty($this->doneEndDate)) {
            $query->whereHas('updates', function ($q) {
                $q->whereBetween('tanggal_selesai', [$this->doneStartDate, $this->doneEndDate]);
            });
}


        // Filter status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Filter departemen
        if ($this->departemen) {
            $query->where('departemen', $this->departemen);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nomor WO', 'Status', 'Nama Pemohon', 'Departemen', 'Departemen Lainnya',
            'Tanggal Pembuatan', 'Target Selesai', 'Tanggal Pengerjaan', 'Tanggal Selesai',
            'Jenis Pekerjaan', 'Jenis Pekerjaan Lainnya', 'Deskripsi', 'Tindakan', 'Saran',
            'Nama Barang', 'Qty', 'Unit', 'Nomor PR'
        ];
    }

    public function map($workOrder): array
    {
        $updates = $workOrder->updates()->first();
        $items = $workOrder->items()->get();

        return [
            $workOrder->nomor_wo,
            $workOrder->status,
            $workOrder->nama_pemohon,
            $workOrder->departemen,
            $workOrder->departemen_lainnya,
            Carbon::parse($workOrder->tanggal_pembuatan)->format('d-m-Y'),
            Carbon::parse($workOrder->target_selesai)->format('d-m-Y'),
            optional($updates)->tanggal_pengerjaan 
                ? Carbon::parse($updates->tanggal_pengerjaan)->format('d-m-Y') 
                : 'Belum Dikerjakan',
            optional($updates)->tanggal_selesai 
                ? Carbon::parse($updates->tanggal_selesai)->format('d-m-Y') 
                : 'Belum Selesai',
            is_array($workOrder->jenis_pekerjaan) 
                ? implode(', ', $workOrder->jenis_pekerjaan) 
                : (is_string($workOrder->jenis_pekerjaan) ? $workOrder->jenis_pekerjaan : ''),
            
            is_array($workOrder->jenis_pekerjaan_lainnya) 
                ? implode(', ', $workOrder->jenis_pekerjaan_lainnya) 
                : (is_string($workOrder->jenis_pekerjaan_lainnya) ? $workOrder->jenis_pekerjaan_lainnya : ''),

            $workOrder->deskripsi,
            $updates ? $updates->tindakan : 'Tidak ada tindakan',
            $updates ? $updates->saran : 'Tidak ada saran',
            $items->pluck('nama_barang')->implode(', '),
            $items->pluck('qty')->implode(', '),
            $items->pluck('unit')->implode(', '),
            $items->pluck('nomor_pr')->implode(', '),
        ];
    }
}
