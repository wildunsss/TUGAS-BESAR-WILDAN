<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('areas')) {
            Schema::create('areas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nama_area', 100);
                $table->enum('tipe', ['indoor', 'outdoor']);
                $table->text('deskripsi')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
