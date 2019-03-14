-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 17, 2017 at 09:59 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amazonEbay`
--

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_amazonOrder`
--

CREATE TABLE IF NOT EXISTS `amaEb_amazonOrder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderRef` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `purchaseDate` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `lastUpdatedDate` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `orderStatus` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fullFillmentChannel` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `salesChannel` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `shipServiceLevel` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `totalAmount` double(10,2) DEFAULT NULL,
  `currencyCode` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `numberOfItemsShipped` int(11) DEFAULT NULL,
  `numberOfItemsUnshipped` int(11) DEFAULT NULL,
  `paymentMethod` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `marketplaceId` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `buyerName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `buyerEmail` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `earliestShipDate` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `latestShipDate` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `earliestDeliveryDate` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `latestDeliveryDate` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `trackingNumber` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `amaEb_amazonOrder`
--

INSERT INTO `amaEb_amazonOrder` (`id`, `orderRef`, `purchaseDate`, `lastUpdatedDate`, `orderStatus`, `fullFillmentChannel`, `salesChannel`, `shipServiceLevel`, `totalAmount`, `currencyCode`, `numberOfItemsShipped`, `numberOfItemsUnshipped`, `paymentMethod`, `marketplaceId`, `buyerName`, `buyerEmail`, `earliestShipDate`, `latestShipDate`, `earliestDeliveryDate`, `latestDeliveryDate`, `status`, `trackingNumber`) VALUES
(1, '111-7352763-9115455', '2017-11-15T17:06:53Z', '2017-11-16T09:22:28Z', 'Unshipped', 'MFN', 'Amazon.com', 'Exp US D2D Dom', 152.99, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Kayla Holman', '7nf84q26zp4p03p@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-20T08:00:00Z', '2017-11-23T07:59:59Z', 1, ''),
(2, '113-4580511-0709867', '2017-11-15T22:39:59Z', '2017-11-16T09:22:31Z', 'Unshipped', 'MFN', 'Amazon.com', 'Std US D2D Dom', 143.80, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Daniel J Haines', 'qnb4cmzqzr16h5p@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-25T07:59:59Z', 1, ''),
(3, '113-2651700-3828208', '2017-11-14T13:57:19Z', '2017-11-16T09:22:51Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 99.85, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Helen Surprenant', '1jcj79wjbm3gh9x@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(4, '113-0249850-7321017', '2017-11-15T21:17:49Z', '2017-11-16T09:23:51Z', 'Unshipped', 'MFN', 'Amazon.com', 'Exp US D2D Dom', 77.84, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'jody duffy', 'q4qkw0nzmzq5j0y@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-20T08:00:00Z', '2017-11-23T07:59:59Z', 1, ''),
(5, '112-8571820-4830664', '2017-11-15T16:37:32Z', '2017-11-16T09:25:56Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 45.86, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'James N Trachtenberg', 'hbnhdp3h6hl6t5h@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(6, '112-4748785-1472263', '2017-11-16T08:55:45Z', '2017-11-16T09:25:58Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 42.90, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Max Wimberley', 'stwhsb39kn06q78@marketplace.amazon.com', '2017-11-20T08:00:00Z', '2017-11-22T07:59:59Z', '2017-11-24T08:00:00Z', '2017-11-30T07:59:59Z', 1, ''),
(7, '111-4964687-2917034', '2017-11-15T21:38:59Z', '2017-11-16T09:28:42Z', 'Unshipped', 'MFN', 'Amazon.com', 'Exp US D2D Dom', 79.06, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Mia Carpenter', '2pqz60h8ft6bsk2@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-20T08:00:00Z', '2017-11-23T07:59:59Z', 1, ''),
(8, '111-5411998-1358662', '2017-11-16T00:56:22Z', '2017-11-16T09:34:47Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 45.79, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'catherine shetzler', 'x3r9md3jlry3ytp@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(9, '114-1448873-8608225', '2017-11-15T21:27:47Z', '2017-11-16T09:34:56Z', 'Unshipped', 'MFN', 'Amazon.com', 'Std US D2D Dom', 53.46, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Susan B. Sutherland', '39mhkn72rqds218@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-20T08:00:00Z', '2017-11-23T07:59:59Z', 1, ''),
(10, '114-7652166-8995434', '2017-11-15T14:25:32Z', '2017-11-16T09:41:20Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 42.89, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Barbara Falkenstine', 'g3d4hqq16bzm89j@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(11, '113-1938239-4161865', '2017-11-14T14:13:41Z', '2017-11-16T09:41:30Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 55.66, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'charlotte woods', 'ld1cm6bz11sfyns@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(12, '113-8322619-8916241', '2017-11-14T14:46:21Z', '2017-11-16T09:43:36Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 55.66, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Beverly Gould', 'lhfp3q1sl4w71t3@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(13, '111-2136447-2145013', '2017-11-15T14:29:01Z', '2017-11-16T09:45:36Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 116.92, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'JamieLynn Walker', 'wdq21x9knkp5q6x@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(14, '111-5835330-1678662', '2017-11-14T14:53:46Z', '2017-11-16T09:45:37Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 74.95, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Kelly Viator', '23f91n5g3qwt530@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(15, '112-4297392-9980224', '2017-11-15T17:02:55Z', '2017-11-16T09:45:43Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 100.00, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Wyatt Duncan', 'lhsxw97fpbmtl0v@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(16, '114-1445324-4243426', '2017-11-15T14:29:59Z', '2017-11-16T09:48:01Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 119.99, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Vickey Lynn Owen', 's5nbts2bycpmlkq@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(17, '114-2610675-8854646', '2017-11-15T17:04:17Z', '2017-11-16T09:49:33Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 46.07, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Barbara Torres', '27vst1fpjdsydqd@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(18, '111-4128258-6362659', '2017-11-14T15:15:38Z', '2017-11-16T09:50:33Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 122.10, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'CESAR MENDEZ', 'cb2p09jcjxscdtl@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(19, '111-7459058-6805845', '2017-11-15T14:39:07Z', '2017-11-16T09:50:40Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 145.06, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'John', '54yzyj724shz681@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(20, '111-0178782-8343447', '2017-11-15T17:08:51Z', '2017-11-16T09:53:35Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 42.99, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Scott Steed', '570bw0x5cplzks9@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(21, '114-8721913-5468261', '2017-11-15T17:47:24Z', '2017-11-16T09:54:10Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 45.60, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'shelley trigili', 'fmtnm791k3yhbt2@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(22, '111-8287745-2347403', '2017-11-15T14:46:14Z', '2017-11-16T09:54:38Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 56.02, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Todd Wilson', 'mtpf2qs94bdc4vd@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(23, '113-7691839-7666603', '2017-11-15T17:52:10Z', '2017-11-16T09:55:56Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 34.69, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Maureen L Taylor', 'bvdsz1gmvxl303x@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(24, '111-7357246-6299466', '2017-11-15T17:09:01Z', '2017-11-16T09:56:48Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 116.92, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'claudia machon', 't0nbvw79qhn2stc@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(25, '112-8584642-0714639', '2017-11-16T09:27:02Z', '2017-11-16T09:57:16Z', 'Unshipped', 'MFN', 'Amazon.com', 'Exp US D2D Dom', 56.90, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Thomas B. Kirksey Jr', 'w2wg3v657d7nqfr@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-20T08:00:00Z', '2017-11-23T07:59:59Z', 1, ''),
(26, '111-7851846-3497019', '2017-11-14T17:08:49Z', '2017-11-16T09:58:19Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 42.90, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Theresa DeGolyer', 'npgt4mts8ykymm0@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(27, '114-1067103-1813836', '2017-11-15T17:51:57Z', '2017-11-16T09:59:04Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 47.11, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Mark Oros', 'vyyklb1rmty6lcs@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(28, '111-0292457-9332245', '2017-11-15T17:54:19Z', '2017-11-16T10:00:31Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 87.90, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Robbi G. Pfeffer', 'tkdp3bqycdyblwj@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(29, '113-9055564-3322660', '2017-11-15T17:56:22Z', '2017-11-16T10:01:59Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 116.92, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Sal W.  Varsalona', 'wqd7qkxspvk8x42@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(30, '114-7768551-7970650', '2017-11-15T14:53:55Z', '2017-11-16T10:02:01Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 84.45, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'mervick nunez', '83g260f51zfm2n6@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(31, '111-7797246-5701810', '2017-11-15T17:10:13Z', '2017-11-16T10:02:22Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 117.31, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Kathi Burt', '9vh6mlybbry6qy0@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(32, '111-3624097-4077828', '2017-11-14T23:15:26Z', '2017-11-16T10:04:23Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 168.09, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Monique', '8xxjqnc8f14glfn@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(33, '114-5826910-1365011', '2017-11-15T17:56:34Z', '2017-11-16T10:05:05Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 116.92, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Chase Covington', 'cjm309dl89kz2zv@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(34, '113-9229826-0724248', '2017-11-15T17:58:27Z', '2017-11-16T10:06:51Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 51.98, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Lelanie', 'sdb4mlvjvs8j227@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(35, '112-4181369-9406653', '2017-11-15T17:18:47Z', '2017-11-16T10:07:09Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 59.62, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Diana Flinn', '89cpgb8qn1nhmjb@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(36, '112-9716600-7505018', '2017-11-15T14:58:59Z', '2017-11-16T10:07:46Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 45.87, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Sharon Friedman', 'zxtdxgqqyw24htl@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(37, '113-5936696-6574625', '2017-11-15T17:59:21Z', '2017-11-16T10:08:27Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 139.94, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Samuel Vesa', 'qc3f1738q8r7r56@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(38, '113-7108267-4021864', '2017-11-16T09:38:09Z', '2017-11-16T10:08:27Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 42.90, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Michelle Parr', 'y8zs9thfw494ttf@marketplace.amazon.com', '2017-11-20T08:00:00Z', '2017-11-22T07:59:59Z', '2017-11-24T08:00:00Z', '2017-11-30T07:59:59Z', 1, ''),
(39, '114-9193202-1517859', '2017-11-15T17:59:19Z', '2017-11-16T10:10:09Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 56.02, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Elizabeth Howell', 'lm7c6r3ds88zd01@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(40, '112-9905247-3420223', '2017-11-15T17:55:04Z', '2017-11-16T10:11:36Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 238.82, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Michael D Wright', 'pfpt63r1zmr3z6t@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(41, '114-4781589-2534626', '2017-11-15T17:59:15Z', '2017-11-16T10:13:03Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 154.06, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Kyle King', 'tbqcxc5jyv64dc5@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(42, '112-7200974-1709024', '2017-11-15T22:54:47Z', '2017-11-16T10:13:44Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 126.05, 'USD', 0, 2, 'Other', 'ATVPDKIKX0DER', 'Vilia Lipman', 'hqms3tjsmxnczp7@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(43, '112-6833517-4110610', '2017-11-15T20:07:20Z', '2017-11-16T10:14:36Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 40.44, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Nerelyn', '71psy343jtlvcq6@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(44, '112-0141623-6392203', '2017-11-15T18:01:05Z', '2017-11-16T10:14:39Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 68.99, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Aida Chinappi', 'bh73qsqd177qzzj@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(45, '114-0905047-6065012', '2017-11-16T09:44:57Z', '2017-11-16T10:15:14Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 102.06, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'doris collins', 'wkpgpf6yxv75fhs@marketplace.amazon.com', '2017-11-20T08:00:00Z', '2017-11-22T07:59:59Z', '2017-11-24T08:00:00Z', '2017-11-30T07:59:59Z', 1, ''),
(46, '112-8456741-0184243', '2017-11-15T21:44:46Z', '2017-11-16T10:15:39Z', 'Unshipped', 'MFN', 'Amazon.com', 'Exp US D2D Dom', 66.14, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Brad Layton', 'xx86gvzdbbbcf91@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-17T08:00:00Z', '2017-11-22T07:59:59Z', 1, ''),
(47, '111-0534439-1456264', '2017-11-15T20:04:54Z', '2017-11-16T10:17:31Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 56.02, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Tom Andrews', '060v9qfkzyjpxkf@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(48, '114-3880191-2547428', '2017-11-15T18:13:03Z', '2017-11-16T10:18:03Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 244.24, 'USD', 0, 4, 'Other', 'ATVPDKIKX0DER', 'Laurel Marden', '0tvw1ds6rw3n59j@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(49, '113-7583051-9832246', '2017-11-15T17:20:51Z', '2017-11-16T10:18:29Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 63.61, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Sheri Kingsbury', '6g0pkfzfm11bz04@marketplace.amazon.com', '2017-11-16T08:00:00Z', '2017-11-18T07:59:59Z', '2017-11-21T08:00:00Z', '2017-11-28T07:59:59Z', 1, ''),
(50, '112-2115277-9313025', '2017-11-15T21:17:19Z', '2017-11-16T10:19:04Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 60.93, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'Eladia Medin', '2l39wxzrj6mbk17@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, ''),
(51, '111-2343673-5077865', '2017-11-15T18:29:03Z', '2017-11-16T10:19:33Z', 'Unshipped', 'MFN', 'Amazon.com', 'Econ US Dom', 65.94, 'USD', 0, 1, 'Other', 'ATVPDKIKX0DER', 'evan', 'w3sjxx53x7tn9rk@marketplace.amazon.com', '2017-11-17T08:00:00Z', '2017-11-21T07:59:59Z', '2017-11-22T08:00:00Z', '2017-11-29T07:59:59Z', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_amazonShippingDetail`
--

CREATE TABLE IF NOT EXISTS `amaEb_amazonShippingDetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `addressLine1` text,
  `addressLine2` text,
  `addressLine3` text,
  `city` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `county` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `district` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stateOrRegion` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `postalCode` int(11) DEFAULT NULL,
  `countryCode` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `orderRefId` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `amaEb_amazonShippingDetail`
--

INSERT INTO `amaEb_amazonShippingDetail` (`id`, `customerName`, `addressLine1`, `addressLine2`, `addressLine3`, `city`, `county`, `district`, `stateOrRegion`, `postalCode`, `countryCode`, `phone`, `orderRefId`) VALUES
(1, 'Kayla Holman', '3148 E BRAESIDE DR', '', '', 'BLOOMINGTON', '', '', 'IN', 47408, 'US', '8123453303', '111-7352763-9115455'),
(2, 'Daniel J. Haines II', '3014 Landen Farm Rd E', '', '', 'Hilliard', '', '', 'OH', 43026, 'US', '6148500318', '113-4580511-0709867'),
(3, 'Helen Surprenant', '9101 STEILACOOM RD SE UNIT 9', '', '', 'OLYMPIA', '', '', 'WA', 98513, 'US', '360-870-3010', '113-2651700-3828208'),
(4, 'Stacy Duffy', '4305 LOCHURST DR', '', '', 'PFAFFTOWN', '', '', 'NC', 27040, 'US', '908-578-6749', '113-0249850-7321017'),
(5, 'James Trachtenberg', 'TRACEY INC', '2329 PENNSYLVANIA AVE', '', 'PHILADELPHIA', '', '', 'PA', 19130, 'US', '2672532543', '112-8571820-4830664'),
(6, 'Max Wimberley', '1429 DWIGHT WAY APT 5', '', '', 'BERKELEY', '', '', 'CA', 94702, 'US', '5127695548', '112-4748785-1472263'),
(7, 'Isaiah Stiles', '1025 PACIFIC HILLS PT APT H302', '', '', 'COLORADO SPRINGS', '', '', 'CO', 80906, 'US', '3347282021', '111-4964687-2917034'),
(8, 'catherine shetzler', '110 WALLS WAY', '', '', 'BEAR', '', '', 'DE', 19701, 'US', '3028368628', '111-5411998-1358662'),
(9, 'Susan Sutherland', '252 N DOGWOOD TRL', '', '', 'SOUTHERN SHORES', '', '', 'NC', 27949, 'US', '2522613318', '114-1448873-8608225'),
(10, 'Barbara A Falkenstine', '129 Nottoway St', '', '', 'Leesburg', '', '', 'VA', 20175, 'US', '', '114-7652166-8995434'),
(11, 'charlotte woods', '4127 CROSSWICK TURN', '', '', 'BOWIE', '', '', 'MARYLAND', 20715, 'US', '2408825300', '113-1938239-4161865'),
(12, 'Beverly Gould', '39021 Dover', '', '', 'Livonia', '', '', 'Mi', 48150, 'US', '7344644461', '113-8322619-8916241'),
(13, 'JamieLynn Walker', '419 E MCCLELLAND ST', '', '', 'MONTICELLO', '', '', 'IL', 61856, 'US', '2178175321', '111-2136447-2145013'),
(14, 'Kelly Viator', '2911 COTEAU RD LOT 52', '', '', 'NEW IBERIA', '', '', 'LA', 70560, 'US', '3372560090', '111-5835330-1678662'),
(15, 'Preston Wyatt Duncan', '8306 WEAVER LN', '', '', 'JEFFERSON CITY', '', '', 'MO', 65101, 'US', '5734960188', '112-4297392-9980224'),
(16, 'Vickey Lynn Owen', '69800 E 240 RD', '', '', 'WYANDOTTE', '', '', 'OK', 74370, 'US', '9188370294', '114-1445324-4243426'),
(17, 'Barbara Torres', '536 10TH AVE', '', '', 'NEW HYDE PARK', '', '', 'NY', 11040, 'US', '5163269490', '114-2610675-8854646'),
(18, 'Cesar Mendez', '829 N ZARAGOZA RD B14', '', '', 'EL PASO', '', '', 'TX', 79907, 'US', '9153018918', '111-4128258-6362659'),
(19, 'John R. Abisch', '6123 HEATH RIDGE CT APT A', '', '', 'CHARLOTTE', '', '', 'NC', 28210, 'US', '585-233-1587', '111-7459058-6805845'),
(20, 'Scott Steed Jr.', '160 FAIRMOUNT ST # 1', '', '', 'DORCHESTER', '', '', 'MA', 2124, 'US', '617 406-8374', '111-0178782-8343447'),
(21, 'Shelley trigili', '5596 CARSON RD', '', '', 'RIVERSIDE', '', '', 'CA', 92506, 'US', '7147438882', '114-8721913-5468261'),
(22, 'Todd Wilson/Halsey & Griffith', '1983 10TH AVE N', '', '', 'LAKE WORTH', '', '', 'FLORIDA', 33461, 'US', '561.346.6895', '111-8287745-2347403'),
(23, 'Maureen L Taylor', '1715 Russell Way', '', '', 'Roseville', '', '', 'CA', 95661, 'US', '916-783-3324', '113-7691839-7666603'),
(24, 'Marlena smith', '7000 BARRANCA PKWY FEDEX', '', '', 'IRVINE', '', '', 'CA', 92618, 'US', '3105674990', '111-7357246-6299466'),
(25, 'Sara Kirksey', '16253 MCDOWELL RD', '', '', 'BAY MINETTE', '', '', 'AL', 36507, 'US', '251-253-9316', '112-8584642-0714639'),
(26, 'Theresa DeGolyer', '149 So.Wynd Drive', '', '', 'Lakeville', '', '', 'PA', 18438, 'US', '570-226-3915', '111-7851846-3497019'),
(27, 'Mark  Oros', '7020 SEARSBURG RD', '', '', 'TRUMANSBURG', '', '', 'NY', 14886, 'US', '(607) 387-5800', '114-1067103-1813836'),
(28, 'Robbi Pfeffer', '3066 WINDING OAKS CIR', '', '', 'KAUFMAN', '', '', 'TX', 75142, 'US', '2145383343', '111-0292457-9332245'),
(29, 'Salvatore W. Varsalona', '711 South Charles G. Seivers Blvd.', '', '', 'Clinton', '', '', 'TN', 37716, 'US', '865-680-6151', '113-9055564-3322660'),
(30, 'Mervick Nunez', '10334 HARBOR INN CT', 'UNIT BUILDING 3 SUITE 10334', '', 'CORAL SPRINGS', '', '', 'FL', 33071, 'US', '7754194985', '114-7768551-7970650'),
(31, 'Kathi Burt', '13105 NORMANDY CIR', '', '', 'OMAHA', '', '', 'NE', 68137, 'US', '4029175173', '111-7797246-5701810'),
(32, 'Monique Gurule', '12553 Coronado Dr', '', '', 'Alamosa', '', '', 'Co', 81101, 'US', '7198495655', '111-3624097-4077828'),
(33, 'Chase Covington', 'TRUCKEE POLICE DEPARTMENT', '10183 TRUCKEE AIRPORT RD', '', 'TRUCKEE', '', '', 'CA', 96161, 'US', '5304146375', '114-5826910-1365011'),
(34, 'Lelanie Wilkinson', '9702 GARRETT DR', '', '', 'ROWLETT', '', '', 'TEXAS', 75089, 'US', '972-475-1615', '113-9229826-0724248'),
(35, 'Diana L. Flinn', '168 Valley Road', '', '', 'Indiana', '', '', 'PA', 15701, 'US', '724 465 8502', '112-4181369-9406653'),
(36, 'Sharon Friedman', '17083 WOODMERE DR', '', '', 'CHAGRIN FALLS', '', '', 'OH', 44023, 'US', '440-708-2497', '112-9716600-7505018'),
(37, 'Samuel Vesa', '2104 PIPESTONE DR', '', '', 'SAN ANTONIO', '', '', 'TX', 78232, 'US', '210-545-6272', '113-5936696-6574625'),
(38, 'Michelle Parr', '21515 NE WILLOW GLEN RD', '', '', 'FAIRVIEW', '', '', 'OR', 97024, 'US', '503-367-6284', '113-7108267-4021864'),
(39, 'Elizabeth Howell', '5303 STATE HIGHWAY 49 N APT 13', '', '', 'MARIPOSA', '', '', 'CA', 95338, 'US', '2483747238', '114-9193202-1517859'),
(40, 'Michael Wright', '4 PAMELA LN', '', '', 'CANTON', '', '', 'MA', 2021, 'US', '781-821-1319', '112-9905247-3420223'),
(41, 'Kyle King', '395 TRINITY RD', '', '', 'JONESVILLE', '', '', 'LA', 71343, 'US', '3184039911', '114-4781589-2534626'),
(42, 'Vilia Lipman', '2710 53RD ST', '', '', 'SARASOTA', '', '', 'FL', 34234, 'US', '9415044386', '112-7200974-1709024'),
(43, 'Nerelyn Dalton', '397 Collinwood Drive', '', '', 'Raeford', '', '', 'NC', 28376, 'US', '9105274731', '112-6833517-4110610'),
(44, 'Aida Chinappi', '5403 EDWARDS DR', '', '', 'ARLINGTON', '', '', 'TX', 76017, 'US', '817-329-4274', '112-0141623-6392203'),
(45, 'DORIS COLLINS', '47 BENEDICT DR', '', '', 'SOUTH WINDSOR', '', '', 'CT', 6074, 'US', '', '114-0905047-6065012'),
(46, 'Brad Layton', '22 Bellerive Country Club Grounds', '', '', 'Creve Coeur', '', '', 'MO', 63141, 'US', '314-878-3652', '112-8456741-0184243'),
(47, 'Tom Andrews', '5210 GILMORE RD', '', '', 'POLLOCK PINES', '', '', 'CA', 95726, 'US', '4089815718', '111-0534439-1456264'),
(48, 'Laurel Marden', '800 Montauk Lane', '', '', 'Stansbury Park', '', '', 'Utah', 84074, 'US', '4353152080', '114-3880191-2547428'),
(49, 'OCCC', '7777 S MAY AVE', '', '', 'OKLAHOMA CITY', '', '', 'OK', 73159, 'US', '405-682-7555', '113-7583051-9832246'),
(50, 'Eladia Medin', '3131 FERNCREEK LN', '', '', 'ESCONDIDO', '', '', 'CA', 92027, 'US', '760-233-4927', '112-2115277-9313025'),
(51, 'Evan Brunelle-Bushey', '2230 5TH AVE', '', '', 'TROY', '', '', 'NY', 12180, 'US', '5188528150', '111-2343673-5077865');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_ebayInventory`
--

CREATE TABLE IF NOT EXISTS `amaEb_ebayInventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productRef` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `titleName` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `modelName` varchar(150) NOT NULL,
  `conditionId` int(11) DEFAULT NULL,
  `conditionDescription` text,
  `upc` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `description` text,
  `country` varchar(100) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `colorItem` varchar(200) NOT NULL,
  `quantityEbay` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `ImeNum` text,
  `ebayItemRef` varchar(100) NOT NULL,
  `build` varchar(255) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `startTimeEbay` varchar(150) DEFAULT NULL,
  `endTimeEbay` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `amaEb_ebayInventory`
--

INSERT INTO `amaEb_ebayInventory` (`id`, `productRef`, `titleName`, `modelName`, `conditionId`, `conditionDescription`, `upc`, `description`, `country`, `price`, `colorItem`, `quantityEbay`, `duration`, `ImeNum`, `ebayItemRef`, `build`, `version`, `startTimeEbay`, `endTimeEbay`) VALUES
(1, 'aLZYxWcFtrq9', 'New Samsung', 'C4', 1000, 'test', '1', NULL, 'US', 389.00, '', 59, 7, '78BHd44hnNcv5rcBVd', '110232075418', 'E1037_UNI_API5_18575097_R1', 1037, '2017-11-03T02:43:07.734Z', '2017-11-10T02:43:07.734Z'),
(2, '9bcM0k9z4KSR', 'samsung-s4', 'N3', 1000, 'samsung-s4', 'Does not apply', NULL, 'IN', 360.00, '', 31, 7, 'Nmed56tcfvDjhdvf5667', '110232084605', 'E1037_UNI_API5_18575097_R1', 1037, '2017-11-03T06:20:18.568Z', '2017-11-10T06:20:18.568Z'),
(3, '1dZxBI8oH7bL', 'oppo', 'E5', 1000, 'oppo phone in good condition', 'Does not apply', NULL, 'IN', 437.00, '', 32, 28, 'Ve455vfg6jvGjH45Vedf', '110232819212', 'E1037_UNI_API5_18575097_R1', 1037, '2017-11-06T09:06:01.097Z', '2017-11-13T09:06:01.097Z'),
(4, 'PbiHUk9vAe75', 'oppox8', 'V3', 1000, 'oppox8', 'Does not apply', NULL, 'IN', 343.54, '', 34, 0, 'Tfvf55VSF456FEF45VDE', '110232819327', 'E1037_UNI_API5_18575097_R1', 1037, '2017-11-06T09:30:26.691Z', '2017-11-13T09:30:26.691Z'),
(5, 'tXunQ1qUNV54', 'oppoF2', 'T4', 1000, 'oppoF2', 'Does not apply', NULL, 'IN', 548.00, '', 19, 0, 'MtnvJGSJ453NCHDjs', '110232819653', 'E1037_UNI_API5_18575097_R1', 1037, '2017-11-06T10:27:09.893Z', '2017-11-13T10:27:09.893Z'),
(6, '9bcM0k9z4KSR', 'samsungLatestOne', 'e7', 1000, NULL, 'Does not apply', 'twsuy', 'IN', 879.00, 'black', 1, 0, 'Bft56gh523BCH454nCN', '110242443788', 'E1037_UNI_API5_18575097_R1', 1037, '2017-11-13T12:52:42.698Z', '2017-11-20T12:52:42.698Z');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_images`
--

CREATE TABLE IF NOT EXISTS `amaEb_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `imageName` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `amaEb_images`
--

INSERT INTO `amaEb_images` (`id`, `productId`, `imageName`) VALUES
(1, 'Oyu52jfzRhm0', '1509096348.jpg,1509096350.jpg'),
(2, '9bcM0k9z4KSR', '1509096348.jpg,1509096350.jpg'),
(3, 'aLZYxWcFtrq9', '1509096536.jpg,1509453414.jpg'),
(4, '1dZxBI8oH7bL', '1509950916.jpg,1509950920.jpg'),
(5, 'PbiHUk9vAe75', '1509959664.jpg,1509959667.png'),
(6, 'tXunQ1qUNV54', '1509963802.jpg,1509963806.png');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_inventory`
--

CREATE TABLE IF NOT EXISTS `amaEb_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productRef` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `brandName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `modelName` varchar(50) NOT NULL,
  `invDate` date DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `ImeNum` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `stockNumber` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `kitCost` double(10,2) DEFAULT NULL,
  `cost` double(10,2) DEFAULT NULL,
  `totalCost` double(10,2) DEFAULT NULL,
  `description` text,
  `listedEbay` int(11) NOT NULL DEFAULT '0',
  `listedAmazon` int(11) NOT NULL DEFAULT '0',
  `createdDate` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addedBy` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `amaEb_inventory`
--

INSERT INTO `amaEb_inventory` (`id`, `productRef`, `brandName`, `modelName`, `invDate`, `color`, `quantity`, `ImeNum`, `stockNumber`, `kitCost`, `cost`, `totalCost`, `description`, `listedEbay`, `listedAmazon`, `createdDate`, `status`, `addedBy`) VALUES
(1, 'Oyu52jfzRhm0', 'samsung', 'e7', '2017-10-27', 'black', 60, 'v3434fdgf4454', 'dsf', 435.50, 34.54, 45.66, 'twsuy', 0, 0, '2017-10-27', 1, 'mSCpQOHBCw'),
(2, '9bcM0k9z4KSR', 'samsung', 'e7', '2017-10-27', 'black', 60, 'v3434CEDgf4454', 'dsf', 435.50, 34.54, 45.66, 'twsuy', 1, 0, '2017-10-27', 1, 'mSCpQOHBCw'),
(3, 'aLZYxWcFtrq9', 'samsung', 'e8', '2017-11-01', 'sdf', 20, 'v3434fdgf4454d', '#656', 435.50, 34.54, 45.66, 'testing product', 1, 0, '2017-10-27', 1, 'mSCpQOHBCw'),
(4, '1dZxBI8oH7bL', 'Iphone', '5s', '2017-11-06', 'black', 60, 'Nw44cjnvJDNB4', '23', 435.50, 500.00, 530.00, 'test products', 1, 0, '2017-11-06', 1, 'mSCpQOHBCw'),
(5, 'PbiHUk9vAe75', 'oppo', 'x-67', '2017-11-08', 'black', 60, 'M4723jDnde4', '3243', 23.54, 343.54, 453.66, 'Test product', 1, 0, '2017-11-06', 1, 'mSCpQOHBCw'),
(6, 'tXunQ1qUNV54', 'oppo', 'F2', '2017-11-02', 'white', 1, 'N5r45nwfVUrf', '3243', 566.00, 353.00, 569.00, 'Test product', 1, 0, '2017-11-06', 1, 'mSCpQOHBCw');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_orderDetail`
--

CREATE TABLE IF NOT EXISTS `amaEb_orderDetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderRef` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `orderStatus` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `checkoutStatus` varchar(100) NOT NULL,
  `amountPaid` double(10,2) DEFAULT NULL,
  `subTotal` double(10,2) DEFAULT NULL,
  `shippingService` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `shippingServiceCost` double(10,2) DEFAULT NULL,
  `shippingServicePriority` int(11) DEFAULT NULL,
  `lastModifiedDate` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `paymentMethod` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sellerEmail` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `totalAmt` double(10,2) DEFAULT NULL,
  `totalItemPurchased` int(11) NOT NULL,
  `buyerEmail` varchar(100) NOT NULL,
  `buyerFirstName` varchar(100) DEFAULT NULL,
  `buyerLastName` varchar(100) DEFAULT NULL,
  `buyerUserId` varchar(150) NOT NULL,
  `trackingNumber` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `amaEb_orderDetail`
--

INSERT INTO `amaEb_orderDetail` (`id`, `orderRef`, `orderStatus`, `checkoutStatus`, `amountPaid`, `subTotal`, `shippingService`, `shippingServiceCost`, `shippingServicePriority`, `lastModifiedDate`, `paymentMethod`, `sellerEmail`, `totalAmt`, `totalItemPurchased`, `buyerEmail`, `buyerFirstName`, `buyerLastName`, `buyerUserId`, `trackingNumber`) VALUES
(1, '110226444792-28745675001', 'Active', 'Incomplete', 450.00, 450.00, 'USPSStandardPost', 0.00, 1, '2017-10-12T05:43:42.000Z', 'PayPal', 'sarbrinder@1wayit.com', 450.00, 1, 'Invalid Request', NULL, NULL, 'testuser_preetsingh', NULL),
(2, '110226442585-28745679001', 'Active', 'Incomplete', 500.00, 500.00, 'FlatRateFreight', 0.00, 1, '2017-10-12T05:46:23.000Z', 'PayPal', 'sarbrinder@1wayit.com', 500.00, 1, 'Invalid Request', NULL, NULL, 'testuser_preetsingh', NULL),
(3, '110226518475-28745705001', 'Active', 'Incomplete', 300.00, 300.00, 'USPSPriorityMailSmallFlatRateBox', 0.00, 1, '2017-10-12T06:33:44.000Z', 'PayPal', 'sarbrinder-facilitator@1wayit.com', 300.00, 1, 'Invalid Request', NULL, NULL, 'testuser_preetsingh', NULL),
(4, '110226518475-28745717001', 'Active', 'Incomplete', 300.00, 300.00, 'USPSPriorityMailSmallFlatRateBox', 0.00, 1, '2017-10-12T06:42:03.000Z', 'PayPal', 'sarbrinder-facilitator@1wayit.com', 300.00, 1, 'Invalid Request', NULL, NULL, 'testuser_preetsingh', NULL),
(5, '110229704227-28757111001', 'Active', 'Incomplete', 254.00, 254.00, 'UPSGround', 0.00, 1, '2017-10-27T10:12:57.000Z', 'PayPal', 'megaonlinemerchant@gmail.com', 254.00, 1, 'preet@1wayit.com', NULL, NULL, 'testuser_preetsingh', NULL),
(6, '110232819653-28768685001', 'Active', 'Incomplete', 548.00, 548.00, 'UPSGround', 0.00, 1, '2017-11-07T05:44:01.000Z', 'PayPal', 'megaonlinemerchant@gmail.com', 548.00, 1, 'preet@1wayit.com', NULL, NULL, 'testuser_preetsingh', 'b56453FERE'),
(7, '110232819327-28768686001', 'Active', 'Incomplete', 343.54, 343.54, 'UPSGround', 0.00, 1, '2017-11-07T05:45:07.000Z', 'PayPal', 'megaonlinemerchant@gmail.com', 343.54, 1, 'preet@1wayit.com', NULL, NULL, 'testuser_preetsingh', '49283FJENc44'),
(8, '110232819541-28768687001', 'Active', 'Incomplete', 646.00, 646.00, 'UPSGround', 2.00, 1, '2017-11-08T04:47:36.000Z', 'PayPal', 'megaonlinemerchant@gmail.com', 646.00, 1, 'preet@1wayit.com', NULL, NULL, 'testuser_preetsingh', '583854Fvr45v');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_orderItem`
--

CREATE TABLE IF NOT EXISTS `amaEb_orderItem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemRefId` varchar(50) NOT NULL,
  `orderId` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `itemId` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `site` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `itemTitle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `conditionID` int(11) DEFAULT NULL,
  `conditionName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `amaEb_orderItem`
--

INSERT INTO `amaEb_orderItem` (`id`, `itemRefId`, `orderId`, `itemId`, `site`, `itemTitle`, `conditionID`, `conditionName`) VALUES
(1, 'cylFGnwOgWuV', '110226444792-28745675001', '110226444792', 'US', 'JWELLER FOR WOMEN[Chandelier]', 1500, 'New without tags'),
(2, '8Bh5NrrfFZuL', '110226442585-28745679001', '110226442585', 'US', 'Mobile Phones', 1000, 'New'),
(3, '4BR3e6EyFcsz', '110226518475-28745705001', '110226518475', 'US', 'Moto Phone', 1000, 'New'),
(4, '43EWMxI4Jj0K', '110226518475-28745717001', '110226518475', 'US', 'Moto Phone', 1000, 'New'),
(5, 'D3zWCBVrelWS', '110229704227-28757111001', '110229704227', 'US', 'Bag Accessories', 1000, 'New'),
(6, 'q86xA5Yeoq5E', '110232819653-28768685001', '110232819653', 'US', 'oppoF2', 1000, 'New'),
(7, 'ewjsTrYDMn4B', '110232819327-28768686001', '110232819327', 'US', 'oppox8', 1000, 'New'),
(8, 'tpZrK4hsw7Hb', '110232819541-28768687001', '110232819541', 'US', 'oppox9', 1000, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_orderShippingDetail`
--

CREATE TABLE IF NOT EXISTS `amaEb_orderShippingDetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderIdRef` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `shippingName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `streetFirst` text,
  `streetSec` text,
  `cityName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `state` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `countryName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `postalCode` int(11) DEFAULT NULL,
  `externalAddressID` text,
  `originalPostalCode` int(11) DEFAULT NULL,
  `packagingHandlingCosts` double(10,2) DEFAULT NULL,
  `sellingManagerSalesRecordNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `amaEb_orderShippingDetail`
--

INSERT INTO `amaEb_orderShippingDetail` (`id`, `orderIdRef`, `shippingName`, `streetFirst`, `streetSec`, `cityName`, `state`, `countryName`, `phone`, `postalCode`, `externalAddressID`, `originalPostalCode`, `packagingHandlingCosts`, `sellingManagerSalesRecordNumber`) VALUES
(1, '110226444792-28745675001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 98102, 0.00, 100),
(2, '110226442585-28745679001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0),
(3, '110226518475-28745705001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 98102, 0.00, 102),
(4, '110226518475-28745717001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 98102, 0.00, 103),
(5, '110229704227-28757111001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0),
(6, '110232819653-28768685001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0),
(7, '110232819327-28768686001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0),
(8, '110232819541-28768687001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_orderTransaction`
--

CREATE TABLE IF NOT EXISTS `amaEb_orderTransaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderRefId` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `transactionID` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `transactionPrice` double(10,2) DEFAULT NULL,
  `transactionSiteId` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `platform` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `totalTaxAmount` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `amaEb_orderTransaction`
--

INSERT INTO `amaEb_orderTransaction` (`id`, `orderRefId`, `transactionID`, `transactionPrice`, `transactionSiteId`, `platform`, `totalTaxAmount`) VALUES
(1, '110226444792-28745675001', '28745675001', 450.00, 'US', 'eBay', 0.00),
(2, '110226442585-28745679001', '28745679001', 500.00, 'US', 'eBay', 0.00),
(3, '110226518475-28745705001', '28745705001', 300.00, 'US', 'eBay', 0.00),
(4, '110226518475-28745717001', '28745717001', 300.00, 'US', 'eBay', 0.00),
(5, '110229704227-28757111001', '28757111001', 254.00, 'US', 'eBay', 0.00),
(6, '110232819653-28768685001', '28768685001', 548.00, 'US', 'eBay', 0.00),
(7, '110232819327-28768686001', '28768686001', 343.54, 'US', 'eBay', 0.00),
(8, '110232819541-28768687001', '28768687001', 646.00, 'US', 'eBay', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `amaEb_users`
--

CREATE TABLE IF NOT EXISTS `amaEb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userRef` varchar(50) NOT NULL,
  `emailId` text,
  `password` text CHARACTER SET utf8,
  `userType` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `amaEb_users`
--

INSERT INTO `amaEb_users` (`id`, `userRef`, `emailId`, `password`, `userType`, `status`) VALUES
(1, 'mSCpQOHBCw', 'æƒ(xµ„‡yž¯:NÜ(', '$2y$10$wpbW902fnlWX0YjjOccyJOonDOvonzGOom/tUqwZBnCAVJMkY./iO', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
