

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `soal` (
  `id_soal` int(100) NOT NULL AUTO_INCREMENT,
  `id_materi` int(10) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `soal` text NOT NULL,
  `jawaban_soal` text NOT NULL,
  PRIMARY KEY (`id_soal`),
  KEY `s_materi` (`id_materi`) USING BTREE,
  KEY `s_admin` (`id_admin`),
  CONSTRAINT `s_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `s_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('soal', function (Blueprint $table) {
        // ["id_soal","int(100)",null,"NO","PRI",null,"auto_increment","select,insert,update,references",""]
            $table->integer('id_soal');
        // ["id_materi","int(10)",null,"NO","MUL",null,"","select,insert,update,references",""]
            $table->integer('id_materi');
        // ["id_admin","int(10)",null,"NO","MUL",null,"","select,insert,update,references",""]
            $table->integer('id_admin');
        // ["soal","text","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->text('soal');
        // ["jawaban_soal","text","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->text('jawaban_soal');
            $table->index(["id_materi"]);
            $table->index(["id_admin"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soal');
    }
}

