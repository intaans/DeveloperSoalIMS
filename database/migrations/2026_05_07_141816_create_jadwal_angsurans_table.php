<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_angsurans', function (Blueprint $table) {
            $table->id();
            $table->string('KONTRAK_NO', 20);
            $table->integer('ANGSURAN_KE');
            $table->decimal('ANGSURAN_PER_BULAN', 15, 2);
            $table->date('TANGGAL_JATUH_TEMPO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_angsurans');
    }
};
