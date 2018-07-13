-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 13, 2018 at 03:45 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timesheetapp`
--
CREATE DATABASE IF NOT EXISTS `timesheetapp` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `timesheetapp`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `add_clients`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_clients` ()  NO SQL
insert into client (name) VALUES
(
    'MITS'
),(
    'EIMS'
),(
    'BOJ'
),(
    'KSAMS'
),(
    'IOJ'
)$$

DROP PROCEDURE IF EXISTS `add_employees`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_employees` ()  NO SQL
insert into 
employee(user_name,	pword,first_name,last_name,active,address,position) 

VALUES('bwilliams',MD5('password'),'Bob','Williams',1,'1 Main Street, Townsville',2),
('swilliams',MD5('password'),'Sam','Williams',1,'2 Main Street, Townsville',3)
,
('lwilliams',MD5('password'),'Larry','Williams',1,'7 Main Street, Townsville',2)
,
('psmith',MD5('password'),'Perl','Smith',1,'16 Main Street, Townsville',2)
,
('jthomas',MD5('password'),'Janet','Thomas',1,'16 Beach Street, Townsville',1),
('lthomas',MD5('password'),'Lorraine','Thomas',1,'16 Beach Street, Townsville',3)$$

DROP PROCEDURE IF EXISTS `add_job_roles`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_job_roles` ()  NO SQL
insert into job_role (name) VALUES(
    'MANAGER'
),(
    'OFFICE EMPLOYEE'
),(
    'CONTRACTOR'
)$$

DROP PROCEDURE IF EXISTS `assign_managers`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `assign_managers` ()  NO SQL
insert into 
employee_manager(manager_id	,employee_id) 

VALUES(5,1),
(7,2)
,
(5,3)
,
(7,4)
,
(5,6)$$

DROP PROCEDURE IF EXISTS `login_user`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `login_user` (IN `uname` VARCHAR(255), IN `psword` VARCHAR(255), OUT `output` VARCHAR(255))  NO SQL
SELECT user_name into  @output FROM employee 
      WHERE user_name=@uname and pword=@psword$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` VALUES
(1, 'MITS'),
(2, 'EIMS'),
(3, 'BOJ'),
(4, 'KSAMS'),
(5, 'IOJ');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` VALUES
(1, 'bwilliams', '5f4dcc3b5aa765d61d8327deb882cf99', 'Bob', 'Williams', 1, '1 Main Street, Townsville', 2),
(2, 'swilliams', '5f4dcc3b5aa765d61d8327deb882cf99', 'Sam', 'Williams', 1, '2 Main Street, Townsville', 3),
(3, 'lwilliams', '5f4dcc3b5aa765d61d8327deb882cf99', 'Larry', 'Williams', 1, '7 Main Street, Townsville', 2),
(4, 'psmith', '5f4dcc3b5aa765d61d8327deb882cf99', 'Perl', 'Smith', 1, '16 Main Street, Townsville', 2),
(5, 'jthomas', '5f4dcc3b5aa765d61d8327deb882cf99', 'Janet', 'Thomas', 1, '16 Beach Street, Townsville', 1),
(6, 'lthomas', '5f4dcc3b5aa765d61d8327deb882cf99', 'Lorraine', 'Thomas', 1, '16 Beach Street, Townsville', 3),
(7, 'mfrans', '5f4dcc3b5aa765d61d8327deb882cf99', 'Mary', 'Frans', 1, '22 Steel Street', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_manager`
--

DROP TABLE IF EXISTS `employee_manager`;
CREATE TABLE IF NOT EXISTS `employee_manager` (
  `manager_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`manager_id`,`employee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_manager`
--

INSERT INTO `employee_manager` VALUES
(5, 1),
(5, 3),
(5, 6),
(7, 2),
(7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `job_role`
--

DROP TABLE IF EXISTS `job_role`;
CREATE TABLE IF NOT EXISTS `job_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_role`
--

INSERT INTO `job_role` VALUES
(1, 'MANAGER'),
(2, 'OFFICE EMPLOYEE'),
(3, 'CONTRACTOR');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `comments` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` VALUES
(1, 'testupdate', 1, 1, '2010-04-04', '08:20:00', '16:20:00', 'testingupdatequery'),
(2, 'sectest', 1, 1, '1989-11-20', '08:30:00', '21:40:00', 'seconding'),
(3, 'thirdtest', 2, 1, '1991-03-30', '08:20:00', '10:10:00', 'third up'),
(4, 'test', 1, 1, '2000-02-22', '10:10:00', '12:12:00', 'whats going on'),
(5, 'new', 2, 1, '2010-02-22', '11:59:00', '23:08:00', 'new test'),
(6, 'seccccc', 2, 1, '2010-02-22', '10:59:00', '23:08:00', 'new test');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
