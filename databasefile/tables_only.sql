-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2016 at 06:42 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bcipndba`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `cost_sharing`
--

CREATE TABLE IF NOT EXISTS `cost_sharing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `party` varchar(200) NOT NULL COMMENT 'Name of cost sharing parties',
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;


-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE IF NOT EXISTS `course_category` (
  `course_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `coursename` varchar(100) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`course_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Table structure for table `course_subcategory`
--

CREATE TABLE IF NOT EXISTS `course_subcategory` (
  `course_subcat_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_cat_id` int(11) NOT NULL,
  `subcoursename` varchar(150) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`course_subcat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Table structure for table `coverage_level`
--

CREATE TABLE IF NOT EXISTS `coverage_level` (
  `coverage_level_id` int(11) NOT NULL AUTO_INCREMENT,
  `coverage_level` varchar(60) NOT NULL,
  PRIMARY KEY (`coverage_level_id`),
  UNIQUE KEY `coverage_level` (`coverage_level`),
  KEY `coverage_level_id` (`coverage_level_id`,`coverage_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


--
-- Table structure for table `coverage_location`
--

CREATE TABLE IF NOT EXISTS `coverage_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coverage_location_code` varchar(11) NOT NULL,
  `coverage_level` int(11) NOT NULL,
  `coverage_location` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coverage_level` (`coverage_level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;


-- --------------------------------------------------------

--
-- Table structure for table `currency_unit`
--

CREATE TABLE IF NOT EXISTS `currency_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `currency_unit`
--

INSERT INTO `currency_unit` (`id`, `unit`) VALUES
(1, 'nrs'),
(2, '$');

-- --------------------------------------------------------

--
-- Table structure for table `default_privileges`
--

CREATE TABLE IF NOT EXISTS `default_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `form` varchar(50) NOT NULL,
  `create` tinyint(4) NOT NULL,
  `edit` tinyint(4) NOT NULL,
  `delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;



-- --------------------------------------------------------

--
-- Table structure for table `direct_cost`
--

CREATE TABLE IF NOT EXISTS `direct_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `tdc` float NOT NULL COMMENT 'Total direct cost',
  `staff_cost` float NOT NULL,
  `travel_cost` float NOT NULL,
  `updated_by` varchar(60) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `course_cat_id` int(11) NOT NULL COMMENT 'now event',
  `course_subcat_id` int(11) DEFAULT NULL COMMENT 'now course',
  `coverage_level` varchar(25) NOT NULL COMMENT 'now coverage level',
  `coverage_location` varchar(100) NOT NULL,
  `year` year(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `venue` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `country` varchar(40) NOT NULL DEFAULT 'Nepal',
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `Budget_unit` varchar(10) DEFAULT NULL COMMENT 'for budget currency',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;


--
-- Table structure for table `event_cost_shares`
--

CREATE TABLE IF NOT EXISTS `event_cost_shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `share` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_eventCOstShare` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;


--
-- Table structure for table `event_implementing_partner`
--

CREATE TABLE IF NOT EXISTS `event_implementing_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `implementing_partner_id` int(11) NOT NULL COMMENT 'id is same as main organizer id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=449 ;


--
-- Table structure for table `event_organizer`
--

CREATE TABLE IF NOT EXISTS `event_organizer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `event_organizer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=538 ;


--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `help_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `updated_by` varchar(60) NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`help_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`help_id`, `content`, `updated_by`, `updated_date`, `deleted`) VALUES
(2, 'Building Code Implementation Program in Nepal (BCIPN) is a project being implemented by NSET with the funding support from US Office of Foreign Disaster Assistance (USAID/OFDA) with the main aim to enhance earthquake resilience of urban settlements in Nepal . The project started from October 2012 and will run till September 2015.<br />\r\n<br />\r\nBCIPN focuses on assisting the municipal governments in Nepal in enhancing their capacities to develop and administer the building permits and control system properly for ensuring improved seismic performance of all new building construtction in those urban and urbanizing areas of Nepal where compliance to the National Building Code has been made mandatory by law. This entails, on one hand , helping the municipalities to develop an effective mechanism for building code implementation, and on the other, enhance earthquake awareness of the residents and technical knowledge of the municipal official on aspects of earthquake risk management including earthquake-resistant design and construction. This will be achieved by conducting a series of training courses for technical personnel including the contractors and maosn and by conducting earthquake orientation and other awareness activities.<br />\r\n<br />\r\nA small part of the project aims at supporting some municipalities with provision of technical human resources such as engineers and construction technicians as and when necessary. The project will also allow NSET to look back critically in its performance through revisiting its mission, vision and strategic objectives, and adjust those comensurate with the present day situation and expectations of Nepalese society from NSET.<br />\r\n<br />\r\nThus, BCIPN will complement the on-going initiatives for earthquake risk reductuion in Nepal, especially the OFDA-supported ongoing Nepal Earthquake Risk Management Project Stage 2 (NERMPII) and the 3PERM program.', 'admin', '2013-08-13 10:50:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inkind_contribution`
--

CREATE TABLE IF NOT EXISTS `inkind_contribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `level` varchar(60) NOT NULL COMMENT 'level of person eg. secretory',
  `description` varchar(200) NOT NULL,
  `pax` int(11) NOT NULL COMMENT 'Number of pax',
  `hour` float NOT NULL COMMENT 'hour spent in event',
  `rate` float NOT NULL COMMENT 'rate per hour',
  `updated_by` varchar(60) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `login` datetime NOT NULL,
  `logout` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=507 ;

--
-- Table structure for table `organizer_master`
--

CREATE TABLE IF NOT EXISTS `organizer_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Table structure for table `participated_in`
--

CREATE TABLE IF NOT EXISTS `participated_in` (
  `participated_in_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `person_age` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `is_instructor` tinyint(1) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`participated_in_id`),
  KEY `fk_participatedIn` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1569 ;

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(6) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `dob_np` date NOT NULL,
  `dob_en` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `p_address` varchar(150) NOT NULL,
  `c_address` varchar(150) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `country` varchar(35) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `org_name` varchar(60) NOT NULL,
  `org_address` varchar(150) NOT NULL,
  `org_phone` varchar(20) NOT NULL,
  `org_fax` varchar(25) NOT NULL,
  `position` varchar(30) NOT NULL,
  `current_status` varchar(50) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1452 ;


--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `path_image` varchar(200) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `position` int(11) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `visible` tinyint(4) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(15) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form` varchar(30) NOT NULL,
  `create` tinyint(4) NOT NULL,
  `update` tinyint(4) NOT NULL,
  `delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `direct_cost`
--
ALTER TABLE `direct_cost`
  ADD CONSTRAINT `fk_directCost` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_cost_shares`
--
ALTER TABLE `event_cost_shares`
  ADD CONSTRAINT `fk_eventCOstShare` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `inkind_contribution`
--
ALTER TABLE `inkind_contribution`
  ADD CONSTRAINT `fk_inkindContribution` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `participated_in`
--
ALTER TABLE `participated_in`
  ADD CONSTRAINT `fk_participatedIn` FOREIGN KEY (`person_id`) REFERENCES `person` (`person_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
