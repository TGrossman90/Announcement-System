-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2017 at 10:12 PM
-- Server version: 5.5.55-0+deb8u1
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
-- Table structure for table `allusers`
--

CREATE TABLE IF NOT EXISTS `allusers` (
`id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
`id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `dateSent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `priority` varchar(7) NOT NULL,
  `author` varchar(32) NOT NULL,
  `subject` varchar(32) NOT NULL,
  `announcement` varchar(255) NOT NULL,
  `hashkey` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
`id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facultyViewPermissions`
--

CREATE TABLE IF NOT EXISTS `facultyViewPermissions` (
`id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `groupName` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(11) NOT NULL,
  `groupName` varchar(32) NOT NULL,
  `groupParent` varchar(32) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `optstatus` tinyint(4) NOT NULL,
  `userLevel` int(11) NOT NULL DEFAULT '10',
  `verification` varchar(63) NOT NULL,
  `passreset` varchar(128) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


--
-- Indexes for table `allusers`
--
ALTER TABLE `allusers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facultyViewPermissions`
--
ALTER TABLE `facultyViewPermissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);
 
--
-- Intial setup queries
--

INSERT INTO `users`(`username`, `name`, `password`, `userLevel`, `verification`) 
	VALUES ('admin', 'admin', '$2a$04$Yx.NFdE2a7oMeLpOSyZsHeq4kwOjjnJRd2tG904jBMXMPXnhoPa3W', '100', 'verified');
	
INSERT INTO `groups`(`groupName`) 
	VALUES ('allusers');
	
INSERT INTO `groups`(`groupName`) 
	VALUES ('faculty');

--
-- Default Admin Login
-- User: admin
-- Password: password
--