-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2024 at 01:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courtspotter`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminUsername` varchar(20) NOT NULL,
  `adminPassword` varchar(20) NOT NULL,
  `adminFirstName` varchar(20) DEFAULT NULL,
  `adminLastName` varchar(20) DEFAULT NULL,
  `adminGender` varchar(6) DEFAULT NULL,
  `adminNRIC` varchar(20) DEFAULT NULL,
  `adminPhone` varchar(15) DEFAULT NULL,
  `adminEmail` varchar(20) DEFAULT NULL,
  `adminAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminUsername`, `adminPassword`, `adminFirstName`, `adminLastName`, `adminGender`, `adminNRIC`, `adminPhone`, `adminEmail`, `adminAddress`) VALUES
('admin123', 'password', 'Sang', 'Admin', NULL, NULL, '0', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingID` varchar(50) NOT NULL,
  `courtID` varchar(15) NOT NULL,
  `userUsername` varchar(20) NOT NULL,
  `bookingDate` date NOT NULL,
  `bookingStartTime` time NOT NULL,
  `bookingEndTime` time NOT NULL,
  `bookingDuration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingID`, `courtID`, `userUsername`, `bookingDate`, `bookingStartTime`, `bookingEndTime`, `bookingDuration`) VALUES
('adil_1708737051_7175', 'Bdmntn01', 'adil', '2024-02-24', '14:00:00', '16:00:00', 2),
('amsyar_nz_1708480018_7314', 'Bdmntn01', 'amsyar_nz', '2024-02-29', '12:00:00', '13:00:00', 1),
('amsyar_nz_1708480051_5610', 'Ftsl02', 'amsyar_nz', '2024-02-29', '08:00:00', '11:00:00', 3),
('amsyar_nz_1708480350_2524', 'Bdmntn08', 'amsyar_nz', '2024-02-28', '12:00:00', '15:00:00', 3),
('amsyar_nz_1708480532_3050', 'Bdmntn05', 'amsyar_nz', '2024-02-26', '12:00:00', '13:00:00', 1),
('amsyar_nz_1708737026_5344', 'Ftsl03', 'amsyar_nz', '2024-02-24', '10:00:00', '12:00:00', 2),
('amsyar_nz_1708758236_3191', 'Bdmntn06', 'amsyar_nz', '2024-02-24', '16:00:00', '17:00:00', 1),
('amsyar_nz_1708763421_8178', 'Ftsl06', 'amsyar_nz', '2024-02-26', '20:00:00', '23:00:00', 3),
('aris_1708766888_5246', 'Bdmntn03', 'aris', '2024-02-25', '08:00:00', '09:00:00', 1),
('aris_1708767411_9551', 'Bdmntn01', 'aris', '2024-02-24', '18:00:00', '21:00:00', 3),
('aris_1708767424_9148', 'Bdmntn01', 'aris', '2024-02-27', '12:00:00', '15:00:00', 3),
('qyhaaaa_1708673905_5289', 'Bdmntn01', 'qyhaaaa', '2024-02-24', '23:00:00', '02:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `courtinfo`
--

CREATE TABLE `courtinfo` (
  `courtID` varchar(11) NOT NULL,
  `courtType` varchar(20) NOT NULL,
  `courtName` varchar(15) NOT NULL,
  `courtPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courtinfo`
--

INSERT INTO `courtinfo` (`courtID`, `courtType`, `courtName`, `courtPrice`) VALUES
('Bdmntn01', 'Badminton', 'Badminton 01', 40),
('Bdmntn02', 'Badminton ', 'Badminton 02', 40),
('Bdmntn03', 'Badminton', 'Badminton 03', 40),
('Bdmntn04', 'Badminton', 'Badminton 04', 40),
('Bdmntn05', 'Badminton', 'Badminton 05', 30),
('Bdmntn06', 'Badminton ', 'Badminton 06', 30),
('Bdmntn07', 'Badminton', 'Badminton 07', 30),
('Bdmntn08', 'Badminton', 'Badminton 08', 30),
('Ftsl01', 'Futsal', 'Futsal 01', 100),
('Ftsl02', 'Futsal', 'Futsal 02', 100),
('Ftsl03', 'Futsal', 'Futsal 03', 100),
('Ftsl04', 'Futsal', 'Futsal 04', 120),
('Ftsl05', 'Futsal', 'Futsal 05', 120),
('Ftsl06', 'Futsal', 'Futsal 06', 120);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` varchar(100) NOT NULL,
  `userUsername` varchar(20) NOT NULL,
  `userFirstName` varchar(20) NOT NULL,
  `userLastName` varchar(20) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPhone` varchar(15) NOT NULL,
  `feedbackType` varchar(30) NOT NULL,
  `feedbackDescription` varchar(255) NOT NULL,
  `feedbackStatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackID`, `userUsername`, `userFirstName`, `userLastName`, `userEmail`, `userPhone`, `feedbackType`, `feedbackDescription`, `feedbackStatus`) VALUES
('amsyar_nz_1708743810', 'amsyar_nz', 'Amsyar', 'Zahran', 'amsyar.zahran@gmail.com', '+601128253665', 'Improvement Recommendation', 'Please add more toilet ', 'Submitted'),
('amsyar_nz_1708743828', 'amsyar_nz', 'Amsyar', 'Zahran', 'amsyar.zahran@gmail.com', '+601128253665', 'Complaint', 'The trash bin is not emptied on time, too much rubbish', 'Submitted');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` varchar(20) NOT NULL,
  `bookingID` varchar(20) NOT NULL,
  `paymentMethod` varchar(20) NOT NULL,
  `paymentPrice` varchar(20) NOT NULL,
  `paymentReciept` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userUsername` varchar(20) NOT NULL,
  `userFirstName` varchar(20) DEFAULT NULL,
  `userLastName` varchar(20) DEFAULT NULL,
  `userNRIC` varchar(15) DEFAULT NULL,
  `userPassword` varchar(20) NOT NULL,
  `userGender` varchar(6) DEFAULT NULL,
  `userPhone` varchar(15) DEFAULT NULL,
  `userEmail` varchar(50) DEFAULT NULL,
  `userAddress` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userUsername`, `userFirstName`, `userLastName`, `userNRIC`, `userPassword`, `userGender`, `userPhone`, `userEmail`, `userAddress`) VALUES
