-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2015 at 02:33 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phalcon`
--

-- --------------------------------------------------------

--
-- Table structure for table `motorbikes`
--

CREATE TABLE IF NOT EXISTS `motorbikes` (
`id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `motorbikes`
--

INSERT INTO `motorbikes` (`id`, `name`) VALUES
(11, '123456'),
(12, '123456'),
(13, '123456'),
(14, '123456'),
(15, '123456'),
(16, '123456'),
(17, '123456'),
(18, '123456'),
(19, '123456'),
(20, '123456'),
(21, '123456'),
(22, '1234564'),
(23, '1234564333'),
(24, '1234564333er'),
(25, '1234564333er'),
(26, '1234564333ersc'),
(27, '1234564333erscer'),
(28, 'scsc'),
(29, 'asdfsdfsdf'),
(30, '878787'),
(31, 'scscsc'),
(32, 'ccc'),
(33, '98999'),
(34, '515151');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `motorbikes`
--
ALTER TABLE `motorbikes`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `motorbikes`
--
ALTER TABLE `motorbikes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
