-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 03:36 AM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filemanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(129) NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `email`) VALUES
(1, 'Andrew', '47278066fd0526ed8ca9cb4da765fc0217ab2664bba446d20ecb1985d2ce04021abf2ea2963bbda1da2333b03f6bd8fbc100297c5cb0c1aa5ba9eb66cabd8785', 'andrew_guterman@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `path` varchar(256) NOT NULL,
  `name` varchar(128) NOT NULL,
  `fileid` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user`, `path`, `name`, `fileid`) VALUES
(1, 1, 'C:/xampp/uploads/c4ca4238a0b9', 'vacation.png', 'c4ca4238a0b9'),
(2, 1, 'C:/xampp/uploads/c81e728d9d4c', 'buttsecks.png', 'c81e728d9d4c'),
(3, 1, 'C:/xampp/uploads/eccbc87e4b5c', 'filemanager.jpg', 'eccbc87e4b5c'),
(4, 1, 'C:/xampp/uploads/a87ff679a2f3', 'forums.png', 'a87ff679a2f3'),
(5, 1, 'C:/xampp/uploads/e4da3b7fbbce', 'geolocator.png', 'e4da3b7fbbce'),
(6, 1, 'C:/xampp/uploads/1679091c5a88', 'offtoyou.jpg', '1679091c5a88'),
(7, 1, 'C:/xampp/uploads/8f14e45fceea', 'sflimo.jpg', '8f14e45fceea'),
(8, 1, 'C:/xampp/uploads/c9f0f895fb98', 'ucp.jpg', 'c9f0f895fb98'),
(9, 1, 'C:/xampp/uploads/45c48cce2e2d', 'lawless.txt', '45c48cce2e2d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
