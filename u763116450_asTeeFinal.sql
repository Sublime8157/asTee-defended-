-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 09, 2024 at 09:25 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u763116450_asTeeFinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profie` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `profie`, `fname`, `mname`, `lname`, `age`, `email`, `username`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, NULL, 'Eunice', 'Galan', 'Miran', 22, 'egalan2002@gmail.com', 'Sublime', NULL, '$2y$12$VuZpxq.HzZUYLJlb9vEV0.c1gxPp6xbPqCHYXNXQxboPzx4VaHtea', NULL, '2024-05-09 05:16:08', '2024-05-13 16:55:56'),
(3, NULL, 'Eunice', 'Miran', 'Galan', 22, 'egalan81577@gmail.com', 'Euniverse', NULL, '$2y$12$Z/kJAbdrLv4hT1g3SVi0juEt7GNdM9tdUAlYZ1TwSg1kcRHvUeCBC', NULL, '2024-05-09 17:39:52', '2024-05-09 17:39:52'),
(6, NULL, 'Joven', 'Faigmani', 'Miran', 23, 'miran.optogrow@gmail.com', 'admin2', NULL, '$2y$12$.DblTEGZmP7JKfhz0d2HLOIDUcv7fz5.ZlC38PrHdPcNndbrvpIwa', NULL, '2024-06-04 17:31:37', '2024-06-04 17:31:37'),
(14, NULL, 'Joven', 'Faigmani', 'Miran', 23, 'miranj8157@gmail.com', 'admin', '2024-06-04 18:35:04', '$2y$12$uNDxn3myNi.AdU.LZN5mn.f4BljN4a09QWNv/zD/I5M156xpPrYNO', '1T9ehwpAcMpnXRNbL8VGCFhWbrLeW7INCBhM3Iz724hDoscuEitUbG45Yt3q', '2024-06-04 18:34:48', '2024-06-07 14:35:27'),
(15, NULL, 'Lordie', 'Rei', 'Lacaba', 22, 'lordielacaba09@gmail.com', 'Lordengg09', '2024-06-07 13:10:44', '$2y$12$zTIfNo/YA.f5kM3B5lVgU.1SJNMYW1qI2pSOUUU/9NO0YnzQ0sUk2', 'F0of5yFNNOeupgO6Ae21diz2pFXoVF9Ro3dHQRJhbJCtgyCBiNATkln808aO', '2024-06-07 13:01:06', '2024-06-07 13:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `productId` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` bigint(20) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `userStatus` bigint(20) UNSIGNED NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verification` enum('not_verified','verified','','') NOT NULL DEFAULT 'not_verified',
  `validID` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `profile`, `image_path`, `fname`, `mname`, `lname`, `birthday`, `address`, `email`, `contact`, `username`, `userStatus`, `email_verified_at`, `password`, `verification`, `validID`, `remember_token`, `created_at`, `updated_at`) VALUES
(57, 'DP.jpg', NULL, 'Joven', 'Faigmani', 'Miran', '2001-01-23', '90 USUSAN KBS CALOOCAN CITY', 'nevojnarim@gmail.com', 9154403873, 'imjoven23', 2, '2024-05-14 19:57:35', '$2y$12$TMxQtHAD0o0Lnedsmr/tVOzMb8hHOsrfkGdbRGTU5FwbIFWhVrApi', 'verified', 'DTI.jpg', 'dDu9B70Q24X2bHYoAUyjgpoC9T91Esb2chLh9wHkTBhx7BaZlRDKWKYtii2T', '2024-05-14 19:57:03', '2024-06-03 21:46:27'),
(65, 'default.png', NULL, 'raph', NULL, 'Puno', '2024-06-05', '12345 caloocan', 'egalan2002@gmail.com', 9455103455, 'puno', 1, NULL, '$2y$12$51fSXhoot025Gg9I66/Coua3VYnfuMYHoj7vArIfkkRh9S9fEd7Hi', 'not_verified', NULL, NULL, '2024-06-05 01:53:01', '2024-06-05 01:53:01'),
(66, 'IMG_2411.jpeg', NULL, 'Eunice', NULL, 'Galan', '2002-04-01', '284B McDonald St., Yokine', 'egalan8157@gmail.com', 9455103455, 'Euniverse', 1, '2024-06-06 10:34:10', '$2y$12$DnEYTbSz/gMYoB32.lga.e6YWxkEb2X2mQ13lePUE5eeT1RIvrDgK', 'not_verified', 'IMG_1939.jpeg', NULL, '2024-06-06 05:09:05', '2024-06-07 15:13:27'),
(67, 'psdtwch3t8o61.jpg', NULL, 'Wilmar', 'Reyess', 'Lacaba', '2001-06-09', '379 North Bay Boulevard North', 'wilmarlacaba09@gmail.com', 9064041713, 'Lordenggg', 1, '2024-06-07 23:40:29', '$2y$12$qq8Ssx1tI8LmZt2dPAw0JO9umQ2h4dKN5YC2MJu6Aeb4NM5f9.Q96', 'verified', 'test id.jpg', 'euTPm8lMDa1u3qAX5NfwWZcoaTwkg5kGC5N6hGkIjReO0H98iUvdhEKQHq8q', '2024-06-07 11:55:39', '2024-06-07 23:40:29'),
(68, 'default.png', NULL, 'Will', NULL, 'Yutuc', '1994-06-08', '236 7th street Brgy Parada Valenzuela', 'williamlouiscasiyutuc@gmail.com', 9615355644, 'willyutuc', 1, '2024-06-08 15:50:12', '$2y$12$.Z35VyKPUqx9jJjIZQsqOOdvgssPHfU/xLac4U13FbG2GovOABLzC', 'not_verified', NULL, NULL, '2024-06-08 09:13:20', '2024-06-08 15:50:12'),
(69, '20240608_154525.jpg', NULL, 'Joven', 'Faigmani', 'Miran', '2001-01-23', '90 USUSAN KBS CALOOCAN CITY', 'miranj8157@gmail.com', 9154403873, 'Sublime', 1, '2024-06-08 09:17:05', '$2y$12$WopXV.l4ErPdYsPEkVzZoudnYWcwym9ARy2J0jc2scZUd5SGm8JQ2', 'not_verified', 'Valid ID(1).jpg', NULL, '2024-06-08 09:14:48', '2024-06-08 15:43:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `productId` bigint(20) UNSIGNED NOT NULL,
  `starCountAll` int(11) NOT NULL,
  `starCountQuality` int(11) NOT NULL,
  `starCountService` int(11) NOT NULL,
  `specify` varchar(255) DEFAULT NULL,
  `featured` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `userId`, `productId`, `starCountAll`, `starCountQuality`, `starCountService`, `specify`, `featured`, `image`, `created_at`, `updated_at`) VALUES
(17, 67, 17, 5, 5, 5, 'angas lods', 2, 'thumbs up.jpg', '2024-06-07 12:45:49', '2024-06-07 12:46:32'),
(18, 69, 18, 5, 5, 5, 'haksds', 2, 'custom_design (1).png', '2024-06-08 09:36:26', '2024-06-08 09:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Male', NULL, NULL),
(2, 'FeMale', NULL, NULL),
(3, 'Unisex', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `customer_id`, `admin_id`, `message`, `attachment`, `created_at`, `updated_at`) VALUES
(1, 57, NULL, 'hello', NULL, '2024-05-22 19:21:17', '2024-05-22 19:21:17'),
(2, 57, NULL, 'gagi ka', NULL, '2024-05-22 19:24:11', '2024-05-22 19:24:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(648, '2014_10_12_000000_create_users_table', 1),
(649, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(650, '2019_08_19_000000_create_failed_jobs_table', 1),
(651, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(652, '2023_12_06_005345_create_user_status_table', 1),
(653, '2023_12_07_105525_create_customers', 1),
(654, '2024_02_05_071240_create_variations_table', 1),
(655, '2024_02_05_071309_create_genders_table', 1),
(656, '2024_02_05_071319_create_sizes_table', 1),
(657, '2024_02_24_003750_create_productStatus_table', 1),
(658, '2024_02_25_231805_create_status_table', 1),
(659, '2024_02_25_234352_create_on_hand_table', 1),
(660, '2024_02_25_234400_create_on_process_table', 1),
(661, '2024_02_25_234411_create_on_cancel_table', 1),
(662, '2024_03_11_014755_create_sales_table', 1),
(663, '2024_03_12_151152_create_admin_login_table', 1),
(664, '2024_03_21_052208_create_carts_table', 1),
(665, '2024_04_07_104814_create_products_table', 1),
(666, '2024_04_09_122227_create_orders_table', 1),
(667, '2024_04_10_232734_create_feedback_table', 1),
(668, '2014_10_12_100000_create_password_resets_table', 2),
(669, '2024_05_23_022901_create_messages_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `productId` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`productId`)),
  `address` varchar(255) NOT NULL,
  `contact` bigint(20) NOT NULL,
  `mop` enum('cash_on_delivery','online_payment') NOT NULL DEFAULT 'online_payment',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `productId`, `address`, `contact`, `mop`, `created_at`, `updated_at`) VALUES
(129, 66, '\"[248]\"', '284B McDonald St., Yokine', 9455103455, 'online_payment', '2024-06-06 05:11:39', '2024-06-06 05:11:39'),
(130, 66, '\"[248,249]\"', '284B McDonald St., Yokine', 9455103455, 'online_payment', '2024-06-06 05:11:39', '2024-06-06 05:11:39'),
(131, 67, '\"[250]\"', '379 North Bay Boulevard North', 9064041713, 'cash_on_delivery', '2024-06-07 12:36:42', '2024-06-07 12:36:42'),
(132, 67, '\"[251]\"', '379 North Bay Boulevard North', 9064041713, 'cash_on_delivery', '2024-06-07 12:41:44', '2024-06-07 12:41:44'),
(133, 69, '\"[252]\"', '90 USUSAN KBS CALOOCAN CITY', 9154403873, 'online_payment', '2024-06-08 09:18:48', '2024-06-08 09:18:48'),
(134, 69, '\"[252,253]\"', '90 USUSAN KBS CALOOCAN CITY', 9154403873, 'online_payment', '2024-06-08 09:18:48', '2024-06-08 09:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('nevojnarim@gmail.com', '$2y$12$miAQd/slWJYrbwIXMV9kI.dbPUz6l548c9z1tOuTFdbFTAb5shyOC', '2024-06-03 01:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `productId` bigint(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `userId`, `productId`, `image_path`, `description`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'p1.jpg', 'Reiciendis est rerum reprehenderit. Qui soluta quos quia laudantium et quia minima. Nemo eum rerum vero deleniti veritatis consequatur. Nihil optio et voluptas ex.', 36, 93, '2024-04-12 14:57:47', '2024-04-12 14:57:47'),
(2, 1, 0, 'p1.jpg', 'Rerum doloremque facere enim id non fugiat. Distinctio omnis mollitia in aut sint. Quos et esse ex maiores corrupti corrupti.', 91, 80, '2024-04-12 14:57:53', '2024-04-12 14:57:53'),
(3, 17, 0, 'p1.jpg', 'Sed aspernatur enim earum facere tempora. Ratione dolorem dolor soluta atque culpa maxime maiores.', 15, 1, '2024-04-12 23:59:16', '2024-04-12 23:59:16'),
(4, 6, 0, 'p1.jpg', 'Voluptatem nesciunt veritatis sit deserunt sed quam. Ut modi unde iste distinctio. Consequatur sit aliquam voluptatem incidunt rerum veritatis et mollitia. Et incidunt cupiditate sunt culpa qui est.', 17, 1, '2024-04-13 03:36:56', '2024-04-13 03:36:56'),
(5, 6, 25, 'p1.jpg', 'Saepe itaque commodi dolorem atque illum. Nostrum ipsum nesciunt aspernatur dolorum et. Facilis exercitationem error sed tenetur dolor.', 79, 1, '2024-04-13 06:28:21', '2024-04-13 06:28:21'),
(6, 19, 47, 'custom_design.png', 'This is your custom design', 150, 2, '2024-04-17 03:09:57', '2024-04-17 03:09:57'),
(7, 6, 71, 'p1.jpg', 'Corrupti sed dignissimos qui nesciunt dolores excepturi. Reprehenderit est non commodi facere unde fuga. Vitae et saepe similique nihil sequi. Nam ut sunt mollitia.', 45, 1, '2024-05-08 18:49:20', '2024-05-08 18:49:20'),
(8, 58, 130, 'p1.jpg', 'Aspernatur enim veniam quod laboriosam modi vitae. Veniam fuga quisquam esse similique modi beatae. Ipsa deserunt error exercitationem ullam provident.', 12, 1, '2024-05-19 01:21:16', '2024-05-19 01:21:16'),
(9, 61, 153, 'p1.jpg', 'Omnis aut dicta hic et perferendis enim aut. Deleniti mollitia aperiam eum odit. Fugit mollitia temporibus amet cum est. Qui aut ut expedita atque maxime saepe sed.', 55, 1, '2024-05-27 22:07:13', '2024-05-27 22:07:13'),
(10, 63, 233, 'p1.jpg', 'Omnis aut dicta hic et perferendis enim aut. Deleniti mollitia aperiam eum odit. Fugit mollitia temporibus amet cum est. Qui aut ut expedita atque maxime saepe sed.', 55, 3, '2024-06-02 21:55:19', '2024-06-02 21:55:19'),
(11, 63, 234, 'p1.jpg', 'Omnis aut dicta hic et perferendis enim aut. Deleniti mollitia aperiam eum odit. Fugit mollitia temporibus amet cum est. Qui aut ut expedita atque maxime saepe sed.', 55, 1, '2024-06-02 22:31:25', '2024-06-02 22:31:25'),
(12, 63, 234, 'p1.jpg', 'Omnis aut dicta hic et perferendis enim aut. Deleniti mollitia aperiam eum odit. Fugit mollitia temporibus amet cum est. Qui aut ut expedita atque maxime saepe sed.', 55, 1, '2024-06-02 22:31:38', '2024-06-02 22:31:38'),
(13, 63, 235, 'p1.jpg', 'Ut id aut alias. Aut voluptatem dolores voluptatem optio impedit sit. Consequatur cum quo autem enim eius non. Atque ut maxime dignissimos praesentium commodi animi.', 47, 3, '2024-06-02 23:07:48', '2024-06-02 23:07:48'),
(14, 63, 240, 'p1.jpg', 'Aspernatur enim veniam quod laboriosam modi vitae. Veniam fuga quisquam esse similique modi beatae. Ipsa deserunt error exercitationem ullam provident.', 12, 1, '2024-06-05 02:28:35', '2024-06-05 02:28:35'),
(15, 63, 244, 'p1.jpg', 'Praesentium deserunt sapiente provident quis dignissimos autem. Reprehenderit voluptate quas quod. Minima nostrum corporis consequatur quia velit aut amet. Tempore fugiat corporis modi sunt qui.', 26, 4, '2024-06-05 17:51:48', '2024-06-05 17:51:48'),
(16, 63, 244, 'p1.jpg', 'Praesentium deserunt sapiente provident quis dignissimos autem. Reprehenderit voluptate quas quod. Minima nostrum corporis consequatur quia velit aut amet. Tempore fugiat corporis modi sunt qui.', 26, 4, '2024-06-05 17:53:54', '2024-06-05 17:53:54'),
(17, 67, 251, '4.jpg', 'Custom made t shirt', 350, 1, '2024-06-07 12:45:49', '2024-06-07 12:45:49'),
(18, 69, 252, '3.jpg', 'Custom made t shirt', 350, 2, '2024-06-08 09:36:26', '2024-06-08 09:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_on_hand`
--

