-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-01-10 21:23:31
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `mksto`
--

-- --------------------------------------------------------

--
-- 表的结构 `api_down`
--

CREATE TABLE `api_down` (
  `id` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `content` text,
  `img` varchar(150) DEFAULT NULL,
  `down` varchar(150) DEFAULT NULL,
  `Maintain` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `title_site` varchar(100) NOT NULL,
  `top` varchar(20) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `Yes` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `api_down`
--
ALTER TABLE `api_down`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `api_down`
--
ALTER TABLE `api_down`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
