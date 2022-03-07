

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `nilai` (
  `id_nilai` int(100) NOT NULL AUTO_INCREMENT,
  `npm` varchar(9) NOT NULL,
  `id_materi` int(10) NOT NULL,
  `nilai_akhir` int(100) NOT NULL,
  PRIMARY KEY (`id_nilai`),
  KEY `n_materi` (`id_materi`),
  KEY `n_mahasiswa` (`npm`),
  CONSTRAINT `n_mahasiswa` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `n_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
        // ["id_nilai","int(100)",null,"NO","PRI",null,"auto_increment","select,insert,update,references",""]
            $table->integer('id_nilai');
        // ["npm","varchar(9)","utf8mb4_general_ci","NO","MUL",null,"","select,insert,update,references",""]
            $table->string('npm', 9);
        // ["id_materi","int(10)",null,"NO","MUL",null,"","select,insert,update,references",""]
            $table->integer('id_materi');
        // ["nilai_akhir","int(100)",null,"NO","",null,"","select,insert,update,references",""]
            $table->integer('nilai_akhir');
            $table->index(["id_materi"]);
            $table->index(["npm"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai');
    }
}

