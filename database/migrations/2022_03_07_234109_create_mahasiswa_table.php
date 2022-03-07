

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `mahasiswa` (
  `npm` varchar(9) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nama_mhs` varchar(60) NOT NULL,
  `id_kelas` int(10) DEFAULT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`npm`),
  KEY `kls_mhs` (`id_kelas`),
  CONSTRAINT `kls_mhs` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
        // ["npm","varchar(9)","utf8mb4_general_ci","NO","PRI",null,"","select,insert,update,references",""]
            $table->string('npm', 9);
        // ["email","varchar(60)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->string('email', 60);
        // ["nama_mhs","varchar(60)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->string('nama_mhs', 60);
        // ["id_kelas","int(10)",null,"YES","MUL",null,"","select,insert,update,references",""]
            $table->integer('id_kelas');
        // ["password","char(60)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->char('password', 60);
            $table->index(["id_kelas"]);
            $table->primary(["npm"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}

