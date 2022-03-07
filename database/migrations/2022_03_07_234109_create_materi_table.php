

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `materi` (
  `id_materi` int(10) NOT NULL AUTO_INCREMENT,
  `judul_materi` varchar(60) NOT NULL,
  `pertemuan` int(3) NOT NULL,
  PRIMARY KEY (`id_materi`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('materi', function (Blueprint $table) {
        // ["id_materi","int(10)",null,"NO","PRI",null,"auto_increment","select,insert,update,references",""]
            $table->integer('id_materi');
        // ["judul_materi","varchar(60)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->string('judul_materi', 60);
        // ["pertemuan","int(3)",null,"NO","",null,"","select,insert,update,references",""]
            $table->integer('pertemuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materi');
    }
}

