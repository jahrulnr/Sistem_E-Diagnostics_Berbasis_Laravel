

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `jawaban` (
  `id_jawaban` int(100) NOT NULL AUTO_INCREMENT,
  `npm` varchar(9) NOT NULL,
  `id_soal` int(100) NOT NULL,
  `jawaban_mhs` text NOT NULL,
  PRIMARY KEY (`id_jawaban`),
  KEY `j_npm` (`npm`),
  KEY `j_soal` (`id_soal`),
  CONSTRAINT `j_npm` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `j_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban', function (Blueprint $table) {
        // ["id_jawaban","int(100)",null,"NO","PRI",null,"auto_increment","select,insert,update,references",""]
            $table->integer('id_jawaban');
        // ["npm","varchar(9)","utf8mb4_general_ci","NO","MUL",null,"","select,insert,update,references",""]
            $table->string('npm', 9);
        // ["id_soal","int(100)",null,"NO","MUL",null,"","select,insert,update,references",""]
            $table->integer('id_soal');
        // ["jawaban_mhs","text","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->text('jawaban_mhs');
            $table->index(["npm"]);
            $table->index(["id_soal"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban');
    }
}

