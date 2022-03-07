<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
    		$table->string('npm')->length(9)->unsigned();
    		$table->string('email',60);
    		$table->string('nama_mhs',60);
    		$table->integer('id_kelas',10)->nullable()->default('NULL');
    		$table->char('password',60);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}