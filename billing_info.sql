-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2023 at 05:32 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing info`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `phone_number`, `email`, `users_id`) VALUES
(1, 'c1', 465, 'asd@asd.com', 1),
(2, 'Megha Agarwa', 123, 'as@sad.c', 1),
(3, 'B02', 111, '[value-3]', 1),
(4, 'B02', 1111, '[value-3]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_cust_user`
--

CREATE TABLE `invoice_cust_user` (
  `invoice_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_cust_user`
--

INSERT INTO `invoice_cust_user` (`invoice_id`, `users_id`, `customer_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_product`
--

CREATE TABLE `invoice_product` (
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `Num` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_product`
--

INSERT INTO `invoice_product` (`invoice_id`, `product_id`, `Num`, `price`) VALUES
(1, 2, 3, '150000.00'),
(1, 3, 2, '24.00');

--
-- Triggers `invoice_product`
--
DELIMITER $$
CREATE TRIGGER `add_price` BEFORE INSERT ON `invoice_product` FOR EACH ROW BEGIN
	set new.price = (SELECT product.price from product  where product.product_id = new.product_id) * new.num;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `add_total` AFTER INSERT ON `invoice_product` FOR EACH ROW BEGIN  
DECLARE cut int;
set cut = (SELECT count(*) from invoice_total where invoice_total.invoice_id = new.invoice_id);
              IF (cut = 0)
              THEN
              INSERT into invoice_total(invoice_total.invoice_id,total_pro,total_amt) VALUES(new.invoice_id,(SELECT sum(invoice_product.num) from invoice_product where invoice_product.invoice_id = new.invoice_id ),(SELECT sum(invoice_product.price) from invoice_product where invoice_product.invoice_id = new.invoice_id ));
     END IF;
     IF (cut > 0)
     THEN
     UPDATE invoice_total
SET total_pro = (SELECT sum(invoice_product.num) from invoice_product where invoice_product.invoice_id = new.invoice_id ),
total_amt = (SELECT sum(invoice_product.price) from invoice_product where invoice_product.invoice_id = new.invoice_id )
WHERE invoice_total.invoice_id = new.invoice_id;
END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_total`
--

CREATE TABLE `invoice_total` (
  `invoice_id` int(11) NOT NULL,
  `total_pro` int(11) NOT NULL,
  `total_amt` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_total`
--

INSERT INTO `invoice_total` (`invoice_id`, `total_pro`, `total_amt`) VALUES
(1, 5, '150024.00');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `users_id`) VALUES
(1, 'wqew', '1231.00', 1),
(2, 'Casd', '50000.00', 1),
(3, 'asd', '12.00', 1),
(4, 'hjg', '12.00', 1),
(5, '123', '123.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `name`, `email`, `PASSWORD`) VALUES
(1, 'John', 'john@example.com', 'abc'),
(2, 'Nidhi', 'nidhi@gmail.com', 'nidhi123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `invoice_cust_user`
--
ALTER TABLE `invoice_cust_user`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `invoice_total`
--
ALTER TABLE `invoice_total`
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoice_cust_user`
--
ALTER TABLE `invoice_cust_user`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);

--
-- Constraints for table `invoice_cust_user`
--
ALTER TABLE `invoice_cust_user`
  ADD CONSTRAINT `invoice_cust_user_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`),
  ADD CONSTRAINT `invoice_cust_user_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD CONSTRAINT `invoice_product_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice_cust_user` (`invoice_id`),
  ADD CONSTRAINT `invoice_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `invoice_total`
--
ALTER TABLE `invoice_total`
  ADD CONSTRAINT `invoice_total_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice_cust_user` (`invoice_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
