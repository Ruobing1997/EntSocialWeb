-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2021 at 11:02 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(15) NOT NULL,
  `userId` int(15) NOT NULL,
  `postId` int(15) NOT NULL,
  `comment` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `userId`, `postId`, `comment`, `datetime`) VALUES
(4, 38, 9, 'test', '2021-12-03 14:36:30');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(15) NOT NULL,
  `userId` int(15) NOT NULL,
  `postId` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `userId`, `postId`) VALUES
(6, 40, 11);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(15) NOT NULL,
  `userId` int(15) NOT NULL,
  `title` text NOT NULL,
  `tags` varchar(255) NOT NULL,
  `details` longtext NOT NULL,
  `file` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userId`, `title`, `tags`, `details`, `file`, `date`) VALUES
(8, 37, 'Test Posts', 'test,tag', 'This is to test!', '56857dbdf645b55f690df0d4cc2bf703.', '2021-12-03 10:41:32'),
(9, 37, 'Another Post!', 'post,test', 'Here is another a post!', '3175deb0a64b5811185a941dcb04b3b2.', '2021-12-03 10:42:12'),
(10, 40, 'post to test related', 'test', 'test posts', 'e4a8fe6ad46d9f4989c8f07ecfd4e276.', '2021-12-03 21:42:54'),
(11, 40, 'Test search page', 'search', 'This is to test the search page', '6189b95cfe28bd6c2c0e56e7584a53da.', '2021-12-03 22:14:31'),
(12, 40, 'make test question', 'question', 'this is a sample test question', '05c9f0c95d8e39fc1c414b3132a6da97.', '2021-12-03 22:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `profilePhoto` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `aboutMe` longtext NOT NULL,
  `twitterLink` varchar(255) NOT NULL,
  `facebookLink` varchar(255) NOT NULL,
  `instagramLink` varchar(255) NOT NULL,
  `youtubeLink` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `authtoken` varchar(255) NOT NULL,
  `status` enum('pending','blocked','active','deleted') NOT NULL,
  `type` enum('user','admin') NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `profilePhoto`, `location`, `aboutMe`, `twitterLink`, `facebookLink`, `instagramLink`, `youtubeLink`, `email`, `password`, `authtoken`, `status`, `type`, `datetime`) VALUES
(37, 'Ruobing Wang', '', '', '', '', '', '', '', 'ruobing2@andrew.cmu.edu', 'e10adc3949ba59abbe56e057f20f883e', '', 'active', 'user', '2021-12-03 04:41:06'),
(38, 'testuser1', '', '', '', '', '', '', '', 'testuser1@test1.com', '202cb962ac59075b964b07152d234b70', '', 'active', 'user', '2021-12-03 04:42:42'),
(39, 'Robin', '', '', '', '', '', '', '', 'robin@test.com', 'e10adc3949ba59abbe56e057f20f883e', '', 'active', 'user', '2021-12-03 15:13:40'),
(40, 'RobinFromCMU', '', '', '', '', '', '', '', 'testuser888@test.com', 'a550a85bcdda69a00506155ad8d11170', '', 'active', 'user', '2021-12-03 15:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(15) NOT NULL,
  `userId` int(15) NOT NULL,
  `postId` int(15) NOT NULL,
  `vote` enum('0','1','-1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `userId`, `postId`, `vote`) VALUES
(63, 40, 11, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
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
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
