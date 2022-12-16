<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembayaran')->unique();
            $table->string('bukti_pembayaran')->nullable();
            $table->string('status');
            $table->boolean('verifikasi');
            $table->integer('total_bayar')->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->date('tgl_pembayaran')->nullable();
            $table->unsignedBigInteger('id_pendaftaran');
            $table->foreign('id_pendaftaran')
                ->references('id')
                ->on('pendaftaran')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
