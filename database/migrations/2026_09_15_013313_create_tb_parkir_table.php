<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_parkir', function (Blueprint $table) {
            $table->id('id_parkir');
            $table->unsignedBigInteger('id_kendaraan');
            $table->unsignedBigInteger('tarif_id');
            $table->unsignedBigInteger('petugas_id');
            $table->unsignedBigInteger('id_area')->nullable();
            $table->dateTime('jam_masuk');
            $table->dateTime('jam_keluar')->nullable();
            $table->decimal('biaya', 10, 2)->nullable();
            $table->enum('status', ['masuk', 'keluar'])->default('masuk');
            $table->timestamps();

            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('tb_kendaraan')->onDelete('cascade');
            $table->foreign('tarif_id')->references('id_tarif')->on('tb_tarif');
            $table->foreign('petugas_id')->references('id_user')->on('tb_user');
            $table->foreign('id_area')->references('id_area')->on('tb_area_parkir');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_parkir');
    }
};