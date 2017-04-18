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
-- Table structure for table `stringGroup`
--

CREATE TABLE IF NOT EXISTS `stringGroup` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `windsPercussionGroup`
--

CREATE TABLE IF NOT EXISTS `windsPercussionGroup` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vocalGroup`
--

CREATE TABLE IF NOT EXISTS `vocalGroup` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departmentWideGroup`
--

CREATE TABLE IF NOT EXISTS `departmentWideGroup` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `musicEdGroup`
--

CREATE TABLE IF NOT EXISTS `musicEdGroup` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facAdminUsers`
--

CREATE TABLE IF NOT EXISTS `facAdminUsers` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` varchar(32) NOT NULL,
	`permissions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `studentUsers`
--

CREATE TABLE IF NOT EXISTS `studentUsers` (
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
	`userLevel` int(11) NOT NULL DEFAULT '10'
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
	`announcement` varchar(255) NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
