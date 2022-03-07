<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTable extends Migration
{
    public function up()
    {
        Schema::create('jawaban', function (Blueprint $table) {
    		$table->integer('id_jawaban')->length(100)->unsigned();
    		$table->string('npm',9);
    		$table->integer('id_soal',100);
    		$table->text('jawaban_mhs');
        });
    
    }

    public function down()
    {
        Schema::dropIfExists('jawaban');
    }
}