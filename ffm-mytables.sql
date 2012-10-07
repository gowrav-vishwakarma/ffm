-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 07, 2012 at 11:05 AM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_func`()
BEGIN
    SELECT 'Hello World';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxcategory`
--

CREATE TABLE IF NOT EXISTS `jos_xxcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `jos_xxgroups`
--

INSERT INTO `jos_xxgroups` (`id`, `name`, `head_id`, `group_id`, `Path`, `pos_id`, `lft`, `rgt`) VALUES
(1, 'root', NULL, NULL, NULL, NULL, 0, 51),
(2, 'Capital Account', 1, NULL, NULL, NULL, 1, 2),
(3, 'Bank OD', 2, NULL, NULL, NULL, 3, 4),
(4, 'Bank CC', 2, NULL, NULL, NULL, 5, 6),
(5, 'Bank Loan', 1, NULL, NULL, NULL, 7, 8),
(6, 'Secured Loan', 1, NULL, NULL, NULL, 9, 10),
(7, 'Un Secured Loan', 2, NULL, NULL, NULL, 11, 12),
(8, 'Sundry Creditors', 3, NULL, NULL, NULL, 13, 14),
(9, 'Duties And Taxes', 3, NULL, NULL, NULL, 15, 16),
(10, 'Provisions', 3, NULL, NULL, NULL, 17, 18),
(11, 'Suspance', 4, NULL, NULL, NULL, 19, 20),
(12, 'Branches And Divisions', 5, NULL, NULL, NULL, 21, 22),
(13, 'Fixed Assets', 6, NULL, NULL, NULL, 23, 24),
(14, 'Investments', 7, NULL, NULL, NULL, 25, 26),
(15, 'Closing Stocks', 8, NULL, NULL, NULL, 27, 28),
(16, 'Current Assets', 8, NULL, NULL, NULL, 29, 30),
(17, 'Loan And Advances (Assets)', 8, NULL, NULL, NULL, 31, 32),
(18, 'Sundry Debtors', 8, NULL, NULL, NULL, 33, 34),
(19, 'Bank Accounts', 8, NULL, NULL, NULL, 35, 36),
(20, 'Direct Expenses', 10, NULL, NULL, NULL, 37, 38),
(21, 'In Direct Expenses', 11, NULL, NULL, NULL, 39, 40),
(22, 'Direct Income', 12, NULL, NULL, NULL, 41, 42),
(23, 'In Direct Income', 13, NULL, NULL, NULL, 43, 44),
(24, 'Purchase Account', 14, NULL, NULL, NULL, 45, 46),
(25, 'Sales Account', 15, NULL, NULL, NULL, 47, 48),
(26, 'Distributors', 3, NULL, NULL, NULL, 49, 50);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxkitledgers`
--

CREATE TABLE IF NOT EXISTS `jos_xxkitledgers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kit_id` int(11) DEFAULT NULL,
  `ledger_id` int(11) DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jos_xxkitledgers`
--

INSERT INTO `jos_xxkitledgers` (`id`, `kit_id`, `ledger_id`, `Amount`) VALUES
(2, 1, 16, 700);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jos_xxledgers`
--

