<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
    		$table->integer('id_nilai',100);
    		$table->string('npm',9);
    		$table->integer('id_materi',10);
    		$table->integer('nilai_akhir',100);
        });

    }

    public function down()
    {
        Schema::dropIfExists('nilai');
    }
}