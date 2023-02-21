-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2023 at 07:07 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Men\'s Apparel', '2023-02-19 09:39:49', '2023-02-21 09:40:20'),
(4, 'Home Entertainment', '2023-02-19 09:39:49', '2023-02-21 09:41:22'),
(5, 'Babies & Kids', '2023-02-19 12:37:07', '2023-02-19 12:37:07'),
(6, 'Home & Living', '2023-02-19 12:37:07', '2023-02-19 12:37:07'),
(7, 'Groceries', '2023-02-19 12:37:07', '2023-02-19 12:37:07'),
(8, 'Toys, Games & Collectibles', '2023-02-19 12:37:07', '2023-02-19 12:37:07'),
(9, 'Laptop & Computers', '2023-02-19 12:37:07', '2023-02-19 12:37:07'),
(10, 'Pet Care', '2023-02-19 12:37:07', '2023-02-19 12:37:07'),
(45, 'Test Category 2', '2023-02-21 15:06:04', '2023-02-21 15:06:04'),
(44, 'Test Category 1', '2023-02-21 15:05:54', '2023-02-21 15:05:54'),
(43, 'New Category', '2023-02-21 15:05:43', '2023-02-21 15:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `sold` int DEFAULT '0',
  `img_url` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `sold`, `img_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'Shirt', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '800.00', 39, 700, '{ \"imgid_no\": [ \"1_1\", \"1_2\", \"1_3\", \"1_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(2, 1, 'Pants', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '735.76', 38, 800, '{ \"imgid_no\": [ \"2_1\", \"2_2\", \"2_3\", \"2_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(3, 2, 'Iphone 13', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '40000.00', 1, 3, '{ \"imgid_no\": [ \"3_1\", \"3_2\", \"3_3\", \"3_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(4, 2, 'MAIMEITE MT5', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '30000.00', 2, 2, '{ \"imgid_no\": [ \"4_1\", \"4_2\", \"4_3\", \"4_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(5, 3, 'LG TV', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '50000.00', 6, 18, '{ \"imgid_no\": [ \"5_1\", \"5_2\", \"5_3\", \"5_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(6, 3, 'Solar Inverter', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '30000.00', 2, 17, '{ \"imgid_no\": [ \"6_1\", \"6_2\", \"6_3\", \"6_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(7, 4, 'Care Suite', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '10000.00', 5, 3, '{ \"imgid_no\": [ \"7_1\", \"7_2\", \"7_3\", \"7_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11'),
(8, 4, 'Stroller', 'Description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... description ... ', '10000.00', 10, 22, '{ \"imgid_no\": [ \"8_1\", \"8_2\", \"8_3\", \"8_4\" ] }', '2023-02-19 13:24:14', '2023-02-20 10:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact_number` varchar(11) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `role` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `contact_number`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '09212355533', 'admin', '9'),
(2, 'user', 'user', 'user@user.com', '09212355533', 'user', '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
