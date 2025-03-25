<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderUpdate extends Model
{
    use HasFactory;
    // protected $table = 'work_orders_updates'; // Nama tabel di database

    protected $fillable = [
        'work_order_id',
        'tindakan',
        'saran',
        'tanggal_pengerjaan',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_pengerjaan' => 'date',
        'tanggal_selesai' => 'date'
    ];
}