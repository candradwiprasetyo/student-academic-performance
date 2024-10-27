-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 06:14 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_academic_performance`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `area_name`) VALUES
(1, 'Perkotaan Besar'),
(2, 'Pinggiran Kota'),
(3, 'Desa');

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `campus_id` int(11) NOT NULL,
  `campus_name` varchar(100) NOT NULL,
  `campus_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`campus_id`, `campus_name`, `campus_address`) VALUES
(1, 'Kampus Syahdan', 'Jl. K H. Syahdan No. 9, Kelurahan Kemanggisan, Kecamatan Palmerah, Jakarta Barat 11480'),
(2, 'Kampus Anggrek', 'Jl. Kebon Jeruk Raya No. 27, Kebon Jeruk, Jakarta Barat 11530'),
(3, 'Kampus Kijang', 'Jl. Kemanggisan Ilir III No. 45, Kelurahan Kemanggisan, Jakarta Barat 11480'),
(4, 'Kampus Alam Sutera', 'Jl. Jalur Sutera Barat, Alam Sutera, Kota Tangerang 15143'),
(5, 'Kampus JWC', 'Jl. Hang Lekir I No. 6, Senayan, Jakarta Selatan 10270'),
(6, 'Kampus Bekasi', 'Jalan Lingkar Boulevar Blok WA No.1 Summarecon Bekasi Kel, Marga Mulya, Kec. Bekasi Utara, Kota Bekasi, Jawa Barat 17142'),
(7, 'Kampus Bandung', 'Jalan Pasir Kaliki No. 25-27, Kebon Jeruk, Andir, Kb. Jeruk, Kec. Andir, Kota Bandung, Jawa Barat 40181'),
(8, 'Kampus Malang', 'Jalan Araya Mansion No. 8-22 Araya, Purwodadi, Kec. Blimbing, Kota Malang, Jawa Timur 65126'),
(9, 'Kampus Semarang', 'POJ Avenue Kav. 3 (Gedung C) Kel. Tawangsari, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50144');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_gpa` decimal(3,2) NOT NULL,
  `student_transportation_access_score` int(11) NOT NULL,
  `student_distance_to_campus_km` decimal(5,0) NOT NULL,
  `student_address` varchar(255) NOT NULL,
  `student_enrollment_year` year(4) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `campus_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `student_gpa`, `student_transportation_access_score`, `student_distance_to_campus_km`, `student_address`, `student_enrollment_year`, `area_id`, `campus_id`) VALUES
(1, 'Andi Santoso', 3.50, 8, 3, 'Jl. Raya Kebon Jeruk No. 1, Jakarta', '2021', 1, 3),
(2, 'Budi Setiawan', 3.75, 9, 1, 'Jl. Sudirman No. 45, Jakarta', '2022', 2, 7),
(3, 'Cindy Li', 3.80, 8, 3, 'Jl. Melati No. 10, Jakarta', '2023', 1, 2),
(4, 'Dewi Anggraini', 3.60, 7, 4, 'Jl. Cendana No. 5, Jakarta', '2020', 2, 9),
(5, 'Eko Prabowo', 3.40, 7, 2, 'Jl. Jend. Sudirman No. 15, Jakarta', '2021', 1, 5),
(6, 'Fina Nurbani', 3.90, 9, 2, 'Jl. Anggrek No. 12, Jakarta', '2022', 3, 1),
(7, 'Gilang Rahardjo', 3.20, 6, 5, 'Jl. Kuningan No. 20, Jakarta', '2023', 1, 6),
(8, 'Hani Sofiana', 3.85, 5, 3, 'Jl. Taman No. 18, Jakarta', '2020', 2, 4),
(9, 'Iwan Kurniawan', 3.55, 7, 3, 'Jl. Pahlawan No. 25, Jakarta', '2024', 3, 8),
(10, 'Joko Widodo', 3.45, 8, 5, 'Jl. Merpati No. 3, Jakarta', '2021', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'Candra', 'candra@gmail.com', '$2y$10$M16t8RwVy1TGKBqr02crv.SAqPR9yQB/btynvaFxfRRvFu5ARCnau');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`campus_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `campus_id` (`campus_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `campus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`campus_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
