<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalTable extends Migration
{
    public function up()
    {
        Schema::create('soal', function (Blueprint $table) {
    		$table->integer('id_soal',100);
    		$table->integer('id_materi',10);
    		$table->integer('id_admin',10);
    		$table->text('soal');
    		$table->text('jawaban_soal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('soal');
    }
}