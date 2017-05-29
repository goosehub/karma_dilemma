-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2017 at 03:45 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `theory`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(10) UNSIGNED NOT NULL,
  `started_flag` bit(1) NOT NULL,
  `finished_flag` bit(1) NOT NULL,
  `a_user_key` int(10) UNSIGNED NOT NULL,
  `b_user_key` int(10) UNSIGNED NOT NULL,
  `a_action` bit(1) NOT NULL,
  `b_action` bit(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `game_bid`
--

CREATE TABLE `game_bid` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_key` int(10) UNSIGNED NOT NULL,
  `user_key` int(10) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `karma`
--

CREATE TABLE `karma` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` bit(1) NOT NULL,
  `resale_flag` bit(1) NOT NULL,
  `sold_flag` bit(1) NOT NULL,
  `buyer_user_key` int(10) UNSIGNED NOT NULL,
  `seller_user_key` int(10) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `karma_bid`
--

CREATE TABLE `karma_bid` (
  `id` int(10) UNSIGNED NOT NULL,
  `karma_key` int(10) UNSIGNED NOT NULL,
  `user_key` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payoff`
--

CREATE TABLE `payoff` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_key` int(10) UNSIGNED NOT NULL,
  `a_payoff` int(11) NOT NULL,
  `b_payoff` int(11) NOT NULL,
  `a_action` bit(1) NOT NULL,
  `b_action` bit(1) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_flag` bit(1) NOT NULL,
  `user_key` int(10) UNSIGNED NOT NULL,
  `ip` varchar(100) NOT NULL,
  `api_flag` bit(1) NOT NULL,
  `route_url` varchar(1000) NOT NULL,
  `full_url` varchar(1000) NOT NULL,
  `get_data` text NOT NULL,
  `post_data` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `last_load` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ab_test` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  `owned_positive_karma` int(11) UNSIGNED NOT NULL,
  `owned_negative_karma` int(11) UNSIGNED NOT NULL,
  `positive_karma` int(11) UNSIGNED NOT NULL,
  `negative_karma` int(11) UNSIGNED NOT NULL,
  `email` varchar(250) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `auth_token` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_bid`
--
ALTER TABLE `game_bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karma`
--
ALTER TABLE `karma`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karma_bid`
--
ALTER TABLE `karma_bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payoff`
--
ALTER TABLE `payoff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `game_bid`
--
ALTER TABLE `game_bid`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `karma`
--
ALTER TABLE `karma`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `karma_bid`
--
ALTER TABLE `karma_bid`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payoff`
--
ALTER TABLE `payoff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
