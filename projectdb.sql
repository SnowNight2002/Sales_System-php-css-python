-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2022-06-16 08:51:18
-- 服务器版本： 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectdb`
--

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE `customer` (
  `customerEmail` varchar(50) NOT NULL,
  `customerName` varchar(100) NOT NULL,
  `phoneNumber` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`customerEmail`, `customerName`, `phoneNumber`) VALUES
('mary@gmail.com', 'Mary', '58674321'),
('tom@gmail.com', 'Tom', '57568291');

-- --------------------------------------------------------

--
-- 表的结构 `item`
--

CREATE TABLE `item` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemDescription` text,
  `stockQuantity` int(11) NOT NULL DEFAULT '0',
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `item`
--

INSERT INTO `item` (`itemID`, `itemName`, `itemDescription`, `stockQuantity`, `price`) VALUES
(1, 'NOVEL NF4091 9\" All-way Strong Wind Circulation Fan', 'Simple Design with 3D stereo blower Turbo super strong wind up', 50, 500),
(2, 'CS-RZ24YKA 2.5 HP \"Inverter\" Split Type Heat Pump Air-Conditioner', '2.5 HP (Heat Pump Model - With Remote Control)', 100, 20000),
(3, 'QN100B Neo QLED 2K LED LCD TV', 'Infinity Screen, More immersive viewing experience', 80, 13000),
(4, 'M33 5G Smartphone', '6.6\" FHD+ Infinity-V Display, 120Hz refresh rate 50MP main camera equipped with small ', 300, 2000);

-- --------------------------------------------------------

--
-- 表的结构 `itemorders`
--

CREATE TABLE `itemorders` (
  `orderID` varchar(255) CHARACTER SET utf8 NOT NULL,
  `itemID` int(11) NOT NULL,
  `orderQuantity` int(5) NOT NULL,
  `soldPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `itemorders`
--

INSERT INTO `itemorders` (`orderID`, `itemID`, `orderQuantity`, `soldPrice`) VALUES
('1', 1, 2, 1000),
('1', 4, 1, 2000),
('2', 3, 1, 13000),
('3', 1, 1, 500);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `orderID` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customerEmail` varchar(50) NOT NULL,
  `staffID` varchar(50) NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deliveryAddress` varchar(255) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `orderAmount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`orderID`, `customerEmail`, `staffID`, `dateTime`, `deliveryAddress`, `deliveryDate`, `orderAmount`) VALUES
('1', 'mary@gmail.com', 's0001', '2022-03-24 13:12:13', NULL, NULL, 2910),
('2', 'tom@gmail.com', 's0001', '2022-04-10 14:10:20', 'Flat 8, Chates Farm Court, John Street, Hong Kong', '2022-04-15', 11440),
('3', 'mary@gmail.com', 's0003', '2022-04-12 14:10:20', NULL, NULL, 500);

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(50) NOT NULL,
  `staffName` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `staff`
--

INSERT INTO `staff` (`staffID`, `staffName`, `password`, `position`) VALUES
('s0001', 'Chan Tai Man', 'a123', 'Staff'),
('s0002', 'Wong Ka Ho', 'b123', 'Manager'),
('s0003', 'Chan ka Chung', 'c123', 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerEmail`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `itemorders`
--
ALTER TABLE `itemorders`
  ADD PRIMARY KEY (`orderID`,`itemID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `staffID` (`staffID`),
  ADD KEY `orders_ibfk_1` (`customerEmail`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`);

--
-- 限制导出的表
--

--
-- 限制表 `itemorders`
--
ALTER TABLE `itemorders`
  ADD CONSTRAINT `itemorders_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `itemorders_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemID`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customerEmail`) REFERENCES `customer` (`customerEmail`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
