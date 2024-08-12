-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 10:11 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(5) NOT NULL,
  `name` varchar(15) NOT NULL,
  `email` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$pPh8v0kflKJIvz1oOeP8wOK6fhuOWV8uEuz/bFIm9rs3bz5rCnqaS');

-- --------------------------------------------------------

--
-- Table structure for table `confirmed_orders`
--

CREATE TABLE `confirmed_orders` (
  `id` int(5) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'confirmed',
  `confirmed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `confirmed_orders`
--

INSERT INTO `confirmed_orders` (`id`, `order_id`, `order_status`, `confirmed_at`) VALUES
(1, 'ORDER_18370', 'confirmed', '2024-05-08 06:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `message`, `date`) VALUES
(1, 'vinay kshirsagar', 'kshirsagarvinay1234@gmail.com', '9890668274', 'Hello !', '2024-04-20 13:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(5) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `order_cost` decimal(6,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_id` varchar(255) NOT NULL,
  `payment_status` text NOT NULL DEFAULT '\'on_hold\''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `order_cost`, `user_id`, `user_name`, `user_email`, `user_phone`, `user_city`, `user_address`, `order_date`, `payment_id`, `payment_status`) VALUES
(1, 'ORDER_18370', '499.00', 1, 'vinay kshirsagar', 'kshirsagarvinay1234@gmail.com', 2147483647, 'pune', 'Bharti-Vidhyapeeth , Pune', '2024-05-08 08:49:56', 'pay_O7uG7nxQ0jT1ic', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_size` varchar(10) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_category` varchar(100) DEFAULT NULL,
  `order_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `user_id`, `product_id`, `product_name`, `product_price`, `product_quantity`, `product_size`, `product_image`, `product_category`, `order_date`) VALUES
(1, 'ORDER_18370', 1, 1, 'Lucknowi Kurti', '499.00', 1, 'XXl', 'feature1.png', 'Featured', '2024-05-08 08:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(108) NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_price`) VALUES
(1, 'Lucknowi Kurti', 'Featured', 'Best in class product.', 'feature1.png', '499.00'),
(2, 'Dress', 'Featured', 'Best in class product.', 'feature2.png', '349.00'),
(3, 'Lucknowi Kurta', 'Featured', 'Best in class product.', 'featured3.png', '800.00'),
(4, 'Sweatshirt', 'Featured', 'Best in class product.', 'feature4.png', '499.00'),
(5, 'Polo', 'Men', 'Best in class product.', 'men1.png', '250.00'),
(6, 'Denim', 'Men', 'Best in class product.', 'men2.png', '400.00'),
(7, 'Casual', 'Men', 'Best in class product.', 'men3.png', '349.00'),
(8, 'Suite', 'Men', 'Best in class product.', 'men4.png', '1999.00'),
(9, 'Saree', 'Women', 'Best in class product.', 'women1.png', '1500.00'),
(10, 'Cocktail Dress', 'Women', 'Best in class product.', 'women2.png', '799.00'),
(11, 'Skirt', 'Women', 'Best in class product.', 'women3.png', '1000.00'),
(12, 'Wrap Dress', 'Women', 'Best in class product.', 'women4.png', '199.00'),
(13, 'Polo', 'Kid', 'Best in class product.', 'kid1.png', '250.00'),
(14, 'T-Shirt', 'Kid', 'Best in class product.', 'kid2.png', '200.00'),
(15, 'Sweater', 'Kid', 'Best in class product.', 'kid3.png', '899.00'),
(16, 'Dress', 'Kid', 'Best in class product.', 'kid4.png', '1100.00'),
(35, 'vinay', 'men', 'syfcghbdfcv', 'meesho.png', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory`
--

CREATE TABLE `product_inventory` (
  `product_id` int(11) DEFAULT NULL,
  `product_size` varchar(10) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_inventory`
--

INSERT INTO `product_inventory` (`product_id`, `product_size`, `product_quantity`) VALUES
(1, 'S', 8),
(1, 'M', 10),
(1, 'L', 10),
(1, 'Xl', 10),
(1, 'XXl', 9),
(2, 'S', 0),
(2, 'M', 0),
(2, 'L', 0),
(2, 'Xl', 0),
(2, 'XXl', 0),
(3, 'S', 8),
(3, 'M', 4),
(3, 'L', 8),
(3, 'Xl', 8),
(3, 'XXl', 0),
(4, 'S', 0),
(4, 'M', 9),
(4, 'L', 9),
(4, 'Xl', 10),
(4, 'XXl', 10),
(5, 'S', 10),
(5, 'M', 10),
(5, 'L', 10),
(5, 'Xl', 10),
(5, 'XXl', 6),
(6, 'S', 9),
(6, 'M', 10),
(6, 'L', 10),
(6, 'Xl', 10),
(6, 'XXl', 4),
(7, 'S', 7),
(7, 'M', 8),
(7, 'L', 7),
(7, 'Xl', 10),
(7, 'XXl', 3),
(8, 'S', 9),
(8, 'M', 7),
(8, 'L', 10),
(8, 'Xl', 9),
(8, 'XXl', 0),
(9, 'S', 3),
(9, 'M', 5),
(9, 'L', 10),
(9, 'Xl', 10),
(9, 'XXl', 10),
(10, 'S', 7),
(10, 'M', 10),
(10, 'L', 10),
(10, 'Xl', 10),
(10, 'XXl', 10),
(11, 'S', 9),
(11, 'M', 10),
(11, 'L', 9),
(11, 'Xl', 5),
(11, 'XXl', 10),
(12, 'S', 10),
(12, 'M', 10),
(12, 'L', 10),
(12, 'Xl', 10),
(12, 'XXl', 10),
(13, 'S', 10),
(13, 'M', 10),
(13, 'L', 9),
(13, 'Xl', 10),
(13, 'XXl', 10),
(14, 'S', 10),
(14, 'M', 9),
(14, 'L', 10),
(14, 'Xl', 10),
(14, 'XXl', 10),
(15, 'S', 10),
(15, 'M', 9),
(15, 'L', 10),
(15, 'Xl', 9),
(15, 'XXl', 10),
(16, 'S', 9),
(16, 'M', 10),
(16, 'L', 10),
(16, 'Xl', 5),
(16, 'XXl', 10),
(35, 'S', 10),
(35, 'M', 10),
(35, 'L', 10),
(35, 'XL', 10),
(35, 'XXL', 10);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(10) NOT NULL,
  `our_story` varchar(1000) NOT NULL,
  `about_img` varchar(255) NOT NULL,
  `our_mission` varchar(1000) NOT NULL,
  `our_team` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `our_story`, `about_img`, `our_mission`, `our_team`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla aliquam, tortor at lobortis maximus, nulla neque aliquet nisi, ut convallis quam odio vel dolor.Integer ut nulla vel risus fermentum aliquet id a nisi. Phasellus vitae semper nulla. Proin euismod, est vel gravida suscipit, sapien risus vestibulum tortor, at efficitur odio risus a lorem.', 'about.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla aliquam, tortor at lobortis maximus, nulla neque aliquet nisi, ut convallis quam odio vel dolor.Integer ut nulla vel risus fermentum aliquet id a nisi. Phasellus vitae semper nulla. Proin euismod, est vel gravida suscipit, sapien risus vestibulum tortor, at efficitur odio risus a lorem.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla aliquam, tortor at lobortis maximus, nulla neque aliquet nisi, ut convallis quam odio vel dolor.Integer ut nulla vel risus fermentum aliquet id a nisi. Phasellus vitae semper nulla. Proin euismod, est vel gravida suscipit, sapien risus vestibulum tortor, at efficitur odio risus a lorem.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'unverified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_username`, `user_email`, `user_phone`, `user_password`, `user_address`, `user_city`, `status`) VALUES
(1, 'vinay kshirsagar', 'vinay', 'kshirsagarvinay1234@gmail.com', '9890668274', '$2y$10$ivuYATj7wamgB4co8rAw9Otdf3L4uF6YvI5I5qzO6y77mGXsJ9xAu', 'Bharti-Vidhyapeeth , Pune', 'pune', 'verified');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `confirmed_orders`
--
ALTER TABLE `confirmed_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD KEY `product_inventory_ibfk_1` (`product_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `confirmed_orders`
--
ALTER TABLE `confirmed_orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD CONSTRAINT `product_inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
