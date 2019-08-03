-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2019 at 02:36 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--
CREATE DATABASE IF NOT EXISTS `tms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tms`;

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

DROP TABLE IF EXISTS `discussion`;
CREATE TABLE IF NOT EXISTS `discussion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tasks_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `discussion`
--

TRUNCATE TABLE `discussion`;
-- --------------------------------------------------------

--
-- Table structure for table `discussion_attachment`
--

DROP TABLE IF EXISTS `discussion_attachment`;
CREATE TABLE IF NOT EXISTS `discussion_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discussion_id` int(11) NOT NULL,
  `file_details_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `discussion_attachment`
--

TRUNCATE TABLE `discussion_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `file_details`
--

DROP TABLE IF EXISTS `file_details`;
CREATE TABLE IF NOT EXISTS `file_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_original_name` varchar(255) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `file_ext` varchar(5) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` enum('profile_pic','task_attachment','comment_attachment') NOT NULL DEFAULT 'comment_attachment',
  `users_id` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `file_details`
--

TRUNCATE TABLE `file_details`;
-- --------------------------------------------------------

--
-- Table structure for table `market_visit`
--

DROP TABLE IF EXISTS `market_visit`;
CREATE TABLE IF NOT EXISTS `market_visit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `company_address` text,
  `company_phone` varchar(15) DEFAULT NULL,
  `company_email` varchar(45) DEFAULT NULL,
  `company_website` varchar(45) DEFAULT NULL,
  `brief` text NOT NULL,
  `followup_date` date NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `market_visit`
--

TRUNCATE TABLE `market_visit`;
-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_users_id` int(11) NOT NULL,
  `to_users_id` int(11) NOT NULL,
  `table` enum('projects','tasks','discussion','market_visit','telemerketing') NOT NULL,
  `table_id` int(11) NOT NULL,
  `notice` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('read','unread') NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `notification`
--

TRUNCATE TABLE `notification`;
-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `clients_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `projects`
--

TRUNCATE TABLE `projects`;
-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projects_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `priority` enum('high','medium','low') NOT NULL DEFAULT 'low',
  `duration` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `asign_to` int(11) NOT NULL DEFAULT '0',
  `status` enum('ongoing','queued','completed') NOT NULL DEFAULT 'queued',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `tasks`
--

TRUNCATE TABLE `tasks`;
-- --------------------------------------------------------

--
-- Table structure for table `task_attachment`
--

DROP TABLE IF EXISTS `task_attachment`;
CREATE TABLE IF NOT EXISTS `task_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tasks_id` int(11) NOT NULL DEFAULT '0',
  `file_details_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `task_attachment`
--

TRUNCATE TABLE `task_attachment`;
-- --------------------------------------------------------

--
-- Table structure for table `telemerketing`
--

DROP TABLE IF EXISTS `telemerketing`;
CREATE TABLE IF NOT EXISTS `telemerketing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) DEFAULT NULL,
  `company_name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `company_phone` varchar(15) NOT NULL,
  `brief` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `telemerketing`
--

TRUNCATE TABLE `telemerketing`;
-- --------------------------------------------------------

--
-- Table structure for table `temp_file_upload`
--

DROP TABLE IF EXISTS `temp_file_upload`;
CREATE TABLE IF NOT EXISTS `temp_file_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_details_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `attach_table` enum('tasks','discussion','users') NOT NULL DEFAULT 'tasks',
  `status` enum('queued','done') NOT NULL DEFAULT 'queued',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `temp_file_upload`
--

TRUNCATE TABLE `temp_file_upload`;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` enum('admin','developer','marketing','client') NOT NULL DEFAULT 'client',
  `profile_pic_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_UNIQUE` (`username`),
  UNIQUE KEY `users_email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `type`, `profile_pic_id`, `status`) VALUES
(1, 'Azim', 'Uddin Tipu', 'azim', 'azim@intensebd.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', NULL, 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
