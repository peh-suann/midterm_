-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-12-28 15:36:33
-- 伺服器版本： 10.4.27-MariaDB
-- PHP 版本： 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `mountain_midtern`
--

-- --------------------------------------------------------

--
-- 資料表結構 `coupon`
--

CREATE TABLE `coupon` (
  `sid` int(11) NOT NULL,
  `promo_name` varchar(255) DEFAULT NULL,
  `coupon_name` varchar(25) NOT NULL,
  `coupon_code` varchar(25) NOT NULL,
  `min_purchase` int(11) NOT NULL,
  `coupon_rate` float NOT NULL,
  `start_date_coup` datetime NOT NULL,
  `end_date_coup` datetime NOT NULL,
  `coupon_status` varchar(25) DEFAULT NULL,
  `display` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `coupon`
--

INSERT INTO `coupon` (`sid`, `promo_name`, `coupon_name`, `coupon_code`, `min_purchase`, `coupon_rate`, `start_date_coup`, `end_date_coup`, `coupon_status`, `display`) VALUES
(1, '', '聖誕節全館特價', '11112', 100, 5, '1996-01-01 00:00:00', '1996-04-01 00:00:00', '可使用', 1),
(2, '', '春節限時特價', '11113', 500, 8, '1996-04-01 00:00:00', '1996-07-01 00:00:00', '可使用', 1),
(3, '', '生日特價', '11114', 200, 85, '1996-07-01 00:00:00', '1996-10-01 00:00:00', '失效', 1),
(4, '', '評價特價', '11115', 1000, 9, '1996-10-01 00:00:00', '1996-12-01 00:00:00', '可使用', 1),
(5, '', '會員特價', '11116', 2000, 95, '1997-01-01 00:00:00', '1997-04-01 00:00:00', '可使用', 1),
(6, '', '新手特價', '11117', 3000, 8, '1997-04-01 00:00:00', '2026-07-01 00:00:00', '可使用', 1),
(7, '', '滿500折', '11118', 1500, 7, '1997-07-01 00:00:00', '1997-10-01 00:00:00', '失效', 1),
(8, '', '早鳥優惠', '11119', 2500, 65, '1997-10-01 00:00:00', '1997-12-01 00:00:00', '可使用', 1),
(9, '', '補助優惠', '11120', 500, 9, '1998-01-01 00:00:00', '1998-04-01 00:00:00', '失效', 1),
(10, '', '中秋限時特價', '11121', 1000, 95, '1998-04-01 00:00:00', '1998-07-01 00:00:00', '可使用', 1),
(11, '', '端午節全館特價', '11122', 2000, 8, '1998-07-01 00:00:00', '1998-10-01 00:00:00', '失效', 1),
(12, '', '聖誕節全館特價', '11123', 100, 5, '1996-01-01 00:00:00', '1996-04-01 00:00:00', '可使用', 1),
(13, '', '春節限時特價', '11124', 500, 8, '1996-04-01 00:00:00', '1996-07-01 00:00:00', '可使用', 1),
(14, '', '生日特價', '11125', 200, 85, '1996-07-01 00:00:00', '1996-10-01 00:00:00', '失效', 1),
(15, '', '評價特價', '11126', 1000, 9, '2005-01-01 00:00:00', '2024-01-01 00:00:00', '可使用', 1),
(16, '', '會員特價', '11127', 2000, 95, '1997-01-01 00:00:00', '1997-04-01 00:00:00', '失效', 1),
(17, '', '新手特價', '11128', 3000, 8, '1997-04-01 00:00:00', '2026-07-01 00:00:00', '可使用', 1),
(18, '', '滿500折', '11129', 1500, 7, '1997-07-01 00:00:00', '1997-10-01 00:00:00', '失效', 1),
(19, '', '早鳥優惠', '11130', 500, 65, '1997-10-01 00:00:00', '1997-12-01 00:00:00', '失效', 1),
(20, '', '補助優惠', '11131', 500, 9, '1998-01-01 01:00:00', '1998-04-01 00:00:00', '失效', 1),
(24, '', 'coupon1', '11135', 900, 85, '2022-12-01 22:05:00', '2022-12-31 22:06:00', '失效', 0),
(26, '', 'coupon1', '22222', 900, 9, '2022-12-01 22:08:00', '2022-12-31 22:08:00', '失效', 0),
(28, '', 'coupon', 'abcde', 900, 8, '2022-12-28 22:26:00', '2022-12-31 12:29:00', '失效', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`),
  ADD KEY `coupon_code_2` (`coupon_code`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coupon`
--
ALTER TABLE `coupon`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
