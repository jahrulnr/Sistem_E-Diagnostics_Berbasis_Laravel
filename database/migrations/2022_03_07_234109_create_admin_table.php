

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `nama_dsn` varchar(30) NOT NULL,
  `noHP` varchar(12) NOT NULL,
  `password` char(60) NOT NULL,
  `hak_akses` enum('admin','dosen') NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
        // ["id_admin","int(10)",null,"NO","PRI",null,"auto_increment","select,insert,update,references",""]
            $table->integer('id_admin');
        // ["email","varchar(60)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->string('email', 60);
        // ["nama_dsn","varchar(30)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->string('nama_dsn', 30);
        // ["noHP","varchar(12)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->string('noHP', 12);
        // ["password","char(60)","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->char('password', 60);
        // ["hak_akses","enum('admin','dosen')","utf8mb4_general_ci","NO","",null,"","select,insert,update,references",""]
            $table->enum('hak_akses', ['admin', 'dosen']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}

