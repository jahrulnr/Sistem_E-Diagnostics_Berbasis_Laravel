

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelasTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `kelas` (
  `id_kelas` int(10) NOT NULL AUTO_INCREMENT,
  `id_admin` int(10) NOT NULL,
  `kelas` char(1) NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `kls_id_admin` (`id_admin`),
  CONSTRAINT `kls_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
        // ["id_kelas","int(10)",null,"NO","PRI",null,"auto_increment","select,insert,update,references",""]
            $table->integer('id_kelas');
        // ["id_admin","int(10)",null,"NO","MUL",null,"","select,insert,update,references",""]
            $table->integer('id_admin');
        // ["kelas","char(1)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->char('kelas', 1);
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
        Schema::dropIfExists('kelas');
    }
}

