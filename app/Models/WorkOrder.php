<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_orders'; // Nama tabel di database

    protected $fillable = [
        'nomor_wo',
        'nama_pemohon',
        'departemen',
        'departemen_lainnya',
        'tanggal_pembuatan',
        'target_selesai',
        'jenis_pekerjaan',
        'jenis_pekerjaan_lainnya',
        'deskripsi',
        'status',
        'tindakan',
        'saran',
        'items',
        'tanggal_pengerjaan',
        'tanggal_selesai'
    ];

    protected $casts = [
        'items' => 'array',
        'jenis_pekerjaan' => 'array', // Karena bisa lebih dari satu, disimpan dalam format JSON
        'tanggal_pembuatan' => 'date',
        'target_selesai' => 'date',
        'tanggal_pengerjaan' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function updates()
    {
        return $this->hasMany(WorkOrderUpdate::class);
    }

    public function items()
    {
        return $this->hasMany(WorkOrderItem::class);
    }
}