CREATE TABLE `product_on_hand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gender` bigint(20) UNSIGNED NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_on_hand`
--

INSERT INTO `product_on_hand` (`id`, `image_path`, `variation_id`, `description`, `gender`, `size`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(98, '2.jpg', 1, 'Custom made t shirt', 1, 4, 350, 1, '2024-06-07 12:19:20', '2024-06-07 12:19:20'),
(105, '5.jpg', 1, 'Family shirt with for 3 persons 2LARGE 1MD', 1, 1, 400, 1, '2024-06-07 12:27:54', '2024-06-07 12:27:54'),
(106, '7.jpg', 1, '2024 Family Shirt', 1, 1, 500, 5, '2024-06-07 12:28:55', '2024-06-07 12:28:55'),
(107, '8.jpg', 1, 'family shirt also for year of 2024', 1, 1, 250, 1, '2024-06-07 12:29:53', '2024-06-07 12:29:53'),
(108, '9.jpg', 1, '2024 family shirt', 1, 1, 500, 4, '2024-06-07 12:30:16', '2024-06-07 12:30:16'),
(109, '10.jpg', 1, 'family shirt 2024', 1, 1, 600, 2, '2024-06-07 12:30:32', '2024-06-07 12:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `product_on_process`
--

CREATE TABLE `product_on_process` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gender` bigint(20) UNSIGNED NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `productStatus` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_on_process`
--

INSERT INTO `product_on_process` (`id`, `userId`, `image_path`, `variation_id`, `description`, `gender`, `size`, `price`, `quantity`, `total`, `productStatus`, `created_at`, `updated_at`) VALUES
(253, 69, '6.jpg', 1, 'custom made design', 1, 1, 400, 2, 800, 2, '2024-06-08 09:18:48', '2024-06-08 09:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_on_return_cancel`
--

