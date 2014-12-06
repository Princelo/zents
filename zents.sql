-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: 118.123.16.148
-- Generation Time: Dec 06, 2014 at 09:56 AM
-- Server version: 5.1.69
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zents`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` varchar(32) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10114 ;

-- --------------------------------------------------------

--
-- Table structure for table `failed_voted_log`
--

CREATE TABLE IF NOT EXISTS `failed_voted_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_agent` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `ip` char(15) NOT NULL,
  `vote_datetime` int(10) NOT NULL,
  `strdate` char(19) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `flash`
--

CREATE TABLE IF NOT EXISTS `flash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `playerlist`
--

CREATE TABLE IF NOT EXISTS `playerlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_chi` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `prcid` char(18) NOT NULL,
  `address` varchar(255) NOT NULL,
  `song` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `vote` bigint(20) NOT NULL DEFAULT '0',
  `is_valid` tinyint(1) NOT NULL DEFAULT '0',
  `avatardir` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `thxlist`
--

CREATE TABLE IF NOT EXISTS `thxlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `hint` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vote_log`
--

CREATE TABLE IF NOT EXISTS `vote_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `vote_datetime` int(10) NOT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1475 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
