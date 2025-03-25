<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('work_order_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->onDelete('cascade');
            $table->date('tanggal_pengerjaan')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('tindakan');
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('work_order_updates');
    }
};
