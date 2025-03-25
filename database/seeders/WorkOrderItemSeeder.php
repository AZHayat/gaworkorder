<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $workOrderItems = [
            [
                'work_order_id' => 1,
                'nama_barang' => 'Freon AC',
                'qty' => 2,
                'unit' => 'kg',
                'nomor_pr' => 'PR-2025-001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 1,
                'nama_barang' => 'Filter AC',
                'qty' => 1,
                'unit' => 'pcs',
                'nomor_pr' => 'PR-2025-002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 2,
                'nama_barang' => 'Pipa PVC',
                'qty' => 10,
                'unit' => 'm',
                'nomor_pr' => 'PR-2025-003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 3,
                'nama_barang' => 'Besi Custom',
                'qty' => 5,
                'unit' => 'kg',
                'nomor_pr' => 'PR-2025-004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 4,
                'nama_barang' => 'Bahan Baku A',
                'qty' => 100,
                'unit' => 'kg',
                'nomor_pr' => 'PR-2025-005',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 5,
                'nama_barang' => 'Alat Pembersih',
                'qty' => 3,
                'unit' => 'pcs',
                'nomor_pr' => 'PR-2025-006',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 6,
                'nama_barang' => 'Kabel Lift',
                'qty' => 2,
                'unit' => 'roll',
                'nomor_pr' => 'PR-2025-007',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 7,
                'nama_barang' => 'Buku Panduan',
                'qty' => 20,
                'unit' => 'pcs',
                'nomor_pr' => 'PR-2025-008',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 8,
                'nama_barang' => 'Server Rack',
                'qty' => 1,
                'unit' => 'pcs',
                'nomor_pr' => 'PR-2025-009',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 8,
                'nama_barang' => 'Hard Disk',
                'qty' => 4,
                'unit' => 'pcs',
                'nomor_pr' => 'PR-2025-010',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 9,
                'nama_barang' => 'Dokumen Audit',
                'qty' => 1,
                'unit' => 'set',
                'nomor_pr' => 'PR-2025-011',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'work_order_id' => 10,
                'nama_barang' => 'Brosur Produk',
                'qty' => 500,
                'unit' => 'pcs',
                'nomor_pr' => 'PR-2025-012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('work_order_items')->insert($workOrderItems);
    }
}
