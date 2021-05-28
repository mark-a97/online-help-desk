-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2021 at 06:30 PM
-- Server version: 5.7.34
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mra25_helpDesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_speciality`
--

CREATE TABLE `admin_speciality` (
  `specialityID` int(11) NOT NULL,
  `userSpeciality` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_speciality`
--

INSERT INTO `admin_speciality` (`specialityID`, `userSpeciality`) VALUES
(25, 'Hardware'),
(26, 'Software'),
(27, 'Networking');

-- --------------------------------------------------------

--
-- Table structure for table `faq_table`
--

CREATE TABLE `faq_table` (
  `faqID` int(11) NOT NULL,
  `faq_topic` varchar(64) NOT NULL,
  `fUsername` varchar(64) NOT NULL,
  `faq_question` varchar(64) NOT NULL,
  `faq_answer` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq_table`
--

INSERT INTO `faq_table` (`faqID`, `faq_topic`, `fUsername`, `faq_question`, `faq_answer`) VALUES
(47, 'test', 'admin2', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationID` int(11) NOT NULL,
  `noti_from` varchar(64) NOT NULL,
  `noti_to` varchar(64) NOT NULL,
  `noti_type` varchar(64) NOT NULL,
  `noti_time` datetime DEFAULT NULL,
  `noti_entity` varchar(64) DEFAULT NULL,
  `noti_msg` varchar(128) NOT NULL,
  `readNotification` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationID`, `noti_from`, `noti_to`, `noti_type`, `noti_time`, `noti_entity`, `noti_msg`, `readNotification`) VALUES
(262, 'admin2', 'admin2', 'assignedTo', '2021-05-21 13:53:02', '128', ' has assigned you to the ticket: final test. Click here to view.', 'False'),
(263, 'admin2', 'admin2', 'assignedToUser', '2021-05-21 13:53:02', '128', ' has assigned admin2 to your ticket: final test. You should get a response soon.', 'False'),
(264, 'admin2', 'admin2', 'Ticket', '2021-05-21 13:56:15', '128', ' has replied to your ticket (final test). Click here to view.', 'False'),
(265, 'admin2', 'admin2', 'Ticket', '2021-05-21 13:56:23', '128', ' has replied to your ticket (final test). Click here to view.', 'False'),
(266, 'admin2', 'admin2', 'deleteTicket', '2021-05-21 13:56:40', '128', ' has deleted your ticket: final test. Click here to view your tickets', 'False');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `replyID` int(11) NOT NULL,
  `ticketID` int(11) NOT NULL,
  `fUsername` varchar(64) NOT NULL,
  `replyTime` datetime NOT NULL,
  `ticketReply` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`replyID`, `ticketID`, `fUsername`, `replyTime`, `ticketReply`) VALUES
(111, 82, 'admin2', '2021-03-24 20:13:56', 'Can now update username, email and change password'),
(112, 83, 'admin2', '2021-03-24 20:27:05', 'Added, next to add a background colour depending on the priority'),
(113, 79, 'admin2', '2021-03-24 20:32:43', 'Fixed'),
(114, 84, 'admin2', '2021-03-24 20:33:05', 'Done'),
(115, 81, 'admin2', '2021-03-25 01:17:35', 'Done'),
(116, 83, 'admin2', '2021-03-25 17:57:13', 'Done'),
(117, 75, 'admin2', '2021-03-25 19:50:42', 'Done'),
(118, 78, 'admin2', '2021-03-25 23:06:34', 'Added FAQ system where level 2 admins can manually add question topics and answered, unsure it will stay like this'),
(119, 77, 'admin2', '2021-03-26 01:08:12', 'Updating the burger button to work properly with mobile'),
(120, 77, 'admin2', '2021-03-28 22:21:51', 'Side nav had some issues related to the grid, changed. Changed the grid, which has led to there being no margin errors. Slight bug in regards to the burger nav opening and closing'),
(121, 86, 'admin2', '2021-03-28 22:22:17', 'Closed'),
(122, 98, 'admin2', '2021-03-31 06:03:10', 'Now display in a better format, need to update so it displays in the table'),
(123, 98, 'admin2', '2021-03-31 21:36:08', 'Done'),
(124, 87, 'admin2', '2021-04-01 01:33:14', 'Majority fixed, need to organise the tables so they are consistent with one another'),
(125, 87, 'admin2', '2021-04-01 01:33:18', 'test'),
(126, 98, 'admin2', '2021-04-01 01:34:01', 'Done'),
(127, 77, 'admin2', '2021-04-01 01:36:18', 'Fixed nav issues'),
(128, 80, 'admin2', '2021-04-01 19:11:48', 'DASDSADASDSADS'),
(129, 102, 'user', '2021-04-03 00:37:08', 'This is my first reply'),
(130, 102, 'admin2', '2021-04-03 00:37:56', 'This is my other reply'),
(131, 102, 'admin2', '2021-04-04 06:50:00', 'Done'),
(132, 80, 'admin2', '2021-04-04 14:56:05', 'Testing notificaton'),
(133, 80, 'admin2', '2021-04-04 14:56:30', 'Testing notificaton'),
(174, 105, 'admin2', '2021-04-05 17:10:28', 'Closed'),
(175, 105, 'admin2', '2021-04-05 18:02:40', 'asd'),
(176, 105, 'admin2', '2021-04-05 18:02:52', 'asd'),
(177, 106, 'user', '2021-04-05 20:28:20', 'test'),
(178, 106, 'admin2', '2021-04-05 20:32:13', 'test'),
(179, 106, 'user', '2021-04-05 20:32:24', 'test'),
(180, 106, 'admin2', '2021-04-05 20:32:33', 'closed'),
(181, 121, 'admin2', '2021-04-07 21:02:11', 'asdasdasdasdasdas'),
(182, 121, 'admin2', '2021-04-07 21:02:16', 'closed'),
(183, 122, 'admin2', '2021-04-07 22:47:48', 'asd'),
(184, 78, 'admin2', '2021-04-08 19:46:44', 'Done'),
(185, 78, 'admin2', '2021-04-08 20:16:33', 'Test'),
(186, 78, 'admin2', '2021-04-08 20:16:45', 'Test'),
(187, 117, 'admin2', '2021-04-08 20:17:25', 'test'),
(188, 78, 'admin2', '2021-04-12 05:22:51', 'Done'),
(189, 80, 'admin2', '2021-04-12 05:23:12', 'Done'),
(190, 87, 'admin2', '2021-04-12 05:23:37', 'Done'),
(191, 125, 'admin2', '2021-04-13 14:21:20', 'Replying to test ticket'),
(192, 125, 'user', '2021-04-13 14:21:49', 'replying to test ticket'),
(198, 125, 'admin2', '2021-04-13 14:32:27', 'test'),
(199, 126, 'admin2', '2021-04-13 14:37:25', 'test'),
(200, 126, 'admin2', '2021-04-23 20:14:32', 'test'),
(201, 128, 'admin2', '2021-05-21 13:53:17', 'closed'),
(202, 128, 'admin2', '2021-05-21 13:53:24', 'closed'),
(203, 128, 'admin2', '2021-05-21 13:56:15', 'test'),
(204, 128, 'admin2', '2021-05-21 13:56:23', 'closed');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `techID` int(11) NOT NULL,
  `fUsername` varchar(64) NOT NULL,
  `userSpeciality` varchar(64) DEFAULT NULL,
  `can_delete` int(11) NOT NULL,
  `can_modify` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`techID`, `fUsername`, `userSpeciality`, `can_delete`, `can_modify`) VALUES
(1, 'admin2', 'Software', 0, 1),
(6, 'admin', 'Software', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketID` int(11) NOT NULL,
  `fUsername` varchar(64) NOT NULL,
  `assignedTo` varchar(64) DEFAULT NULL,
  `ticketSubject` varchar(64) NOT NULL,
  `speciality` varchar(64) NOT NULL,
  `priority` varchar(32) NOT NULL,
  `ticketDescription` varchar(255) NOT NULL,
  `ticketDate` datetime NOT NULL,
  `ticketStatus` varchar(32) NOT NULL,
  `ticketLastMessage` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketID`, `fUsername`, `assignedTo`, `ticketSubject`, `speciality`, `priority`, `ticketDescription`, `ticketDate`, `ticketStatus`, `ticketLastMessage`) VALUES
(76, 'admin2', 'admin2', 'Website settings', 'Software', 'High', 'Add website settings that admins can adjust certain website settings', '2021-03-24 19:33:51', 'In progress', '2021-04-05 15:59:40'),
(78, 'admin2', 'admin2', 'FAQ page', 'Software', 'High', 'Being able to add solved tickets to a page with the question and solution', '2021-03-22 19:35:17', 'Closed', '2021-04-08 19:46:44'),
(80, 'admin2', 'admin2', 'Fix notification system', 'Software', 'High', 'General notification fixes / updates', '2021-03-24 19:36:20', 'Closed', '2021-04-04 14:56:40'),
(87, 'admin2', 'admin2', 'Responsiveness', 'Software', 'Medium', 'Set the rest of the tables to be responsive like the admin panel', '2021-03-28 22:22:52', 'Active', '2021-04-01 01:33:18'),
(125, 'user', 'admin2', 'Test ticket', 'Software', 'Low', 'This is a test ticket', '2021-04-13 14:20:22', 'Active', '2021-04-13 14:20:22'),
(126, 'admin2', 'admin2', 'test', 'Software', 'Medium', 'test', '2021-04-13 14:36:27', 'Active', '2021-04-13 14:36:27'),
(127, 'admin2', NULL, 'asd', 'Networking', 'Medium', 'asd', '2021-05-19 20:38:34', 'Active', '2021-05-19 20:38:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `fUsername` varchar(32) NOT NULL,
  `fEmail` varchar(64) NOT NULL,
  `fPassword` varchar(255) NOT NULL,
  `adminLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `mobile_number`, `fUsername`, `fEmail`, `fPassword`, `adminLevel`) VALUES