INSERT INTO `jos_xxledgers` (`id`, `name`, `created_at`, `updated_at`, `distributor_id`, `group_id`, `pos_id`, `staff_id`, `default_account`, `items_id`, `ledger_type`) VALUES
(1, 'pos_9', '2012-10-07 00:00:00', '2012-10-07 00:00:00', 1, 12, NULL, NULL, 1, NULL, NULL),
(2, 'Cash', '2012-10-07 00:00:00', '2012-10-07 00:00:00', NULL, 8, NULL, NULL, 0, NULL, NULL),
(3, 'DISCOUNT_GIVEN', '2012-10-07 00:00:00', '2012-10-07 00:00:00', NULL, 11, NULL, NULL, 0, NULL, NULL),
(4, 'DISCOUNT_TAKEN', '2012-10-07 00:00:00', '2012-10-07 00:00:00', NULL, 13, NULL, NULL, 0, NULL, NULL),
(5, 'Purchase Account', '2012-10-07 00:00:00', '2012-10-07 00:00:00', NULL, 13, NULL, NULL, 0, NULL, NULL),
(6, 'Sales Account', '2012-10-07 00:00:00', '2012-10-07 00:00:00', NULL, 15, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxpos`
--

CREATE TABLE IF NOT EXISTS `jos_xxpos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `ledger_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jos_xxpos`
--

INSERT INTO `jos_xxpos` (`id`, `name`, `owner_id`, `type`, `ledger_id`) VALUES
(9, 'COMPANY POS', 1, 'Company', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jos_xxstaff`
--

INSERT INTO `jos_xxstaff` (`id`, `name`, `username`, `password`, `pos_id`, `AccessLevel`) VALUES
(1, 'COMPANY POS_SUPER_STAFF', 'pos_1_admin', 'admin', NULL, '1000'),
(2, 'Udaipur Depot_SUPER_STAFF', 'pos_2_admin', 'admin', NULL, '100'),
(3, 'Kota Retailer Shoppe_SUPER_STAFF', 'pos_3_admin', 'admin', NULL, '100'),
(4, 'COMPANY POS_SUPER_STAFF', 'pos_4_admin', 'admin', NULL, '1000'),
(5, 'COMPANY POS_SUPER_STAFF', 'pos_5_admin', 'admin', NULL, '1000'),
(6, 'COMPANY POS_SUPER_STAFF', 'pos_6_admin', 'admin', NULL, '1000'),
(7, 'COMPANY POS_SUPER_STAFF', 'pos_7_admin', 'admin', NULL, '1000'),
(8, 'COMPANY POS_SUPER_STAFF', 'pos_8_admin', 'admin', NULL, '1000'),
(9, 'COMPANY POS_SUPER_STAFF', 'pos_9_admin', 'admin', 9, '1000');

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxstocks`
--

CREATE TABLE IF NOT EXISTS `jos_xxstocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `Stock` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jos_xxstocks`
--

INSERT INTO `jos_xxstocks` (`id`, `pos_id`, `item_id`, `Stock`) VALUES
(1, 3, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxvoucherdetails`
--

CREATE TABLE IF NOT EXISTS `jos_xxvoucherdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) DEFAULT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `Rate` float DEFAULT NULL,
  `Qty` float DEFAULT NULL,
  `Amount` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jos_xxvoucherdetails`
--

INSERT INTO `jos_xxvoucherdetails` (`id`, `voucher_id`, `pos_id`, `item_id`, `Rate`, `Qty`, `Amount`) VALUES
(1, 1, NULL, 3, 2, 1, 3),
(2, 3, NULL, 3, 2, 1, 3),
(3, 5, NULL, 3, 2, 1, 3),
(4, 7, NULL, 3, 2, 1, 3),
(5, 15, NULL, 3, 1, 1, 110);

-- --------------------------------------------------------

--
-- Table structure for table `jos_xxvouchers`
--

CREATE TABLE IF NOT EXISTS `jos_xxvouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ledger_id` int(11) DEFAULT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `AmountCR` float DEFAULT NULL,
  `AmountDR` float DEFAULT NULL,
  `ContraAmount` float DEFAULT NULL,
  `VoucherNo` int(11) DEFAULT NULL,
  `Narration` text,
  `VoucherType` varchar(45) DEFAULT NULL,
  `RefAccount` int(11) DEFAULT NULL,
  `has_details` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `jos_xxvouchers`
--

INSERT INTO `jos_xxvouchers` (`id`, `ledger_id`, `pos_id`, `AmountCR`, `AmountDR`, `ContraAmount`, `VoucherNo`, `Narration`, `VoucherType`, `RefAccount`, `has_details`) VALUES
(9, 14, 3, NULL, 600, 600, 1, 'JV on date 2012-09-30', 'JV', NULL, 0),
(10, 1, 3, 300, NULL, 300, 1, 'JV on date 2012-09-30', 'JV', NULL, 0),
(11, 13, 3, 100, NULL, 100, 1, 'JV on date 2012-09-30', 'JV', NULL, 0),
(12, 9, 3, 200, NULL, 200, 1, 'JV on date 2012-09-30', 'JV', NULL, 0),
(13, 14, 3, NULL, 500, 500, 1, 'PAYMENT on date 2012-09-30', 'PAYMENT', NULL, 0),
(14, 15, 3, 500, NULL, 500, 1, 'PAYMENT on date 2012-09-30', 'PAYMENT', NULL, 0),
(15, 16, 3, NULL, 110, 110, 1, 'PURCHASED on date 2012-09-30', 'PURCHASE', NULL, 1),
(16, 1, 3, 110, NULL, 110, 1, 'PURCHASED on date 2012-09-30', 'PURCHASE', NULL, 1),
(17, 14, 3, NULL, 650, 650, 2, 'dsfsdfsdf', 'JV', NULL, 0),
(18, 16, 3, 200, NULL, 200, 2, 'dsfsdfsdf', 'JV', NULL, 0),
(19, 13, 3, 210, NULL, 210, 2, 'dsfsdfsdf', 'JV', NULL, 0),
(20, 9, 3, 240, NULL, 240, 2, 'dsfsdfsdf', 'JV', NULL, 0);

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
