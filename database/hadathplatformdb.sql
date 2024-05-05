-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2024 at 08:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hadathplatformdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE `attendee` (
  `attendeeID` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `college` enum('CCSIT','CBA','COE','ARCH','MED') NOT NULL,
  `attendeeImage` varchar(255) DEFAULT NULL,
  `birthDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`attendeeID`, `firstName`, `lastName`, `email`, `password`, `gender`, `college`, `attendeeImage`, `birthDate`) VALUES
(1, 'Rayyan', 'Alyami', 'rayyan@hadathplatform.com', 'Asd@12345', 'M', 'CCSIT', './assets/uploadedImages/file_17134465891657.png', '2001-06-08'),
(2, 'Faisal', 'Almadi', 'faisal@hadathplatform.com', 'Asd@12345', 'M', 'CBA', './assets/uploadedImages/file_17134465891657.png', '2000-10-02'),
(3, 'Raad', 'Alharthi', 'raadalnofaly@gmail.com', 'Asd@12345', 'M', 'CCSIT', './assets/uploadedImages/file_17134465891657.png', '1999-06-19'),
(4, 'Raad', 'Alharthi', 'raadalnofaly@gmail.co', 'Asd@12345', 'F', 'CCSIT', './assets/uploadedImages/file_17134465891657.png', '1992-06-03'),
(5, 'Raad', 'Alharthi', 'raadalnofaly@gmail.c', 'Asd@12345', 'F', 'CCSIT', './assets/uploadedImages/file_17134465891657.png', '1992-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `attendeenotifications`
--

CREATE TABLE `attendeenotifications` (
  `attendeeID` int(10) NOT NULL,
  `notificationID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `certificateID` int(10) NOT NULL,
  `attendeeID` int(10) NOT NULL,
  `eventID` int(10) NOT NULL,
  `issueDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `certificateDetails` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventID` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `eventType` enum('ACD','ART','AWC','CHE','COM','CFS','ENT','EXB','HOL','NET','SEM','SHO','WRK') NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(4000) DEFAULT NULL,
  `organizerID` int(10) NOT NULL,
  `capacity` int(10) DEFAULT NULL,
  `numberOfRegistered` int(10) DEFAULT NULL,
  `registrationDeadline` datetime NOT NULL,
  `eventImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `title`, `eventType`, `date`, `time`, `location`, `description`, `organizerID`, `capacity`, `numberOfRegistered`, `registrationDeadline`, `eventImage`) VALUES
(1, 'Introduction of Operating Systems', 'ACD', '2024-05-06', '13:00:00', 'A11 Building, Room #2154', 'Delve into the fundamental concepts of operating systems with our comprehensive introductory course. This course is designed to provide you with a foundational understanding of how operating systems function as the backbone of every computer system. Starting with the basics, you will learn about the roles and responsibilities of an operating system, including process management, memory management, file systems, and input/output management. We will also cover the evolution of operating systems from simple batch systems to modern multi-user environments.\r\n\r\nBy integrating theoretical knowledge with practical skills, this course will guide you through the architecture of widely-used operating systems such as Windows, macOS, and Linux. You\'ll gain insights into system design and operation, including how operating systems are adapting to current trends such as virtualization and cloud computing.', 2, 30, 3, '2024-04-01 12:00:00', ''),
(2, 'What is Cyber Security', 'ACD', '2024-05-05', '15:00:00', 'A11 Building, Room #1199', 'Cybersecurity is at the forefront of essential knowledge for professionals across all industries. In this course, we will unravel the complexities of cybersecurity. You\'ll learn what cybersecurity is, why it\'s critically important, and how it affects individuals and businesses alike. We will explore various types of cyber threats, from the basics of viruses and malware to sophisticated phishing and ransomware attacks. Additionally, this course will cover protective measures to secure data and personal information, touching on encryption, firewalls, and secure software development practices. With engaging multimedia content, like our visually descriptive video guides, you\'ll gain not just theoretical knowledge but also practical understanding. Prepare to dive into the world of cybersecurity and emerge well-equipped to protect yourself and your organization against digital threats.', 1, 20, 4, '2024-05-15 14:00:00', ''),
(5, 'Management System', 'ACD', '2024-05-17', '13:11:00', 'A11, aa', 'ddd', 1, 20, NULL, '0000-00-00 00:00:00', '../assets/uploadedImages/file_17148499187052.png');

-- --------------------------------------------------------

--
-- Table structure for table `eventstatistics`
--

CREATE TABLE `eventstatistics` (
  `statisticID` int(10) NOT NULL,
  `eventID` int(10) NOT NULL,
  `attendeeID` int(10) NOT NULL,
  `ratingID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationID` int(10) NOT NULL,
  `attendeeID` int(10) NOT NULL,
  `notificationType` varchar(255) NOT NULL,
  `message` varchar(4000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `organizerID` int(10) NOT NULL,
  `organizerName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `college` enum('CCSIT','CBA','COE','ARCH','MED') NOT NULL,
  `organizerImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`organizerID`, `organizerName`, `email`, `password`, `college`, `organizerImage`) VALUES
(1, 'Cyber Security Club', 'csc@hadathplatform.com', 'Asd@12345', 'CCSIT', './assets/uploadedImages/2.jpg'),
(2, 'College of Computer Science and Information Technology Club', 'ccsitc@hadathplatform.com', 'Asd@12345', 'CCSIT', './assets/uploadedImages/1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `ratingID` int(10) NOT NULL,
  `eventID` int(10) NOT NULL,
  `attendeeID` int(10) NOT NULL,
  `ratingValue` int(10) NOT NULL,
  `ratingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registrationID` int(10) NOT NULL,
  `attendeeID` int(10) NOT NULL,
  `eventID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registrationID`, `attendeeID`, `eventID`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 5),
(4, 4, 5),
(5, 5, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`attendeeID`);

--
-- Indexes for table `attendeenotifications`
--
ALTER TABLE `attendeenotifications`
  ADD PRIMARY KEY (`attendeeID`,`notificationID`),
  ADD KEY `notificationID` (`notificationID`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`certificateID`),
  ADD KEY `attendeeID` (`attendeeID`),
  ADD KEY `eventID` (`eventID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `organizerID` (`organizerID`);

--
-- Indexes for table `eventstatistics`
--
ALTER TABLE `eventstatistics`
  ADD PRIMARY KEY (`statisticID`),
  ADD KEY `eventID` (`eventID`),
  ADD KEY `attendeeID` (`attendeeID`),
  ADD KEY `ratingID` (`ratingID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationID`),
  ADD KEY `attendeeID` (`attendeeID`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`organizerID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`ratingID`),
  ADD KEY `eventID` (`eventID`),
  ADD KEY `attendeeID` (`attendeeID`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registrationID`),
  ADD KEY `attendeeID` (`attendeeID`),
  ADD KEY `eventID` (`eventID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendee`
--
ALTER TABLE `attendee`
  MODIFY `attendeeID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificateID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `eventstatistics`
--
ALTER TABLE `eventstatistics`
  MODIFY `statisticID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `organizerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `ratingID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registrationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendeenotifications`
--
ALTER TABLE `attendeenotifications`
  ADD CONSTRAINT `attendeenotifications_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendeenotifications_ibfk_2` FOREIGN KEY (`notificationID`) REFERENCES `notifications` (`notificationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizerID`) REFERENCES `organizer` (`organizerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventstatistics`
--
ALTER TABLE `eventstatistics`
  ADD CONSTRAINT `eventstatistics_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventstatistics_ibfk_2` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eventstatistics_ibfk_3` FOREIGN KEY (`ratingID`) REFERENCES `ratings` (`ratingID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