(8, 'Mark', 'Angus', '09283928475', 'user', 'user@user.com', '$2y$10$FmEEadw8gbSmqIT62QpQK.6cjY9qMAstlf0wjjhKYca3CRiWK5pxS', 0),
(16, 'test', 't', '23412345232', 'admin2', 'admin@admin2.com', '$2y$10$TcpqIOez.UTaZ.ryBECcEuFbRKiCqa6E4jlIVM/yOPaXPCRa1jFG2', 2),
(18, 'Mark', 'Angus', '07283927122', 'Admin', 'admin@admin.com', '$2y$10$TcpqIOez.UTaZ.ryBECcEuFbRKiCqa6E4jlIVM/yOPaXPCRa1jFG2', 1),
(19, 'X', 'X', NULL, 'TEST_USER_1', 'TEST_USER_1', '', 0),
(20, 'X', 'X', NULL, 'TEST_USER_2', 'TEST_USER_2', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_image`
--

CREATE TABLE `user_image` (
  `image_id` int(11) NOT NULL,
  `fUsername` varchar(64) NOT NULL,
  `picture_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_image`
--

INSERT INTO `user_image` (`image_id`, `fUsername`, `picture_status`) VALUES
(2, 'user', 0),
(10, 'admin2', 0),
(12, 'Admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_speciality`
--
ALTER TABLE `admin_speciality`
  ADD PRIMARY KEY (`specialityID`);

--
-- Indexes for table `faq_table`
--
ALTER TABLE `faq_table`
  ADD PRIMARY KEY (`faqID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationID`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`replyID`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`techID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_speciality`
--
ALTER TABLE `admin_speciality`
  MODIFY `specialityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `faq_table`
--
ALTER TABLE `faq_table`
  MODIFY `faqID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `replyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `techID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
