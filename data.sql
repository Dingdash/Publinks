-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 04, 2020 at 06:05 PM
-- Server version: 10.3.23-MariaDB-log-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT
= 0;
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `publinks_publink`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE
IF NOT EXISTS `books`
(
  `book_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint
(20) UNSIGNED NOT NULL,
  `toc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `free` int
(1) DEFAULT NULL,
  `mature` varchar
(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `progress` bigint
(20) DEFAULT NULL,
  `min_price` int
(11) DEFAULT NULL,
  `max_price` int
(11) DEFAULT NULL,
  `cover` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint
(1) DEFAULT 0,
  `status` tinyint
(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`book_id`),
  KEY `books_category_id_foreign`
(`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `books`
--
DROP TRIGGER IF EXISTS `delete_cart`;
DELIMITER $$
CREATE TRIGGER `delete_cart` AFTER
UPDATE ON `books` FOR EACH ROW
BEGIN
    IF OLD.free <> NEW.free THEN
    DELETE FROM `shopping_cart` where product_item = OLD.book_id;
END
IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `deletedbook`;
DELIMITER $$
CREATE TRIGGER `deletedbook` AFTER
UPDATE ON `books` FOR EACH ROW
BEGIN
    IF NEW.status = 0 THEN
    DELETE FROM `shopping_cart` where product_item = OLD.book_id;
    DELETE FROM `wishlist` where item_id = OLD.book_id;
END
IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `book_tag`
--

DROP TABLE IF EXISTS `book_tag`;
CREATE TABLE
IF NOT EXISTS `book_tag`
(
  `book_id` bigint
(20) UNSIGNED NOT NULL,
  `tag_id` bigint
(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `book_tag_book_id_foreign`
(`book_id`),
  KEY `book_tag_tag_id_foreign`
(`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE
IF NOT EXISTS `categories`
(
  `category_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dtrans`
--

DROP TABLE IF EXISTS `dtrans`;
CREATE TABLE
IF NOT EXISTS `dtrans`
(
  `dtrans_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_item` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal
(20,0) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`dtrans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE
IF NOT EXISTS `followers`
(
  `id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `follower_id` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp
() ON
UPDATE current_timestamp(),
  `updated_at
` timestamp NOT NULL DEFAULT current_timestamp
(),
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE
IF NOT EXISTS `jobs`
(
  `id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint
(3) UNSIGNED NOT NULL,
  `reserved_at` int
(10) UNSIGNED DEFAULT NULL,
  `available_at` int
(10) UNSIGNED NOT NULL,
  `created_at` int
(10) UNSIGNED NOT NULL,
  PRIMARY KEY
(`id`),
  KEY `jobs_queue_index`
(`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

DROP TABLE IF EXISTS `library`;
CREATE TABLE
IF NOT EXISTS `library`
(
  `id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `favorited` int
(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE
IF NOT EXISTS `migrations`
(
  `id` int
(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int
(11) NOT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE
IF NOT EXISTS `notifications`
(
  `id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recipient` varchar
(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int
(10) UNSIGNED NOT NULL,
  `book_id` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isRead` int
(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` int
(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
CREATE TABLE
IF NOT EXISTS `rates`
(
  `rate_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `review_id` bigint
(20) UNSIGNED NOT NULL,
  `reviewer_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int
(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`rate_id`),
  KEY `rates_review_id_foreign`
(`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE
IF NOT EXISTS `reviews`
(
  `review_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reviewer_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reply` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `replier_id` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_flags`
--

DROP TABLE IF EXISTS `review_flags`;
CREATE TABLE
IF NOT EXISTS `review_flags`
(
  `flag_id` bigint
(10) NOT NULL AUTO_INCREMENT,
  `review_id` bigint
(10) NOT NULL,
  `type` varchar
(64) NOT NULL,
  `description` text NOT NULL,
  `author` varchar
(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp
() ON
UPDATE current_timestamp(),
  `updated_at
` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY
(`flag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE
IF NOT EXISTS `sessions`
(
  `id` varchar
(255) NOT NULL,
  `payload` text NOT NULL,
  `ip_address` varchar
(255) DEFAULT NULL,
  `user_id` varchar
(255) DEFAULT NULL,
  `user_agent` varchar
(255) DEFAULT NULL,
  `last_activity` int
(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
CREATE TABLE
IF NOT EXISTS `shopping_cart`
(
  `id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_item` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

DROP TABLE IF EXISTS `stories`;
CREATE TABLE
IF NOT EXISTS `stories`
(
  `chapter_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` text NOT NULL,
  `position` int
(11) NOT NULL,
  `manuscript` text DEFAULT NULL,
  `chapter_title` text NOT NULL,
  `published` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp
(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp
(),
  PRIMARY KEY
(`chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE
IF NOT EXISTS `tag`
(
  `tag_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE
IF NOT EXISTS `transaction` (
  `transaction_id` varchar
(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal
(20,0) UNSIGNED DEFAULT NULL,
  `cart` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE
IF NOT EXISTS `users`
(
  `user_id` varchar
(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar
(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar
(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar
(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profpic` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `activation_code` varchar
(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `status` int
(11) NOT NULL DEFAULT 0,
  `about` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar
(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int
(1) DEFAULT NULL,
  `password` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`user_id`),
  UNIQUE KEY `users_username_unique`
(`username`),
  UNIQUE KEY `users_email_unique`
(`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
CREATE TABLE
IF NOT EXISTS `user_log`
(
  `id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar
(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar
(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar
(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` varchar
(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viewtraffics`
--

DROP TABLE IF EXISTS `viewtraffics`;
CREATE TABLE
IF NOT EXISTS `viewtraffics`
(
  `traffic_id` bigint
(20) NOT NULL AUTO_INCREMENT,
  `book_id` text NOT NULL,
  `ip_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp
(),
  `updated_at` timestamp NULL DEFAULT current_timestamp
(),
  PRIMARY KEY
(`traffic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE
IF NOT EXISTS `wishlist`
(
  `wishlist_id` bigint
(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar
(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint
(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY
(`wishlist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY
(`category_id`) REFERENCES `categories`
(`category_id`) ON
DELETE CASCADE;

--
-- Constraints for table `book_tag`
--
ALTER TABLE `book_tag`
ADD CONSTRAINT `book_tag_book_id_foreign` FOREIGN KEY
(`book_id`) REFERENCES `books`
(`book_id`),
ADD CONSTRAINT `book_tag_tag_id_foreign` FOREIGN KEY
(`tag_id`) REFERENCES `tag`
(`tag_id`);

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
ADD CONSTRAINT `rates_review_id_foreign` FOREIGN KEY
(`review_id`) REFERENCES `reviews`
(`review_id`) ON
DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
