-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 24, 2012 at 02:30 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `piqchaco_smsapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `noticeboard`
--

CREATE TABLE IF NOT EXISTS `noticeboard` (
  `userid` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'primary/referral ID',
  `emailaddr` varchar(250) NOT NULL COMMENT 'paid user email address',
  `pswd` varchar(40) NOT NULL COMMENT 'user password',
  `twid` varchar(50) DEFAULT NULL COMMENT 'user twitter unique Id',
  `twname` varchar(20) DEFAULT NULL,
  `twimage` varchar(250) DEFAULT NULL COMMENT 'user profile picture',
  `token` varchar(200) DEFAULT NULL,
  `secret` varchar(200) DEFAULT NULL,
  `payer_id` varchar(200) DEFAULT NULL COMMENT 'paypal associated data',
  `address_name` varchar(250) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `mc_value` varchar(11) DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `pinneddate` datetime NOT NULL COMMENT 'date the user registered',
  `lastlogin` datetime DEFAULT NULL COMMENT 'the last time the user used the application',
  `unpindate` datetime DEFAULT NULL COMMENT 'date the user''s subscription will expire',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `userunique` (`emailaddr`,`twid`,`txn_id`),
  KEY `keys` (`pswd`,`twname`,`twimage`,`token`,`secret`,`address_name`,`unpindate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='twitter user verifier' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `noticeboard`
--

