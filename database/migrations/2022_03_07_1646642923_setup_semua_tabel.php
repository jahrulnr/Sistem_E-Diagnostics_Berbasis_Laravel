<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SetupTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE `admin` MODIFY `id_admin` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT');
        DB::statement('ALTER TABLE `jawaban` MODIFY `id_jawaban` int(100) NOT NULL PRIMARY KEY AUTO_INCREMENT');
        DB::statement('ALTER TABLE `kelas` MODIFY `id_kelas` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT');
        DB::statement('ALTER TABLE `mahasiswa` ADD PRIMARY KEY (`npm`)');
        DB::statement('ALTER TABLE `materi` MODIFY `id_materi` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT');
        DB::statement('ALTER TABLE `nilai` MODIFY `id_nilai` int(100) NOT NULL PRIMARY KEY AUTO_INCREMENT');
        DB::statement('ALTER TABLE `soal` MODIFY `id_soal` int(100) NOT NULL PRIMARY KEY AUTO_INCREMENT');

        DB::statement('ALTER TABLE `jawaban` ADD CONSTRAINT `j_npm` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `j_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE');
        DB::statement('ALTER TABLE `kelas` ADD CONSTRAINT `kls_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE');
        DB::statement('ALTER TABLE `mahasiswa` ADD CONSTRAINT `kls_mhs` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL ON UPDATE NO ACTION');
        DB::statement('ALTER TABLE `nilai` ADD CONSTRAINT `n_mahasiswa` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `n_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE');
        DB::statement('ALTER TABLE `soal` ADD CONSTRAINT `s_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `s_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE');

        DB::table('admin')
            ->insert([
                'email' => 'admin@gmail.com', 
                'nama_dsn' => 'Jahrulnr', 
                'noHP' => '082218594993', 
                'password' => bcrypt('admin'), 
                'hak_akses' => 'admin'
            ]);
    }

    public function down()
    {
    }
}