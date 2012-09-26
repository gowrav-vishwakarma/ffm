-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2012 at 09:34 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ffm`
--

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxcategory`
--

CREATE TABLE IF NOT EXISTS `jos_xxcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_xxcategory`
--

INSERT INTO `jos_xxcategory` (`id`, `name`) VALUES
(1, 'Category1');

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxgroups`
--

CREATE TABLE IF NOT EXISTS `jos_xxgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `Path` text,
  `pos_id` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jos_xxgroups_jos_xxpos1` (`pos_id`),
  KEY `fk_jos_xxgroups_jos_xxheads1` (`head_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `jos_xxgroups`
--

INSERT INTO `jos_xxgroups` (`id`, `name`, `head_id`, `group_id`, `Path`, `pos_id`, `lft`, `rgt`) VALUES
(1, 'root', NULL, NULL, NULL, NULL, 0, 61),
(2, 'Capital Account', 1, NULL, NULL, NULL, 1, 2),
(3, 'Bank OD', 2, NULL, NULL, NULL, 3, 4),
(4, 'Bank CC', 2, NULL, NULL, NULL, 5, 6),
(5, 'Bank Loan', 1, NULL, NULL, NULL, 7, 8),
(6, 'Secured Loan', 1, NULL, NULL, NULL, 9, 10),
(7, 'Un Secured Loan', 2, NULL, NULL, NULL, 11, 12),
(8, 'Sundry Creditors', 3, NULL, NULL, NULL, 13, 16),
(9, 'Duties And Taxes', 3, NULL, NULL, NULL, 17, 18),
(10, 'Provisions', 3, NULL, NULL, NULL, 19, 20),
(11, 'Suspance', 4, NULL, NULL, NULL, 21, 22),
(12, 'Branches And Divisions', 5, NULL, NULL, NULL, 23, 32),
(13, 'Fixed Assets', 6, NULL, NULL, NULL, 33, 34),
(14, 'Investments', 7, NULL, NULL, NULL, 35, 36),
(15, 'Closing Stocks', 8, NULL, NULL, NULL, 37, 38),
(16, 'Current Assets', 8, NULL, NULL, NULL, 39, 42),
(17, 'Loan And Advances (Assets)', 8, NULL, NULL, NULL, 43, 44),
(18, 'Sundry Debtors', 8, NULL, NULL, NULL, 45, 46),
(19, 'Bank Accounts', 8, NULL, NULL, NULL, 47, 48),
(20, 'Direct Expenses', 10, NULL, NULL, NULL, 49, 50),
(21, 'In Direct Expenses', 11, NULL, NULL, NULL, 51, 52),
(22, 'Direct Income', 12, NULL, NULL, NULL, 53, 54),
(23, 'In Direct Income', 13, NULL, NULL, NULL, 55, 56),
(24, 'Purchase Account', 14, NULL, NULL, NULL, 57, 58),
(25, 'Sales Account', 15, NULL, NULL, NULL, 59, 60),
(26, 'My Branches And Division', 5, 12, NULL, 2, 30, 31),
(27, 'Distributors', 3, 8, NULL, NULL, 14, 15),
(28, 'Cash Group', 8, 16, NULL, NULL, 40, 41);

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxheads`
--

CREATE TABLE IF NOT EXISTS `jos_xxheads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `isPANDL` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `jos_xxheads`
--

