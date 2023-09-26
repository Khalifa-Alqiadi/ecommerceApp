-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13 نوفمبر 2021 الساعة 20:36
-- إصدار الخادم: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Parent` varchar(255) NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` int(11) NOT NULL DEFAULT 0,
  `Allow_Comment` int(11) NOT NULL DEFAULT 0,
  `Allow_Ads` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Games', 'The Past Games', '0', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- بنية الجدول `comments`
--

CREATE TABLE `comments` (
  `C_ID` int(11) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `Comment_Date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `comments`
--

INSERT INTO `comments` (`C_ID`, `Comment`, `Status`, `Comment_Date`, `item_id`, `user_id`) VALUES
(1, 'this is a good', 0, '2021-04-15', 1, 1),
(2, 'this is a good', 0, '2021-04-15', 1, 1),
(3, 'sdgsdrfhgdfsg', 1, '2021-06-30', 3, 1);

-- --------------------------------------------------------

--
-- بنية الجدول `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL,
  `Add_Date` date NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Tags` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `Approve` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Country_Made`, `Status`, `Add_Date`, `Cat_ID`, `Member_ID`, `Tags`, `avatar`, `Approve`) VALUES
(1, 'Pupgy', 'the is a good game', '100', 'USA', 1, '2021-04-15', 1, 1, 'Games', '93444_36662_pupgy.jpg', 1),
(2, 'Ys Oath In Felghana', 'The Worst Games Ecer', '20', 'China', 4, '2021-04-16', 1, 1, 'RPG, Online, Game', '8436_92704_81CtqOIiW4L._SS500_ Ys.jpg', 1),
(3, 'Phone Not 10 ', 'This Game Is Very Good And Vary Nice', '300', 'اليمن', 1, '2021-06-30', 1, 1, 'phone,games', '1476_706_تنزيل.jpg', 1),
(4, 'Phone Not 10 ', 'This Mobile Is Galaxy', '300', 'USA', 1, '2021-09-24', 1, 1, 'Games', '39935_5.jpg', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `FullName`, `Email`, `Pass`, `Date`, `RegStatus`, `GroupID`, `avatar`) VALUES
(0, 'ayman', 'aymen aljafry', 'aymen@gmail.com', '5a78babbb162531b3a16c55310a4e7228d68f2e9', '2021-04-15', 0, 0, '33894_التقاط.PNG'),
(1, 'fiter', 'fiter alaiadi', 'fiteeralqiadi@gmail.com', '2778cb15047b69e5e1e166cbb0d8c4323c9595c6', '2021-03-21', 1, 1, ''),
(4, 'fiteer', 'alqiadi', 'khaleifa@gmail.com', '58482244cc523e4a8cf6168089ea7cb846cd0700', '0000-00-00', 0, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`C_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `C_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
