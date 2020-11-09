-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2020 at 06:11 PM
-- Server version: 8.0.22-0ubuntu0.20.04.2
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `axos_pizza_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_type`
--

CREATE TABLE `ingredient_type` (
  `id` int NOT NULL,
  `ingredient_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredient_type`
--

INSERT INTO `ingredient_type` (`id`, `ingredient_type`) VALUES
(1, 'Sauce'),
(2, 'Topping');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(3, 'Bake'),
(4, 'Box'),
(5, 'Delivery'),
(1, 'Order Placed'),
(2, 'Prep');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_combination`
--

CREATE TABLE `pizza_combination` (
  `id` int NOT NULL,
  `pizza_id` int NOT NULL DEFAULT '0',
  `ingredient_id` int NOT NULL,
  `pizza_partition_section` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_ingredient`
--

CREATE TABLE `pizza_ingredient` (
  `id` int NOT NULL,
  `ingredient_name` varchar(100) NOT NULL,
  `ingredient_type_id` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pizza_ingredient`
--

INSERT INTO `pizza_ingredient` (`id`, `ingredient_name`, `ingredient_type_id`, `price_dollar`, `price_cent`) VALUES
(1, 'Ham', 2, 0, 50),
(2, 'Beef', 2, 0, 50),
(3, 'Salami', 2, 0, 50),
(4, 'Pepperoni', 2, 0, 50),
(5, 'Italian Sausage', 2, 0, 50),
(6, 'Premium Chicken', 2, 0, 75),
(7, 'Bacon', 2, 0, 75),
(8, 'Philly Steak', 2, 0, 75),
(9, 'Garlic', 2, 0, 50),
(10, 'Jalapeno Peppers', 2, 0, 50),
(11, 'Onions', 2, 0, 50),
(12, 'Banana Peppers', 2, 0, 50),
(13, 'Diced Tomatoes', 2, 0, 50),
(14, 'Black Olives', 2, 0, 50),
(15, 'Mushrooms', 2, 0, 50),
(16, 'Pineapple', 2, 0, 50),
(17, 'Green Peppers', 2, 0, 50),
(18, 'Cheese', 2, 0, 0),
(19, 'Spinach', 2, 0, 50),
(20, 'Fire Roasted Red Peppers', 2, 0, 50),
(21, 'Marinara', 1, 0, 0),
(22, 'BBQ', 1, 0, 25),
(23, 'Alfredo', 1, 0, 25);

-- --------------------------------------------------------

--
-- Table structure for table `pizza_order`
--

CREATE TABLE `pizza_order` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status_id` int NOT NULL,
  `total_price_dollar` int NOT NULL,
  `total_price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_order_line`
--

CREATE TABLE `pizza_order_line` (
  `id` int NOT NULL,
  `pizza_order_id` int NOT NULL,
  `pizza_combination_id` int NOT NULL,
  `pizza_size_id` int NOT NULL,
  `price_dollar` int NOT NULL,
  `price_cent` smallint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizza_size`
--

CREATE TABLE `pizza_size` (
  `id` int NOT NULL,
  `size` varchar(25) NOT NULL,
  `price_cent` smallint NOT NULL,
  `price_dollar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pizza_size`
--

INSERT INTO `pizza_size` (`id`, `size`, `price_cent`, `price_dollar`) VALUES
(1, 'Small', 0, 5),
(2, 'Medium', 50, 6),
(3, 'Large', 0, 8),
(4, 'X-Large', 0, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient_type`
--
ALTER TABLE `ingredient_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ingredient_type` (`ingredient_type`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`);

--
-- Indexes for table `pizza_combination`
--
ALTER TABLE `pizza_combination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`) USING BTREE;

--
-- Indexes for table `pizza_ingredient`
--
ALTER TABLE `pizza_ingredient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ingredient_name` (`ingredient_name`),
  ADD KEY `FK_PIZZAINGREDIENT_INGREDIENTTYPE` (`ingredient_type_id`);

--
-- Indexes for table `pizza_order`
--
ALTER TABLE `pizza_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PIZZAORDER_CUSTOMER` (`customer_id`),
  ADD KEY `FK_PIZZAORDER_ORDERSTATUS` (`order_status_id`);

--
-- Indexes for table `pizza_order_line`
--
ALTER TABLE `pizza_order_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PIZZAORDERLINE_PIZZAORDER` (`pizza_order_id`),
  ADD KEY `FK_PIZZAORDERLINE_PIZZACOMBINATION` (`pizza_combination_id`),
  ADD KEY `FK_PIZZAORDERLINE_PIZZASIZE` (`pizza_size_id`);

--
-- Indexes for table `pizza_size`
--
ALTER TABLE `pizza_size`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ingredient_type`
--
ALTER TABLE `ingredient_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pizza_combination`
--
ALTER TABLE `pizza_combination`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizza_ingredient`
--
ALTER TABLE `pizza_ingredient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pizza_order`
--
ALTER TABLE `pizza_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pizza_order_line`
--
ALTER TABLE `pizza_order_line`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizza_size`
--
ALTER TABLE `pizza_size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pizza_combination`
--
ALTER TABLE `pizza_combination`
  ADD CONSTRAINT `FK_PIZZACOMBINATION_PIZZAINGREDIENT` FOREIGN KEY (`ingredient_id`) REFERENCES `pizza_ingredient` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pizza_ingredient`
--
ALTER TABLE `pizza_ingredient`
  ADD CONSTRAINT `FK_PIZZAINGREDIENT_INGREDIENTTYPE` FOREIGN KEY (`ingredient_type_id`) REFERENCES `ingredient_type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pizza_order`
--
ALTER TABLE `pizza_order`
  ADD CONSTRAINT `FK_PIZZAORDER_CUSTOMER` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_PIZZAORDER_ORDERSTATUS` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `pizza_order_line`
--
ALTER TABLE `pizza_order_line`
  ADD CONSTRAINT `FK_PIZZAORDERLINE_PIZZAORDER` FOREIGN KEY (`pizza_order_id`) REFERENCES `pizza_order` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_PIZZAORDERLINE_PIZZASIZE` FOREIGN KEY (`pizza_size_id`) REFERENCES `pizza_size` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
