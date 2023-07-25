-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.epizy.com
-- Generation Time: Jan 26, 2023 at 01:07 PM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_32925678_major_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `date`, `user_id`, `full_name`, `address`, `mobile_number`, `total_price`, `payment_type`, `status`) VALUES
(4, '2023-01-23 14:39:30', 2, 'Gaurang Bagwe', '101/B Wing Poonam Apartment, Janata Market, Subhash Road, Bhandup West.', '9930726663', '6756.64', 'Cash on Delivery', 'Delivered '),
(5, '2023-01-24 07:48:08', 2, 'Gaurang Bagwe', '101/B Wing Poonam Apartment, Janata Market, Subhash Road, Bhandup West.', '9930726663', '6756.64', 'Cash on Delivery', ''),
(6, '2023-01-25 14:09:20', 2, 'Gaurang Bagwe', '101/B Wing Poonam Apartment, Janata Market, Subhash Road, Bhandup West.', '9930726663', '4537.76', 'Cash on Delivery', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `date`, `order_id`, `product_id`, `product_name`, `quantity`) VALUES
(1, '2023-01-23 14:39:30', 4, 2, 'HIGHLANDER	', 1),
(2, '2023-01-23 14:39:30', 4, 3, 'HIGHLANDER	', 1),
(3, '2023-01-23 14:39:30', 4, 1, 'HIGHLANDER', 1),
(4, '2023-01-24 07:48:08', 5, 2, 'HIGHLANDER	', 1),
(5, '2023-01-24 07:48:08', 5, 1, 'HIGHLANDER', 1),
(6, '2023-01-24 07:48:08', 5, 3, 'HIGHLANDER	', 1),
(7, '2023-01-25 14:09:20', 6, 3, 'HIGHLANDER	', 1),
(8, '2023-01-25 14:09:20', 6, 4, 'HIGHLANDER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `product_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount_price` int(11) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `date`, `product_name`, `description`, `price`, `discount_price`, `discount_percent`, `product_image`) VALUES
(1, '2023-01-19', 'HIGHLANDER', 'Men Black Printed Hooded Sweatshirt', 1999, 659, 67, 'products/1654243241cool.png'),
(2, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1512040546233102cool.png'),
(3, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1210357188546233102cool.png'),
(4, '2023-01-19', 'HIGHLANDER', 'Men Black Printed Hooded Sweatshirt', 1999, 659, 67, 'products/1654243241cool.png'),
(5, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1512040546233102cool.png'),
(6, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1210357188546233102cool.png'),
(7, '2023-01-19', 'HIGHLANDER', 'Men Black Printed Hooded Sweatshirt', 1999, 659, 67, 'products/1654243241cool.png'),
(8, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1512040546233102cool.png'),
(9, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1210357188546233102cool.png'),
(10, '2023-01-19', 'HIGHLANDER', 'Men Black Printed Hooded Sweatshirt', 1999, 659, 67, 'products/1654243241cool.png'),
(11, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1512040546233102cool.png'),
(12, '2023-01-19', 'HIGHLANDER	', 'Men Black Printed Hooded Sweatshirt', 1999, 0, 0, 'products/1210357188546233102cool.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `full_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `date`, `full_name`, `email`, `password`, `mobile_number`, `Address`, `token`, `status`, `image`) VALUES
(1, '2023-01-22 08:00:01', 'Admin', 'Admin@123', 'e3afed0047b08059d0fada10f400c1e5', '', '', '7885d7e6672834f3f234aef7350f84ec', 1, ''),
(2, '2023-01-22 08:00:01', 'Gaurang Bagwe', 'gaurangbagwe7@gmail.com', '202cb962ac59075b964b07152d234b70', '9930726663', '101/B Wing Poonam Apartment, Janata Market, Subhash Road, Bhandup West.', '11a4a657a24c71d70e4cc312d4cab44c', 1, 'uploads/148601861620190201123017_IMG_9603-01.jpeg'),
(3, '2023-01-22 08:00:01', 'Shivam Bhasin ', 'ssbhasin71@gmail.com', '5d82aec39fa24d61930cce84b5dfd4a6', '', '', '750196f305f0f9069e3f112ed5143efd', 1, ''),
(4, '2023-01-22 08:00:01', 'Shivam Bhasin ', 'shivamsbhasin@gmail.com', 'ac6bcc3de42feaa34e759d1778303ab8', '', '', 'b650acad0e3acc304d6d616c76d4157d', 1, ''),
(5, '2023-01-22 08:00:01', 'Gaurang bagwe', 'helofex682@ktasy.com', '202cb962ac59075b964b07152d234b70', '', '', 'e9a364f59c301f639a5b89e412bf1bfa', 1, ''),
(6, '2023-01-22 08:00:01', 'Gaurang Bagwe', 'xokolax458@harcity.com', '202cb962ac59075b964b07152d234b70', '', '', 'c5a5fb170a5152f887b1fb2ed71fa8f6', 1, ''),
(7, '2023-01-22 08:00:01', 'moyeje', 'moyeje8383@klblogs.com', '202cb962ac59075b964b07152d234b70', '', '', '444301e63ac780e7ba44bf01407ce2e4', 1, ''),
(8, '2023-01-22 08:00:01', 'Shraddha', 'shraddhs.jadhav@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '1234567890', 'Bhandup', 'f66c392d6a69c37737da4851f51d4658', 1, ''),
(9, '2023-01-22 08:00:01', 'abc ', 'bociw17268@irebah.com', '202cb962ac59075b964b07152d234b70', '1234567', 'bay gsd', '1032e96a193c47c83ab94b84d8e1006e', 1, ''),
(10, '2023-01-22 08:00:01', 'Rocky Felix', 'rockyfelix007@gmail.com', '202cb962ac59075b964b07152d234b70', '9930726663', '201/B Wing Poonam Apartment, Janata Market, Subhash Road, Bhandup West.', '485cfe0bd8d2fffd9e50861085047991', 1, 'uploads/402162487Screenshot 2022-08-12 210848.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
