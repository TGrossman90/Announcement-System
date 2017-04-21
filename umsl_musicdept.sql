--
-- umsl_musicdept.sql
-- Created by Tom Grossman on 3/24/2017
-- Copyright © 2017 Tom Grossman. All Rights Reserved
--

-- Server version: 5.5.54-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `umsl_musicdept`
--

CREATE DATABASE IF NOT EXISTS `umsl_musicdept` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `umsl_musicdept`;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`groupName` varchar(32) NOT NULL,
	`groupParent` varchar(32)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `groups` (`groupName`) VALUES (".None");

-- --------------------------------------------------------

--
-- Table structure for table `allusers`
--

CREATE TABLE IF NOT EXISTS `allusers` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL,
	`password` varchar(64) NOT NULL,
	`mobile` varchar(32) NOT NULL,
	`userLevel` int(11) NOT NULL DEFAULT '10',
	`verification` varchar(63) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL,
	`dateSent` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`priority` varchar(7) NOT NULL,
	`author` varchar(32) NOT NULL,
	`subject` varchar (32) NOT NULL,
	`announcement` varchar(255) NOT NULL,
	`hashkey` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facultyViewPermissions`
--

CREATE TABLE IF NOT EXISTS `facultyViewPermissions` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL,
	`groupName` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Intial setup queries
--

INSERT INTO `users`(`username`, `password`, `userLevel`, `verification`) 
	VALUES ('admin','$2y$10$OdhFrsFL1YUQp8tVVHqUXeyBfG1C.LTOnWf5ARCNyo0ArrbeXI3Ii', '100', 'verified');
	
INSERT INTO `groups`(`groupName`) 
	VALUES ('allusers');
	
INSERT INTO `groups`(`groupName`) 
	VALUES ('faculty');
	
-- Password for admin account is defaulted to "password"