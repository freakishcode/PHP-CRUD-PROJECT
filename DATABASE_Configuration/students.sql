-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2022 at 01:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `ProfilePicture` varchar(500) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `faculty_dept` varchar(400) NOT NULL,
  `JAMB_reg_no` varchar(100) NOT NULL,
  `phone_no` int(25) NOT NULL,
  `date_of_birth` varchar(200) NOT NULL,
  `state_of_origin` varchar(100) NOT NULL,
  `LGA` varchar(300) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `ProfilePicture`, `username`, `email`, `last_name`, `first_name`, `faculty_dept`, `JAMB_reg_no`, `phone_no`, `date_of_birth`, `state_of_origin`, `LGA`, `gender`, `password`, `date`) VALUES
(23, '1552371651283.jpg', 'freakishkid5', 'ajibolabakare@gmail.com', 'Bakare', 'Ahmed', 'Science/Math&Stats', 'u201755abc', 2147483647, '2022-10-18', 'Haryana', 'atiba', 'Male', '$2y$10$8vgfeZlCtWSzdP9yZ6386OP4kRWlUyswv9.Kl1cRmSuDURYm0yBLO', '2022-10-18 12:11:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
