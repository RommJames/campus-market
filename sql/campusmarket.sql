-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2026 at 07:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campusmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$5yc.2tuwWCJoow6JgGGRfOktRA4aZ2pUqRk/aVcyiAGXCs7AK2trC');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_type` varchar(50) NOT NULL DEFAULT 'general'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_type`) VALUES
(1, 'Textbooks', 'academic'),
(2, 'Calculators', 'academic'),
(3, 'School Supplies', 'academic'),
(4, 'Uniforms', 'academic'),
(5, 'Laptops', 'academic'),
(6, 'Photography Equipment', 'entertainment_media'),
(7, 'Videography Equipment', 'entertainment_media'),
(8, 'Audio Equipment', 'entertainment_media'),
(9, 'Musical Instruments', 'entertainment_media'),
(10, 'Lighting Equipment', 'entertainment_media'),
(11, 'Film Props & Costumes', 'entertainment_media'),
(12, 'Graphic Tablets & Editing Accessories', 'entertainment_media'),
(13, 'Creative Services', 'entertainment_media');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_saved` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `product_id`, `date_saved`) VALUES
(1, 1, 4, '2026-07-17 13:11:57'),
(2, 1, 7, '2026-07-17 13:11:57'),
(3, 2, 9, '2026-07-17 13:11:57'),
(4, 3, 3, '2026-07-17 13:11:57'),
(5, 4, 6, '2026-07-17 13:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_status` varchar(20) DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `order_status`, `total_amount`) VALUES
(1, 1, '2026-07-17 13:11:57', 'completed', 650.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `subtotal`) VALUES
(1, 1, 2, 1, 650.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_rental` tinyint(1) DEFAULT 0,
  `rental_price` decimal(10,2) DEFAULT NULL,
  `rental_duration` varchar(50) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT 'no-image.png',
  `status` varchar(20) DEFAULT 'available',
  `date_posted` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `category_id`, `product_name`, `description`, `price`, `is_rental`, `rental_price`, `rental_duration`, `product_image`, `status`, `date_posted`) VALUES
(1, 1, 1, 'Calculus Early Transcendentals 8th Ed', 'Used textbook, minimal highlighting, good condition.', 450.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(2, 1, 2, 'Casio FX-991ES Plus Scientific Calculator', 'Barely used, comes with original box.', 650.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(3, 2, 5, 'Acer Aspire 5 Laptop (i5, 8GB RAM)', 'Good for school work, light gaming. Battery still healthy.', 18500.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(4, 2, 6, 'Canon EOS M50 Mirrorless Camera', 'Great for photography and vlogging. Includes 15-45mm lens.', 0.00, 1, 800.00, 'per day', 'no-image.png', 'available', '2026-07-17 13:11:57'),
(5, 3, 7, 'DJI Ronin-S Gimbal Stabilizer', 'For smooth cinematic shots. Well maintained.', 0.00, 1, 500.00, 'per day', 'no-image.png', 'available', '2026-07-17 13:11:57'),
(6, 3, 8, 'Rode NT-USB Condenser Microphone', 'Studio-quality mic, perfect for podcasts and voice-overs.', 3200.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(7, 4, 9, 'Yamaha Acoustic Guitar F310', 'Great beginner guitar, includes soft case.', 2800.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(8, 4, 10, 'Neewer Ring Light with Stand (18-inch)', 'Perfect for content creation and photoshoots.', 0.00, 1, 250.00, 'per day', 'no-image.png', 'rented', '2026-07-17 13:11:57'),
(9, 5, 11, 'Vintage Polaroid-style Camera Prop', 'Non-functional, great for photoshoots or film props.', 350.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(10, 5, 12, 'Wacom Intuos Drawing Tablet', 'Used for digital art and graphic design. Works perfectly.', 2500.00, 0, NULL, NULL, 'no-image.png', 'sold', '2026-07-17 13:11:57'),
(11, 2, 3, 'Complete Drafting/Drawing Set', 'Includes ruler, compass, protractor, and case.', 180.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57'),
(12, 1, 4, 'PE Uniform Set (Medium)', 'Lightly used, washed and ready.', 300.00, 0, NULL, NULL, 'no-image.png', 'available', '2026-07-17 13:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `service_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'available',
  `date_posted` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `user_id`, `category_id`, `service_name`, `description`, `price`, `status`, `date_posted`) VALUES
(1, 2, 13, 'Event Photography Coverage', 'Full event coverage with edited photos delivered within 3 days.', 1500.00, 'available', '2026-07-17 13:11:57'),
(2, 3, 13, 'Video Editing (Reels/TikTok Style)', 'Fast-turnaround short-form video editing with captions and transitions.', 500.00, 'available', '2026-07-17 13:11:57'),
(3, 4, 13, 'Logo & Brand Design', 'Custom logo design with 3 revision rounds included.', 800.00, 'available', '2026-07-17 13:11:57'),
(4, 5, 13, 'Voice Acting / Voice Over', 'Clear, professional voice recording for projects, ads, or games.', 400.00, 'available', '2026-07-17 13:11:57'),
(5, 3, 13, 'Music Production (Beat Making)', 'Custom instrumental production for original songs or covers.', 1200.00, 'available', '2026-07-17 13:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'default.png',
  `date_registered` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `student_id`, `contact_number`, `profile_image`, `date_registered`) VALUES
(1, 'Romm James Cuya', 'romm.cuya@ciit.edu.ph', '$2y$10$AsK2a1pdXn9v2kuC0nBMbOt53Zaj3tho6gNyQZyLe.GyPqR.UdBBe', '123', '', 'default.png', '2026-07-17 12:03:05'),
(2, 'Maria Santos', 'maria.santos@student.edu', '$2y$10$QaCWdASzWIMeDtdK8jKTrO8DoTsQ2TuJwNmWEhyIpsLN8EytGEsFO', '2023-00145', '09171234567', 'default.png', '2026-07-17 13:11:57'),
(3, 'Juan Dela Cruz', 'juan.delacruz@student.edu', '$2y$10$QaCWdASzWIMeDtdK8jKTrO8DoTsQ2TuJwNmWEhyIpsLN8EytGEsFO', '2023-00212', '09182345678', 'default.png', '2026-07-17 13:11:57'),
(4, 'Angela Reyes', 'angela.reyes@student.edu', '$2y$10$QaCWdASzWIMeDtdK8jKTrO8DoTsQ2TuJwNmWEhyIpsLN8EytGEsFO', '2022-00089', '09193456789', 'default.png', '2026-07-17 13:11:57'),
(5, 'Miguel Torres', 'miguel.torres@student.edu', '$2y$10$QaCWdASzWIMeDtdK8jKTrO8DoTsQ2TuJwNmWEhyIpsLN8EytGEsFO', '2023-00301', '09204567890', 'default.png', '2026-07-17 13:11:57'),
(6, 'Bea Fernandez', 'bea.fernandez@student.edu', '$2y$10$QaCWdASzWIMeDtdK8jKTrO8DoTsQ2TuJwNmWEhyIpsLN8EytGEsFO', '2021-00456', '09215678901', 'default.png', '2026-07-17 13:11:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `unique_favorite` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