INSERT INTO `jos_xxheads` (`id`, `name`, `type`, `isPANDL`) VALUES
(1, 'Capital Account', 'Liability', 0),
(2, 'Loans (Liability)', 'Liability', 0),
(3, 'Current Liabilities', 'Liability', 0),
(4, 'Suspance Account', 'Liability', 0),
(5, 'Branch And Division', 'Liability', 0),
(6, 'Fixed Assets', 'Asset', 0),
(7, 'Investements', 'Asset', 0),
(8, 'Current Assets', 'Asset', 0),
(9, 'Loans And Advances (Assets)', 'Asset', 0),
(10, 'Direct Expenses', 'P&L', 1),
(11, 'InDirect Expenses', 'P&L', 1),
(12, 'Direct Income', 'P&L', 1),
(13, 'InDirect Income', 'P&L', 1),
(14, 'Purchase Account', 'P&L', 1),
(15, 'Sales Account', 'P&L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxitems`
--

CREATE TABLE IF NOT EXISTS `jos_xxitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `LastPurchasePrice` float DEFAULT NULL,
  `DP` float DEFAULT NULL,
  `MRP` float DEFAULT NULL,
  `DealerPrice` float DEFAULT NULL,
  `RetailerPrice` float DEFAULT NULL,
  `Unit` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jos_xxitems_jos_xxcategory1` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jos_xxitems`
--

INSERT INTO `jos_xxitems` (`id`, `name`, `category_id`, `LastPurchasePrice`, `DP`, `MRP`, `DealerPrice`, `RetailerPrice`, `Unit`) VALUES
(3, 'Item 1', 1, 0, 100, 150, 120, 130, 'PCS');

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxledgers`
--

CREATE TABLE IF NOT EXISTS `jos_xxledgers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `default_account` tinyint(1) DEFAULT NULL,
  `items_id` int(11) DEFAULT NULL,
  `ledger_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jos_xxledgers_jos_xxgroups1` (`group_id`),
  KEY `fk_jos_xxledgers_jos_xxpos1` (`pos_id`),
  KEY `fk_jos_xxledgers_jos_xxstaff1` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `jos_xxledgers`
--

INSERT INTO `jos_xxledgers` (`id`, `name`, `created_at`, `updated_at`, `distributor_id`, `group_id`, `pos_id`, `staff_id`, `default_account`, `items_id`, `ledger_type`) VALUES
(1, 'pos_1', '2012-09-09 00:00:00', '2012-09-09 00:00:00', 1, 12, NULL, NULL, NULL, NULL, NULL),
(2, 'pos_2', '2012-09-09 00:00:00', '2012-09-09 00:00:00', 8, 12, NULL, NULL, NULL, NULL, NULL),
(3, 'pos_3', '2012-09-09 00:00:00', '2012-09-09 00:00:00', 25, 12, NULL, NULL, 1, NULL, NULL),
(4, 'Ram La bank OD', '2012-09-09 00:00:00', '2012-09-09 00:00:00', NULL, 3, 3, 3, 0, NULL, NULL),
(5, 'Purchase Account', '2012-09-09 00:00:00', '2012-09-09 00:00:00', NULL, 24, NULL, NULL, 1, NULL, NULL),
(6, 'Shyam lal', '2012-09-09 00:00:00', '2012-09-09 00:00:00', NULL, 18, 2, 2, 0, NULL, NULL),
(7, 'My Branch', '2012-09-10 00:00:00', '2012-09-10 00:00:00', NULL, 12, 2, 2, 0, NULL, NULL),
(8, 'My Branch 2', '2012-09-10 00:00:00', '2012-09-10 00:00:00', NULL, 26, 2, 2, 0, NULL, NULL),
(9, 'Discount Taken', '2012-09-10 00:00:00', '2012-09-10 00:00:00', NULL, 23, NULL, NULL, 1, NULL, NULL),
(10, 'Discount Given', '2012-09-10 00:00:00', '2012-09-10 00:00:00', NULL, 21, NULL, NULL, 1, NULL, NULL),
(11, 'Ram Lal', '2012-09-13 00:00:00', '2012-09-13 00:00:00', NULL, 27, 2, 2, 0, NULL, NULL),
(12, 'Sales Account', '2012-09-13 00:00:00', '2012-09-13 00:00:00', NULL, 25, 2, 2, 0, NULL, NULL),
(13, 'Sales Account', '2012-09-13 00:00:00', '2012-09-13 00:00:00', NULL, 25, 3, 3, 0, NULL, NULL),
(14, 'Ram la pos 3', '2012-09-13 00:00:00', '2012-09-13 00:00:00', NULL, 27, 3, 3, 0, NULL, NULL),
(15, 'Cash', '2012-09-14 00:00:00', '2012-09-14 00:00:00', NULL, 28, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxpos`
--

CREATE TABLE IF NOT EXISTS `jos_xxpos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jos_xxpos`
--

INSERT INTO `jos_xxpos` (`id`, `name`, `owner_id`, `type`) VALUES
(1, 'COMPANY POS', 1, 'Company'),
(2, 'Udaipur Depot', 8, 'Depot'),
(3, 'Kota Retailer Shoppe', 25, 'Retailer');

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxstaff`
--

CREATE TABLE IF NOT EXISTS `jos_xxstaff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `AccessLevel` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jos_xxstaff_jos_xxpos` (`pos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jos_xxstaff`
--

INSERT INTO `jos_xxstaff` (`id`, `name`, `username`, `password`, `pos_id`, `AccessLevel`) VALUES
(1, 'COMPANY POS_SUPER_STAFF', 'pos_1_admin', 'admin', 1, '1000'),
(2, 'Udaipur Depot_SUPER_STAFF', 'pos_2_admin', 'admin', 2, '100'),
(3, 'Kota Retailer Shoppe_SUPER_STAFF', 'pos_3_admin', 'admin', 3, '100');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jos_xxgroups`
--
ALTER TABLE `jos_xxgroups`
  ADD CONSTRAINT `fk_jos_xxgroups_jos_xxheads1` FOREIGN KEY (`head_id`) REFERENCES `jos_xxheads` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jos_xxgroups_jos_xxpos1` FOREIGN KEY (`pos_id`) REFERENCES `jos_xxpos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jos_xxitems`
--
ALTER TABLE `jos_xxitems`
  ADD CONSTRAINT `fk_jos_xxitems_jos_xxcategory1` FOREIGN KEY (`category_id`) REFERENCES `jos_xxcategory` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jos_xxledgers`
--
ALTER TABLE `jos_xxledgers`
  ADD CONSTRAINT `fk_jos_xxledgers_jos_xxgroups1` FOREIGN KEY (`group_id`) REFERENCES `jos_xxgroups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jos_xxledgers_jos_xxpos1` FOREIGN KEY (`pos_id`) REFERENCES `jos_xxpos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jos_xxledgers_jos_xxstaff1` FOREIGN KEY (`staff_id`) REFERENCES `jos_xxstaff` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jos_xxstaff`
--
ALTER TABLE `jos_xxstaff`
  ADD CONSTRAINT `fk_jos_xxstaff_jos_xxpos` FOREIGN KEY (`pos_id`) REFERENCES `jos_xxpos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
