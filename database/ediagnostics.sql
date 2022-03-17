-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2022 at 02:51 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ediagnostics`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(10) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nama_dsn` varchar(30) NOT NULL,
  `noHP` varchar(12) NOT NULL,
  `password` char(60) NOT NULL,
  `hak_akses` enum('admin','dosen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `email`, `nama_dsn`, `noHP`, `password`, `hak_akses`) VALUES
(1, 'jahrulnr@gmail.com', 'Jahrulnrr', '082218594993', '$2a$12$royGgfCsGcm/KvDy9rcBjejcKh/2ARrFcwJLz9Wd389QbeZqlNovS', 'admin'),
(10, 'dosen@gmail.com', 'Contoh nama dosen', '088221859499', '$2y$10$NLCBH0JSN2SJTKmTuyztC.qWu694RfSga9l/WsDBkYbUIhujWL/QC', 'dosen'),
(11, 'dosen@gmail.com1', 'Contoh nama 2', '088221859499', '$2y$10$k6IbcUVFgnCw3VJApL7CWeSAhsXEu9lwMQwgHaM8vwxorh/Ka.zZ6', 'dosen');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(10) NOT NULL,
  `npm` varchar(9) NOT NULL,
  `id_soal` int(10) NOT NULL,
  `jawaban_mhs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `npm`, `id_soal`, `jawaban_mhs`) VALUES
(1, '173510428', 1, 'redirect(url()->previous() . \'#berhasil_disimpan\')'),
(2, '173510428', 2, 'if(!empty($data))\r\n			$db = DB::table(\'jawaban\')\r\n				->insert($data);'),
(3, '173510428', 3, '$data = [\r\n				\'npm\'	  	  => session(\'id\'),\r\n				\'id_soal\' 	  => $id,\r\n				\'jawaban_mhs\' => $jawaban\r\n			];'),
(4, '173510428', 4, 'DB::table(\'jawaban\')\r\n				->where(\'npm\', session(\'id\'))\r\n				->where(\'id_soal\', $id)\r\n				->exists()'),
(5, '173510428', 5, 'if($soal->jawaban_mhs != null){\r\n				$data[\'jawaban\'] = true;\r\n				break;\r\n			}'),
(6, '173510428', 6, '$data[\'soal\'] = DB::table(\'soal\')\r\n			->select([\'soal.*\', \'jawaban.jawaban_mhs\'])\r\n			->leftJoin(\'jawaban\', \'soal.id_soal\', \'jawaban.id_soal\')\r\n			->where(\'id_admin\', $data[\'dosen\']->id_admin)\r\n			->where(\'id_materi\', $id_materi);');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(10) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `kelas` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `id_admin`, `kelas`) VALUES
(1, 10, 'A'),
(2, 10, 'B'),
(3, 10, 'C'),
(4, 11, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `npm` varchar(9) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nama_mhs` varchar(60) NOT NULL,
  `id_kelas` int(10) DEFAULT NULL,
  `password` char(60) NOT NULL DEFAULT '$2a$12$M7F8mhRwCfsuCudFOJ9vnuOaC2Cew93qTjneDW7sqFMPbnRI.sAH2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`npm`, `email`, `nama_mhs`, `id_kelas`, `password`) VALUES
('173510001', 'mhs@contoh.co', 'Contoh Nama', 1, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510002', 'mhs@contoh.co', 'Contoh Nama', 2, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510003', 'mhs@contoh.co', 'Contoh Nama', 2, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510004', 'mhs@contoh.co', 'Contoh Nama', 3, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510005', 'mhs@contoh.co', 'Contoh Nama', 3, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510006', 'mhs@contoh.co', 'Contoh Nama', 4, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510007', 'mhs@contoh.co', 'Contoh Nama', 4, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC'),
('173510428', 'mhs@contoh.com', 'Contoh Nama', 1, '$2y$10$UsOu10AAxI/ZllxZLOKCo.uMeSAcIOgE50SH02o5bmil1eUhfSoHC');

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(10) NOT NULL,
  `judul_materi` varchar(60) NOT NULL,
  `pertemuan` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materi`
--

INSERT INTO `materi` (`id_materi`, `judul_materi`, `pertemuan`) VALUES
(2, 'Logika dan Algoritma Pemrograman', 1),
(3, 'Pengenalan Pascal', 2),
(4, 'Input dan Output Pemrograman Pascal', 3),
(5, 'Kondisi atau Percabangan', 5),
(6, 'Kondisi Bersarang', 6);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(10) NOT NULL,
  `npm` varchar(9) NOT NULL,
  `id_materi` int(10) NOT NULL,
  `nilai_akhir` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `npm`, `id_materi`, `nilai_akhir`) VALUES
(1, '173510428', 2, 58.2501);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(10) NOT NULL,
  `id_materi` int(10) NOT NULL,
  `id_admin` int(10) NOT NULL,
  `soal` text NOT NULL,
  `jawaban_soal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id_soal`, `id_materi`, `id_admin`, `soal`, `jawaban_soal`) VALUES
(1, 2, 10, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(2, 2, 10, 'tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(3, 2, 10, 'quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(4, 2, 10, 'consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(5, 2, 10, 'cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(6, 2, 10, 'proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `j_npm` (`npm`),
  ADD KEY `j_soal` (`id_soal`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kls_id_admin` (`id_admin`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`npm`),
  ADD KEY `kls_mhs` (`id_kelas`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `n_materi` (`id_materi`),
  ADD KEY `n_mahasiswa` (`npm`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `s_materi` (`id_materi`) USING BTREE,
  ADD KEY `s_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `j_npm` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `j_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kls_id_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `kls_mhs` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `n_mahasiswa` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `n_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `s_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `s_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
