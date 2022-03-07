<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateTable extends Migration
{
    public function up()
    {
        $backup = __DIR__ . '/../ediagnostics.sql';
        DB::unprepared(file_get_contents($backup));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('mahasiswa');
    }
}

