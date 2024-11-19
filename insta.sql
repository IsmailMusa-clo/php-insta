-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2024 at 04:27 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `insta`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user_to`, `user_from`) VALUES
(15, 'khaled_mouse', 'ahmed_reyad'),
(16, 'ali_mohammed', 'galal_mubaraki');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(34, 'salem_jaber', 67),
(35, 'salem_jaber', 68),
(37, 'ali_mohammed', 69),
(38, 'khaled_mouse', 71),
(39, 'ali_mohammed', 66),
(40, 'ahmed_reyad', 72),
(41, 'salem_jaber', 72),
(42, 'salem_jaber', 71),
(54, 'ahmed_reyad', 66),
(55, 'ahmed_reyad', 75),
(58, 'ahmed_reyad', 77),
(61, 'galal_mubaraki', 87);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(44, 'ahmed_reyad', 'ahmed_reyad', 'hiiii', '2018-05-29 15:32:46', 'yes', 'no', 'no'),
(45, 'ahmed_reyad', 'ahmed_reyad', 'hellooo\r\n', '2018-05-30 20:53:23', 'yes', 'no', 'no'),
(46, 'salem_jaber', 'ahmed_reyad', 'hiii\r\n', '2018-05-30 20:53:52', 'yes', 'no', 'no'),
(47, 'salem_jaber', 'ahmed_reyad', 'hiii\r\n', '2018-05-30 20:57:32', 'yes', 'no', 'no'),
(48, 'salem_jaber', 'salem_jaber', 'hiiii', '2018-05-30 22:36:42', 'yes', 'no', 'no'),
(49, 'ahmed_reyad', 'salem_jaber', 'helooo\r\n', '2018-05-30 22:37:16', 'yes', 'no', 'no'),
(50, 'ahmed_reyad', 'salem_jaber', 'whats up bro??\r\n', '2018-05-30 22:40:00', 'yes', 'no', 'no'),
(51, 'ahmed_reyad', 'ahmed_reyad', 'hello', '2018-05-31 04:10:52', 'yes', 'no', 'no'),
(52, 'ahmed_reyad', 'ali_mohammed', 'hiii akhil', '2018-05-31 05:36:19', 'yes', 'no', 'no'),
(53, 'ali_mohammed', 'ahmed_reyad', 'hiii tom', '2018-05-31 05:37:10', 'yes', 'no', 'no'),
(54, 'ali_mohammed', 'ahmed_reyad', 'how you doing??', '2018-05-31 05:37:22', 'yes', 'no', 'no'),
(55, 'ahmed_reyad', 'ali_mohammed', 'good what about you da', '2018-05-31 05:37:59', 'yes', 'no', 'no'),
(56, 'ahmed_reyad', 'ali_mohammed', 'كيف الحال', '2024-11-18 17:50:02', 'yes', 'no', 'no'),
(57, 'ali_mohammed', 'ahmed_reyad', 'مرحبا\r\n', '2024-11-19 11:55:17', 'yes', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `body` mediumtext NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'no',
  `deleted` varchar(3) NOT NULL,
  `likes` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`) VALUES
(66, 'hello', 'ahmed_reyad', 'none', '2018-05-29 14:53:43', 'no', 'yes', 6),
(67, 'hello!! Good afternoon', 'salem_jaber', 'none', '2018-05-30 15:36:27', 'no', 'no', 1),
(68, 'Hiii akhil!! what\'s up??', 'salem_jaber', 'ahmed_reyad', '2018-05-30 16:33:51', 'no', 'yes', 1),
(69, 'hiii akhil..!! whats up??', 'khaled_mouse', 'ahmed_reyad', '2018-05-31 04:55:53', 'no', 'yes', 1),
(70, 'hiii', 'khaled_mouse', 'none', '2018-05-31 05:26:32', 'no', 'yes', 0),
(71, 'hiiii', 'ali_mohammed', 'none', '2018-05-31 05:34:56', 'no', 'no', 2),
(72, 'hiiii akhil whats up??', 'ali_mohammed', 'ahmed_reyad', '2018-05-31 05:35:25', 'no', 'yes', 2),
(73, 'hello every body', 'khaled_mouse', 'none', '2024-11-18 18:23:09', 'no', 'no', 0),
(74, 'hello every body', 'khaled_mouse', 'none', '2024-11-18 18:24:05', 'no', 'no', 0),
(75, 'مرحبا هذا او منشور لي', 'ahmed_reyad', 'none', '2024-11-19 10:57:24', 'no', 'yes', 1),
(76, 'مرحبا هذا او منشور لي', 'ahmed_reyad', 'none', '2024-11-19 10:58:25', 'no', 'no', 0),
(77, 'هل امورك اليوم جيدة', 'ahmed_reyad', 'none', '2024-11-19 12:05:30', 'no', 'yes', 1),
(78, 'هل امورك اليوم جيدة', 'ahmed_reyad', 'none', '2024-11-19 12:05:40', 'no', 'no', 0),
(79, 'اهلا وسهلا بكم', 'جميل_محمد', 'none', '2024-11-19 18:22:03', 'no', 'yes', 0),
(80, 'اهلا وسهلا بكم', 'جميل_محمد', 'none', '2024-11-19 18:22:21', 'no', 'yes', 0),
(81, 'اهلا وسهلا بكم', 'جميل_محمد', 'none', '2024-11-19 18:22:25', 'no', 'yes', 0),
(82, 'اهلا وسهلا بكم', 'جميل_محمد', 'none', '2024-11-19 18:22:29', 'no', 'no', 0),
(83, 'اهلا وسهلا بكم', 'جميل_محمد', 'none', '2024-11-19 18:22:33', 'no', 'no', 0),
(84, 'مرحبا', 'khald_slamt', 'none', '2024-11-19 18:53:28', 'no', 'no', 0),
(85, 'مرحبا', 'khald_slamt', 'none', '2024-11-19 19:05:59', 'no', 'yes', 0),
(86, 'مرحبا', 'khald_slamt', 'none', '2024-11-19 19:06:12', 'no', 'yes', 0),
(87, 'مرحبا', 'galal_mubaraki', 'none', '2024-11-19 19:21:07', 'no', 'no', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int NOT NULL,
  `num_likes` int NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(1, 'Ali', 'Mohammed', 'ali_mohammed', 'ali.98@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-05-29', 'assets/images/profile_pics/ahmed_reyad6e2fccee03881d0690fdc3638696ea90n.jpeg', 1, 3, 'no', ',salem_jaber,khaled_mouse,ali_mohammed,ahmed_reyad,'),
(2, 'Khaled', 'Ali', 'khaled_mouse', 'khaledmouse@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-05-30', 'assets/images/profile_pics/ahmed_reyad6e2fccee0388...', 4, 2, 'no', ',ahmed_reyad,'),
(3, 'Salem', 'Jaber', 'salem_jaber', 'salemjaber@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-05-31', 'assets/images/profile_pics/defaults/head_wet_asphalt.png', 2, 1, 'yes', ',ahmed_reyad,'),
(4, 'Ahmed', 'Reyad', 'ahmed_reyad', 'ahmed@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2018-05-31', 'assets/images/profile_pics/ali_mohammed6154f51837c8d33585e99362bd5b982fn.jpeg', 6, 9, 'no', ',ahmed_reyad,ali_mohammed,'),
(18, 'Galal', 'Mubaraki', 'galal_mubaraki', 'galal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-11-19', 'assets/images/profile_pics/defaults/head_wet_asphalt.png', 1, 1, 'no', ',');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
