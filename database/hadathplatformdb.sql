-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 01:57 PM
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
(14, 'Mohammed', 'Alshamsi', 'mohammed@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'M', 'CCSIT', '../assets/uploadedImages/file_17159888203550.jpg', '1995-05-17'),
(15, 'Fayez', 'Almalki', 'fayez@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'M', 'CBA', '../assets/uploadedImages/file_17159888203551.jpg', '1970-05-14'),
(16, 'Tareq', 'Alharbi', 'tareq@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'M', 'MED', '../assets/uploadedImages/file_17159888203552.jpg', '1980-06-08'),
(17, 'Ghazi', 'ALthiyabi', 'ghazi@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'M', 'COE', '../assets/uploadedImages/file_17159888203553.jpg', '1996-05-29'),
(18, 'Naif', 'Alotaibi', 'naif@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'M', 'CCSIT', '../assets/uploadedImages/file_17159888203554.jpg', '1995-05-16'),
(19, 'Rajeh', 'Alharthi', 'rajeh@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'M', 'ARCH', '../assets/uploadedImages/file_17159888203555.jpg', '1990-05-21'),
(20, 'Nora', 'Alyami', 'nora@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'F', 'MED', '../assets/uploadedImages/file_17159888203556.png', '1980-05-22'),
(21, 'Modhi', 'Alshehri', 'modhi@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'F', 'MED', '../assets/uploadedImages/file_17159888203556.png', '1980-05-21');

-- --------------------------------------------------------

--
-- Table structure for table `attendeenotifications`
--

CREATE TABLE `attendeenotifications` (
  `notificationID` int(10) NOT NULL,
  `attendeeID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendeenotifications`
--

INSERT INTO `attendeenotifications` (`notificationID`, `attendeeID`) VALUES
(30, 14),
(30, 15),
(30, 16),
(30, 17),
(30, 18),
(30, 19),
(30, 20),
(30, 21),
(31, 14),
(31, 15),
(31, 16),
(31, 17),
(31, 18),
(31, 19),
(31, 20),
(31, 21),
(32, 14),
(32, 15),
(32, 16),
(32, 17),
(32, 18),
(32, 19),
(32, 20),
(32, 21),
(33, 14),
(33, 15),
(33, 16),
(33, 17),
(33, 18),
(33, 19),
(33, 20),
(33, 21),
(34, 14),
(34, 15),
(34, 16),
(34, 17),
(34, 18),
(34, 19),
(34, 20),
(34, 21),
(35, 14),
(35, 15),
(35, 16),
(35, 17),
(35, 18),
(35, 19),
(35, 20),
(35, 21),
(36, 14),
(36, 15),
(36, 16),
(36, 17),
(36, 18),
(36, 19),
(36, 20),
(36, 21);

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
  `capacity` int(10) NOT NULL DEFAULT 0,
  `numberOfRegistered` int(10) DEFAULT NULL,
  `eventImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `title`, `eventType`, `date`, `time`, `location`, `description`, `organizerID`, `capacity`, `numberOfRegistered`, `eventImage`) VALUES
(37, 'CryptoCon The Future of Cryptography', 'EXB', '2024-06-20', '12:00:00', 'College of Computer Science and Information Technology', 'Join us at CryptoCon for a deep dive into the latest in cryptography. Network with experts, explore quantum encryption, blockchain security, and advance your cybersecurity expertise.', 11, 100, 5, '../assets/uploadedImages/file_17160308355517.png'),
(38, 'Frontiers of AI Unveiling the Future of Technology and Neuroscience', 'CFS', '2024-06-10', '12:00:00', 'College of Computer Science and Information Technology', 'Join industry leaders to explore cutting-edge AI and neuroscience advancements. Discover new technologies and ethical debates in a dynamic conference environment.Join industry leaders to explore cutting-edge AI and neuroscience advancements. Discover new technologies and ethical debates in a dynamic conference environment.', 12, 100, 7, '../assets/uploadedImages/file_17160309546821.jpg'),
(39, 'Cloud Connect Navigating the Next Wave of Cloud Computing', 'ACD', '2024-05-15', '10:30:00', 'College of Computer Science and Information Technology', 'Dive into the latest in cloud computing at Cloud Connect. Engage with experts, learn about emerging trends, and enhance your understanding of cloud solutions.', 12, 50, 5, '../assets/uploadedImages/file_17160310447918.jpg'),
(40, 'Finance Forward Trends and Innovations', 'SEM', '2024-05-01', '09:00:00', 'College of Business Administration', 'Dive into the world of finance at Finance Forward. This vibrant event brings together leading financial experts, innovators, and enthusiasts to discuss emerging trends and innovative strategies in finance. Perfect for professionals seeking to expand their knowledge and network in the financial industry.', 13, 75, 4, '../assets/uploadedImages/file_17160311639895.png'),
(41, 'Digital Marketing Summit 2024 Voice of the Future', 'EXB', '2024-06-30', '13:30:00', 'College of Business Administration', 'Join us at the Digital Marketing Summit 2024 for a comprehensive exploration of the latest trends and strategies in digital marketing. Gain insights from industry leaders on how to harness the power of social media, cloud technology, and digital communication to elevate your marketing campaigns. Ideal for marketers aiming to stay ahead in the digital curve.', 13, 100, 4, '../assets/uploadedImages/file_17160312452022.jpg'),
(42, 'Engineering Innovations Shaping the Future', 'SHO', '2024-07-02', '09:30:00', 'College of Engineering', 'Celebrate the spirit of innovation on Engineers\' Day at our Engineering Innovations event. Engage with top engineers, explore cutting-edge projects, and gain insights into future technologies that are shaping our world. Perfect for professionals and aspiring engineers.', 14, 100, 5, '../assets/uploadedImages/file_17160313515383.png'),
(43, 'HealthTech Innovating for Tomorrows Healthcare', 'NET', '2024-06-20', '13:00:00', 'College of Medicine', 'HealthTech brings together medical professionals, researchers, and technologists to explore advancements in healthcare technology. Discover new tools, treatments, and strategies to enhance patient care and medical research. Ideal for healthcare professionals looking to integrate technology and improve outcomes.', 15, 100, 4, '../assets/uploadedImages/file_17160314695617.png');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notificationID` int(10) NOT NULL,
  `notificationType` varchar(255) NOT NULL,
  `message` varchar(4000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationID`, `notificationType`, `message`, `date`) VALUES
(23, 'New Event', 'New Conferences event named Frontiers of AI Unveiling the Future of Technology and Neuroscience, offered by AI and Robot Club will be held on 12:00', '2024-05-17 23:22:02'),
(24, 'New Event', 'New Academic Events event named Cloud Connect Navigating the Next Wave of Cloud Computing, offered by AI and Robot Club will be held on 10:30', '2024-05-17 23:23:27'),
(25, 'New Event', 'New Exhibitions event named CryptoCon The Future of Cryptography, offered by Cyber Security Club will be held on 00:00', '2024-05-17 23:25:16'),
(26, 'New Event', 'New Seminars event named Finance Forward Trends and Innovations, offered by CBA Club will be held on 09:00', '2024-05-17 23:28:31'),
(27, 'New Event', 'New Exhibitions event named Digital Marketing Summit 2024 Voice of the Future, offered by CBA Club will be held on 13:30', '2024-05-17 23:29:52'),
(28, 'New Event', 'New Showcase event named Engineering Innovations Shaping the Future, offered by Engineering Club will be held on 09:30', '2024-05-17 23:31:34'),
(29, 'New Event', 'New Networking Events event named HealthTech Innovating for Tomorrows Healthcare, offered by Medicine Club will be held on 13:00', '2024-05-17 23:33:41'),
(30, 'New Event', 'New Exhibitions event named CryptoCon The Future of Cryptography, offered by Cyber Security Club will be held on 12:00', '2024-05-18 11:13:55'),
(31, 'New Event', 'New Conferences event named Frontiers of AI Unveiling the Future of Technology and Neuroscience, offered by AI and Robot Club will be held on 12:00', '2024-05-18 11:15:54'),
(32, 'New Event', 'New Academic Events event named Cloud Connect Navigating the Next Wave of Cloud Computing, offered by AI and Robot Club will be held on 10:30', '2024-05-18 11:17:24'),
(33, 'New Event', 'New Seminars event named Finance Forward Trends and Innovations, offered by CBA Club will be held on 09:00', '2024-05-18 11:19:23'),
(34, 'New Event', 'New Exhibitions event named Digital Marketing Summit 2024 Voice of the Future, offered by CBA Club will be held on 13:30', '2024-05-18 11:20:45'),
(35, 'New Event', 'New Showcase event named Engineering Innovations Shaping the Future, offered by Engineering Club will be held on 09:30', '2024-05-18 11:22:32'),
(36, 'New Event', 'New Networking Events event named HealthTech Innovating for Tomorrows Healthcare, offered by Medicine Club will be held on 13:00', '2024-05-18 11:24:29');

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
(11, 'Cyber Security Club', 'csc@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'CCSIT', '../assets/uploadedImages/file_17159873441273.png'),
(12, 'AI and Robot Club', 'ai@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'CCSIT', '../assets/uploadedImages/file_17159873441274.png'),
(13, 'CBA Club', 'cba@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'CBA', '../assets/uploadedImages/file_17159873441275.jpg'),
(14, 'Engineering Club', 'eng@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'COE', '../assets/uploadedImages/file_17159873441276.jpg'),
(15, 'Medicine Club', 'med@hadath.com', 'bcd530adcab1620d1c412f6c3120c5a6', 'MED', '../assets/uploadedImages/file_17159873441277.jpg');

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

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`ratingID`, `eventID`, `attendeeID`, `ratingValue`, `ratingDate`) VALUES
(6, 39, 14, 10, '2024-05-18 11:38:58'),
(7, 39, 16, 5, '2024-05-18 11:39:13'),
(8, 39, 18, 9, '2024-05-18 11:39:36'),
(9, 39, 20, 6, '2024-05-18 11:39:50'),
(10, 39, 21, 1, '2024-05-18 11:40:07'),
(11, 40, 15, 10, '2024-05-18 11:43:31'),
(12, 40, 18, 7, '2024-05-18 11:45:06'),
(13, 40, 18, 5, '2024-05-18 11:45:15'),
(14, 40, 20, 7, '2024-05-18 11:45:19');

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
(20, 15, 37),
(21, 15, 38),
(22, 15, 40),
(23, 15, 41),
(24, 14, 37),
(25, 14, 38),
(26, 14, 39),
(27, 16, 43),
(28, 16, 39),
(29, 17, 42),
(30, 17, 38),
(31, 18, 43),
(32, 18, 37),
(33, 18, 38),
(34, 18, 39),
(35, 18, 40),
(36, 18, 41),
(37, 18, 42),
(38, 19, 38),
(39, 19, 42),
(40, 20, 37),
(41, 20, 38),
(42, 20, 39),
(43, 20, 40),
(44, 20, 41),
(45, 20, 42),
(46, 20, 43),
(47, 21, 37),
(48, 21, 38),
(49, 21, 39),
(50, 21, 40),
(51, 21, 41),
(52, 21, 42),
(53, 21, 43);

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
  ADD KEY `notificationID` (`notificationID`,`attendeeID`),
  ADD KEY `attendeeID` (`attendeeID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `organizerID` (`organizerID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationID`);

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
  MODIFY `attendeeID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `organizerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `ratingID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registrationID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendeenotifications`
--
ALTER TABLE `attendeenotifications`
  ADD CONSTRAINT `attendeenotifications_ibfk_1` FOREIGN KEY (`notificationID`) REFERENCES `notification` (`notificationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendeenotifications_ibfk_2` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizerID`) REFERENCES `organizer` (`organizerID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