CREATE TABLE `product_on_return_cancel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reason` int(11) DEFAULT NULL,
  `specify` varchar(255) DEFAULT NULL,
  `gender` bigint(20) UNSIGNED NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_on_return_cancel`
--

INSERT INTO `product_on_return_cancel` (`id`, `userId`, `image_path`, `variation_id`, `description`, `reason`, `specify`, `gender`, `size`, `price`, `quantity`, `total`, `created_at`, `updated_at`) VALUES
(46, 67, '1.jpg', 1, 'Custom made t shirt', 4, 'yoko na', 1, 4, 350, 1, 350, '2024-06-07 12:39:35', '2024-06-07 12:39:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_status`
--

CREATE TABLE `product_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_status`
--

INSERT INTO `product_status` (`id`, `status`) VALUES
(1, 'To Pay'),
(2, 'To Ship'),
(3, 'To Recieve'),
(4, 'To Feedback'),
(5, 'To Cancel');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `productId` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `productId`, `userId`, `amount`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 36, 93, '2024-04-12 14:55:26', '2024-04-12 14:55:26'),
(2, 22, 17, 15, 1, '2024-04-12 23:57:58', '2024-04-12 23:57:58'),
(3, 24, 6, 17, 1, '2024-04-13 03:36:46', '2024-04-13 03:36:46'),
(4, 47, 19, 150, 2, '2024-04-17 03:09:12', '2024-04-17 03:09:12'),
(5, 71, 6, 45, 1, '2024-05-08 18:47:44', '2024-05-08 18:47:44'),
(6, 139, 58, 55, 1, '2024-05-19 18:48:24', '2024-05-19 18:48:24'),
(7, 157, 63, 400, 1, '2024-05-31 00:12:40', '2024-05-31 00:12:40'),
(8, 158, 63, 55, 1, '2024-05-31 01:27:58', '2024-05-31 01:27:58'),
(9, 160, 63, 55, 1, '2024-05-31 01:31:54', '2024-05-31 01:31:54'),
(10, 161, 63, 47, 1, '2024-05-31 01:32:22', '2024-05-31 01:32:22'),
(11, 162, 63, 20, 1, '2024-05-31 01:32:22', '2024-05-31 01:32:22'),
(12, 164, 63, 47, 1, '2024-05-31 01:41:17', '2024-05-31 01:41:17'),
(13, 165, 63, 20, 1, '2024-05-31 01:41:17', '2024-05-31 01:41:17'),
(14, 166, 63, 47, 1, '2024-05-31 01:41:32', '2024-05-31 01:41:32'),
(15, 167, 63, 20, 1, '2024-05-31 01:41:32', '2024-05-31 01:41:32'),
(16, 175, 63, 47, 1, '2024-05-31 01:49:35', '2024-05-31 01:49:35'),
(17, 176, 63, 47, 1, '2024-05-31 01:49:52', '2024-05-31 01:49:52'),
(18, 177, 63, 20, 1, '2024-05-31 01:49:52', '2024-05-31 01:49:52'),
(19, 178, 63, 47, 1, '2024-05-31 01:51:32', '2024-05-31 01:51:32'),
(20, 179, 63, 20, 1, '2024-05-31 01:51:32', '2024-05-31 01:51:32'),
(21, 180, 63, 47, 1, '2024-05-31 01:51:35', '2024-05-31 01:51:35'),
(22, 181, 63, 20, 1, '2024-05-31 01:51:35', '2024-05-31 01:51:35'),
(23, 189, 63, 47, 1, '2024-05-31 02:24:42', '2024-05-31 02:24:42'),
(24, 190, 63, 55, 1, '2024-05-31 02:24:42', '2024-05-31 02:24:42'),
(25, 191, 63, 47, 1, '2024-05-31 02:25:26', '2024-05-31 02:25:26'),
(26, 192, 63, 12, 1, '2024-05-31 02:25:26', '2024-05-31 02:25:26'),
(27, 193, 63, 47, 1, '2024-05-31 02:26:07', '2024-05-31 02:26:07'),
(28, 194, 63, 47, 1, '2024-05-31 02:32:57', '2024-05-31 02:32:57'),
(29, 195, 63, 47, 1, '2024-05-31 02:33:15', '2024-05-31 02:33:15'),
(30, 196, 63, 47, 1, '2024-05-31 02:33:29', '2024-05-31 02:33:29'),
(31, 197, 63, 55, 1, '2024-05-31 02:33:29', '2024-05-31 02:33:29'),
(32, 198, 63, 47, 1, '2024-05-31 02:33:46', '2024-05-31 02:33:46'),
(33, 199, 63, 55, 1, '2024-05-31 02:33:46', '2024-05-31 02:33:46'),
(34, 200, 63, 47, 1, '2024-05-31 02:35:32', '2024-05-31 02:35:32'),
(35, 201, 63, 55, 1, '2024-05-31 02:35:32', '2024-05-31 02:35:32'),
(36, 202, 63, 47, 1, '2024-05-31 03:26:41', '2024-05-31 03:26:41'),
(37, 203, 63, 55, 1, '2024-05-31 03:26:41', '2024-05-31 03:26:41'),
(38, 204, 63, 47, 1, '2024-05-31 03:32:57', '2024-05-31 03:32:57'),
(39, 205, 63, 12, 1, '2024-05-31 03:32:57', '2024-05-31 03:32:57'),
(40, 206, 63, 12, 1, '2024-05-31 05:08:51', '2024-05-31 05:08:51'),
(41, 207, 63, 12, 1, '2024-05-31 05:09:45', '2024-05-31 05:09:45'),
(42, 208, 63, 55, 1, '2024-05-31 06:21:06', '2024-05-31 06:21:06'),
(43, 209, 63, 55, 1, '2024-05-31 06:21:56', '2024-05-31 06:21:56'),
(44, 210, 63, 55, 1, '2024-05-31 06:22:26', '2024-05-31 06:22:26'),
(45, 211, 63, 55, 1, '2024-05-31 06:27:53', '2024-05-31 06:27:53'),
(46, 212, 63, 20, 1, '2024-05-31 06:27:53', '2024-05-31 06:27:53'),
(47, 213, 63, 12, 1, '2024-05-31 06:31:45', '2024-05-31 06:31:45'),
(48, 214, 63, 12, 1, '2024-05-31 07:22:00', '2024-05-31 07:22:00'),
(49, 215, 63, 55, 1, '2024-05-31 07:22:00', '2024-05-31 07:22:00'),
(50, 216, 63, 20, 1, '2024-05-31 07:22:00', '2024-05-31 07:22:00'),
(51, 217, 63, 47, 1, '2024-05-31 08:03:23', '2024-05-31 08:03:23'),
(52, 218, 63, 12, 1, '2024-05-31 08:03:23', '2024-05-31 08:03:23'),
(53, 219, 63, 55, 1, '2024-05-31 08:03:23', '2024-05-31 08:03:23'),
(54, 220, 63, 47, 1, '2024-05-31 08:05:47', '2024-05-31 08:05:47'),
(55, 221, 63, 12, 1, '2024-05-31 08:05:47', '2024-05-31 08:05:47'),
(56, 222, 63, 55, 1, '2024-05-31 08:05:47', '2024-05-31 08:05:47'),
(57, 223, 63, 255, 1, '2024-05-31 08:06:30', '2024-05-31 08:06:30'),
(58, 224, 63, 159, 1, '2024-05-31 08:06:30', '2024-05-31 08:06:30'),
(59, 225, 63, 36, 1, '2024-05-31 08:06:30', '2024-05-31 08:06:30'),
(60, 226, 63, 55, 1, '2024-06-02 18:10:00', '2024-06-02 18:10:00'),
(61, 227, 63, 47, 1, '2024-06-02 18:11:49', '2024-06-02 18:11:49'),
(62, 228, 63, 47, 1, '2024-06-02 18:14:29', '2024-06-02 18:14:29'),
(63, 229, 63, 47, 1, '2024-06-02 18:18:11', '2024-06-02 18:18:11'),
(64, 230, 63, 47, 1, '2024-06-02 18:34:50', '2024-06-02 18:34:50'),
(65, 231, 63, 47, 1, '2024-06-02 18:35:01', '2024-06-02 18:35:01'),
(66, 232, 63, 12, 1, '2024-06-02 18:35:57', '2024-06-02 18:35:57'),
(67, 233, 63, 165, 1, '2024-06-02 18:40:49', '2024-06-02 18:40:49'),
(68, 234, 63, 55, 1, '2024-06-02 18:45:24', '2024-06-02 18:45:24'),
(69, 235, 63, 141, 1, '2024-06-02 18:47:00', '2024-06-02 18:47:00'),
(70, 236, 63, 141, 1, '2024-06-02 18:51:40', '2024-06-02 18:51:40'),
(71, 237, 63, 141, 1, '2024-06-02 18:53:01', '2024-06-02 18:53:01'),
(72, 238, 63, 55, 1, '2024-06-03 01:31:10', '2024-06-03 01:31:10'),
(73, 239, 63, 20, 1, '2024-06-03 01:31:10', '2024-06-03 01:31:10'),
(74, 240, 63, 12, 1, '2024-06-03 01:31:10', '2024-06-03 01:31:10'),
(75, 242, 64, 55, 1, '2024-06-03 21:23:22', '2024-06-03 21:23:22'),
(76, 243, 64, 55, 1, '2024-06-03 21:23:50', '2024-06-03 21:23:50'),
(77, 244, 63, 104, 1, '2024-06-05 02:18:26', '2024-06-05 02:18:26'),
(78, 245, 63, 104, 1, '2024-06-05 02:18:47', '2024-06-05 02:18:47'),
(79, 244, 63, 26, 4, '2024-06-05 02:28:17', '2024-06-05 02:28:17'),
(80, 246, 63, 12, 1, '2024-06-05 18:00:28', '2024-06-05 18:00:28'),
(81, 247, 63, 47, 1, '2024-06-05 18:00:28', '2024-06-05 18:00:28'),
(82, 248, 66, 12, 1, '2024-06-06 05:11:39', '2024-06-06 05:11:39'),
(83, 249, 66, 20, 1, '2024-06-06 05:11:39', '2024-06-06 05:11:39'),
(84, 250, 67, 350, 1, '2024-06-07 12:36:42', '2024-06-07 12:36:42'),
(85, 251, 67, 350, 1, '2024-06-07 12:41:44', '2024-06-07 12:41:44'),
(86, 252, 69, 700, 1, '2024-06-08 09:18:48', '2024-06-08 09:18:48'),
(87, 253, 69, 800, 1, '2024-06-08 09:18:48', '2024-06-08 09:18:48'),
(88, 252, 69, 350, 2, '2024-06-08 09:35:59', '2024-06-08 09:35:59');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `created_at`, `updated_at`) VALUES
(1, 'XS', NULL, NULL),
(2, 'Small', NULL, NULL),
(3, 'Medium', NULL, NULL),
(4, 'Large', NULL, NULL),
(5, 'XL', NULL, NULL),
(6, 'XXL', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'On Hand', NULL, NULL),
(2, 'On Process', NULL, NULL),
(3, 'On Cancel_Return', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE `user_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'active', NULL, NULL),
(2, 'blocked', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variation` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `variation`, `created_at`, `updated_at`) VALUES
(1, 'Couple Shirt', NULL, NULL),
(2, 'Solo Shirt', NULL, NULL),
(3, 'Family Shirt', NULL, NULL),
(4, 'Kids Wear', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_login_email_unique` (`email`),
  ADD UNIQUE KEY `admin_login_username_unique` (`username`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_userid_foreign` (`userId`),
  ADD KEY `carts_productid_foreign` (`productId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_username_unique` (`username`),
  ADD KEY `customers_userstatus_foreign` (`userStatus`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_userid_foreign` (`userId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_customer_id_foreign` (`customer_id`),
  ADD KEY `messages_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_userid_foreign` (`userId`),
  ADD KEY `orders_productid_foreign` (`productId`(768));

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_userid_foreign` (`userId`);

--
-- Indexes for table `product_on_hand`
--
ALTER TABLE `product_on_hand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_on_hand_variation_id_foreign` (`variation_id`),
  ADD KEY `product_on_hand_gender_foreign` (`gender`),
  ADD KEY `product_on_hand_size_foreign` (`size`);

--
-- Indexes for table `product_on_process`
--
ALTER TABLE `product_on_process`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_on_process_variation_id_foreign` (`variation_id`),
  ADD KEY `product_on_process_gender_foreign` (`gender`),
  ADD KEY `product_on_process_size_foreign` (`size`),
  ADD KEY `product_on_process_productstatus_foreign` (`productStatus`),
  ADD KEY `product_on_process_userid_foreign` (`userId`);

--
-- Indexes for table `product_on_return_cancel`
--
ALTER TABLE `product_on_return_cancel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_on_return_cancel_variation_id_foreign` (`variation_id`),
  ADD KEY `product_on_return_cancel_gender_foreign` (`gender`),
  ADD KEY `product_on_return_cancel_size_foreign` (`size`),
  ADD KEY `product_on_return_cancel_userid_foreign` (`userId`);

--
-- Indexes for table `product_status`
--
ALTER TABLE `product_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_userid_foreign` (`userId`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=670;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_on_hand`
--
ALTER TABLE `product_on_hand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `product_on_process`
--
ALTER TABLE `product_on_process`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `product_on_return_cancel`
--
ALTER TABLE `product_on_return_cancel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product_status`
--
ALTER TABLE `product_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_productid_foreign` FOREIGN KEY (`productId`) REFERENCES `product_on_hand` (`id`),
  ADD CONSTRAINT `carts_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `customers` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_userstatus_foreign` FOREIGN KEY (`userStatus`) REFERENCES `user_status` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `feedback_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `customers` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admin_login` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `customers` (`id`);

--
-- Constraints for table `product_on_hand`
--
ALTER TABLE `product_on_hand`
  ADD CONSTRAINT `product_on_hand_gender_foreign` FOREIGN KEY (`gender`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `product_on_hand_size_foreign` FOREIGN KEY (`size`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `product_on_hand_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);

--
-- Constraints for table `product_on_process`
--
ALTER TABLE `product_on_process`
  ADD CONSTRAINT `product_on_process_gender_foreign` FOREIGN KEY (`gender`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `product_on_process_productstatus_foreign` FOREIGN KEY (`productStatus`) REFERENCES `product_status` (`id`),
  ADD CONSTRAINT `product_on_process_size_foreign` FOREIGN KEY (`size`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `product_on_process_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `product_on_process_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);

--
-- Constraints for table `product_on_return_cancel`
--
ALTER TABLE `product_on_return_cancel`
  ADD CONSTRAINT `product_on_return_cancel_gender_foreign` FOREIGN KEY (`gender`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `product_on_return_cancel_size_foreign` FOREIGN KEY (`size`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `product_on_return_cancel_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `product_on_return_cancel_variation_id_foreign` FOREIGN KEY (`variation_id`) REFERENCES `variations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
