-- phpMyAdmin SQL Dump
-- version 4.4.15.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2017 at 11:05 AM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baliyoghardba`
--

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_type`
--

CREATE TABLE IF NOT EXISTS `beneficiary_type` (
  `beneficiary_type_id` int(11) NOT NULL,
  `beneficiary_name` varchar(100) DEFAULT NULL,
  `course_category_id` int(11) DEFAULT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_by` varchar(60) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beneficiary_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `certification_status`
--

CREATE TABLE IF NOT EXISTS `certification_status` (
  `certification_status_id` int(11) NOT NULL,
  `certification_status_name` varchar(100) DEFAULT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_by` varchar(60) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certification_status`
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
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

-- --------------------------------------------------------

--
-- Table structure for table `cost_sharing`
--

CREATE TABLE IF NOT EXISTS `cost_sharing` (
  `id` int(11) NOT NULL,
  `party` varchar(200) NOT NULL COMMENT 'Name of cost sharing parties',
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `deleted_by` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE IF NOT EXISTS `course_category` (
  `course_cat_id` int(11) NOT NULL,
  `coursename` varchar(100) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_category`
--

INSERT INTO `course_category` (`course_cat_id`, `coursename`, `created_by`, `created_date`, `deleted_by`, `deleted_date`, `deleted`) VALUES
(29, 'M&E Survey', 'admin', '2016-09-07 05:53:02', '', '0000-00-00 00:00:00', 1),
(30, 'Training', 'admin', '2016-09-08 15:31:19', '', '0000-00-00 00:00:00', 1),
(31, 'Orientation', 'admin', '2016-09-08 15:33:31', '', '0000-00-00 00:00:00', 1),
(32, 'Demonstration', 'admin', '2016-09-14 10:23:01', '', '0000-00-00 00:00:00', 1),
(33, 'Mason Training', 'admin', '2017-05-26 18:04:35', '', '0000-00-00 00:00:00', 0),
(34, 'Orientation', 'admin', '2017-05-26 18:04:44', '', '0000-00-00 00:00:00', 0),
(35, 'Mason MTOT', 'admin', '2017-05-26 18:05:55', '', '0000-00-00 00:00:00', 0),
(36, 'Social Mobilizer Training', 'admin', '2017-06-02 13:22:26', '', '0000-00-00 00:00:00', 0),
(37, 'Training For Government Officials', 'admin', '2017-06-02 13:25:57', '', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_subcategory`
--

CREATE TABLE IF NOT EXISTS `course_subcategory` (
  `course_subcat_id` int(11) NOT NULL,
  `course_cat_id` int(11) NOT NULL,
  `subcoursename` varchar(150) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted_by` varchar(60) NOT NULL,
  `deleted_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;


--
-- Table structure for table `coverage_level`
--

CREATE TABLE IF NOT EXISTS `coverage_level` (
  `coverage_level_id` int(11) NOT NULL,
  `coverage_level` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


--
-- Table structure for table `coverage_location`
--

CREATE TABLE IF NOT EXISTS `coverage_location` (
  `id` int(11) NOT NULL,
  `coverage_location_code` varchar(11) NOT NULL,
  `coverage_level` int(11) NOT NULL,
  `coverage_location` varchar(150) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;


--
-- Table structure for table `currency_unit`
--

CREATE TABLE IF NOT EXISTS `currency_unit` (
  `id` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


--
-- Table structure for table `default_privileges`
--

CREATE TABLE IF NOT EXISTS `default_privileges` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `form` varchar(50) NOT NULL,
  `create` tinyint(4) NOT NULL,
  `edit` tinyint(4) NOT NULL,
  `delete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `direct_cost`
--

CREATE TABLE IF NOT EXISTS `direct_cost` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `tdc` float NOT NULL COMMENT 'Total direct cost',
  `staff_cost` float NOT NULL,
  `travel_cost` float NOT NULL,
  `updated_by` varchar(60) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `disaggregation_group`
--

CREATE TABLE IF NOT EXISTS `disaggregation_group` (
  `disaggregation_group_id` int(11) NOT NULL,
  `label` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `drtc`
--

CREATE TABLE IF NOT EXISTS `drtc` (
  `id` int(11) NOT NULL,
  `d_code` varchar(2) DEFAULT NULL,
  `d_name` varchar(50) DEFAULT NULL,
  `numbering` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `education_levels`
--

CREATE TABLE IF NOT EXISTS `education_levels` (
  `education_level_id` int(11) NOT NULL,
  `education_level` varchar(100) NOT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_by` varchar(60) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL,
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
  `event_code` varchar(100) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `vdc` varchar(50) DEFAULT NULL,
  `ward_no` varchar(50) DEFAULT NULL,
  `tole` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=latin1;

--
-- Table structure for table `event_cost_shares`
--

CREATE TABLE IF NOT EXISTS `event_cost_shares` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `share` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_implementing_partner`
--

CREATE TABLE IF NOT EXISTS `event_implementing_partner` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `implementing_partner_id` int(11) NOT NULL COMMENT 'id is same as main organizer id'
) ENGINE=InnoDB AUTO_INCREMENT=527 DEFAULT CHARSET=latin1;


--
-- Table structure for table `event_organizer`
--

CREATE TABLE IF NOT EXISTS `event_organizer` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_organizer_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=789 DEFAULT CHARSET=latin1;


--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `help_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `updated_by` varchar(60) NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inkind_contribution`
--

CREATE TABLE IF NOT EXISTS `inkind_contribution` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `level` varchar(60) NOT NULL COMMENT 'level of person eg. secretory',
  `description` varchar(200) NOT NULL,
  `pax` int(11) NOT NULL COMMENT 'Number of pax',
  `hour` float NOT NULL COMMENT 'hour spent in event',
  `rate` float NOT NULL COMMENT 'rate per hour',
  `updated_by` varchar(60) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `login` datetime NOT NULL,
  `logout` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=909 DEFAULT CHARSET=latin1;


--
-- Table structure for table `lrtc`
--

CREATE TABLE IF NOT EXISTS `lrtc` (
  `id` int(11) NOT NULL,
  `ddvdc_code` varchar(5) NOT NULL,
  `vdc_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `np_districts`
--

CREATE TABLE IF NOT EXISTS `np_districts` (
  `code` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `label_en` text NOT NULL,
  `label_np` text NOT NULL,
  `parent_code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `np_vdcs`
--

CREATE TABLE IF NOT EXISTS `np_vdcs` (
  `id` int(11) NOT NULL,
  `d_code` varchar(50) NOT NULL,
  `dist_name` varchar(50) NOT NULL,
  `zone_name` varchar(50) NOT NULL,
  `vdc_name` varchar(50) NOT NULL,
  `ocha_vname` varchar(50) NOT NULL,
  `cbs_code` varchar(5) NOT NULL,
  `hlcit_code` varchar(17) NOT NULL,
  `ocha_pcode` varchar(12) NOT NULL,
  `hr_name` varchar(50) NOT NULL,
  `hr_pcode` varchar(15) NOT NULL,
  `hr_parent` varchar(11) NOT NULL,
  `label_en` text NOT NULL,
  `label_np_utp8` text NOT NULL,
  `label_np_preeti` text NOT NULL,
  `ddvdc_code` varchar(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=266 DEFAULT CHARSET=latin1;

--
-- Table structure for table `nset_unit`
--

CREATE TABLE IF NOT EXISTS `nset_unit` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `st_district` varchar(50) NOT NULL,
  `st_vdc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organizer_master`
--

CREATE TABLE IF NOT EXISTS `organizer_master` (
  `id` int(11) NOT NULL,
  `organizer` varchar(100) NOT NULL,
  `dcode` varchar(2) DEFAULT NULL,
  `vcode` varchar(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Table structure for table `participated_in`
--

CREATE TABLE IF NOT EXISTS `participated_in` (
  `participated_in_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `person_age` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `is_instructor` tinyint(1) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `certification_code` varchar(30) DEFAULT NULL,
  `certification_status` int(11) DEFAULT NULL,
  `certification_date` date DEFAULT NULL,
  `beneficiary_type` int(11) DEFAULT NULL,
  `participation_role` int(11) DEFAULT NULL,
  `experience_years` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3687 DEFAULT CHARSET=latin1;

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int(11) NOT NULL,
  `title` varchar(6) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `dob_np` date DEFAULT NULL,
  `dob_en` date DEFAULT NULL,
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
  `caste_ethnicity` int(11) DEFAULT NULL,
  `citizenship_no` varchar(30) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `work_type_id` int(11) DEFAULT NULL,
  `education_level` int(11) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `pa_dist_code` int(2) DEFAULT NULL,
  `pa_vdc_code` int(3) DEFAULT NULL,
  `pa_ward_no` int(2) DEFAULT NULL,
  `ca_dist_code` int(2) DEFAULT NULL,
  `ca_vdc_code` int(3) DEFAULT NULL,
  `ca_ward_no` int(2) DEFAULT NULL,
  `work_experience_years` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3595 DEFAULT CHARSET=latin1;


--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `image_id` int(11) NOT NULL,
  `path_image` varchar(200) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `position` int(11) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `created_date` datetime NOT NULL,
  `visible` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_type` varchar(20) NOT NULL,
  `unit_name` varchar(150) NOT NULL,
  `st_district` varchar(50) NOT NULL,
  `st_vdc` varchar(50) NOT NULL,
  `cov_level` varchar(20) NOT NULL,
  `numbering` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(15) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form` varchar(30) NOT NULL,
  `create` tinyint(4) NOT NULL,
  `update` tinyint(4) NOT NULL,
  `delete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

CREATE TABLE IF NOT EXISTS `work_experience` (
  `id` int(11) NOT NULL,
  `organization` int(100) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `role` int(250) NOT NULL,
  `no_of_years` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work_type`
--

CREATE TABLE IF NOT EXISTS `work_type` (
  `work_type_id` int(11) NOT NULL,
  `work_name` varchar(100) DEFAULT NULL,
  `course_category_id` int(11) DEFAULT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `deleted_by` varchar(60) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beneficiary_type`
--
ALTER TABLE `beneficiary_type`
  ADD PRIMARY KEY (`beneficiary_type_id`),
  ADD UNIQUE KEY `beneficiary_name` (`beneficiary_name`);

--
-- Indexes for table `certification_status`
--
ALTER TABLE `certification_status`
  ADD PRIMARY KEY (`certification_status_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `cost_sharing`
--
ALTER TABLE `cost_sharing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`course_cat_id`);

--
-- Indexes for table `course_subcategory`
--
ALTER TABLE `course_subcategory`
  ADD PRIMARY KEY (`course_subcat_id`);

--
-- Indexes for table `coverage_level`
--
ALTER TABLE `coverage_level`
  ADD PRIMARY KEY (`coverage_level_id`),
  ADD UNIQUE KEY `coverage_level` (`coverage_level`),
  ADD KEY `coverage_level_id` (`coverage_level_id`,`coverage_level`);

--
-- Indexes for table `coverage_location`
--
ALTER TABLE `coverage_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coverage_level` (`coverage_level`);

--
-- Indexes for table `currency_unit`
--
ALTER TABLE `currency_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `default_privileges`
--
ALTER TABLE `default_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_cost`
--
ALTER TABLE `direct_cost`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_id` (`event_id`);

--
-- Indexes for table `disaggregation_group`
--
ALTER TABLE `disaggregation_group`
  ADD PRIMARY KEY (`disaggregation_group_id`);

--
-- Indexes for table `drtc`
--
ALTER TABLE `drtc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_levels`
--
ALTER TABLE `education_levels`
  ADD PRIMARY KEY (`education_level_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_cost_shares`
--
ALTER TABLE `event_cost_shares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_eventCOstShare` (`event_id`);

--
-- Indexes for table `event_implementing_partner`
--
ALTER TABLE `event_implementing_partner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_organizer`
--
ALTER TABLE `event_organizer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help`
--
ALTER TABLE `help`
  ADD PRIMARY KEY (`help_id`);

--
-- Indexes for table `inkind_contribution`
--
ALTER TABLE `inkind_contribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lrtc`
--
ALTER TABLE `lrtc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `np_districts`
--
ALTER TABLE `np_districts`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `np_vdcs`
--
ALTER TABLE `np_vdcs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nset_unit`
--
ALTER TABLE `nset_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizer_master`
--
ALTER TABLE `organizer_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participated_in`
--
ALTER TABLE `participated_in`
  ADD PRIMARY KEY (`participated_in_id`),
  ADD KEY `fk_participatedIn` (`person_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `work_experience`
--
ALTER TABLE `work_experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_type`
--
ALTER TABLE `work_type`
  ADD PRIMARY KEY (`work_type_id`),
  ADD UNIQUE KEY `work_name` (`work_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beneficiary_type`
--
ALTER TABLE `beneficiary_type`
  MODIFY `beneficiary_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `certification_status`
--
ALTER TABLE `certification_status`
  MODIFY `certification_status_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cost_sharing`
--
ALTER TABLE `cost_sharing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course_category`
--
ALTER TABLE `course_category`
  MODIFY `course_cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `course_subcategory`
--
ALTER TABLE `course_subcategory`
  MODIFY `course_subcat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `coverage_level`
--
ALTER TABLE `coverage_level`
  MODIFY `coverage_level_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `coverage_location`
--
ALTER TABLE `coverage_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `currency_unit`
--
ALTER TABLE `currency_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `default_privileges`
--
ALTER TABLE `default_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `direct_cost`
--
ALTER TABLE `direct_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `disaggregation_group`
--
ALTER TABLE `disaggregation_group`
  MODIFY `disaggregation_group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `drtc`
--
ALTER TABLE `drtc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `education_levels`
--
ALTER TABLE `education_levels`
  MODIFY `education_level_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=255;
--
-- AUTO_INCREMENT for table `event_cost_shares`
--
ALTER TABLE `event_cost_shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_implementing_partner`
--
ALTER TABLE `event_implementing_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=527;
--
-- AUTO_INCREMENT for table `event_organizer`
--
ALTER TABLE `event_organizer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=789;
--
-- AUTO_INCREMENT for table `help`
--
ALTER TABLE `help`
  MODIFY `help_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inkind_contribution`
--
ALTER TABLE `inkind_contribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=909;
--
-- AUTO_INCREMENT for table `lrtc`
--
ALTER TABLE `lrtc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `np_vdcs`
--
ALTER TABLE `np_vdcs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=266;
--
-- AUTO_INCREMENT for table `nset_unit`
--
ALTER TABLE `nset_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organizer_master`
--
ALTER TABLE `organizer_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `participated_in`
--
ALTER TABLE `participated_in`
  MODIFY `participated_in_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3687;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3595;
--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_experience`
--
ALTER TABLE `work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_type`
--
ALTER TABLE `work_type`
  MODIFY `work_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
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
