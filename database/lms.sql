-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2023 at 08:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `book_price` decimal(10,2) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `quantity` int(22) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `isbn`, `author`, `book_price`, `genre`, `quantity`, `created_on`) VALUES
(1, 'The Rise of the Dragon: An Illustrated History of the Targaryen Dynasty, Volume One (The Targaryen Dynasty: The House of the Dragon)', '1984859250', 'George R. R. Martin', 1518.00, 'Action , Sci-FI', 1, '2023-12-17 11:32:16'),
(3, 'Fire & Blood: 300 Years Before A Game of Thrones (The Targaryen Dynasty: The House of the Dragon)', '152479628X', 'JK Rowling', 1070.00, 'Action', 9, '2023-12-17 13:04:51'),
(4, 'The Growth Leader: Strategies to Drive the Top and Bottom Lines', '1639080473', 'Scott K. Edinger', 1259.44, 'leadership', 7, '2023-12-17 19:22:05'),
(5, 'The World of Ice & Fire: The Untold History of Westeros and the Game of Throns', '0553805444', 'George R. R. Martin', 1561.84, 'Fantasy', 3, '2023-12-17 19:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `book_issuance`
--

CREATE TABLE `book_issuance` (
  `id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date NOT NULL,
  `is_return` int(1) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `user_id` int(22) NOT NULL,
  `book_id` int(22) NOT NULL,
  `penalty` decimal(10,2) NOT NULL,
  `is_approve` int(10) NOT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_issuance`
--

INSERT INTO `book_issuance` (`id`, `issue_date`, `return_date`, `is_return`, `remarks`, `user_id`, `book_id`, `penalty`, `is_approve`, `approved_by`, `created_on`) VALUES
(1, '2023-12-17', '2023-12-23', 1, '', 3, 1, 0.00, 1, 'Administrator, LMS', '2023-12-17 14:19:16'),
(2, '2023-12-17', '2023-12-21', 1, '', 3, 3, 0.00, -1, 'Administrator, LMS', '2023-12-17 14:27:27'),
(9, '2023-12-17', '2023-12-22', -1, '', 3, 3, 0.00, 1, 'Administrator, LMS', '2023-12-17 17:30:11'),
(10, '2023-12-12', '2023-12-15', 1, '', 4, 1, 0.00, 1, 'Administrator, LMS', '2023-12-17 18:33:22');

--
-- Triggers `book_issuance`
--
DELIMITER $$
CREATE TRIGGER `notify_overdue` BEFORE UPDATE ON `book_issuance` FOR EACH ROW BEGIN
    DECLARE three_days_before DATE;
    SET three_days_before = DATE_SUB(NEW.return_date, INTERVAL 3 DAY);
    
    IF NEW.is_return = 0 AND NEW.return_date = CURDATE() THEN
        INSERT INTO notification (description, issuance_id, user_id, status, created_on)
        VALUES ('Book overdue', NEW.id, NEW.user_id, 0, NOW());
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `issuance_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `status` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `description`, `issuance_id`, `user_id`, `status`, `created_on`) VALUES
(1, 'Book overdue', 1, 4, 0, '2023-12-17 19:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` int(22) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `type`, `username`, `password`, `firstname`, `lastname`, `phone_no`, `email`, `age`, `address`, `image`, `created_on`) VALUES
(2, 'admin', 'admin', '$2y$10$KhGY1ZpNILy9NRrNYw.lUOtXkIOqV4Rv3MtA7tXDWLX4pKyJUE8n.', 'LMS', 'Administrator', '9222222110', 'uc_lms@gmail.com', 20, 'sanciangko st.', 'e8d4b30b43ea648657327780a12b284b657f49ea04a04.jpg', '2023-12-17 10:02:53'),
(3, 'student', 'tester101', '$2y$10$gMZpW0eanfnaHCPZCn8fIey3euxlOeD24lILRRQsJJTp9JgvcpOgK', 'Tester', 'QA', '9532288400', 'tester.101@gmail.com', 19, 'Sanciangko St.', 'default_pic.jpg', '2023-12-17 13:57:15'),
(4, 'student', 'jethro123', '$2y$10$WoowMlDzA8M8ZTcTwKdyMOelXXyocvwXGUnN4tlMecybm0c0gcjh2', 'jethro', 'de real', '9532288400', 'jethro_dereal@gmail.com', 23, 'Y&S Bldg. Corner V. Rama Avenue & R. Duterte St. Guadalupe', '939bff117b8a2daee93d6fc7cda9a2ec657f30f54e45f.jpg', '2023-12-17 18:32:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_issuance`
--
ALTER TABLE `book_issuance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`user_id`) USING BTREE,
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `issuance_id` (`issuance_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `book_issuance`
--
ALTER TABLE `book_issuance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_issuance`
--
ALTER TABLE `book_issuance`
  ADD CONSTRAINT `book_issuance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_issuance_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`issuance_id`) REFERENCES `book_issuance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
