-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 12:08 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moda`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detailes` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipper_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `title`, `detailes`, `city`, `customer_id`, `shipper_id`) VALUES
(3, 'Water', 'sperospats  sperospats ', 'ksa', 1, 4),
(5, 'Car', 'Marcieds Car', 'Germany', 1, 2),
(6, 'mobilphone', 'mobilphone mobilphone ', 'koria', 2, 5),
(10, 'Sandwitch', 'Burger meat Sandwich', 'Spain', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `descripton` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_name`, `descripton`, `status`, `created_at`) VALUES
(1, 'food', 'food food food', '1', '2024-01-26 06:16:06'),
(2, 'political', 'political political political', '0', '2024-01-26 06:16:17'),
(3, 'software', 'software software software', '1', '2024-01-26 06:16:19'),
(4, 'sport', 'sport sport sport', '1', '2024-01-26 06:16:22'),
(91, 'uyuyu', 'yuyuy', '', '2024-03-19 04:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `shippers`
--

CREATE TABLE `shippers` (
  `shipper_id` int(11) NOT NULL,
  `shipper_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shippers`
--

INSERT INTO `shippers` (`shipper_id`, `shipper_name`, `country`, `phone`, `status`, `created_at`) VALUES
(1, 'AliExpress', 'Ksa', '0111115646', '1', '2024-01-26 06:28:18'),
(2, 'SOOQ', 'Egypt', '787887', '1', '2024-01-26 06:28:25'),
(3, 'AppExpress', 'kwuit', '3232223', '0', '2024-01-26 06:28:49'),
(4, 'Amazon', 'Usa', '+013444554', '1', '2024-01-26 06:27:57'),
(5, 'elghazawy express', 'india', '+504444', '1', '2024-02-17 23:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'ali', 'ali@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'admin', '1', '2024-03-22 23:07:13'),
(2, 'ghonem', 'ghonem@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'admin', '1', '2024-03-20 07:17:00'),
(3, 'lamis', 'lamis@gmail.com', '758cc085848d16895460', 'admin', '0', '2024-03-19 17:18:07'),
(4, 'ahmed', 'ahmed@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'user', '1', '2024-03-19 17:16:01'),
(5, 'mohamed', 'mohamed@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'user', '1', '2024-03-19 17:16:20'),
(6, 'adham', 'adham@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'user', '1', '2024-03-19 17:16:35'),
(7, 'kareem', 'kareem@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'user', '1', '2024-03-19 17:16:55'),
(8, 'Amgad', 'amgad@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'user', '1', '2024-03-22 22:33:23'),
(9, 'samir', 'samir@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'user', '1', '2024-03-22 22:33:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `shipper_id` (`shipper_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `shippers`
--
ALTER TABLE `shippers`
  ADD PRIMARY KEY (`shipper_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `shippers`
--
ALTER TABLE `shippers`
  MODIFY `shipper_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35353538;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipper_id`) REFERENCES `shippers` (`shipper_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
