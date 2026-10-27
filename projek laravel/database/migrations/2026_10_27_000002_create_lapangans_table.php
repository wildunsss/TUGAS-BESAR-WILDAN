<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('lapangans')) {
            Schema::create('lapangans', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('area_id');
                $table->string('kode', 20)->unique();
                $table->string('nama_lapangan', 100);
                $table->string('cabang_olahraga', 50);
                $table->enum('jenis_permukaan', ['rumput_alami', 'rumput_sintetis', 'vinyl', 'parket', 'semen', 'karpet']);
                $table->decimal('panjang', 6, 2);
                $table->decimal('lebar', 6, 2);
                $table->enum('status_fisik', ['baik', 'perlu_perbaikan', 'rusak'])->default('baik');
                $table->text('keterangan')->nullable();

                $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
