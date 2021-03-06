-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 17, 2018 at 11:26 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dbLOI`
--
CREATE DATABASE IF NOT EXISTS `dbLOI` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dbLOI`;

-- --------------------------------------------------------

--
-- Table structure for table `Blogs`
--

CREATE TABLE `Blogs` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Content` text NOT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `Username`, `Email`, `Password`) VALUES
(1, 'admin', 'janwillemkeizer@gmail.com', '84ab36b2995bb3949db34038a2b24c64');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Blogs`
--
ALTER TABLE `Blogs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Blogs`
--
ALTER TABLE `Blogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Blogs`
--
ALTER TABLE `Blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`);
