-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2019 at 07:29 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wholesale_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyer_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyer_id`, `name`, `address`) VALUES
(1, 'Ashish\'s Farm', '234 Oak Way, Para NJ '),
(2, 'Henry\'s Mechanical Parts', '56 One Star Lane, Que NJ'),
(6, 'Alabi Fish Farm', '3445 ,Epuc NJ'),
(12, 'Jorge\'s Raw Metals', '222, Locust Bills NJ');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `first_name`, `last_name`, `address`) VALUES
(1, 'Morty', 'Montgomery', '90 Plains, Plainer NJ'),
(3, 'Rick', 'Sanchez', '278 Clifton Ave NJ');

-- --------------------------------------------------------

--
-- Table structure for table `defaulter`
--

CREATE TABLE `defaulter` (
  `default_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `defaulter`
--

INSERT INTO `defaulter` (`default_id`, `customer_id`, `stock_id`, `amount`) VALUES
(1, 3, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `cost` float NOT NULL,
  `expense_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `buyer_id`, `stock_id`, `cost`, `expense_date`) VALUES
(1, 2, 1, 211.67, '2019-11-21'),
(2, 2, 2, 2.2, '2019-11-29'),
(3, 6, 2, 0.11, '2019-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `revenue_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `payment` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  `revenue_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`revenue_id`, `customer_id`, `stock_id`, `payment`, `status`, `revenue_date`) VALUES
(3, 1, 1, 1119.9, 0, '2015-06-12'),
(4, 3, 3, 915.98, 1, '2019-11-21'),
(5, 1, 2, 5.37, 1, '2019-12-01'),
(6, 3, 2, 35.8, 0, '2019-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `min_quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `unit_cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `name`, `quantity`, `min_quantity`, `unit_price`, `unit_cost`) VALUES
(1, 'Nvidia GTX 1070 Graphics Card', 356, 25, 559.95, 211.67),
(2, 'Cabbage', 1340, 200, 1.79, 0.11),
(3, 'Asus 4k Monitor', 12, 20, 457.99, 89.79);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `defaulter`
--
ALTER TABLE `defaulter`
  ADD PRIMARY KEY (`default_id`),
  ADD KEY `foreign_key_customer_id` (`customer_id`),
  ADD KEY `foreign_key_stock_id_2` (`stock_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `foreign_key_buyer_id` (`buyer_id`),
  ADD KEY `foreign_key_stock_id` (`stock_id`);

--
-- Indexes for table `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`revenue_id`),
  ADD KEY `foreign_key_customer_id` (`customer_id`),
  ADD KEY `foreign_key_stock_id_3` (`stock_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `defaulter`
--
ALTER TABLE `defaulter`
  MODIFY `default_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `revenue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `defaulter`
--
ALTER TABLE `defaulter`
  ADD CONSTRAINT `foreign_key_stock_id_2` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `foreign_key_buyer_id` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreign_key_stock_id` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `revenue`
--
ALTER TABLE `revenue`
  ADD CONSTRAINT `foreign_key_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreign_key_stock_id_3` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
