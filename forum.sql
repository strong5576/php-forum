-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2017-12-03 20:13:34
-- 伺服器版本: 10.1.21-MariaDB
-- PHP 版本： 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `forum`
--

-- --------------------------------------------------------

--
-- 資料表結構 `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `thread_id` int(10) NOT NULL,
  `poster` int(10) NOT NULL,
  `message` text NOT NULL,
  `posted_on` int(16) NOT NULL,
  `children` int(10) NOT NULL,
  `parent` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `posts`
--

INSERT INTO `posts` (`post_id`, `thread_id`, `poster`, `message`, `posted_on`, `children`, `parent`) VALUES
(1, 1, 1, '我最喜歡 Breaking Dead，神劇', 1512222844, 1, 0),
(2, 2, 6, '我最喜歡王力宏，超帥！', 1512223292, 1, 0),
(3, 3, 5, 'BMW x5！！！', 1512223423, 0, 0),
(4, 1, 5, '當然是 Game of The Thrones..................', 1512223554, 0, 0),
(5, 1, 5, 'Breaking Dead+1', 1512223578, 0, 1),
(6, 2, 5, '劉若英', 1512223630, 0, 0),
(7, 2, 5, '林熙蕾也不錯！', 1512223668, 0, 0),
(8, 2, 5, '也很喜歡安心亞', 1512223699, 0, 0),
(9, 2, 1, '最近很迷蘇宗怡', 1512223794, 0, 0),
(10, 2, 1, '藍心湄', 1512223828, 0, 0),
(11, 2, 1, '陳海茵很漂亮。', 1512223870, 0, 0),
(12, 2, 1, '張菲', 1512223895, 0, 0),
(13, 2, 1, '還有他弟弟費玉清', 1512223940, 0, 0),
(14, 2, 1, '王力宏，是的我喜歡', 1512224004, 0, 2),
(15, 2, 1, '康康，性情中人。', 1512224070, 0, 2),
(16, 3, 1, '馬自達不錯', 1512224119, 0, 0),
(17, 3, 1, '還有瑪莎拉蒂。', 1512224165, 0, 0),
(18, 3, 2, '首選 CRV', 1512224660, 0, 0),
(19, 3, 2, 'Mercedes-Benz', 1512224713, 0, 0),
(20, 3, 2, 'Mercedes-Benz S600 讚！', 1512224767, 0, 0),
(21, 3, 2, 'Mercedes-AMG GT 才是王者！', 1512224851, 0, 0),
(22, 3, 2, '當然 BMW 大7 也不錯！', 1512224904, 0, 0),
(23, 1, 1, 'The Sopranos 最好看', 1512301965, 0, 0),
(24, 1, 1, 'The Americans 正在看，還不錯！', 1512302009, 0, 0),
(25, 1, 2, 'Game of The Thrones 神劇！', 1512302119, 1, 0),
(26, 1, 2, '那隻龍太逼真了。', 1512302166, 0, 0),
(27, 1, 2, '還有一部 Gilmore Girl 很溫馨！', 1512302221, 0, 0),
(28, 1, 3, 'Sex And The City , Good！！！', 1512302289, 0, 0),
(29, 1, 3, 'Prison Break 男主角很帥。', 1512302360, 0, 0),
(30, 1, 1, '剛追玩 Downton Abbey，正點。', 1512302442, 0, 0),
(31, 1, 1, '女主角很耐看。', 1512302481, 1, 0),
(32, 1, 1, '男主角太帥了！', 1512302541, 0, 31),
(33, 1, 1, '真的，太好看了。', 1512302610, 0, 25),
(34, 1, 1, '期待第六季，聽說花大錢拍攝。', 1512302749, 0, 25),
(35, 1, 1, '非常期待。', 1512302794, 0, 25);

-- --------------------------------------------------------

--
-- 資料表結構 `threads`
--

CREATE TABLE `threads` (
  `thread_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `subject` varchar(150) NOT NULL,
  `built_on` int(12) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `threads`
--

INSERT INTO `threads` (`thread_id`, `created_by`, `subject`, `built_on`) VALUES
(1, 1, '那一部歐美影集最好看？', 1512222844),
(2, 6, '說說看最喜歡那一個明星？', 1512223292),
(3, 5, '那一部車最正點？', 1512223423);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(40) NOT NULL,
  `alias` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `join_date` int(16) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `alias`, `email`, `join_date`) VALUES
(1, 'david', 'aa743a0aaec8f7d7a1f01442503957f4d7a2d634', '戴維', 'strong5576@yahoo.com', 1512222709),
(2, 'allen', 'a4aed34f4966dc8688b8e67046bf8b276626e284', '艾倫', 'allen@yahoo.com', 1512222917),
(3, 'kevin', 'ffb4761cba839470133bee36aeb139f58d7dbaa9', '凱文', 'kevin@yahoo.com', 1512222968),
(4, 'eric', '96f164ad4d9b2b0dacf8ebee2bb1eeb3aa69adf1', '艾立克', 'eric@gmail.com', 1512223019),
(5, 'tony', '1001e8702733cced254345e193c88aaa47a4f5de', '湯尼', 'tony@hotmail.com', 1512223062),
(6, 'sarah', 'be8ec20d52fdf21c23e83ba2bb7446a7fecb32ac', '莎菈', 'sarah@hotmail.com', 1512223115);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- 資料表索引 `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用資料表 AUTO_INCREMENT `threads`
--
ALTER TABLE `threads`
  MODIFY `thread_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用資料表 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