('adil', 'adil', 'hakimi', '020829100654', '123456', 'Male', '01887263475', 'adil@gmail.com', 'no 35 jalan sp 1/4 taman seri pristana'),
('amsyar_nz', 'Amsyar', 'Zahran', '020210140197', 'password', 'Male', '+601128253665', 'amsyar.zahran@gmail.com', 'No 36, Lot 1175, Kampung Haji Pahlil,  Batu 15 Dusun Tua, 43100, Hulu Langat, Selangor'),
('aris', 'aris', 'aziz', '020428040053', 'aris28', 'male', '01151638420', NULL, 'masjid tanah, melaka'),
('marchensem', 'marc', 'jonathan', '020222141480', 'Mjchdk0207.', 'Male', '01116573288', 'marccjonathan@gmail.com', 'No 36, Lot 1175, Kampung Haji Pahlil, Batu 15 Dusun Tua, 43100, Hulu Langat, Selangor'),
('newuser', 'new', 'user', '0202131097', 'password', 'male', '01128753775', NULL, 'Unisel Bestari Jaya'),
('newuser123', '123', 'user', '326426543', '123', 'female', '4325613541352', NULL, 'No 36, Lot 1175, Kampung Haji Pahlil, Batu 15 Dusun Tua, 43100, Hulu Langat, Selangor'),
('norgenji', 'Aizat', 'Comey', '020718100181', '123', 'Male', '0125339257', 'aizatdanial02@gmail.com', 'Ulu Klang'),
('qyhaaaa', 'Faqihah', 'Insyirah', '030817110552', 'password', 'Male', '0188727579', 'faqihah.insyirah@gmail.com', 'Jerteh Terengganu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminUsername`),
  ADD UNIQUE KEY `adminNRIC` (`adminNRIC`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingID`);

--
-- Indexes for table `courtinfo`
--
ALTER TABLE `courtinfo`
  ADD PRIMARY KEY (`courtID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userUsername`),
  ADD UNIQUE KEY `userNRIC` (`userNRIC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
