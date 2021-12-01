-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2021 at 09:57 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

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
(1, 2, 2, 'asdasd', '2021-08-06 22:57:35'),
(2, 2, 2, '', '2021-08-06 23:08:43');

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
(1, 2, 'asd', 'sfsd,e3tb,asd,dfgh5t', 'asd\r\nasd\r\nasd\r\nasd\r\nasd', '', '2021-07-26 00:00:00'),
(2, 2, 'asda jsjf ajshiueqh asd', 'ad, as, a,sd a,sd,asd', 'asd\r\nas \r\nasd\r\n ', '', '2021-07-26 00:00:00'),
(3, 2, 'sadasd', 'asd', 'asd', '', '2021-11-30 21:56:10'),
(4, 2, 'asdasd', 'asd asd,asdasd asd', 'asdasd', '192438e425a15665492b13674bbd4407.jpg', '2021-11-30 21:59:37'),
(5, 2, 'asd asd', 'sadasd,asd', 'sadasd', '1e3af7db40c95778b73bab820af3f0ef.jpg', '2021-11-30 03:00:23'),
(6, 2, 'me', 'asd', 'asd', 'b34c3acc3b59a79b32796b2cb5918d67.', '2021-11-30 18:15:28'),
(7, 2, 'asd', 'asd', 'asd', '812c97638eb7bf0edbf08e91e7f76218.', '2021-11-30 18:25:05');

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
(1, 'Arden Smithasdsa', '', 'United Statesasdsa', 'asdasd', 'asd', 'asd', 'asd', 'asd', 'admin@website.com', '21232f297a57a5a743894a0e4a801fc3', '', 'active', 'admin', '2021-06-16 20:04:08'),
(2, 'Wasim Suleman', '51cd624f115b32a18e0450a2c9031afe.jpg', 'United States', 'ausdsadasdasdasdhasdasdjasd<p><br></p><p><br></p><p> ajsdasd   jaksdkasdk              asdasd                    asd                                asdas                           asd                     asdas d                          asdsadhasd</p>', 'twitter.com/w33svm', 'facebook.com/w33svm', 'facebook.com/w33svm', 'youtube.com/w33svm', 'wasimsuleman.ws@gmail.com', '698d51a19d8a121ce581499d7b701668', '', 'active', 'user', '2021-06-16 20:04:08'),
(35, 'Steelforge', '', '', '', '', '', '', '', 'afran1@yahoo.fr', '698d51a19d8a121ce581499d7b701668', '', 'active', 'user', '2021-08-08 17:22:38'),
(36, 'Wasim Suleman', '', '', '', '', '', '', '', '123@website.com', '698d51a19d8a121ce581499d7b701668', '', 'deleted', 'user', '2021-12-01 12:33:42');

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
(14, 2, 1, '1'),
(16, 2, 2, '1'),
(29, 2, 7, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
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
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
