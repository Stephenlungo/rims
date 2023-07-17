-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2023 at 09:41 AM
-- Server version: 5.7.42
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pipatzam_pipatzambia2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `branch_ids` text NOT NULL,
  `agent_type_ids` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `max_value` varchar(200) NOT NULL DEFAULT '100',
  `gsm_code` varchar(10) NOT NULL,
  `ussd_code` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL DEFAULT '100',
  `warning` int(1) NOT NULL DEFAULT '0',
  `services` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_targets`
--

CREATE TABLE `activity_targets` (
  `id` int(10) NOT NULL,
  `unit_id` int(10) NOT NULL,
  `activity_id` int(10) NOT NULL,
  `operation_number` int(10) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `_date` int(200) NOT NULL,
  `img_src` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `agent_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL DEFAULT '0',
  `group_id` int(10) NOT NULL DEFAULT '0',
  `contact_number` varchar(200) NOT NULL,
  `question_id` int(10) NOT NULL,
  `question_answer` varchar(200) NOT NULL,
  `gender` int(1) NOT NULL DEFAULT '0',
  `age` varchar(10) NOT NULL,
  `msg_text` text NOT NULL,
  `_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_groups`
--

CREATE TABLE `affiliate_groups` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `company_id` int(10) NOT NULL,
  `year_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_questions`
--

CREATE TABLE `affiliate_questions` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `year_id` int(10) NOT NULL,
  `title` text NOT NULL,
  `gsm_code` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929183`
--

CREATE TABLE `agents_partition_1659929183` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929204`
--

CREATE TABLE `agents_partition_1659929204` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929224`
--

CREATE TABLE `agents_partition_1659929224` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929253`
--

CREATE TABLE `agents_partition_1659929253` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929288`
--

CREATE TABLE `agents_partition_1659929288` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929315`
--

CREATE TABLE `agents_partition_1659929315` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929355`
--

CREATE TABLE `agents_partition_1659929355` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929383`
--

CREATE TABLE `agents_partition_1659929383` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929412`
--

CREATE TABLE `agents_partition_1659929412` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929450`
--

CREATE TABLE `agents_partition_1659929450` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929514`
--

CREATE TABLE `agents_partition_1659929514` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1659929554`
--

CREATE TABLE `agents_partition_1659929554` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1672732047`
--

CREATE TABLE `agents_partition_1672732047` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1677674525`
--

CREATE TABLE `agents_partition_1677674525` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1683015381`
--

CREATE TABLE `agents_partition_1683015381` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agents_partition_1687790002`
--

