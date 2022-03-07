<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriTable extends Migration
{
    public function up()
    {
        Schema::create('materi', function (Blueprint $table) {
    		$table->integer('id_materi')->length(10)->unsigned();
    		$table->string('judul_materi',60);
    		$table->integer('pertemuan',3);
        });
    }

    public function down()
    {
        Schema::dropIfExists('materi');
    }
}