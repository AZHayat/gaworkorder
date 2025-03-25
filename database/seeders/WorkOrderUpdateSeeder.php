<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkOrderUpdateSeeder extends Seeder
{
    public function run(): void
    {
        $workOrderUpdates = [
            [
                'work_order_id' => 1,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-01'),
                'tanggal_selesai' => null,
                'tindakan' => 'Pengecekan dan perbaikan AC.',
                'saran' => 'Rutin melakukan maintenance setiap 6 bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 2,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-03'),
                'tanggal_selesai' => Carbon::parse('2025-03-05'),
                'tindakan' => 'Pembuatan jalur pipa baru selesai.',
                'saran' => 'Pastikan jalur pipa dicek setiap bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 3,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-06'),
                'tanggal_selesai' => Carbon::parse('2025-03-07'),
                'tindakan' => 'Pembuatan alat custom selesai.',
                'saran' => 'Lakukan uji coba alat sebelum digunakan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 4,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-08'),
                'tanggal_selesai' => Carbon::parse('2025-03-09'),
                'tindakan' => 'Pengiriman bahan baku selesai.',
                'saran' => 'Pastikan bahan baku diterima dengan baik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 5,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-10'),
                'tanggal_selesai' => Carbon::parse('2025-03-11'),
                'tindakan' => 'Pembersihan dan upgrade ruang lab selesai.',
                'saran' => 'Lakukan pembersihan rutin setiap bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 6,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-12'),
                'tanggal_selesai' => Carbon::parse('2025-03-13'),
                'tindakan' => 'Perbaikan lift selesai.',
                'saran' => 'Lakukan pengecekan lift setiap 3 bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 7,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-14'),
                'tanggal_selesai' => Carbon::parse('2025-03-15'),
                'tindakan' => 'Pelatihan karyawan baru selesai.',
                'saran' => 'Lakukan evaluasi pelatihan setiap 6 bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 8,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-16'),
                'tanggal_selesai' => Carbon::parse('2025-03-17'),
                'tindakan' => 'Upgrade server selesai.',
                'saran' => 'Lakukan pengecekan server setiap bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 9,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-18'),
                'tanggal_selesai' => Carbon::parse('2025-03-19'),
                'tindakan' => 'Audit keuangan tahunan selesai.',
                'saran' => 'Lakukan audit keuangan setiap tahun.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 10,
                'tanggal_pengerjaan' => Carbon::parse('2025-03-20'),
                'tanggal_selesai' => Carbon::parse('2025-03-21'),
                'tindakan' => 'Kampanye produk baru selesai.',
                'saran' => 'Evaluasi hasil kampanye setiap bulan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('work_order_updates')->insert($workOrderUpdates);
    }
}
