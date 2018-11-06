-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2018 at 04:06 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta`
--
CREATE DATABASE IF NOT EXISTS `ta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ta`;

-- --------------------------------------------------------

--
-- Stand-in structure for view `allvu`
-- (See below for the actual view)
--
CREATE TABLE `allvu` (
`nim` varchar(12)
,`id` int(11)
,`nama_dpn` text
,`nama_blkg` text
,`kelas` text
,`hobi` text
,`genre` text
,`wisata` text
,`tanggal` text
,`username` text
,`password` text
,`email` text
);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nama_dpn` text NOT NULL,
  `nama_blkg` text NOT NULL,
  `nim` varchar(12) NOT NULL,
  `kelas` text NOT NULL,
  `hobi` text NOT NULL,
  `genre` text NOT NULL,
  `wisata` text NOT NULL,
  `tanggal` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nim` varchar(12) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `allvu`
--
DROP TABLE IF EXISTS `allvu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `allvu`  AS  select `mahasiswa`.`nim` AS `nim`,`mahasiswa`.`id` AS `id`,`mahasiswa`.`nama_dpn` AS `nama_dpn`,`mahasiswa`.`nama_blkg` AS `nama_blkg`,`mahasiswa`.`kelas` AS `kelas`,`mahasiswa`.`hobi` AS `hobi`,`mahasiswa`.`genre` AS `genre`,`mahasiswa`.`wisata` AS `wisata`,`mahasiswa`.`tanggal` AS `tanggal`,`user`.`username` AS `username`,`user`.`password` AS `password`,`user`.`email` AS `email` from (`mahasiswa` join `user` on((`mahasiswa`.`nim` = `user`.`nim`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `user` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
