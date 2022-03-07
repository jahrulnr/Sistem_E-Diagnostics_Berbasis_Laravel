<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
    		$table->integer('id_admin')->length(10)->unsigned();
    		$table->string('email',60);
    		$table->string('nama_dsn',30);
    		$table->string('noHP',12);
    		$table->char('password',60);
    		$table->enum('hak_akses',['admin','dosen']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
}