-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 13, 2018 at 02:52 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id4437658_fuzzycreatures_db`
--
CREATE DATABASE IF NOT EXISTS `id4437658_fuzzycreatures_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id4437658_fuzzycreatures_db`;

-- --------------------------------------------------------

--
-- Table structure for table `ear_genes`
--

CREATE TABLE `ear_genes` (
  `eid` int(11) NOT NULL,
  `ear_type` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ear_length` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ear_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eye_genes`
--

CREATE TABLE `eye_genes` (
  `eid` int(11) NOT NULL,
  `eye_gene` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eye_color` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eye_url` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eye_shader` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fur_genes`
--

CREATE TABLE `fur_genes` (
  `fid` int(11) NOT NULL,
  `fur_length` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fur_color` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fur_shader` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fur_image` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuzzy_creatures`
--

CREATE TABLE `fuzzy_creatures` (
  `fid` int(10) NOT NULL,
  `name` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eye_color` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eye_type` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eye_shader` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fur_color` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fur_length` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fur_shader` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mouth_size` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mouth_type` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wing_size` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wing_type` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ear_type` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ear_length` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `fur_color2` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `fur_color3` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `fur_color4` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fuzzy_creatures`
--

INSERT INTO `fuzzy_creatures` (`fid`, `name`, `eye_color`, `eye_type`, `eye_shader`, `fur_color`, `fur_length`, `fur_shader`, `mouth_size`, `mouth_type`, `wing_size`, `wing_type`, `ear_type`, `ear_length`, `fur_color2`, `fur_color3`, `fur_color4`) VALUES
(1, 'Terris', 'R', 'R', NULL, 'r', NULL, NULL, 'M', 'm', NULL, NULL, NULL, 'h', 'r', 'b', 'b');

-- --------------------------------------------------------

--
-- Table structure for table `mouth_genes`
--

CREATE TABLE `mouth_genes` (
  `mid` int(11) NOT NULL,
  `mouth_type` int(3) NOT NULL,
  `mouth_size` int(3) NOT NULL,
  `mouth_image` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wing_genes`
--

CREATE TABLE `wing_genes` (
  `wid` int(11) NOT NULL,
  `wing_size` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `wing_type` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `wing_image` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ear_genes`
--
ALTER TABLE `ear_genes`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `eye_genes`
--
ALTER TABLE `eye_genes`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `fur_genes`
--
ALTER TABLE `fur_genes`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `fuzzy_creatures`
--
ALTER TABLE `fuzzy_creatures`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `mouth_genes`
--
ALTER TABLE `mouth_genes`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `wing_genes`
--
ALTER TABLE `wing_genes`
  ADD PRIMARY KEY (`wid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ear_genes`
--
ALTER TABLE `ear_genes`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eye_genes`
--
ALTER TABLE `eye_genes`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fur_genes`
--
ALTER TABLE `fur_genes`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuzzy_creatures`
--
ALTER TABLE `fuzzy_creatures`
  MODIFY `fid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mouth_genes`
--
ALTER TABLE `mouth_genes`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wing_genes`
--
ALTER TABLE `wing_genes`
  MODIFY `wid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
