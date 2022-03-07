<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
    		$table->integer('id_kelas')->length(10);
    		$table->integer('id_admin',10);
    		$table->char('kelas',1);
        });

    }

    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}