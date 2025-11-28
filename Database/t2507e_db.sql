-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2025 at 03:26 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `t2507e_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Fashion', 'fashion'),
(2, 'Watch', 'watch'),
(3, 'Smart Phone', 'smart-phone'),
(4, 'Computer', 'computer'),
(5, 'Tablet', 'tablet');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(12,4) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `qty` int(10) UNSIGNED DEFAULT NULL,
  `description` text,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `thumbnail`, `qty`, `description`, `category_id`) VALUES
(9, 'Red Lipstick-9', '21.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(10, 'iPhone 5s-10', '209.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(12, 'Eyeshadow Palette with Mirror-12', '31.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(13, 'Powder Canister-13', '27.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(14, 'Red Lipstick-14', '26.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(15, 'iPhone 5s-15', '214.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(16, 'Essence Mascara Lash Princess-16', '25.9900', 'https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp', 9, 'The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.', 1),
(17, 'Eyeshadow Palette with Mirror-17', '36.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(18, 'Powder Canister-18', '32.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(19, 'Red Lipstick-19', '31.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(20, 'iPhone 5s-20', '219.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(21, 'Essence Mascara Lash Princess-21', '30.9900', 'https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp', 9, 'The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.', 1),
(22, 'Eyeshadow Palette with Mirror-22', '41.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(23, 'Powder Canister-23', '37.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(24, 'Red Lipstick-24', '36.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(25, 'iPhone 5s-25', '224.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(26, 'iPad Mini 2021 Starlight-26', '325.0000', 'https://cdn.dummyjson.com/product-images/tablets/ipad-mini-2021-starlight/thumbnail.webp', 3, 'The iPad Mini 2021 in Starlight is a compact and powerful tablet from Apple. Featuring a stunning Retina display, powerful A-series chip, and a sleek design, it offers a premium tablet experience.', 5),
(27, 'Essence Mascara Lash Princess-27', '36.9900', 'https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp', 9, 'The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.', 1),
(28, 'Eyeshadow Palette with Mirror-28', '47.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(29, 'Powder Canister-29', '43.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(30, 'Red Lipstick-30', '42.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(31, 'iPhone 5s-31', '230.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(32, 'Essence Mascara Lash Princess-32', '41.9900', 'https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp', 9, 'The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.', 1),
(33, 'Eyeshadow Palette with Mirror-33', '52.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(34, 'Powder Canister-34', '48.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(35, 'Red Lipstick-35', '47.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(36, 'iPhone 5s-36', '235.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(37, 'Essence Mascara Lash Princess-37', '46.9900', 'https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp', 9, 'The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.', 1),
(38, 'Eyeshadow Palette with Mirror-38', '57.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(39, 'Powder Canister-39', '53.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(40, 'Red Lipstick-40', '52.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(41, 'iPhone 5s-41', '240.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(42, 'Essence Mascara Lash Princess-42', '51.9900', 'https://cdn.dummyjson.com/product-images/beauty/essence-mascara-lash-princess/thumbnail.webp', 9, 'The Essence Mascara Lash Princess is a popular mascara known for its volumizing and lengthening effects. Achieve dramatic lashes with this long-lasting and cruelty-free formula.', 1),
(43, 'Eyeshadow Palette with Mirror-43', '62.9900', 'https://cdn.dummyjson.com/product-images/beauty/eyeshadow-palette-with-mirror/thumbnail.webp', 2, 'The Eyeshadow Palette with Mirror offers a versatile range of eyeshadow shades for creating stunning eye looks. With a built-in mirror, it\'s convenient for on-the-go makeup application.', 1),
(44, 'Powder Canister-44', '58.9900', 'https://cdn.dummyjson.com/product-images/beauty/powder-canister/thumbnail.webp', 5, 'The Powder Canister is a finely milled setting powder designed to set makeup and control shine. With a lightweight and translucent formula, it provides a smooth and matte finish.', 1),
(45, 'Red Lipstick-45', '57.4900', 'https://cdn.dummyjson.com/product-images/beauty/red-lipstick/thumbnail.webp', 23, 'The Red Lipstick is a classic and bold choice for adding a pop of color to your lips. With a creamy and pigmented formula, it provides a vibrant and long-lasting finish.', 2),
(46, 'iPhone 5s-46', '245.9900', 'https://cdn.dummyjson.com/product-images/smartphones/iphone-5s/thumbnail.webp', 23, 'The iPhone 5s is a classic smartphone known for its compact design and advanced features during its release. While it\'s an older model, it still provides a reliable user experience.', 3),
(47, 'iPad Mini 2021 Starlight-47', '346.0000', 'https://cdn.dummyjson.com/product-images/tablets/ipad-mini-2021-starlight/thumbnail.webp', 3, 'The iPad Mini 2021 in Starlight is a compact and powerful tablet from Apple. Featuring a stunning Retina display, powerful A-series chip, and a sleek design, it offers a premium tablet experience.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'nguyen manh tu', 'mail@mail.com', '$2y$10$wWfHzx99pogRiORWsbXnhOdVuxwgWa6TazEE8AZ/oCJK6VOytqhqe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
