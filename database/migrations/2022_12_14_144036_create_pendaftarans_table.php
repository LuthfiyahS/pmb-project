<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('id_pendaftaran')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('nisn');
            $table->string('nik');
            $table->string('nama_siswa');
            $table->string('jenis_kelamin');
            $table->string('pas_foto');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');

            //Kontak
            $table->string('email');
            $table->string('hp');

            // Alamat lengkap
            $table->string('alamat')->nullable();
            
            $table->string('provinsi_id')->nullable();
            // $table->foreign('provinsi_id')
            //     ->references('id')
            //     ->on('provinces')
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->string('kabupaten_id')->nullable();
            // $table->foreign('kabupaten_id')
            //     ->references('id')
            //     ->on('regencies')
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->string('kecamatan_id')->nullable();
            // $table->foreign('kecamatan_id')
            //     ->references('id')
            //     ->on('districts')
            //     ->onUpdate('cascade')->onDelete('cascade');

            $table->string('kelurahan_id')->nullable();
            // $table->foreign('kelurahan_id')
            //     ->references('id')
            //     ->on('villages')
            //     ->onUpdate('cascade')->onDelete('cascade');

            //data pendaftaran
            $table->unsignedBigInteger('gelombang');
            $table->foreign('gelombang')
                ->references('id')
                ->on('jadwal_kegiatan')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('tahun_masuk');
            $table->unsignedBigInteger('pil1');
            $table->foreign('pil1')
                ->references('id')
                ->on('program_studi')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('pil2');
            $table->foreign('pil2')
                ->references('id')
                ->on('program_studi')
                ->onUpdate('cascade')->onDelete('cascade');

            //data orang tua
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ayah');
            $table->string('pekerjaan_ibu');
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('nohp_ayah')->nullable();
            $table->string('nohp_ibu')->nullable();
            $table->string('penghasilan_ayah');
            $table->string('penghasilan_ibu');

            $table->string('berkas_ortu');//kk akte ijazah raport penghasilan


            //data nilai dan sekolah
            $table->unsignedBigInteger('sekolah');
            $table->foreign('sekolah')
                ->references('id')
                ->on('program_studi')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->double('smt1');
            $table->double('smt2');
            $table->double('smt3');
            $table->double('smt4');
            $table->double('smt5');
            $table->double('smt6');
            $table->string('berkas_siswa');//kk akte ijazah raport penghasilan
            $table->string('prestasi')->nullable();


            $table->boolean('status');
            $table->datetime('tgl_pendaftaran');
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
        Schema::dropIfExists('pendaftaran');
    }
}