CREATE TABLE `agents_partition_1687790002` (
  `id` int(10) NOT NULL,
  `branch_id` int(10) DEFAULT '0',
  `account_number` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `responsibility` varchar(200) NOT NULL,
  `agent_type_id` text NOT NULL,
  `validation_request` int(1) NOT NULL DEFAULT '0',
  `validation_request_user` int(10) NOT NULL DEFAULT '0',
  `validation_request_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_user_id` int(10) NOT NULL DEFAULT '0',
  `validation_allocation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_date` varchar(200) NOT NULL DEFAULT '0',
  `validation_action_user_id` int(10) NOT NULL DEFAULT '0',
  `qualification` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL DEFAULT '0',
  `id_type` int(1) NOT NULL DEFAULT '1',
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `gender` int(1) NOT NULL DEFAULT '1',
  `password` varchar(250) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(10) NOT NULL DEFAULT '0',
  `user_code` varchar(10) NOT NULL DEFAULT '0',
  `roles` text NOT NULL,
  `agent_type` int(1) NOT NULL DEFAULT '0',
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '0',
  `recoveryRequest` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `access_status` int(1) NOT NULL DEFAULT '0',
  `bgColor` varchar(100) NOT NULL DEFAULT '#fff',
  `bgImage` varchar(100) NOT NULL DEFAULT 'none',
  `foregroundColor` varchar(100) NOT NULL DEFAULT '#000',
  `foregroundTxtColor` varchar(10) NOT NULL DEFAULT '#000',
  `foregroundOpacity` varchar(100) NOT NULL DEFAULT '20',
  `paperColor` varchar(10) NOT NULL DEFAULT '#fff',
  `paperTxtColor` varchar(100) NOT NULL DEFAULT '#000',
  `paperOpacity` varchar(10) NOT NULL DEFAULT '90',
  `updated` varchar(200) NOT NULL DEFAULT '0',
  `updateUser_date` varchar(200) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL DEFAULT '0',
  `department_division_id` int(10) NOT NULL DEFAULT '0',
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agent_files`
--

CREATE TABLE `agent_files` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `file_src` text NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `agent_types`
--

CREATE TABLE `agent_types` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(10) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `script` varchar(200) NOT NULL,
  `src_type` int(1) NOT NULL DEFAULT '0',
  `publishStatus` int(1) NOT NULL DEFAULT '1',
  `updated` varchar(200) NOT NULL,
  `_order` int(5) NOT NULL,
  `access_level` int(11) NOT NULL,
  `img_src` varchar(200) NOT NULL,
  `show_img` int(1) NOT NULL DEFAULT '0',
  `offline_access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bg_images`
--

CREATE TABLE `bg_images` (
  `id` int(5) NOT NULL,
  `src` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bin`
--

CREATE TABLE `bin` (
  `id` int(10) NOT NULL,
  `error_msg` text NOT NULL,
  `message_sent` text NOT NULL,
  `_date` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `allow_virtualworkplace` int(1) NOT NULL DEFAULT '0',
  `workplace_administration_type` int(1) NOT NULL DEFAULT '0',
  `workplace_administration_unit_type` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(10) NOT NULL,
  `political_party` int(10) NOT NULL,
  `election_category` int(10) NOT NULL,
  `province_id` int(10) NOT NULL DEFAULT '0',
  `district_id` int(10) NOT NULL DEFAULT '0',
  `constituency_id` int(10) NOT NULL DEFAULT '0',
  `ward_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `img_src` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `captive_data_sets`
--

CREATE TABLE `captive_data_sets` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `wifi_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `captive_user_id` int(10) NOT NULL,
  `_date` int(10) NOT NULL,
  `score` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `change_tracker`
--

CREATE TABLE `change_tracker` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `alteration_table` varchar(200) NOT NULL,
  `entry_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `sql_query` text NOT NULL,
  `undo_query` text NOT NULL,
  `query_description` text NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_screening`
--

CREATE TABLE `client_screening` (
  `id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` int(4) NOT NULL,
  `partner_who_has_hiv` int(4) NOT NULL,
  `sex_without_condom` int(4) NOT NULL,
  `tested_hiv_in_six_months` int(4) NOT NULL,
  `hiv_status` int(4) NOT NULL,
  `on_art_or_prep` varchar(10) NOT NULL,
  `marital_status` int(4) NOT NULL,
  `district` int(4) NOT NULL,
  `township` varchar(255) NOT NULL,
  `house_number` varchar(255) NOT NULL,
  `next_of_kin` varchar(255) NOT NULL,
  `next_of_kin_address` varchar(255) NOT NULL,
  `forced_sex` int(4) NOT NULL,
  `sexually_active` int(4) NOT NULL,
  `symptoms` int(4) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `_type` int(1) NOT NULL DEFAULT '0',
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `alert_email` text NOT NULL,
  `town` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `tpin` varchar(200) NOT NULL,
  `vat_reg` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `logo_src` varchar(200) NOT NULL,
  `vehicle_servicing_alert` int(1) NOT NULL DEFAULT '0',
  `vehicle_servicing_mileage` varchar(200) NOT NULL,
  `remaining_notify` varchar(200) NOT NULL,
  `insurance_alert` int(1) NOT NULL DEFAULT '1',
  `insurance_interval` varchar(200) NOT NULL,
  `insurance_remaining_notify` varchar(200) NOT NULL,
  `road_tax_alert` int(1) NOT NULL DEFAULT '1',
  `road_tax_interval` varchar(200) NOT NULL,
  `road_tax_remaining_notify` varchar(200) NOT NULL,
  `driver_access` int(1) NOT NULL DEFAULT '1',
  `licenseKeyID` int(50) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `updateUser_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `covid_clients`
--

CREATE TABLE `covid_clients` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL DEFAULT '0',
  `grz_identifier` varchar(200) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(200) NOT NULL,
  `date_of_birth` varchar(200) NOT NULL DEFAULT '0',
  `id_number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `physical_address` varchar(200) NOT NULL DEFAULT '0',
  `house_number` varchar(200) NOT NULL DEFAULT '0',
  `non_disc_district` varchar(200) NOT NULL DEFAULT '0',
  `non_disc_province` varchar(200) DEFAULT '0',
  `non_disc_town` varchar(200) NOT NULL DEFAULT '0',
  `non_disc_street` varchar(200) NOT NULL DEFAULT '0',
  `other_landmark` varchar(200) NOT NULL DEFAULT '0',
  `next_of_kin_name` varchar(200) NOT NULL DEFAULT '0',
  `next_of_kin_contact_number` varchar(200) NOT NULL DEFAULT '0',
  `next_of_kin_alt_number` varchar(200) NOT NULL DEFAULT '0',
  `home_based_monitoring_start_date` varchar(200) NOT NULL DEFAULT '0',
  `risk_level` int(5) NOT NULL,
  `case_classification_id` int(10) NOT NULL DEFAULT '0',
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `investigation_day` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department_divisions`
--

CREATE TABLE `department_divisions` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `department_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_checklists`
--

CREATE TABLE `dynamic_checklists` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `checklist_title` varchar(200) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `description` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `_order` int(10) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `dependencies` text NOT NULL,
  `form_linkage_id` int(1) NOT NULL DEFAULT '0',
  `data_processing_method` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_checklist_categories`
--

CREATE TABLE `dynamic_checklist_categories` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_checklist_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_checklist_category_options`
--

CREATE TABLE `dynamic_checklist_category_options` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_checklist_id` int(10) NOT NULL,
  `dynamic_checklist_category_id` int(10) NOT NULL,
  `option_title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `option_necessity` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `_order` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_checklist_data_sets`
--

CREATE TABLE `dynamic_checklist_data_sets` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_checklist_id` int(10) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_checklist_values`
--

CREATE TABLE `dynamic_checklist_values` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_checklist_id` int(10) NOT NULL,
  `dynamic_checklist_category_id` int(10) NOT NULL,
  `dynamic_checklist_category_option_id` int(10) NOT NULL,
  `dynamic_checklist_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_dashboards`
--

CREATE TABLE `dynamic_dashboards` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `accessibility_type` int(1) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL DEFAULT '0',
  `province_id` int(10) NOT NULL DEFAULT '0',
  `hub_id` int(10) NOT NULL DEFAULT '0',
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `group_ids` text NOT NULL,
  `user_ids` text NOT NULL,
  `unit_ids` text NOT NULL,
  `default_dashboard` int(1) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `show_description` int(1) NOT NULL DEFAULT '1',
  `user_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_dashboard_areas`
--

CREATE TABLE `dynamic_dashboard_areas` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `dashboard_id` int(10) NOT NULL,
  `_width` varchar(200) NOT NULL,
  `_height` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `show_title` int(1) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `show_description` int(1) NOT NULL DEFAULT '1',
  `show_buttons` int(1) NOT NULL DEFAULT '1',
  `_order` int(10) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_forms`
--

CREATE TABLE `dynamic_forms` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `form_title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `_order` int(10) NOT NULL,
  `user_date` varchar(200) NOT NULL DEFAULT '0',
  `dependencies` text NOT NULL,
  `data_processing_method` int(1) NOT NULL DEFAULT '0',
  `custom_script` text NOT NULL,
  `status_change_id` int(1) NOT NULL DEFAULT '-1',
  `form_display_type` int(1) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_categories`
--

CREATE TABLE `dynamic_form_categories` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `header_text` text NOT NULL,
  `footer_text` text NOT NULL,
  `_order` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `necessity` int(1) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_category_options`
--

CREATE TABLE `dynamic_form_category_options` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `category_title` varchar(400) NOT NULL,
  `option_type` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `default_option` int(1) NOT NULL DEFAULT '0',
  `days_before_due_date` int(10) NOT NULL DEFAULT '0',
  `schedule_message` text NOT NULL,
  `_order` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets`
--

CREATE TABLE `dynamic_form_data_sets` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649230629`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649230629` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649230721`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649230721` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649230773`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649230773` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649230830`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649230830` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649230966`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649230966` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231002`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231002` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231053`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231053` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231124`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231124` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231153`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231153` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231194`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231194` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231250`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231250` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231294`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231294` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231318`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231318` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231344`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231344` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231379`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231379` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231412`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231412` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231453`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231453` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231498`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231498` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649231545`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649231545` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1649302090`
--

CREATE TABLE `dynamic_form_data_sets_partition_1649302090` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1656659479`
--

CREATE TABLE `dynamic_form_data_sets_partition_1656659479` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1661927794`
--

CREATE TABLE `dynamic_form_data_sets_partition_1661927794` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1661927824`
--

CREATE TABLE `dynamic_form_data_sets_partition_1661927824` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1672732028`
--

CREATE TABLE `dynamic_form_data_sets_partition_1672732028` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1680504760`
--

CREATE TABLE `dynamic_form_data_sets_partition_1680504760` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1685612349`
--

CREATE TABLE `dynamic_form_data_sets_partition_1685612349` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_data_sets_partition_1687790108`
--

CREATE TABLE `dynamic_form_data_sets_partition_1687790108` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `client_id` int(11) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values`
--

CREATE TABLE `dynamic_form_values` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649231723`
--

CREATE TABLE `dynamic_form_values_partition_1649231723` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649231834`
--

CREATE TABLE `dynamic_form_values_partition_1649231834` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649231901`
--

CREATE TABLE `dynamic_form_values_partition_1649231901` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649231992`
--

CREATE TABLE `dynamic_form_values_partition_1649231992` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649232344`
--

CREATE TABLE `dynamic_form_values_partition_1649232344` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649232459`
--

CREATE TABLE `dynamic_form_values_partition_1649232459` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649232638`
--

CREATE TABLE `dynamic_form_values_partition_1649232638` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649232781`
--

CREATE TABLE `dynamic_form_values_partition_1649232781` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649232930`
--

CREATE TABLE `dynamic_form_values_partition_1649232930` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233073`
--

CREATE TABLE `dynamic_form_values_partition_1649233073` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233214`
--

CREATE TABLE `dynamic_form_values_partition_1649233214` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233357`
--

CREATE TABLE `dynamic_form_values_partition_1649233357` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233467`
--

CREATE TABLE `dynamic_form_values_partition_1649233467` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233577`
--

CREATE TABLE `dynamic_form_values_partition_1649233577` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233686`
--

CREATE TABLE `dynamic_form_values_partition_1649233686` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649233904`
--

CREATE TABLE `dynamic_form_values_partition_1649233904` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649234097`
--

CREATE TABLE `dynamic_form_values_partition_1649234097` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649234214`
--

CREATE TABLE `dynamic_form_values_partition_1649234214` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649234433`
--

CREATE TABLE `dynamic_form_values_partition_1649234433` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1649302109`
--

CREATE TABLE `dynamic_form_values_partition_1649302109` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1656659504`
--

CREATE TABLE `dynamic_form_values_partition_1656659504` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1661927844`
--

CREATE TABLE `dynamic_form_values_partition_1661927844` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1661927926`
--

CREATE TABLE `dynamic_form_values_partition_1661927926` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1672732088`
--

CREATE TABLE `dynamic_form_values_partition_1672732088` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1680504858`
--

CREATE TABLE `dynamic_form_values_partition_1680504858` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1685612415`
--

CREATE TABLE `dynamic_form_values_partition_1685612415` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_form_values_partition_1687790131`
--

CREATE TABLE `dynamic_form_values_partition_1687790131` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `dynamic_form_id` int(10) NOT NULL,
  `dynamic_form_category_id` int(10) NOT NULL,
  `dynamic_form_category_option_id` int(10) NOT NULL,
  `dynamic_form_data_set_id` int(10) NOT NULL,
  `_value` text NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_graphs`
--

CREATE TABLE `dynamic_graphs` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `dashboard_id` int(10) NOT NULL DEFAULT '0',
  `dashboard_area_id` int(10) NOT NULL DEFAULT '0',
  `source_type` int(1) NOT NULL DEFAULT '0',
  `report_id` int(10) NOT NULL,
  `dynamic_graph_type` int(10) NOT NULL,
  `graph_type_option` int(10) NOT NULL,
  `graph_size_option` varchar(200) NOT NULL,
  `rule_string` text NOT NULL,
  `is_default` int(1) NOT NULL DEFAULT '0',
  `show_grid` int(1) NOT NULL DEFAULT '1',
  `show_legend` int(1) NOT NULL DEFAULT '1',
  `show_title` int(1) NOT NULL DEFAULT '1',
  `accessibility` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_graph_types`
--

CREATE TABLE `dynamic_graph_types` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `icon_src` varchar(200) NOT NULL,
  `script_src` varchar(200) NOT NULL,
  `js_id` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `company_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_reports`
--

CREATE TABLE `dynamic_reports` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `branch_id` int(10) NOT NULL,
  `dashboard_id` int(10) NOT NULL DEFAULT '0',
  `dashboard_area_id` int(10) NOT NULL DEFAULT '0',
  `accessibility_type` int(1) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL DEFAULT '0',
  `province_id` int(10) NOT NULL DEFAULT '0',
  `hub_id` int(10) NOT NULL DEFAULT '0',
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `group_ids` varchar(200) NOT NULL,
  `user_ids` varchar(200) NOT NULL,
  `unit_ids` varchar(200) NOT NULL,
  `default_report` int(1) NOT NULL DEFAULT '0',
  `primary_column_type` int(10) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `default_display` int(1) NOT NULL DEFAULT '0',
  `rule_string` text NOT NULL,
  `column_rule_string` text NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_report_cache`
--

CREATE TABLE `dynamic_report_cache` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `dashboard_id` int(10) NOT NULL,
  `dashboard_area_id` int(10) NOT NULL,
  `dynamic_report_id` int(10) NOT NULL,
  `repor_columns` text NOT NULL,
  `report_rows` text NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_report_primary_columns`
--

CREATE TABLE `dynamic_report_primary_columns` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `primary_column_type_id` varchar(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `allow_disagregation` int(10) NOT NULL,
  `column_disaggregation_rules` text NOT NULL,
  `disagregation_column` varchar(200) NOT NULL,
  `rule_string` text NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_report_primary_column_types`
--

CREATE TABLE `dynamic_report_primary_column_types` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `query_type` varchar(200) NOT NULL,
  `reference_table` varchar(200) NOT NULL,
  `common_reference_column` varchar(200) NOT NULL,
  `module_id` int(10) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` int(10) NOT NULL,
  `political_party` int(10) NOT NULL,
  `election_category_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `constituency_id` int(10) NOT NULL,
  `ward_id` int(10) NOT NULL,
  `station_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `confirmed_user` int(10) NOT NULL DEFAULT '1',
  `votes` int(10) NOT NULL,
  `rejected_votes` varchar(200) NOT NULL,
  `img_src` varchar(200) NOT NULL,
  `tataling_document` varchar(200) NOT NULL,
  `data_entry_mode` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `election_categories`
--

CREATE TABLE `election_categories` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `gsm_code` varchar(200) NOT NULL,
  `_level` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `election_years`
--

CREATE TABLE `election_years` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_queue`
--

CREATE TABLE `email_queue` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `_from` varchar(200) NOT NULL,
  `_to` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `send_status` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `excel_output`
--

CREATE TABLE `excel_output` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `external_apps`
--

CREATE TABLE `external_apps` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `organisation` varchar(200) NOT NULL,
  `organisation_key` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `module_string` varchar(200) NOT NULL,
  `access_roles` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `linkage_id` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forecast`
--

CREATE TABLE `forecast` (
  `id` int(10) NOT NULL,
  `political_party` int(10) NOT NULL,
  `election_category_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `constituency_id` int(10) NOT NULL,
  `ward_id` int(10) NOT NULL,
  `station_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `votes` int(10) NOT NULL,
  `rejected_votes` varchar(200) NOT NULL,
  `img_src` varchar(200) NOT NULL,
  `data_entry_mode` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `analysis_mode` int(1) NOT NULL DEFAULT '0',
  `confirmed` int(1) NOT NULL DEFAULT '0',
  `updated` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hiv_clients`
--

CREATE TABLE `hiv_clients` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `physical_address` varchar(200) NOT NULL,
  `house_number` varchar(200) NOT NULL,
  `non_disc_province` int(10) NOT NULL,
  `non_disc_district` int(10) NOT NULL,
  `non_disc_constituency` int(10) NOT NULL,
  `non_disc_site` int(10) NOT NULL,
  `non_disc_street` varchar(200) NOT NULL,
  `other_landmark` varchar(200) NOT NULL,
  `next_of_kin_name` varchar(200) NOT NULL,
  `next_of_kin_contact_number` varchar(200) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `case_classification_id` int(10) NOT NULL DEFAULT '0',
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `counsellor_id` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hubs`
--

CREATE TABLE `hubs` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `gsm_code` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `id_types`
--

CREATE TABLE `id_types` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `licensekeys`
--

CREATE TABLE `licensekeys` (
  `id` int(5) NOT NULL,
  `licenseID` int(5) NOT NULL,
  `companyID` int(5) NOT NULL,
  `_key` text NOT NULL,
  `startDate` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `licensing`
--

CREATE TABLE `licensing` (
  `id` int(5) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `length` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mail_send_queue`
--

CREATE TABLE `mail_send_queue` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `from_email` varchar(200) NOT NULL,
  `from_name` varchar(200) NOT NULL,
  `to_email` varchar(200) NOT NULL,
  `message_subject` text NOT NULL,
  `message_body` text NOT NULL,
  `option_attributes` text NOT NULL,
  `send_time` varchar(200) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `branch_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `meeting_code` varchar(200) NOT NULL,
  `meeting_code_type` varchar(200) NOT NULL,
  `password` int(11) NOT NULL,
  `region_id` int(10) NOT NULL DEFAULT '0',
  `province_id` int(10) NOT NULL DEFAULT '0',
  `hub_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `unit_id` int(11) NOT NULL,
  `quick_report_unit_id` int(10) NOT NULL DEFAULT '0',
  `quick_report_activity_id` int(10) DEFAULT '0',
  `quick_report_facility_id` int(10) NOT NULL DEFAULT '0',
  `auto_assign_agent_group_id` int(10) NOT NULL DEFAULT '3',
  `auto_assign_responsibility` varchar(200) DEFAULT 'CHW',
  `_from` varchar(200) NOT NULL,
  `_to` varchar(200) NOT NULL,
  `request_type_ids` varchar(200) NOT NULL DEFAULT '0',
  `teams` int(10) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `batched` int(1) NOT NULL DEFAULT '0',
  `batch_number` int(10) NOT NULL DEFAULT '0',
  `_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_batches`
--

CREATE TABLE `meeting_batches` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `meeting_ids` text NOT NULL,
  `batch_number` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `claim_type_ids` varchar(200) NOT NULL,
  `amount` int(100) NOT NULL,
  `file_src` text NOT NULL,
  `_date` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `active_status` int(1) NOT NULL DEFAULT '1',
  `claim_id` int(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_batch_participants`
--

CREATE TABLE `meeting_batch_participants` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `batch_id` int(10) NOT NULL,
  `meeting_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `agent_date` varchar(100) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `responsibility_id` int(10) NOT NULL,
  `nrc` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `days_worked` int(10) NOT NULL DEFAULT '0',
  `days_payable` int(10) NOT NULL,
  `claim_type_id` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `rate` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `period_from` varchar(100) NOT NULL,
  `period_to` varchar(100) NOT NULL,
  `_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_participants`
--

CREATE TABLE `meeting_participants` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `meeting_id` int(10) NOT NULL,
  `agent_date` varchar(100) NOT NULL,
  `form_options` text NOT NULL,
  `new_agent` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `active_status` int(1) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `to_id` int(10) NOT NULL,
  `from_id` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `seen` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `attachments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mother_facilities`
--

CREATE TABLE `mother_facilities` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `active_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offline_scripts`
--

CREATE TABLE `offline_scripts` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `file_src` text NOT NULL,
  `_code` text NOT NULL,
  `script_id` int(10) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `_order` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment_folders`
--

CREATE TABLE `payment_folders` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_type` int(1) NOT NULL DEFAULT '0',
  `parent_id` int(10) NOT NULL,
  `agent_entries` text NOT NULL,
  `agent_limit` int(10) NOT NULL,
  `budget_limit` int(100) NOT NULL,
  `current_budget_amount` int(100) NOT NULL,
  `claim_type_string` text NOT NULL,
  `user_id` int(10) NOT NULL,
  `accessibility_id` int(1) NOT NULL DEFAULT '0',
  `allow_agents` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `_ordering` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_folder_data`
--

CREATE TABLE `payment_folder_data` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `data_set_id` int(10) NOT NULL,
  `claim_type_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `month_id` int(10) NOT NULL,
  `agent_date` varchar(100) NOT NULL,
  `payable_days` int(10) NOT NULL,
  `_date` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_folder_data_sets`
--

CREATE TABLE `payment_folder_data_sets` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `folder_id` int(10) NOT NULL,
  `month_id` int(10) NOT NULL,
  `claim_id` int(10) NOT NULL,
  `claim_status` int(2) NOT NULL DEFAULT '0',
  `level` int(2) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_folder_months`
--

CREATE TABLE `payment_folder_months` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `month` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `_order` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pbi_campaign_users`
--

CREATE TABLE `pbi_campaign_users` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '0',
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `session_start` varchar(200) NOT NULL,
  `session_code` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers`
--

CREATE TABLE `phone_numbers` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929183`
--

CREATE TABLE `phone_numbers_partition_1659929183` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929204`
--

CREATE TABLE `phone_numbers_partition_1659929204` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929224`
--

CREATE TABLE `phone_numbers_partition_1659929224` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929253`
--

CREATE TABLE `phone_numbers_partition_1659929253` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929288`
--

CREATE TABLE `phone_numbers_partition_1659929288` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929315`
--

CREATE TABLE `phone_numbers_partition_1659929315` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929355`
--

CREATE TABLE `phone_numbers_partition_1659929355` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929383`
--

CREATE TABLE `phone_numbers_partition_1659929383` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929412`
--

CREATE TABLE `phone_numbers_partition_1659929412` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929450`
--

CREATE TABLE `phone_numbers_partition_1659929450` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929514`
--

CREATE TABLE `phone_numbers_partition_1659929514` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1659929554`
--

CREATE TABLE `phone_numbers_partition_1659929554` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1672732047`
--

CREATE TABLE `phone_numbers_partition_1672732047` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1677674525`
--

CREATE TABLE `phone_numbers_partition_1677674525` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1683015381`
--

CREATE TABLE `phone_numbers_partition_1683015381` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers_partition_1687790002`
--

CREATE TABLE `phone_numbers_partition_1687790002` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `agent_date` varchar(200) NOT NULL,
  `phone_number` text NOT NULL,
  `primary_no` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `political_parties`
--

CREATE TABLE `political_parties` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `logo_src` varchar(200) NOT NULL,
  `party_color` varchar(200) NOT NULL,
  `gsm_code` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `population_categories`
--

CREATE TABLE `population_categories` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(10) NOT NULL,
  `postID` int(10) NOT NULL,
  `commentDate` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `company_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(5) NOT NULL,
  `companyID` int(10) NOT NULL,
  `targetID` int(10) NOT NULL DEFAULT '0',
  `postDate` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `postImg` varchar(200) NOT NULL,
  `updateUser_date` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients`
--

CREATE TABLE `prep_clients` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649230629`
--

CREATE TABLE `prep_clients_partition_1649230629` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649230721`
--

CREATE TABLE `prep_clients_partition_1649230721` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649230773`
--

CREATE TABLE `prep_clients_partition_1649230773` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649230830`
--

CREATE TABLE `prep_clients_partition_1649230830` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649230966`
--

CREATE TABLE `prep_clients_partition_1649230966` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231002`
--

CREATE TABLE `prep_clients_partition_1649231002` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231053`
--

CREATE TABLE `prep_clients_partition_1649231053` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231124`
--

CREATE TABLE `prep_clients_partition_1649231124` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231153`
--

CREATE TABLE `prep_clients_partition_1649231153` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231194`
--

CREATE TABLE `prep_clients_partition_1649231194` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231250`
--

CREATE TABLE `prep_clients_partition_1649231250` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231294`
--

CREATE TABLE `prep_clients_partition_1649231294` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231318`
--

CREATE TABLE `prep_clients_partition_1649231318` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231344`
--

CREATE TABLE `prep_clients_partition_1649231344` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231379`
--

CREATE TABLE `prep_clients_partition_1649231379` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231412`
--

CREATE TABLE `prep_clients_partition_1649231412` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231453`
--

CREATE TABLE `prep_clients_partition_1649231453` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231498`
--

CREATE TABLE `prep_clients_partition_1649231498` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649231545`
--

CREATE TABLE `prep_clients_partition_1649231545` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1649302090`
--

CREATE TABLE `prep_clients_partition_1649302090` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1656659479`
--

CREATE TABLE `prep_clients_partition_1656659479` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1661927794`
--

CREATE TABLE `prep_clients_partition_1661927794` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1661927824`
--

CREATE TABLE `prep_clients_partition_1661927824` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(300) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1672732028`
--

CREATE TABLE `prep_clients_partition_1672732028` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1680504760`
--

CREATE TABLE `prep_clients_partition_1680504760` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1685612349`
--

CREATE TABLE `prep_clients_partition_1685612349` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0',
  `reason_for_stopping` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_clients_partition_1687790108`
--

CREATE TABLE `prep_clients_partition_1687790108` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL DEFAULT '0',
  `_name` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `sex` int(1) NOT NULL DEFAULT '1',
  `age` varchar(5) NOT NULL,
  `id_number` varchar(200) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `risk_level` int(5) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `reverse_index_id` int(1) NOT NULL DEFAULT '0',
  `population_category_id` int(10) NOT NULL DEFAULT '0',
  `implementing_partner_id` int(10) NOT NULL DEFAULT '1',
  `knowledge_source_id` int(10) NOT NULL DEFAULT '1',
  `inter_departmental_referal_id` int(10) NOT NULL DEFAULT '0',
  `message_schedule_id` int(10) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `account_status` int(1) NOT NULL DEFAULT '1',
  `client_status` int(1) NOT NULL DEFAULT '1',
  `entry_method` int(1) NOT NULL DEFAULT '0',
  `client_updated` int(1) NOT NULL DEFAULT '0',
  `address` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers`
--

CREATE TABLE `prep_client_answers` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649231723`
--

CREATE TABLE `prep_client_answers_partition_1649231723` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649231834`
--

CREATE TABLE `prep_client_answers_partition_1649231834` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649231901`
--

CREATE TABLE `prep_client_answers_partition_1649231901` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649231992`
--

CREATE TABLE `prep_client_answers_partition_1649231992` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649232344`
--

CREATE TABLE `prep_client_answers_partition_1649232344` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649232459`
--

CREATE TABLE `prep_client_answers_partition_1649232459` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649232638`
--

CREATE TABLE `prep_client_answers_partition_1649232638` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649232781`
--

CREATE TABLE `prep_client_answers_partition_1649232781` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649232930`
--

CREATE TABLE `prep_client_answers_partition_1649232930` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233073`
--

CREATE TABLE `prep_client_answers_partition_1649233073` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233214`
--

CREATE TABLE `prep_client_answers_partition_1649233214` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233357`
--

CREATE TABLE `prep_client_answers_partition_1649233357` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233467`
--

CREATE TABLE `prep_client_answers_partition_1649233467` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233577`
--

CREATE TABLE `prep_client_answers_partition_1649233577` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233686`
--

CREATE TABLE `prep_client_answers_partition_1649233686` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649233904`
--

CREATE TABLE `prep_client_answers_partition_1649233904` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649234097`
--

CREATE TABLE `prep_client_answers_partition_1649234097` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649234214`
--

CREATE TABLE `prep_client_answers_partition_1649234214` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649234433`
--

CREATE TABLE `prep_client_answers_partition_1649234433` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1649302109`
--

CREATE TABLE `prep_client_answers_partition_1649302109` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1656659504`
--

CREATE TABLE `prep_client_answers_partition_1656659504` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1661927844`
--

CREATE TABLE `prep_client_answers_partition_1661927844` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1661927926`
--

CREATE TABLE `prep_client_answers_partition_1661927926` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1672732088`
--

CREATE TABLE `prep_client_answers_partition_1672732088` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1680504858`
--

CREATE TABLE `prep_client_answers_partition_1680504858` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1685612415`
--

CREATE TABLE `prep_client_answers_partition_1685612415` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_client_answers_partition_1687790131`
--

CREATE TABLE `prep_client_answers_partition_1687790131` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `tmp_client_id` varchar(200) NOT NULL,
  `client_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `questionnaire_data_set_id` int(10) NOT NULL DEFAULT '0',
  `question_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `score` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_decryption_keys`
--

CREATE TABLE `prep_decryption_keys` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `key_code` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL,
  `expiry_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_message_schedule`
--

CREATE TABLE `prep_message_schedule` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `_from` varchar(200) NOT NULL,
  `_to` varchar(200) NOT NULL,
  `form_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `option_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `action_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_message_scheduler`
--

CREATE TABLE `prep_message_scheduler` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '0',
  `days` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `sms_group_ids` text NOT NULL,
  `start_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_message_scheduler_day_entries`
--

CREATE TABLE `prep_message_scheduler_day_entries` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `scheduler_id` int(10) NOT NULL,
  `schedule_day_entry_value` varchar(200) NOT NULL,
  `time_datestamp` varchar(200) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaires`
--

CREATE TABLE `prep_questionnaires` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `branch_id` int(10) NOT NULL,
  `wifi_id` int(10) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `client_identity` int(1) NOT NULL DEFAULT '1',
  `welcome_image` text NOT NULL,
  `passing_score` int(5) NOT NULL DEFAULT '0',
  `finish_script` varchar(200) NOT NULL DEFAULT '0',
  `passing_color` varchar(10) NOT NULL DEFAULT 'green',
  `passing_message` varchar(400) NOT NULL DEFAULT '''''',
  `failing_message` varchar(400) NOT NULL DEFAULT '''''',
  `failing_color` varchar(10) NOT NULL DEFAULT 'brown',
  `prev_nav` int(1) NOT NULL DEFAULT '0',
  `next_nav` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `necessity` int(1) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets`
--

CREATE TABLE `prep_questionnaire_data_sets` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649230629`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649230629` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649230721`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649230721` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649230773`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649230773` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649230830`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649230830` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649230966`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649230966` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231002`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231002` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231053`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231053` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231124`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231124` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231153`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231153` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231194`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231194` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231250`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231250` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231294`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231294` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231318`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231318` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231344`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231344` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231379`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231379` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231412`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231412` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231453`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231453` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231498`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231498` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649231545`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649231545` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1649302090`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1649302090` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1656659479`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1656659479` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1661927794`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1661927794` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1661927824`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1661927824` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1672732028`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1672732028` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1680504760`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1680504760` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1685612349`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1685612349` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_data_sets_partition_1687790108`
--

CREATE TABLE `prep_questionnaire_data_sets_partition_1687790108` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '3',
  `wifi_id` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(200) NOT NULL DEFAULT '0',
  `captive_user_id` int(10) NOT NULL DEFAULT '0',
  `captive_user_year_long_identity` varchar(200) NOT NULL DEFAULT '0',
  `questionnaire_id` int(10) NOT NULL,
  `client_id` int(10) NOT NULL,
  `score` int(10) NOT NULL,
  `user_id` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questionnaire_sessions`
--

CREATE TABLE `prep_questionnaire_sessions` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_questions`
--

CREATE TABLE `prep_questions` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `title` text NOT NULL,
  `option_type` int(1) NOT NULL DEFAULT '0',
  `mandatory` int(1) NOT NULL DEFAULT '1',
  `response_instruction` text NOT NULL,
  `_order` int(5) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_question_options`
--

CREATE TABLE `prep_question_options` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `questionnaire_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `score` int(10) NOT NULL,
  `response_instruction` text NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `_order` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prep_settings`
--

CREATE TABLE `prep_settings` (
  `id` int(100) NOT NULL,
  `company_id` int(10) NOT NULL,
  `last_id` int(200) NOT NULL,
  `last_user` int(100) NOT NULL,
  `_date` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_destributions`
--

CREATE TABLE `product_destributions` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `client_age` varchar(200) NOT NULL,
  `client_sex` varchar(200) NOT NULL,
  `client_phone` varchar(200) NOT NULL,
  `product_id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `date_distributed` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL,
  `gsm_code` varchar(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL,
  `gsm_code` varchar(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `_type` int(1) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `url` text NOT NULL,
  `access_roles` int(10) NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_columns`
--

CREATE TABLE `report_columns` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category_id` int(10) NOT NULL,
  `column_type` int(1) NOT NULL DEFAULT '0',
  `column_table` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_column_categories`
--

CREATE TABLE `report_column_categories` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `script` varchar(200) NOT NULL,
  `_order` int(5) NOT NULL,
  `access_level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `last_buckup_database` varchar(200) NOT NULL,
  `last_buckup_date` varchar(200) NOT NULL,
  `last_restore_date` varchar(200) NOT NULL,
  `last_sync` varchar(200) NOT NULL,
  `start_page_type` int(1) NOT NULL DEFAULT '0',
  `start_page` varchar(200) NOT NULL,
  `prep_report_busy` int(1) NOT NULL DEFAULT '0',
  `limit_attempts` int(1) NOT NULL DEFAULT '1',
  `allowed_attempts` int(10) NOT NULL DEFAULT '5',
  `action_on_limit` int(10) NOT NULL DEFAULT '0',
  `reattempt_delay` int(10) NOT NULL DEFAULT '0',
  `delay_interval` int(10) NOT NULL DEFAULT '5',
  `password_reset` int(1) NOT NULL DEFAULT '0',
  `username_length` int(10) NOT NULL DEFAULT '0',
  `password_strict` int(10) NOT NULL DEFAULT '0',
  `password_length` int(10) DEFAULT '0',
  `password_expiry` int(1) NOT NULL DEFAULT '0',
  `password_expiry_period` varchar(10) NOT NULL DEFAULT '0',
  `auto_backup` int(1) NOT NULL DEFAULT '0',
  `backup_interval` int(10) NOT NULL DEFAULT '0',
  `backup_time` varchar(200) NOT NULL,
  `access_key` text NOT NULL,
  `url` varchar(200) NOT NULL,
  `main_url` varchar(200) NOT NULL,
  `code_url` varchar(200) NOT NULL,
  `prep_url` varchar(200) NOT NULL,
  `prep_assess_url` varchar(200) NOT NULL,
  `cookie_expiry` varchar(200) NOT NULL,
  `url_password_reset` int(1) NOT NULL DEFAULT '0',
  `url_password_reset_period` int(10) NOT NULL DEFAULT '72',
  `last_meeting_code` int(200) NOT NULL,
  `last_meeting_batch_number` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `election_year` int(10) NOT NULL DEFAULT '1',
  `title` varchar(200) NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `mother_facility_id` int(10) NOT NULL,
  `constituency_code` varchar(200) NOT NULL DEFAULT '0',
  `_province_id` int(10) NOT NULL DEFAULT '0',
  `_district_id` int(10) NOT NULL DEFAULT '0',
  `_constituency_id` int(10) NOT NULL DEFAULT '0',
  `_ward_id` int(10) NOT NULL DEFAULT '0',
  `gsm_code` varchar(10) NOT NULL,
  `gsm_code_2` varchar(200) NOT NULL DEFAULT '0',
  `status` varchar(200) NOT NULL,
  `identified` varchar(200) NOT NULL,
  `started` varchar(200) NOT NULL,
  `assessment` varchar(200) NOT NULL,
  `grading` int(10) NOT NULL DEFAULT '0',
  `gps_code` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `site_type` int(10) NOT NULL DEFAULT '0',
  `active_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_clients`
--

CREATE TABLE `sms_clients` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL DEFAULT '0',
  `province_id` int(10) NOT NULL DEFAULT '0',
  `hub_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `group_id` int(10) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `user_date` varchar(200) NOT NULL,
  `agent_date` varchar(200) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_groups`
--

CREATE TABLE `sms_groups` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `schedule_ids` text NOT NULL,
  `agent_type_ids` text NOT NULL,
  `user_date` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_queue`
--

CREATE TABLE `sms_queue` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `sms_setting_id` int(10) NOT NULL DEFAULT '1',
  `group_id` int(10) NOT NULL DEFAULT '0',
  `client_id` int(10) NOT NULL DEFAULT '0',
  `sms_id` int(10) NOT NULL DEFAULT '0',
  `_from` varchar(200) NOT NULL,
  `_to` varchar(200) NOT NULL,
  `text_message` text NOT NULL,
  `_date` varchar(200) NOT NULL,
  `send_status` int(1) NOT NULL DEFAULT '0',
  `date_sent` varchar(200) NOT NULL DEFAULT '0',
  `user_date` varchar(200) NOT NULL,
  `active_status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_ussd_settings`
--

CREATE TABLE `sms_ussd_settings` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `port` varchar(200) NOT NULL,
  `_username` varchar(200) NOT NULL,
  `_password` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `source_location_data`
--

CREATE TABLE `source_location_data` (
  `id` int(10) NOT NULL,
  `province` varchar(13) DEFAULT NULL,
  `district` varchar(13) DEFAULT NULL,
  `constituency` varchar(16) DEFAULT NULL,
  `ward` varchar(26) DEFAULT NULL,
  `area` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `male_voters` varchar(200) NOT NULL DEFAULT '0',
  `female_voters` varchar(200) NOT NULL DEFAULT '0',
  `streams` int(10) NOT NULL DEFAULT '1',
  `ward_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `constituency_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `station_code` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sync_queue`
--

CREATE TABLE `sync_queue` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `sync_type` int(1) NOT NULL DEFAULT '0',
  `_code` text NOT NULL,
  `_date` varchar(200) NOT NULL,
  `update_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_partitions`
--

CREATE TABLE `table_partitions` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `_type` int(2) NOT NULL,
  `period_from` varchar(100) NOT NULL,
  `period_to` varchar(100) NOT NULL,
  `partition_code` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `module_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `entry_type` int(1) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date_entered` varchar(200) NOT NULL,
  `auto_check_date` varchar(200) NOT NULL,
  `_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_images`
--

CREATE TABLE `tmp_images` (
  `id` int(10) NOT NULL,
  `file_src` varchar(200) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unallocated_prep_ids`
--

CREATE TABLE `unallocated_prep_ids` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `prep_id` int(10) NOT NULL,
  `_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_ids` text NOT NULL,
  `agent_type_ids` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `gsm_code` varchar(200) NOT NULL,
  `ussd_code` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL DEFAULT '100',
  `status` int(1) NOT NULL DEFAULT '1',
  `updated` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `company_id` int(1) DEFAULT NULL,
  `branch_id` int(1) DEFAULT NULL,
  `user_group_ids` text NOT NULL,
  `_date` int(10) DEFAULT NULL,
  `_name` varchar(26) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `responsibility` varchar(45) DEFAULT NULL,
  `qualification` varchar(38) DEFAULT '0',
  `email` varchar(39) DEFAULT NULL,
  `phone` varchar(27) DEFAULT NULL,
  `id_type` int(1) DEFAULT NULL,
  `id_number` varchar(26) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `region_id` int(2) DEFAULT NULL,
  `province_id` int(2) DEFAULT NULL,
  `hub_id` int(3) DEFAULT NULL,
  `mother_facility_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(4) DEFAULT NULL,
  `unit_id` int(2) DEFAULT NULL,
  `user_code` varchar(1) DEFAULT '0',
  `roles` varchar(200) DEFAULT NULL,
  `access_limit` int(1) DEFAULT '0',
  `election_year` int(1) DEFAULT '1',
  `recoveryRequest` int(1) DEFAULT '0',
  `status` int(1) DEFAULT NULL,
  `prep_decryption_key_id` int(2) DEFAULT '0',
  `code_session_expiry` varchar(10) DEFAULT '0',
  `bgColor` varchar(4) DEFAULT '#fff',
  `bgImage` varchar(245) DEFAULT NULL,
  `theme_ind` int(2) DEFAULT '2',
  `foregroundColor` varchar(4) DEFAULT '#000',
  `foregroundTxtColor` varchar(4) DEFAULT '#000',
  `foregroundOpacity` int(2) DEFAULT '20',
  `paperColor` varchar(4) DEFAULT '#fff',
  `paperTxtColor` varchar(4) DEFAULT '#000',
  `paperOpacity` int(2) DEFAULT '90',
  `updated` varchar(10) DEFAULT '0',
  `updateUser_date` varchar(10) DEFAULT '0',
  `department_id` int(1) DEFAULT NULL,
  `department_division_id` int(2) DEFAULT NULL,
  `supervisor` int(3) DEFAULT NULL,
  `division_supervisor` int(1) DEFAULT NULL,
  `virtualworkplace_access` int(1) NOT NULL DEFAULT '1',
  `virtualworkplace_organisation_id` int(10) NOT NULL DEFAULT '0',
  `workplace_administration_unit_id` int(10) NOT NULL DEFAULT '0',
  `virtualworkplace_location` varchar(200) NOT NULL DEFAULT '0',
  `email_send_rule` int(1) DEFAULT '0',
  `img_src` varchar(28) DEFAULT '',
  `online_refresh` int(10) DEFAULT '0',
  `old_id` varchar(3) DEFAULT '0',
  `claims_id` varchar(5) DEFAULT '0',
  `claims_date` varchar(23) DEFAULT '0',
  `signature_src` varchar(200) NOT NULL DEFAULT '',
  `login_attempts` int(10) NOT NULL DEFAULT '0',
  `reset_code` varchar(100) NOT NULL DEFAULT '0',
  `last_password_change` varchar(100) NOT NULL,
  `password_reset_url` varchar(200) NOT NULL DEFAULT '''''',
  `password_reset_request_date` varchar(200) NOT NULL DEFAULT ''''''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_access_log`
--

CREATE TABLE `user_access_log` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `entry_type` int(1) NOT NULL DEFAULT '0',
  `_date` varchar(200) NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(3) NOT NULL,
  `title` varchar(26) DEFAULT NULL,
  `roles` varchar(39) DEFAULT NULL,
  `supervisor_date` varchar(200) NOT NULL,
  `company_id` int(1) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `branch_id` int(1) DEFAULT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `non_admin` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ussd_activity_log`
--

CREATE TABLE `ussd_activity_log` (
  `id` int(10) NOT NULL,
  `c_id` varchar(200) NOT NULL,
  `company_id` int(10) NOT NULL,
  `ussd_code` text NOT NULL,
  `region_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `agent_id` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ussd_areas`
--

CREATE TABLE `ussd_areas` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `script` varchar(200) NOT NULL,
  `max_levels` int(5) NOT NULL,
  `_order` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ussd_menu`
--

CREATE TABLE `ussd_menu` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '0',
  `ussd_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `parent_ussd_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_type` int(1) NOT NULL DEFAULT '0',
  `script` varchar(200) NOT NULL,
  `level` int(5) NOT NULL,
  `show_id` int(1) NOT NULL DEFAULT '1',
  `_order` int(5) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ussd_screening_clients`
--

CREATE TABLE `ussd_screening_clients` (
  `id` int(10) NOT NULL,
  `c_id` varchar(200) NOT NULL,
  `question_string` text NOT NULL,
  `response_string` text NOT NULL,
  `score` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ussd_sessions`
--

CREATE TABLE `ussd_sessions` (
  `id` int(10) NOT NULL,
  `c_id` varchar(200) NOT NULL,
  `ussd_string` text NOT NULL,
  `ussd_string_ids` text NOT NULL,
  `menu_level` int(10) NOT NULL DEFAULT '0',
  `timeout` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `virtualworkplace_administrations`
--

CREATE TABLE `virtualworkplace_administrations` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `organisation_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `_order` int(10) NOT NULL,
  `_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `virtualworkplace_administration_units`
--

CREATE TABLE `virtualworkplace_administration_units` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `organisation_id` int(10) NOT NULL,
  `administration_type` int(1) NOT NULL DEFAULT '0',
  `region_id` int(10) NOT NULL DEFAULT '0',
  `province_id` int(10) NOT NULL DEFAULT '0',
  `hub_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `administration_id` int(10) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `_order` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `virtualworkplace_files`
--

CREATE TABLE `virtualworkplace_files` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `access_type` int(10) NOT NULL,
  `from_id` int(10) NOT NULL,
  `to_id` int(10) NOT NULL,
  `file_src` text NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `virtualworkplace_organisations`
--

CREATE TABLE `virtualworkplace_organisations` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `structure_type` int(1) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `_order` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_covid_clients`
--

CREATE TABLE `visitor_covid_clients` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `_name` varchar(200) NOT NULL,
  `id_number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_covid_tempretures`
--

CREATE TABLE `visitor_covid_tempretures` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `client_type` int(1) NOT NULL DEFAULT '0',
  `client_id` int(10) NOT NULL DEFAULT '0',
  `tempreture` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL,
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wifis`
--

CREATE TABLE `wifis` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `starting_ip` varchar(200) NOT NULL,
  `ending_ip` varchar(200) NOT NULL,
  `confirmation_message` text NOT NULL,
  `redirect_url` varchar(200) NOT NULL,
  `login_script` varchar(200) NOT NULL,
  `login_delay` int(10) NOT NULL,
  `white_list` text NOT NULL,
  `relogin` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_areas`
--

CREATE TABLE `_areas` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `constituency_id` int(10) NOT NULL,
  `ward_id` int(10) NOT NULL,
  `_code` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_constituencies`
--

CREATE TABLE `_constituencies` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL DEFAULT '1',
  `title` varchar(200) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_data`
--

CREATE TABLE `_data` (
  `id` int(10) NOT NULL,
  `unit_id` int(10) NOT NULL,
  `activity_id` int(10) NOT NULL,
  `_value` int(10) NOT NULL,
  `validation_status` int(1) NOT NULL DEFAULT '0',
  `validation_user_date` varchar(200) NOT NULL DEFAULT '0',
  `agent_id` int(10) NOT NULL,
  `site_status` varchar(200) NOT NULL DEFAULT '0',
  `site_latitude` varchar(200) NOT NULL DEFAULT '0',
  `site_longitude` varchar(200) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '1',
  `company_id` int(10) NOT NULL DEFAULT '1',
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `_date` int(200) NOT NULL,
  `img_src` varchar(200) NOT NULL,
  `alarm_status` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_data_new`
--

CREATE TABLE `_data_new` (
  `id` int(10) NOT NULL,
  `unit_id` int(10) NOT NULL,
  `activity_id` int(10) NOT NULL,
  `_value` int(10) NOT NULL,
  `validation_status` int(1) NOT NULL DEFAULT '0',
  `validation_user_date` varchar(200) NOT NULL DEFAULT '0',
  `agent_id` int(10) NOT NULL,
  `site_status` varchar(200) NOT NULL DEFAULT '0',
  `site_latitude` varchar(200) NOT NULL DEFAULT '0',
  `site_longitude` varchar(200) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL,
  `hub_id` int(10) NOT NULL,
  `province_id` int(10) NOT NULL,
  `region_id` int(10) NOT NULL,
  `entry_method` int(1) NOT NULL DEFAULT '1',
  `company_id` int(10) NOT NULL DEFAULT '1',
  `branch_id` int(10) NOT NULL DEFAULT '0',
  `_date` int(200) NOT NULL,
  `img_src` varchar(200) NOT NULL,
  `alarm_status` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_districts`
--

CREATE TABLE `_districts` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `province_id` int(10) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_provinces`
--

CREATE TABLE `_provinces` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_wards`
--

CREATE TABLE `_wards` (
  `id` int(11) NOT NULL,
  `company_id` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `province_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `constituency_id` int(10) NOT NULL,
  `updated` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_targets`
--
ALTER TABLE `activity_targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_groups`
--
ALTER TABLE `affiliate_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_questions`
--
ALTER TABLE `affiliate_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929183`
--
ALTER TABLE `agents_partition_1659929183`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929204`
--
ALTER TABLE `agents_partition_1659929204`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929224`
--
ALTER TABLE `agents_partition_1659929224`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929253`
--
ALTER TABLE `agents_partition_1659929253`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929288`
--
ALTER TABLE `agents_partition_1659929288`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929315`
--
ALTER TABLE `agents_partition_1659929315`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929355`
--
ALTER TABLE `agents_partition_1659929355`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929383`
--
ALTER TABLE `agents_partition_1659929383`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929412`
--
ALTER TABLE `agents_partition_1659929412`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929450`
--
ALTER TABLE `agents_partition_1659929450`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929514`
--
ALTER TABLE `agents_partition_1659929514`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1659929554`
--
ALTER TABLE `agents_partition_1659929554`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1672732047`
--
ALTER TABLE `agents_partition_1672732047`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1677674525`
--
ALTER TABLE `agents_partition_1677674525`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1683015381`
--
ALTER TABLE `agents_partition_1683015381`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agents_partition_1687790002`
--
ALTER TABLE `agents_partition_1687790002`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_files`
--
ALTER TABLE `agent_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_types`
--
ALTER TABLE `agent_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bg_images`
--
ALTER TABLE `bg_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin`
--
ALTER TABLE `bin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `captive_data_sets`
--
ALTER TABLE `captive_data_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_tracker`
--
ALTER TABLE `change_tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_screening`
--
ALTER TABLE `client_screening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `covid_clients`
--
ALTER TABLE `covid_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_divisions`
--
ALTER TABLE `department_divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_checklists`
--
ALTER TABLE `dynamic_checklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_checklist_categories`
--
ALTER TABLE `dynamic_checklist_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_checklist_category_options`
--
ALTER TABLE `dynamic_checklist_category_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_checklist_data_sets`
--
ALTER TABLE `dynamic_checklist_data_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_checklist_values`
--
ALTER TABLE `dynamic_checklist_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_dashboards`
--
ALTER TABLE `dynamic_dashboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_dashboard_areas`
--
ALTER TABLE `dynamic_dashboard_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_forms`
--
ALTER TABLE `dynamic_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_categories`
--
ALTER TABLE `dynamic_form_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_category_options`
--
ALTER TABLE `dynamic_form_category_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets`
--
ALTER TABLE `dynamic_form_data_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649230629`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230629`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649230721`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230721`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649230773`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230773`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649230830`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230830`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649230966`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230966`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231002`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231002`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231053`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231053`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231124`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231124`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231153`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231153`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231194`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231194`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231250`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231250`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231294`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231294`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231318`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231318`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231344`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231344`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231379`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231379`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231412`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231412`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231453`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231453`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231498`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231498`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649231545`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231545`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1649302090`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649302090`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1656659479`
--
ALTER TABLE `dynamic_form_data_sets_partition_1656659479`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1661927794`
--
ALTER TABLE `dynamic_form_data_sets_partition_1661927794`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1661927824`
--
ALTER TABLE `dynamic_form_data_sets_partition_1661927824`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1672732028`
--
ALTER TABLE `dynamic_form_data_sets_partition_1672732028`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1680504760`
--
ALTER TABLE `dynamic_form_data_sets_partition_1680504760`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1685612349`
--
ALTER TABLE `dynamic_form_data_sets_partition_1685612349`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_data_sets_partition_1687790108`
--
ALTER TABLE `dynamic_form_data_sets_partition_1687790108`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values`
--
ALTER TABLE `dynamic_form_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649231723`
--
ALTER TABLE `dynamic_form_values_partition_1649231723`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649231834`
--
ALTER TABLE `dynamic_form_values_partition_1649231834`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649231901`
--
ALTER TABLE `dynamic_form_values_partition_1649231901`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649231992`
--
ALTER TABLE `dynamic_form_values_partition_1649231992`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649232344`
--
ALTER TABLE `dynamic_form_values_partition_1649232344`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649232459`
--
ALTER TABLE `dynamic_form_values_partition_1649232459`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649232638`
--
ALTER TABLE `dynamic_form_values_partition_1649232638`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649232781`
--
ALTER TABLE `dynamic_form_values_partition_1649232781`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649232930`
--
ALTER TABLE `dynamic_form_values_partition_1649232930`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233073`
--
ALTER TABLE `dynamic_form_values_partition_1649233073`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233214`
--
ALTER TABLE `dynamic_form_values_partition_1649233214`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233357`
--
ALTER TABLE `dynamic_form_values_partition_1649233357`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233467`
--
ALTER TABLE `dynamic_form_values_partition_1649233467`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233577`
--
ALTER TABLE `dynamic_form_values_partition_1649233577`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233686`
--
ALTER TABLE `dynamic_form_values_partition_1649233686`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649233904`
--
ALTER TABLE `dynamic_form_values_partition_1649233904`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649234097`
--
ALTER TABLE `dynamic_form_values_partition_1649234097`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649234214`
--
ALTER TABLE `dynamic_form_values_partition_1649234214`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649234433`
--
ALTER TABLE `dynamic_form_values_partition_1649234433`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1649302109`
--
ALTER TABLE `dynamic_form_values_partition_1649302109`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1656659504`
--
ALTER TABLE `dynamic_form_values_partition_1656659504`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1661927844`
--
ALTER TABLE `dynamic_form_values_partition_1661927844`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1661927926`
--
ALTER TABLE `dynamic_form_values_partition_1661927926`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1672732088`
--
ALTER TABLE `dynamic_form_values_partition_1672732088`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1680504858`
--
ALTER TABLE `dynamic_form_values_partition_1680504858`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1685612415`
--
ALTER TABLE `dynamic_form_values_partition_1685612415`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_form_values_partition_1687790131`
--
ALTER TABLE `dynamic_form_values_partition_1687790131`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_graphs`
--
ALTER TABLE `dynamic_graphs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_graph_types`
--
ALTER TABLE `dynamic_graph_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_reports`
--
ALTER TABLE `dynamic_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_report_cache`
--
ALTER TABLE `dynamic_report_cache`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_report_primary_columns`
--
ALTER TABLE `dynamic_report_primary_columns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_report_primary_column_types`
--
ALTER TABLE `dynamic_report_primary_column_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `election_categories`
--
ALTER TABLE `election_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `election_years`
--
ALTER TABLE `election_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_queue`
--
ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excel_output`
--
ALTER TABLE `excel_output`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `external_apps`
--
ALTER TABLE `external_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forecast`
--
ALTER TABLE `forecast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hiv_clients`
--
ALTER TABLE `hiv_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubs`
--
ALTER TABLE `hubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_types`
--
ALTER TABLE `id_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licensekeys`
--
ALTER TABLE `licensekeys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licensing`
--
ALTER TABLE `licensing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_send_queue`
--
ALTER TABLE `mail_send_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_batches`
--
ALTER TABLE `meeting_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_batch_participants`
--
ALTER TABLE `meeting_batch_participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting_participants`
--
ALTER TABLE `meeting_participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mother_facilities`
--
ALTER TABLE `mother_facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_scripts`
--
ALTER TABLE `offline_scripts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_folders`
--
ALTER TABLE `payment_folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_folder_data`
--
ALTER TABLE `payment_folder_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_folder_data_sets`
--
ALTER TABLE `payment_folder_data_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_folder_months`
--
ALTER TABLE `payment_folder_months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbi_campaign_users`
--
ALTER TABLE `pbi_campaign_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929183`
--
ALTER TABLE `phone_numbers_partition_1659929183`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929204`
--
ALTER TABLE `phone_numbers_partition_1659929204`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929224`
--
ALTER TABLE `phone_numbers_partition_1659929224`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929253`
--
ALTER TABLE `phone_numbers_partition_1659929253`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929288`
--
ALTER TABLE `phone_numbers_partition_1659929288`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929315`
--
ALTER TABLE `phone_numbers_partition_1659929315`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929355`
--
ALTER TABLE `phone_numbers_partition_1659929355`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929383`
--
ALTER TABLE `phone_numbers_partition_1659929383`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929412`
--
ALTER TABLE `phone_numbers_partition_1659929412`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929450`
--
ALTER TABLE `phone_numbers_partition_1659929450`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929514`
--
ALTER TABLE `phone_numbers_partition_1659929514`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1659929554`
--
ALTER TABLE `phone_numbers_partition_1659929554`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1672732047`
--
ALTER TABLE `phone_numbers_partition_1672732047`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1677674525`
--
ALTER TABLE `phone_numbers_partition_1677674525`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1683015381`
--
ALTER TABLE `phone_numbers_partition_1683015381`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_numbers_partition_1687790002`
--
ALTER TABLE `phone_numbers_partition_1687790002`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `political_parties`
--
ALTER TABLE `political_parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `population_categories`
--
ALTER TABLE `population_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients`
--
ALTER TABLE `prep_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649230629`
--
ALTER TABLE `prep_clients_partition_1649230629`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649230721`
--
ALTER TABLE `prep_clients_partition_1649230721`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649230773`
--
ALTER TABLE `prep_clients_partition_1649230773`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649230830`
--
ALTER TABLE `prep_clients_partition_1649230830`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649230966`
--
ALTER TABLE `prep_clients_partition_1649230966`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231002`
--
ALTER TABLE `prep_clients_partition_1649231002`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231053`
--
ALTER TABLE `prep_clients_partition_1649231053`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231124`
--
ALTER TABLE `prep_clients_partition_1649231124`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231153`
--
ALTER TABLE `prep_clients_partition_1649231153`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231194`
--
ALTER TABLE `prep_clients_partition_1649231194`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231250`
--
ALTER TABLE `prep_clients_partition_1649231250`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231294`
--
ALTER TABLE `prep_clients_partition_1649231294`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231318`
--
ALTER TABLE `prep_clients_partition_1649231318`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231344`
--
ALTER TABLE `prep_clients_partition_1649231344`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231379`
--
ALTER TABLE `prep_clients_partition_1649231379`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231412`
--
ALTER TABLE `prep_clients_partition_1649231412`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231453`
--
ALTER TABLE `prep_clients_partition_1649231453`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231498`
--
ALTER TABLE `prep_clients_partition_1649231498`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649231545`
--
ALTER TABLE `prep_clients_partition_1649231545`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1649302090`
--
ALTER TABLE `prep_clients_partition_1649302090`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1656659479`
--
ALTER TABLE `prep_clients_partition_1656659479`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1661927794`
--
ALTER TABLE `prep_clients_partition_1661927794`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1661927824`
--
ALTER TABLE `prep_clients_partition_1661927824`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1672732028`
--
ALTER TABLE `prep_clients_partition_1672732028`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1680504760`
--
ALTER TABLE `prep_clients_partition_1680504760`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1685612349`
--
ALTER TABLE `prep_clients_partition_1685612349`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_clients_partition_1687790108`
--
ALTER TABLE `prep_clients_partition_1687790108`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers`
--
ALTER TABLE `prep_client_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649231723`
--
ALTER TABLE `prep_client_answers_partition_1649231723`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649231834`
--
ALTER TABLE `prep_client_answers_partition_1649231834`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649231901`
--
ALTER TABLE `prep_client_answers_partition_1649231901`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649231992`
--
ALTER TABLE `prep_client_answers_partition_1649231992`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649232344`
--
ALTER TABLE `prep_client_answers_partition_1649232344`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649232459`
--
ALTER TABLE `prep_client_answers_partition_1649232459`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649232638`
--
ALTER TABLE `prep_client_answers_partition_1649232638`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649232781`
--
ALTER TABLE `prep_client_answers_partition_1649232781`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649232930`
--
ALTER TABLE `prep_client_answers_partition_1649232930`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233073`
--
ALTER TABLE `prep_client_answers_partition_1649233073`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233214`
--
ALTER TABLE `prep_client_answers_partition_1649233214`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233357`
--
ALTER TABLE `prep_client_answers_partition_1649233357`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233467`
--
ALTER TABLE `prep_client_answers_partition_1649233467`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233577`
--
ALTER TABLE `prep_client_answers_partition_1649233577`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233686`
--
ALTER TABLE `prep_client_answers_partition_1649233686`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649233904`
--
ALTER TABLE `prep_client_answers_partition_1649233904`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649234097`
--
ALTER TABLE `prep_client_answers_partition_1649234097`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649234214`
--
ALTER TABLE `prep_client_answers_partition_1649234214`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649234433`
--
ALTER TABLE `prep_client_answers_partition_1649234433`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1649302109`
--
ALTER TABLE `prep_client_answers_partition_1649302109`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1656659504`
--
ALTER TABLE `prep_client_answers_partition_1656659504`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1661927844`
--
ALTER TABLE `prep_client_answers_partition_1661927844`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1661927926`
--
ALTER TABLE `prep_client_answers_partition_1661927926`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1672732088`
--
ALTER TABLE `prep_client_answers_partition_1672732088`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1680504858`
--
ALTER TABLE `prep_client_answers_partition_1680504858`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1685612415`
--
ALTER TABLE `prep_client_answers_partition_1685612415`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_client_answers_partition_1687790131`
--
ALTER TABLE `prep_client_answers_partition_1687790131`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_decryption_keys`
--
ALTER TABLE `prep_decryption_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_message_schedule`
--
ALTER TABLE `prep_message_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_message_scheduler`
--
ALTER TABLE `prep_message_scheduler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_message_scheduler_day_entries`
--
ALTER TABLE `prep_message_scheduler_day_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaires`
--
ALTER TABLE `prep_questionnaires`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets`
--
ALTER TABLE `prep_questionnaire_data_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649230629`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230629`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649230721`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230721`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649230773`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230773`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649230830`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230830`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649230966`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230966`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231002`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231002`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231053`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231053`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231124`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231124`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231153`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231153`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231194`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231194`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231250`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231250`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231294`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231294`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231318`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231318`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231344`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231344`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231379`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231379`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231412`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231412`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231453`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231453`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231498`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231498`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649231545`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231545`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1649302090`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649302090`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1656659479`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1656659479`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1661927794`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1661927794`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1661927824`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1661927824`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1672732028`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1672732028`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1680504760`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1680504760`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1685612349`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1685612349`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_data_sets_partition_1687790108`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1687790108`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questionnaire_sessions`
--
ALTER TABLE `prep_questionnaire_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_questions`
--
ALTER TABLE `prep_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_question_options`
--
ALTER TABLE `prep_question_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prep_settings`
--
ALTER TABLE `prep_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_destributions`
--
ALTER TABLE `product_destributions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_columns`
--
ALTER TABLE `report_columns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_column_categories`
--
ALTER TABLE `report_column_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_clients`
--
ALTER TABLE `sms_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_groups`
--
ALTER TABLE `sms_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_queue`
--
ALTER TABLE `sms_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_ussd_settings`
--
ALTER TABLE `sms_ussd_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `source_location_data`
--
ALTER TABLE `source_location_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sync_queue`
--
ALTER TABLE `sync_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_partitions`
--
ALTER TABLE `table_partitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tmp_images`
--
ALTER TABLE `tmp_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unallocated_prep_ids`
--
ALTER TABLE `unallocated_prep_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_log`
--
ALTER TABLE `user_access_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ussd_activity_log`
--
ALTER TABLE `ussd_activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ussd_areas`
--
ALTER TABLE `ussd_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ussd_menu`
--
ALTER TABLE `ussd_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ussd_screening_clients`
--
ALTER TABLE `ussd_screening_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ussd_sessions`
--
ALTER TABLE `ussd_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtualworkplace_administrations`
--
ALTER TABLE `virtualworkplace_administrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtualworkplace_administration_units`
--
ALTER TABLE `virtualworkplace_administration_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtualworkplace_files`
--
ALTER TABLE `virtualworkplace_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `virtualworkplace_organisations`
--
ALTER TABLE `virtualworkplace_organisations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_covid_clients`
--
ALTER TABLE `visitor_covid_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_covid_tempretures`
--
ALTER TABLE `visitor_covid_tempretures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wifis`
--
ALTER TABLE `wifis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_areas`
--
ALTER TABLE `_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_constituencies`
--
ALTER TABLE `_constituencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_data`
--
ALTER TABLE `_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_data_new`
--
ALTER TABLE `_data_new`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_districts`
--
ALTER TABLE `_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_provinces`
--
ALTER TABLE `_provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_wards`
--
ALTER TABLE `_wards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_targets`
--
ALTER TABLE `activity_targets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_groups`
--
ALTER TABLE `affiliate_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_questions`
--
ALTER TABLE `affiliate_questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929183`
--
ALTER TABLE `agents_partition_1659929183`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929204`
--
ALTER TABLE `agents_partition_1659929204`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929224`
--
ALTER TABLE `agents_partition_1659929224`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929253`
--
ALTER TABLE `agents_partition_1659929253`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929288`
--
ALTER TABLE `agents_partition_1659929288`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929315`
--
ALTER TABLE `agents_partition_1659929315`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929355`
--
ALTER TABLE `agents_partition_1659929355`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929383`
--
ALTER TABLE `agents_partition_1659929383`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929412`
--
ALTER TABLE `agents_partition_1659929412`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929450`
--
ALTER TABLE `agents_partition_1659929450`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929514`
--
ALTER TABLE `agents_partition_1659929514`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1659929554`
--
ALTER TABLE `agents_partition_1659929554`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1672732047`
--
ALTER TABLE `agents_partition_1672732047`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1677674525`
--
ALTER TABLE `agents_partition_1677674525`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1683015381`
--
ALTER TABLE `agents_partition_1683015381`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents_partition_1687790002`
--
ALTER TABLE `agents_partition_1687790002`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_files`
--
ALTER TABLE `agent_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_types`
--
ALTER TABLE `agent_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bg_images`
--
ALTER TABLE `bg_images`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bin`
--
ALTER TABLE `bin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `captive_data_sets`
--
ALTER TABLE `captive_data_sets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_tracker`
--
ALTER TABLE `change_tracker`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_screening`
--
ALTER TABLE `client_screening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `covid_clients`
--
ALTER TABLE `covid_clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_divisions`
--
ALTER TABLE `department_divisions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_checklists`
--
ALTER TABLE `dynamic_checklists`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_checklist_categories`
--
ALTER TABLE `dynamic_checklist_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_checklist_category_options`
--
ALTER TABLE `dynamic_checklist_category_options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_checklist_data_sets`
--
ALTER TABLE `dynamic_checklist_data_sets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_checklist_values`
--
ALTER TABLE `dynamic_checklist_values`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_dashboards`
--
ALTER TABLE `dynamic_dashboards`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_dashboard_areas`
--
ALTER TABLE `dynamic_dashboard_areas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_forms`
--
ALTER TABLE `dynamic_forms`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_categories`
--
ALTER TABLE `dynamic_form_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_category_options`
--
ALTER TABLE `dynamic_form_category_options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets`
--
ALTER TABLE `dynamic_form_data_sets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649230629`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230629`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649230721`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230721`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649230773`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230773`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649230830`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230830`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649230966`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649230966`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231002`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231002`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231053`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231053`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231124`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231124`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231153`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231153`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231194`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231194`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231250`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231250`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231294`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231294`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231318`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231318`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231344`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231344`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231379`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231379`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231412`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231412`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231453`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231453`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231498`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231498`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649231545`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649231545`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1649302090`
--
ALTER TABLE `dynamic_form_data_sets_partition_1649302090`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1656659479`
--
ALTER TABLE `dynamic_form_data_sets_partition_1656659479`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1661927794`
--
ALTER TABLE `dynamic_form_data_sets_partition_1661927794`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1661927824`
--
ALTER TABLE `dynamic_form_data_sets_partition_1661927824`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1672732028`
--
ALTER TABLE `dynamic_form_data_sets_partition_1672732028`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1680504760`
--
ALTER TABLE `dynamic_form_data_sets_partition_1680504760`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1685612349`
--
ALTER TABLE `dynamic_form_data_sets_partition_1685612349`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_data_sets_partition_1687790108`
--
ALTER TABLE `dynamic_form_data_sets_partition_1687790108`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values`
--
ALTER TABLE `dynamic_form_values`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649231723`
--
ALTER TABLE `dynamic_form_values_partition_1649231723`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649231834`
--
ALTER TABLE `dynamic_form_values_partition_1649231834`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649231901`
--
ALTER TABLE `dynamic_form_values_partition_1649231901`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649231992`
--
ALTER TABLE `dynamic_form_values_partition_1649231992`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649232344`
--
ALTER TABLE `dynamic_form_values_partition_1649232344`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649232459`
--
ALTER TABLE `dynamic_form_values_partition_1649232459`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649232638`
--
ALTER TABLE `dynamic_form_values_partition_1649232638`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649232781`
--
ALTER TABLE `dynamic_form_values_partition_1649232781`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649232930`
--
ALTER TABLE `dynamic_form_values_partition_1649232930`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233073`
--
ALTER TABLE `dynamic_form_values_partition_1649233073`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233214`
--
ALTER TABLE `dynamic_form_values_partition_1649233214`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233357`
--
ALTER TABLE `dynamic_form_values_partition_1649233357`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233467`
--
ALTER TABLE `dynamic_form_values_partition_1649233467`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233577`
--
ALTER TABLE `dynamic_form_values_partition_1649233577`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233686`
--
ALTER TABLE `dynamic_form_values_partition_1649233686`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649233904`
--
ALTER TABLE `dynamic_form_values_partition_1649233904`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649234097`
--
ALTER TABLE `dynamic_form_values_partition_1649234097`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649234214`
--
ALTER TABLE `dynamic_form_values_partition_1649234214`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649234433`
--
ALTER TABLE `dynamic_form_values_partition_1649234433`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1649302109`
--
ALTER TABLE `dynamic_form_values_partition_1649302109`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1656659504`
--
ALTER TABLE `dynamic_form_values_partition_1656659504`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1661927844`
--
ALTER TABLE `dynamic_form_values_partition_1661927844`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1661927926`
--
ALTER TABLE `dynamic_form_values_partition_1661927926`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1672732088`
--
ALTER TABLE `dynamic_form_values_partition_1672732088`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1680504858`
--
ALTER TABLE `dynamic_form_values_partition_1680504858`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1685612415`
--
ALTER TABLE `dynamic_form_values_partition_1685612415`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_form_values_partition_1687790131`
--
ALTER TABLE `dynamic_form_values_partition_1687790131`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_graphs`
--
ALTER TABLE `dynamic_graphs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_reports`
--
ALTER TABLE `dynamic_reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_report_cache`
--
ALTER TABLE `dynamic_report_cache`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_report_primary_columns`
--
ALTER TABLE `dynamic_report_primary_columns`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dynamic_report_primary_column_types`
--
ALTER TABLE `dynamic_report_primary_column_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `election_categories`
--
ALTER TABLE `election_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `election_years`
--
ALTER TABLE `election_years`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_queue`
--
ALTER TABLE `email_queue`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `excel_output`
--
ALTER TABLE `excel_output`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `external_apps`
--
ALTER TABLE `external_apps`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forecast`
--
ALTER TABLE `forecast`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hiv_clients`
--
ALTER TABLE `hiv_clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubs`
--
ALTER TABLE `hubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id_types`
--
ALTER TABLE `id_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licensekeys`
--
ALTER TABLE `licensekeys`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licensing`
--
ALTER TABLE `licensing`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_send_queue`
--
ALTER TABLE `mail_send_queue`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_batches`
--
ALTER TABLE `meeting_batches`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_batch_participants`
--
ALTER TABLE `meeting_batch_participants`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_participants`
--
ALTER TABLE `meeting_participants`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mother_facilities`
--
ALTER TABLE `mother_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_scripts`
--
ALTER TABLE `offline_scripts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_folders`
--
ALTER TABLE `payment_folders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_folder_data`
--
ALTER TABLE `payment_folder_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_folder_data_sets`
--
ALTER TABLE `payment_folder_data_sets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_folder_months`
--
ALTER TABLE `payment_folder_months`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pbi_campaign_users`
--
ALTER TABLE `pbi_campaign_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929183`
--
ALTER TABLE `phone_numbers_partition_1659929183`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929204`
--
ALTER TABLE `phone_numbers_partition_1659929204`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929224`
--
ALTER TABLE `phone_numbers_partition_1659929224`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929253`
--
ALTER TABLE `phone_numbers_partition_1659929253`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929288`
--
ALTER TABLE `phone_numbers_partition_1659929288`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929315`
--
ALTER TABLE `phone_numbers_partition_1659929315`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929355`
--
ALTER TABLE `phone_numbers_partition_1659929355`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929383`
--
ALTER TABLE `phone_numbers_partition_1659929383`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929412`
--
ALTER TABLE `phone_numbers_partition_1659929412`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929450`
--
ALTER TABLE `phone_numbers_partition_1659929450`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929514`
--
ALTER TABLE `phone_numbers_partition_1659929514`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1659929554`
--
ALTER TABLE `phone_numbers_partition_1659929554`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1672732047`
--
ALTER TABLE `phone_numbers_partition_1672732047`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1677674525`
--
ALTER TABLE `phone_numbers_partition_1677674525`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1683015381`
--
ALTER TABLE `phone_numbers_partition_1683015381`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_numbers_partition_1687790002`
--
ALTER TABLE `phone_numbers_partition_1687790002`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `political_parties`
--
ALTER TABLE `political_parties`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `population_categories`
--
ALTER TABLE `population_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients`
--
ALTER TABLE `prep_clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649230629`
--
ALTER TABLE `prep_clients_partition_1649230629`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649230721`
--
ALTER TABLE `prep_clients_partition_1649230721`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649230773`
--
ALTER TABLE `prep_clients_partition_1649230773`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649230830`
--
ALTER TABLE `prep_clients_partition_1649230830`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649230966`
--
ALTER TABLE `prep_clients_partition_1649230966`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231002`
--
ALTER TABLE `prep_clients_partition_1649231002`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231053`
--
ALTER TABLE `prep_clients_partition_1649231053`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231124`
--
ALTER TABLE `prep_clients_partition_1649231124`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231153`
--
ALTER TABLE `prep_clients_partition_1649231153`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231194`
--
ALTER TABLE `prep_clients_partition_1649231194`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231250`
--
ALTER TABLE `prep_clients_partition_1649231250`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231294`
--
ALTER TABLE `prep_clients_partition_1649231294`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231318`
--
ALTER TABLE `prep_clients_partition_1649231318`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231344`
--
ALTER TABLE `prep_clients_partition_1649231344`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231379`
--
ALTER TABLE `prep_clients_partition_1649231379`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231412`
--
ALTER TABLE `prep_clients_partition_1649231412`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231453`
--
ALTER TABLE `prep_clients_partition_1649231453`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231498`
--
ALTER TABLE `prep_clients_partition_1649231498`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649231545`
--
ALTER TABLE `prep_clients_partition_1649231545`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1649302090`
--
ALTER TABLE `prep_clients_partition_1649302090`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1656659479`
--
ALTER TABLE `prep_clients_partition_1656659479`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1661927794`
--
ALTER TABLE `prep_clients_partition_1661927794`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1661927824`
--
ALTER TABLE `prep_clients_partition_1661927824`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1672732028`
--
ALTER TABLE `prep_clients_partition_1672732028`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1680504760`
--
ALTER TABLE `prep_clients_partition_1680504760`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1685612349`
--
ALTER TABLE `prep_clients_partition_1685612349`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_clients_partition_1687790108`
--
ALTER TABLE `prep_clients_partition_1687790108`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers`
--
ALTER TABLE `prep_client_answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649231723`
--
ALTER TABLE `prep_client_answers_partition_1649231723`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649231834`
--
ALTER TABLE `prep_client_answers_partition_1649231834`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649231901`
--
ALTER TABLE `prep_client_answers_partition_1649231901`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649231992`
--
ALTER TABLE `prep_client_answers_partition_1649231992`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649232344`
--
ALTER TABLE `prep_client_answers_partition_1649232344`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649232459`
--
ALTER TABLE `prep_client_answers_partition_1649232459`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649232638`
--
ALTER TABLE `prep_client_answers_partition_1649232638`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649232781`
--
ALTER TABLE `prep_client_answers_partition_1649232781`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649232930`
--
ALTER TABLE `prep_client_answers_partition_1649232930`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233073`
--
ALTER TABLE `prep_client_answers_partition_1649233073`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233214`
--
ALTER TABLE `prep_client_answers_partition_1649233214`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233357`
--
ALTER TABLE `prep_client_answers_partition_1649233357`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233467`
--
ALTER TABLE `prep_client_answers_partition_1649233467`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233577`
--
ALTER TABLE `prep_client_answers_partition_1649233577`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233686`
--
ALTER TABLE `prep_client_answers_partition_1649233686`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649233904`
--
ALTER TABLE `prep_client_answers_partition_1649233904`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649234097`
--
ALTER TABLE `prep_client_answers_partition_1649234097`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649234214`
--
ALTER TABLE `prep_client_answers_partition_1649234214`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649234433`
--
ALTER TABLE `prep_client_answers_partition_1649234433`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1649302109`
--
ALTER TABLE `prep_client_answers_partition_1649302109`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1656659504`
--
ALTER TABLE `prep_client_answers_partition_1656659504`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1661927844`
--
ALTER TABLE `prep_client_answers_partition_1661927844`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1661927926`
--
ALTER TABLE `prep_client_answers_partition_1661927926`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1672732088`
--
ALTER TABLE `prep_client_answers_partition_1672732088`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1680504858`
--
ALTER TABLE `prep_client_answers_partition_1680504858`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1685612415`
--
ALTER TABLE `prep_client_answers_partition_1685612415`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_client_answers_partition_1687790131`
--
ALTER TABLE `prep_client_answers_partition_1687790131`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_decryption_keys`
--
ALTER TABLE `prep_decryption_keys`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_message_schedule`
--
ALTER TABLE `prep_message_schedule`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_message_scheduler`
--
ALTER TABLE `prep_message_scheduler`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_message_scheduler_day_entries`
--
ALTER TABLE `prep_message_scheduler_day_entries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaires`
--
ALTER TABLE `prep_questionnaires`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets`
--
ALTER TABLE `prep_questionnaire_data_sets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649230629`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230629`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649230721`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230721`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649230773`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230773`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649230830`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230830`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649230966`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649230966`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231002`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231002`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231053`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231053`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231124`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231124`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231153`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231153`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231194`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231194`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231250`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231250`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231294`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231294`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231318`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231318`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231344`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231344`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231379`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231379`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231412`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231412`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231453`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231453`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231498`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231498`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649231545`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649231545`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1649302090`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1649302090`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1656659479`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1656659479`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1661927794`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1661927794`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1661927824`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1661927824`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1672732028`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1672732028`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1680504760`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1680504760`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1685612349`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1685612349`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_data_sets_partition_1687790108`
--
ALTER TABLE `prep_questionnaire_data_sets_partition_1687790108`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questionnaire_sessions`
--
ALTER TABLE `prep_questionnaire_sessions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_questions`
--
ALTER TABLE `prep_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_question_options`
--
ALTER TABLE `prep_question_options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prep_settings`
--
ALTER TABLE `prep_settings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_destributions`
--
ALTER TABLE `product_destributions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_columns`
--
ALTER TABLE `report_columns`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_column_categories`
--
ALTER TABLE `report_column_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_clients`
--
ALTER TABLE `sms_clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_groups`
--
ALTER TABLE `sms_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_queue`
--
ALTER TABLE `sms_queue`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_ussd_settings`
--
ALTER TABLE `sms_ussd_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_location_data`
--
ALTER TABLE `source_location_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sync_queue`
--
ALTER TABLE `sync_queue`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_partitions`
--
ALTER TABLE `table_partitions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_images`
--
ALTER TABLE `tmp_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unallocated_prep_ids`
--
ALTER TABLE `unallocated_prep_ids`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_access_log`
--
ALTER TABLE `user_access_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ussd_activity_log`
--
ALTER TABLE `ussd_activity_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ussd_areas`
--
ALTER TABLE `ussd_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ussd_menu`
--
ALTER TABLE `ussd_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ussd_screening_clients`
--
ALTER TABLE `ussd_screening_clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ussd_sessions`
--
ALTER TABLE `ussd_sessions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `virtualworkplace_administration_units`
--
ALTER TABLE `virtualworkplace_administration_units`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `virtualworkplace_files`
--
ALTER TABLE `virtualworkplace_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `virtualworkplace_organisations`
--
ALTER TABLE `virtualworkplace_organisations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_covid_clients`
--
ALTER TABLE `visitor_covid_clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_covid_tempretures`
--
ALTER TABLE `visitor_covid_tempretures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wifis`
--
ALTER TABLE `wifis`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_areas`
--
ALTER TABLE `_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_constituencies`
--
ALTER TABLE `_constituencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_data`
--
ALTER TABLE `_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_data_new`
--
ALTER TABLE `_data_new`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_districts`
--
ALTER TABLE `_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_provinces`
--
ALTER TABLE `_provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_wards`
--
ALTER TABLE `_wards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
