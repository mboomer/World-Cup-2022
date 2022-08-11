-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql.9habu.com
-- Generation Time: Aug 03, 2022 at 01:52 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worldcup2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `Fixtures`
--

CREATE TABLE `Fixtures` (
  `FixtureNo` smallint NOT NULL,
  `GroupID` int NOT NULL,
  `RoundID` int NOT NULL,
  `VenueID` int NOT NULL,
  `HomeTeamID` int NOT NULL,
  `AwayTeamID` int NOT NULL,
  `DatePlayed` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `TimePlayed` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `HomeScore` tinyint DEFAULT NULL,
  `AwayScore` tinyint DEFAULT NULL,
  `ResultID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Fixtures`
--

INSERT INTO `Fixtures` (`FixtureNo`, `GroupID`, `RoundID`, `VenueID`, `HomeTeamID`, `AwayTeamID`, `DatePlayed`, `TimePlayed`, `HomeScore`, `AwayScore`, `ResultID`) VALUES
(1, 1, 1, 1, 1, 3, '2022/07/06', '20:00', 1, 0, 1),
(2, 1, 1, 2, 2, 4, '2022/07/07', '20:00', 4, 1, 1),
(3, 2, 1, 3, 6, 8, '2022/07/08', '17:00', 4, 1, 1),
(4, 2, 1, 4, 5, 7, '2022/07/08', '20:00', 4, 0, 1),
(5, 3, 1, 5, 12, 11, '2022/07/09', '17:00', 2, 2, 3),
(6, 3, 1, 6, 9, 10, '2022/07/09', '17:00', 1, 1, 3),
(7, 4, 1, 7, 15, 16, '2022/07/10', '17:00', 1, 1, 3),
(8, 4, 1, 8, 13, 14, '2022/07/10', '20:00', 5, 1, 1),
(9, 1, 1, 2, 3, 4, '2022/07/11', '17:00', 2, 0, 1),
(10, 1, 1, 10, 1, 2, '2022/07/11', '20:00', 8, 0, 1),
(11, 2, 1, 3, 7, 8, '2022/07/12', '17:00', 1, 0, 1),
(12, 2, 1, 4, 5, 6, '2022/07/12', '20:00', 2, 0, 1),
(13, 3, 1, 6, 10, 11, '2022/07/13', '17:00', 2, 1, 1),
(14, 3, 1, 5, 9, 12, '2022/07/13', '20:00', 3, 2, 1),
(15, 4, 1, 7, 14, 16, '2022/07/14', '17:00', 1, 1, 3),
(16, 4, 1, 8, 13, 15, '2022/07/14', '20:00', 2, 1, 1),
(17, 1, 1, 2, 4, 1, '2022/07/15', '20:00', 0, 5, 2),
(18, 1, 1, 10, 3, 2, '2022/07/15', '20:00', 1, 0, 1),
(19, 2, 1, 3, 8, 5, '2022/07/16', '20:00', 0, 3, 2),
(20, 2, 1, 4, 7, 6, '2022/07/16', '20:00', 0, 1, 2),
(21, 3, 1, 6, 11, 9, '2022/07/17', '17:00', 1, 4, 2),
(22, 3, 1, 5, 10, 12, '2022/07/17', '17:00', 5, 0, 1),
(23, 4, 1, 7, 16, 13, '2022/07/18', '20:00', 1, 1, 3),
(24, 4, 1, 8, 14, 15, '2022/07/18', '20:00', 0, 1, 2),
(25, 8, 3, 10, 1, 6, '2022/07/20', '20:00', 2, 1, 1),
(26, 8, 3, 4, 5, 3, '2022/07/21', '20:00', 2, 0, 1),
(27, 8, 3, 5, 10, 15, '2022/07/22', '20:00', 1, 0, 1),
(28, 8, 3, 8, 13, 9, '2022/07/23', '20:00', 1, 0, 1),
(29, 9, 4, 6, 1, 10, '2022/07/26', '20:00', 4, 0, 1),
(30, 9, 4, 3, 5, 13, '2022/07/27', '20:00', 2, 1, 1),
(31, 10, 5, 9, 1, 5, '2022/07/31', '17:00', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `GoalsScored`
--

CREATE TABLE `GoalsScored` (
  `ID` int NOT NULL,
  `Player` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `TeamID` int NOT NULL,
  `H1Minute` tinyint NOT NULL,
  `H2Minute` tinyint NOT NULL,
  `ET1Minute` tinyint NOT NULL,
  `ET2Minute` tinyint NOT NULL,
  `Penalty` tinyint NOT NULL,
  `OwnGoal` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `GoalsScored`
--

INSERT INTO `GoalsScored` (`ID`, `Player`, `TeamID`, `H1Minute`, `H2Minute`, `ET1Minute`, `ET2Minute`, `Penalty`, `OwnGoal`) VALUES
(1, 'Beth Mead', 1, 16, 0, 0, 0, 0, 0),
(2, 'Julie Blakstad', 2, 10, 0, 0, 0, 0, 0),
(3, 'Frida Maanum', 2, 13, 0, 0, 0, 0, 0),
(4, 'Caroline Graham Hansen', 2, 31, 0, 0, 0, 1, 0),
(5, 'Julie Nelson', 4, 0, 4, 0, 0, 0, 0),
(6, 'Guro Reiten', 2, 0, 9, 0, 0, 0, 0),
(7, 'Irene Paredes', 6, 26, 0, 0, 0, 0, 0),
(8, 'Aitana Bonmatí', 6, 41, 0, 0, 0, 0, 0),
(9, 'Linda Sällström', 8, 1, 0, 0, 0, 0, 0),
(10, 'Lucía García', 6, 0, 30, 0, 0, 0, 0),
(11, 'Mariona Caldentey', 6, 0, 50, 0, 0, 1, 0),
(12, 'Lina Magull', 5, 0, 21, 0, 0, 0, 0),
(13, 'Lea Schüller', 5, 0, 12, 0, 0, 0, 0),
(14, 'Lena Lattwein', 5, 0, 33, 0, 0, 0, 0),
(15, 'Alexandra Popp', 5, 0, 41, 0, 0, 0, 0),
(16, 'Diana Gomes', 12, 0, 13, 0, 0, 0, 0),
(17, 'Jéssica Silva', 12, 0, 20, 0, 0, 0, 0),
(18, 'Coumba Sow', 11, 2, 0, 0, 0, 0, 0),
(19, 'Rahel Kiwic', 11, 5, 0, 0, 0, 0, 0),
(20, 'Jonna Andersson', 10, 36, 0, 0, 0, 0, 0),
(21, 'Jill Roord', 9, 0, 7, 0, 0, 0, 0),
(22, 'Justine Vanhaevermaet', 15, 0, 12, 0, 0, 1, 0),
(23, 'Berglind Thorvaldsdóttir', 16, 0, 5, 0, 0, 0, 0),
(24, 'Grace Geyoro', 13, 9, 0, 0, 0, 0, 0),
(25, 'Grace Geyoro', 13, 40, 0, 0, 0, 0, 0),
(26, 'Grace Geyoro', 13, 45, 0, 0, 0, 0, 0),
(27, 'Marie-Antoinette Katoto', 13, 12, 0, 0, 0, 0, 0),
(28, 'Delphine Cascarino', 13, 38, 0, 0, 0, 0, 0),
(29, 'Martina Piemonte', 14, 0, 31, 0, 0, 0, 0),
(30, 'Katharina Schiechtl', 3, 19, 0, 0, 0, 0, 0),
(31, 'Katharina Naschenweng', 3, 0, 43, 0, 0, 0, 0),
(32, 'Georgia Stanway', 1, 12, 0, 0, 0, 1, 0),
(33, 'Lauren Hemp', 1, 15, 0, 0, 0, 0, 0),
(34, 'Ellen White', 1, 29, 0, 0, 0, 0, 0),
(35, 'Beth Mead', 1, 34, 0, 0, 0, 0, 0),
(36, 'Beth Mead', 1, 38, 0, 0, 0, 0, 0),
(37, 'Ellen White', 1, 41, 0, 0, 0, 0, 0),
(38, 'Alessia Russo', 1, 0, 21, 0, 0, 0, 0),
(39, 'Beth Mead', 1, 0, 41, 0, 0, 0, 0),
(40, 'Pernille Harder', 7, 0, 27, 0, 0, 0, 0),
(41, 'Klara Bühl', 5, 3, 0, 0, 0, 0, 0),
(42, 'Alexandra Popp', 5, 37, 0, 0, 0, 0, 0),
(43, 'Fridolina Rolfö', 10, 0, 8, 0, 0, 0, 0),
(44, 'Hanna Bennison', 10, 0, 34, 0, 0, 0, 0),
(45, 'Ramona Bachmann', 11, 0, 10, 0, 0, 0, 0),
(46, 'Damaris Egurrola', 9, 7, 0, 0, 0, 0, 0),
(47, 'Stefanie van der Gragt', 9, 16, 0, 0, 0, 0, 0),
(48, 'Carole Costa', 12, 38, 0, 0, 0, 1, 0),
(49, 'Diana Silva', 12, 47, 0, 0, 0, 0, 0),
(50, 'Daniëlle van de Donk', 9, 0, 17, 0, 0, 0, 0),
(51, 'Karólína Lea Vilhjálmsdóttir', 16, 3, 0, 0, 0, 0, 0),
(52, 'Valentina Bergamaschi', 14, 0, 27, 0, 0, 0, 0),
(53, 'Kadidiatou Diani', 13, 6, 0, 0, 0, 0, 0),
(54, 'Griedge Mbock Bathy', 13, 41, 0, 0, 0, 0, 0),
(55, 'Janice Cayman', 15, 36, 0, 0, 0, 0, 0),
(56, 'Nicole Billa', 3, 37, 0, 0, 0, 0, 0),
(57, 'Fran Kirby', 1, 41, 0, 0, 0, 0, 0),
(58, 'Beth Mead', 1, 45, 0, 0, 0, 0, 0),
(59, 'Alessia Russo', 1, 0, 3, 0, 0, 0, 0),
(60, 'Alessia Russo', 1, 0, 13, 0, 0, 0, 0),
(61, 'Kelsie Burrows', 4, 0, 31, 0, 0, 0, 1),
(62, 'Sophia Kleinherne', 5, 40, 0, 0, 0, 0, 0),
(63, 'Alexandra Popp', 5, 0, 3, 0, 0, 0, 0),
(64, 'Nicole Anyomi', 5, 0, 18, 0, 0, 0, 0),
(65, 'Marta Cardona', 0, 0, 45, 0, 0, 0, 0),
(66, 'Ana-Maria Crnogorčević', 11, 0, 4, 0, 0, 0, 1),
(67, 'Géraldine Reuteler', 11, 0, 8, 0, 0, 0, 0),
(68, 'Romée Leuchter', 9, 0, 39, 0, 0, 0, 0),
(69, 'Romée Leuchter', 9, 0, 50, 0, 0, 0, 0),
(70, 'Victoria Pelova', 9, 0, 49, 0, 0, 0, 0),
(71, 'Filippa Angeldal', 10, 21, 0, 0, 0, 0, 0),
(72, 'Filippa Angeldal', 10, 45, 0, 0, 0, 0, 0),
(73, 'Carole Costa', 12, 50, 0, 0, 0, 0, 1),
(74, 'Kosovare Asllani', 10, 0, 9, 0, 0, 1, 0),
(75, 'Stina Blackstenius', 10, 0, 46, 0, 0, 0, 0),
(77, 'Tine De Caigny', 15, 0, 4, 0, 0, 0, 0),
(78, 'Melvine Malard', 13, 1, 0, 0, 0, 0, 0),
(79, 'Dagný Brynjarsdóttir', 16, 0, 50, 0, 0, 1, 0),
(80, 'Ella Toone', 1, 0, 39, 0, 0, 0, 0),
(81, 'Georgia Stanway', 1, 0, 0, 6, 0, 0, 0),
(82, 'Esther González', 6, 0, 9, 0, 0, 0, 0),
(83, 'Lina Magull', 5, 25, 0, 0, 0, 0, 0),
(84, 'Alexandra Popp', 5, 0, 45, 0, 0, 0, 0),
(85, 'Linda Sembrant', 10, 0, 47, 0, 0, 0, 0),
(86, 'Ève Périsset', 13, 0, 0, 12, 0, 1, 0),
(87, 'Beth Mead', 1, 34, 0, 0, 0, 0, 0),
(88, 'Lucy Bronze', 1, 0, 3, 0, 0, 0, 0),
(89, 'Alessia Russo', 1, 0, 28, 0, 0, 0, 0),
(90, 'Fran Kirby', 1, 0, 31, 0, 0, 0, 0),
(91, 'Alexandra Popp', 5, 40, 0, 0, 0, 0, 0),
(92, 'Alexandra Popp', 5, 0, 31, 0, 0, 0, 0),
(93, 'Merle Frohms', 5, 0, 44, 0, 0, 0, 1),
(94, ' Ella Toone', 1, 0, 17, 0, 0, 0, 0),
(95, ' Lina Magull', 5, 0, 34, 0, 0, 0, 0),
(96, 'Chloe Kelly', 1, 0, 0, 0, 5, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `GroupStage`
--

CREATE TABLE `GroupStage` (
  `ID` int NOT NULL,
  `Code` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `Description` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `GroupStage`
--

INSERT INTO `GroupStage` (`ID`, `Code`, `Description`) VALUES
(1, 'A', 'Group A'),
(2, 'B', 'Group B'),
(3, 'C', 'Group C'),
(4, 'D', 'Group D'),
(5, 'E', 'Group E'),
(6, 'F', 'Group F'),
(7, 'L', 'Last 16'),
(8, 'Q', 'Quarter Final'),
(9, 'S', 'Semi Final'),
(10, 'N', 'Final');

-- --------------------------------------------------------

--
-- Table structure for table `KnockOutStage`
--

CREATE TABLE `KnockOutStage` (
  `ID` int NOT NULL,
  `Code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `KnockOutStage`
--

INSERT INTO `KnockOutStage` (`ID`, `Code`, `Description`) VALUES
(1, 'LS', 'Last 16'),
(2, 'QF', 'Quarter Final'),
(3, 'SF', 'Semi Final'),
(4, 'FI', 'Final'),
(5, 'DN', 'Did Not Qualify');

-- --------------------------------------------------------

--
-- Table structure for table `PasswordReset`
--

CREATE TABLE `PasswordReset` (
  `ID` int NOT NULL,
  `UserEmail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Selector` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Token` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Expires` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Predictions`
--

CREATE TABLE `Predictions` (
  `UserID` int NOT NULL,
  `FixtureID` int NOT NULL,
  `HomeScore` tinyint NOT NULL,
  `AwayScore` tinyint NOT NULL,
  `HomeTeam` int NOT NULL,
  `AwayTeam` int NOT NULL,
  `ResultID` int NOT NULL,
  `Points` tinyint NOT NULL,
  `Stage` varchar(3) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Predictions`
--

INSERT INTO `Predictions` (`UserID`, `FixtureID`, `HomeScore`, `AwayScore`, `HomeTeam`, `AwayTeam`, `ResultID`, `Points`, `Stage`) VALUES
(1, 4, 3, 4, 5, 7, 2, 3, ''),
(1, 19, 2, 3, 8, 5, 2, 3, ''),
(1, 27, 1, 2, 12, 14, 2, 3, 'QF'),
(1, 28, 3, 1, 13, 10, 1, 3, 'QF'),
(1, 9, 1, 1, 3, 4, 3, 1, ''),
(1, 11, 3, 2, 7, 8, 1, 3, ''),
(1, 12, 1, 1, 5, 6, 3, 1, ''),
(1, 21, 2, 1, 11, 9, 1, 3, ''),
(1, 22, 1, 2, 10, 12, 2, 3, ''),
(1, 30, 1, 2, 7, 13, 2, 3, 'SF'),
(1, 1, 1, 0, 1, 3, 1, 3, ''),
(1, 2, 1, 1, 2, 4, 3, 1, ''),
(1, 3, 1, 2, 6, 8, 2, 3, ''),
(1, 5, 2, 1, 12, 11, 1, 3, ''),
(1, 6, 2, 3, 9, 10, 2, 3, ''),
(1, 15, 2, 1, 14, 16, 1, 3, ''),
(1, 16, 1, 2, 13, 15, 2, 3, ''),
(1, 24, 3, 2, 14, 15, 1, 3, ''),
(1, 25, 2, 1, 1, 5, 1, 3, 'QF'),
(1, 10, 1, 0, 1, 2, 1, 3, ''),
(1, 17, 1, 3, 4, 1, 2, 3, ''),
(1, 18, 1, 1, 3, 2, 3, 1, ''),
(1, 20, 4, 3, 7, 6, 1, 3, ''),
(1, 13, 4, 4, 10, 11, 3, 1, ''),
(1, 14, 4, 3, 9, 12, 1, 3, ''),
(1, 7, 3, 4, 15, 16, 2, 3, ''),
(1, 8, 4, 3, 13, 14, 1, 3, ''),
(1, 23, 3, 4, 16, 13, 2, 3, ''),
(1, 26, 3, 2, 7, 2, 1, 3, 'QF'),
(1, 29, 2, 3, 1, 14, 2, 3, 'SF'),
(1, 31, 1, 2, 7, 13, 2, 3, 'FI'),
(2, 1, 1, 0, 1, 3, 1, 3, ''),
(2, 2, 1, 0, 2, 4, 1, 3, ''),
(2, 9, 2, 3, 3, 4, 2, 3, ''),
(2, 10, 4, 3, 1, 2, 1, 3, ''),
(2, 17, 2, 1, 4, 1, 1, 3, ''),
(2, 18, 1, 2, 3, 2, 2, 3, ''),
(2, 3, 3, 4, 6, 8, 2, 3, ''),
(2, 4, 4, 3, 5, 7, 1, 3, ''),
(2, 11, 2, 1, 7, 8, 1, 3, ''),
(2, 12, 2, 3, 5, 6, 2, 3, ''),
(2, 19, 4, 3, 8, 5, 1, 3, ''),
(2, 20, 2, 3, 7, 6, 2, 3, ''),
(2, 5, 2, 1, 12, 11, 1, 3, ''),
(2, 6, 2, 1, 9, 10, 1, 3, ''),
(2, 13, 2, 3, 10, 11, 2, 3, ''),
(2, 14, 4, 3, 9, 12, 1, 3, ''),
(2, 21, 2, 1, 11, 9, 1, 3, ''),
(2, 22, 2, 3, 10, 12, 2, 3, ''),
(2, 7, 2, 1, 15, 16, 1, 3, ''),
(2, 8, 2, 3, 13, 14, 2, 3, ''),
(2, 15, 2, 1, 14, 16, 1, 3, ''),
(2, 16, 2, 3, 13, 15, 2, 3, ''),
(2, 23, 4, 3, 16, 13, 1, 3, ''),
(2, 24, 3, 2, 14, 15, 1, 3, ''),
(2, 25, 1, 0, 1, 8, 1, 3, 'QF'),
(2, 26, 1, 0, 6, 2, 1, 3, 'QF'),
(2, 27, 1, 0, 12, 15, 1, 3, 'QF'),
(2, 28, 0, 1, 14, 9, 2, 3, 'QF'),
(2, 29, 0, 3, 1, 12, 2, 3, 'SF'),
(2, 30, 1, 2, 6, 9, 2, 3, 'SF'),
(2, 31, 2, 1, 2, 14, 1, 3, 'FI'),
(3, 1, 2, 1, 1, 3, 1, 3, ''),
(3, 2, 2, 3, 2, 4, 2, 3, ''),
(3, 9, 4, 5, 3, 4, 2, 3, ''),
(3, 10, 3, 4, 1, 2, 2, 3, ''),
(3, 17, 3, 2, 4, 1, 1, 3, ''),
(3, 18, 1, 1, 3, 2, 3, 1, ''),
(3, 3, 2, 3, 6, 8, 2, 3, ''),
(3, 4, 2, 1, 5, 7, 1, 3, ''),
(3, 11, 2, 3, 7, 8, 2, 3, ''),
(3, 12, 4, 3, 5, 6, 1, 3, ''),
(3, 19, 2, 4, 8, 5, 2, 3, ''),
(3, 20, 3, 2, 7, 6, 1, 3, ''),
(3, 5, 3, 2, 12, 11, 1, 3, ''),
(3, 6, 1, 2, 9, 10, 2, 3, ''),
(3, 13, 1, 2, 10, 11, 2, 3, ''),
(3, 14, 1, 2, 9, 12, 2, 3, ''),
(3, 21, 3, 1, 11, 9, 1, 3, ''),
(3, 22, 2, 3, 10, 12, 2, 3, ''),
(3, 7, 2, 1, 15, 16, 1, 3, ''),
(3, 8, 2, 0, 13, 14, 1, 3, ''),
(3, 15, 3, 2, 14, 16, 1, 3, ''),
(3, 16, 1, 0, 13, 15, 1, 3, ''),
(3, 23, 4, 3, 16, 13, 1, 3, ''),
(3, 24, 0, 2, 14, 15, 2, 3, ''),
(3, 25, 1, 3, 4, 8, 2, 3, 'QF'),
(3, 26, 0, 2, 5, 2, 2, 3, 'QF'),
(3, 27, 1, 2, 12, 15, 2, 3, 'QF'),
(3, 28, 2, 1, 13, 11, 1, 3, 'QF'),
(3, 29, 1, 0, 8, 2, 1, 3, 'SF'),
(3, 30, 2, 1, 15, 13, 1, 3, 'SF'),
(3, 31, 1, 3, 8, 15, 2, 3, 'FI'),
(4, 1, 4, 2, 1, 3, 1, 3, 'GS'),
(4, 2, 3, 1, 2, 4, 1, 3, 'GS'),
(4, 9, 2, 1, 3, 4, 1, 3, 'GS'),
(4, 10, 3, 2, 1, 2, 1, 3, 'GS'),
(4, 17, 3, 4, 4, 1, 2, 3, 'GS'),
(4, 18, 3, 2, 3, 2, 1, 3, 'GS'),
(4, 3, 1, 0, 6, 8, 1, 3, 'GS'),
(4, 4, 0, 3, 5, 7, 2, 3, 'GS'),
(4, 11, 2, 1, 7, 8, 1, 3, 'GS'),
(4, 12, 0, 0, 5, 6, 3, 1, 'GS'),
(4, 19, 2, 3, 8, 5, 2, 3, 'GS'),
(4, 20, 2, 1, 7, 6, 1, 3, 'GS'),
(4, 5, 2, 0, 12, 11, 1, 3, 'GS'),
(4, 6, 0, 4, 9, 10, 2, 3, 'GS'),
(4, 13, 3, 2, 10, 11, 1, 3, 'GS'),
(4, 14, 3, 2, 9, 12, 1, 3, 'GS'),
(4, 21, 3, 2, 11, 9, 1, 3, 'GS'),
(4, 22, 3, 2, 10, 12, 1, 3, 'GS'),
(4, 7, 1, 0, 15, 16, 1, 3, 'GS'),
(4, 8, 3, 2, 13, 14, 1, 3, 'GS'),
(4, 15, 0, 2, 14, 16, 2, 3, 'GS'),
(4, 16, 3, 3, 13, 15, 3, 1, 'GS'),
(4, 23, 0, 2, 16, 13, 2, 3, 'GS'),
(4, 24, 0, 1, 14, 15, 2, 3, 'GS'),
(4, 25, 2, 1, 1, 7, 1, 3, 'QF'),
(4, 26, 1, 0, 6, 3, 1, 3, 'QF'),
(4, 27, 3, 1, 10, 15, 1, 3, 'QF'),
(4, 28, 3, 0, 13, 12, 1, 3, 'QF'),
(4, 29, 0, 2, 1, 6, 2, 3, 'SF'),
(4, 30, 1, 0, 10, 13, 1, 3, 'SF'),
(4, 31, 0, 2, 6, 10, 2, 3, 'FI'),
(5, 1, 1, 2, 1, 3, 2, 3, 'GS'),
(5, 2, 3, 3, 2, 4, 3, 1, 'GS'),
(5, 9, 2, 3, 3, 4, 2, 3, 'GS'),
(5, 10, 4, 4, 1, 2, 3, 1, 'GS'),
(5, 17, 3, 3, 4, 1, 3, 1, 'GS'),
(5, 18, 2, 1, 3, 2, 1, 3, 'GS'),
(5, 3, 2, 2, 6, 8, 3, 1, 'GS'),
(5, 4, 3, 4, 5, 7, 2, 3, 'GS'),
(5, 11, 3, 3, 7, 8, 3, 1, 'GS'),
(5, 12, 3, 2, 5, 6, 1, 3, 'GS'),
(5, 19, 1, 2, 8, 5, 2, 3, 'GS'),
(5, 20, 3, 3, 7, 6, 3, 1, 'GS'),
(5, 5, 4, 3, 12, 11, 1, 3, 'GS'),
(5, 6, 3, 3, 9, 10, 3, 1, 'GS'),
(5, 13, 2, 2, 10, 11, 3, 1, 'GS'),
(5, 14, 0, 2, 9, 12, 2, 3, 'GS'),
(5, 21, 1, 2, 11, 9, 2, 3, 'GS'),
(5, 22, 2, 2, 10, 12, 3, 1, 'GS'),
(5, 7, 2, 3, 15, 16, 2, 3, 'GS'),
(5, 8, 2, 1, 13, 14, 1, 3, 'GS'),
(5, 15, 2, 3, 14, 16, 2, 3, 'GS'),
(5, 16, 4, 3, 13, 15, 1, 3, 'GS'),
(5, 23, 2, 3, 16, 13, 2, 3, 'GS'),
(5, 24, 2, 1, 14, 15, 1, 3, 'GS'),
(5, 25, 0, 1, 3, 7, 2, 3, 'QF'),
(5, 26, 3, 2, 5, 4, 1, 3, 'QF'),
(5, 27, 1, 2, 12, 16, 2, 3, 'QF'),
(5, 28, 3, 1, 13, 9, 1, 3, 'QF'),
(5, 29, 1, 0, 7, 5, 1, 3, 'SF'),
(5, 30, 0, 3, 16, 13, 2, 3, 'SF'),
(5, 31, 1, 2, 7, 13, 2, 3, 'FI'),
(6, 2, 1, 2, 2, 4, 2, 3, 'GS'),
(6, 9, 3, 3, 3, 4, 3, 1, 'GS'),
(6, 18, 2, 3, 3, 2, 2, 3, 'GS'),
(6, 3, 2, 1, 6, 8, 1, 3, 'GS'),
(6, 4, 2, 3, 5, 7, 2, 3, 'GS'),
(6, 19, 2, 1, 8, 5, 1, 3, 'GS'),
(6, 20, 3, 4, 7, 6, 2, 3, 'GS'),
(6, 5, 2, 3, 12, 11, 2, 3, 'GS'),
(6, 13, 2, 1, 10, 11, 1, 3, 'GS'),
(6, 21, 2, 3, 11, 9, 2, 3, 'GS'),
(6, 8, 2, 3, 13, 14, 2, 3, 'GS'),
(6, 15, 3, 3, 14, 16, 3, 1, 'GS'),
(6, 16, 3, 3, 13, 15, 3, 1, 'GS'),
(6, 1, 1, 2, 1, 3, 2, 3, 'GS'),
(6, 10, 2, 1, 1, 2, 1, 3, 'GS'),
(6, 17, 2, 1, 4, 1, 1, 3, 'GS'),
(6, 11, 2, 3, 7, 8, 2, 3, 'GS'),
(6, 12, 2, 1, 5, 6, 1, 3, 'GS'),
(6, 19, 2, 1, 8, 5, 1, 3, 'GS'),
(6, 20, 2, 0, 7, 6, 1, 3, 'GS'),
(6, 6, 2, 1, 9, 10, 1, 3, 'GS'),
(6, 14, 3, 2, 9, 12, 1, 3, 'GS'),
(6, 21, 1, 3, 11, 9, 2, 3, 'GS'),
(6, 22, 2, 1, 10, 12, 1, 3, 'GS'),
(6, 7, 0, 1, 15, 16, 2, 3, 'GS'),
(6, 23, 2, 3, 16, 13, 2, 3, 'GS'),
(6, 24, 2, 1, 14, 15, 1, 3, 'GS'),
(6, 25, 1, 2, 4, 5, 2, 3, 'QF'),
(6, 26, 3, 2, 8, 2, 1, 3, 'QF'),
(6, 27, 1, 3, 9, 13, 2, 3, 'QF'),
(6, 28, 2, 0, 14, 11, 1, 3, 'QF'),
(6, 29, 2, 1, 5, 8, 1, 3, 'SF'),
(6, 30, 3, 2, 13, 14, 1, 3, 'SF'),
(6, 31, 2, 3, 5, 13, 2, 3, 'FI'),
(7, 1, 1, 2, 1, 3, 2, 3, 'GS'),
(7, 2, 3, 2, 2, 4, 1, 3, 'GS'),
(7, 9, 3, 2, 3, 4, 1, 3, 'GS'),
(7, 10, 1, 2, 1, 2, 2, 3, 'GS'),
(7, 17, 1, 2, 4, 1, 2, 3, 'GS'),
(7, 18, 3, 2, 3, 2, 1, 3, 'GS'),
(7, 3, 1, 4, 6, 8, 2, 3, 'GS'),
(7, 4, 3, 2, 5, 7, 1, 3, 'GS'),
(7, 11, 3, 0, 7, 8, 1, 3, 'GS'),
(7, 12, 0, 4, 5, 6, 2, 3, 'GS'),
(7, 19, 3, 2, 8, 5, 1, 3, 'GS'),
(7, 20, 0, 0, 7, 6, 3, 1, 'GS'),
(7, 5, 3, 2, 12, 11, 1, 3, 'GS'),
(7, 6, 1, 0, 9, 10, 1, 3, 'GS'),
(7, 13, 0, 2, 10, 11, 2, 3, 'GS'),
(7, 14, 3, 2, 9, 12, 1, 3, 'GS'),
(7, 21, 1, 2, 11, 9, 2, 3, 'GS'),
(7, 22, 3, 4, 10, 12, 2, 3, 'GS'),
(7, 7, 3, 2, 15, 16, 1, 3, 'GS'),
(7, 8, 4, 1, 13, 14, 1, 3, 'GS'),
(7, 15, 32, 3, 14, 16, 1, 3, 'GS'),
(7, 16, 1, 3, 13, 15, 2, 3, 'GS'),
(7, 23, 2, 3, 16, 13, 2, 3, 'GS'),
(7, 24, 0, 2, 14, 15, 2, 3, 'GS'),
(7, 25, 1, 2, 3, 7, 2, 3, 'QF'),
(7, 26, 2, 1, 8, 2, 1, 3, 'QF'),
(7, 27, 2, 1, 9, 13, 1, 3, 'QF'),
(7, 28, 2, 3, 15, 12, 2, 3, 'QF'),
(7, 29, 2, 1, 7, 8, 1, 3, 'SF'),
(7, 30, 3, 2, 9, 12, 1, 3, 'SF'),
(7, 31, 1, 0, 7, 9, 1, 3, 'FI'),
(8, 1, 3, 1, 1, 3, 1, 3, ''),
(8, 2, 2, 3, 2, 4, 2, 3, ''),
(8, 9, 2, 3, 3, 4, 2, 3, ''),
(8, 10, 3, 1, 1, 2, 1, 3, ''),
(8, 17, 2, 3, 4, 1, 2, 3, ''),
(8, 18, 0, 0, 3, 2, 3, 1, ''),
(8, 3, 2, 3, 6, 8, 2, 3, ''),
(8, 4, 2, 0, 5, 7, 1, 3, ''),
(8, 11, 2, 2, 7, 8, 3, 1, ''),
(8, 12, 0, 2, 5, 6, 2, 3, ''),
(8, 19, 1, 2, 8, 5, 2, 3, ''),
(8, 20, 3, 2, 7, 6, 1, 3, ''),
(8, 5, 3, 2, 12, 11, 1, 3, ''),
(8, 6, 1, 2, 9, 10, 2, 3, ''),
(8, 13, 1, 2, 10, 11, 2, 3, ''),
(8, 14, 3, 2, 9, 12, 1, 3, ''),
(8, 21, 2, 2, 11, 9, 3, 1, ''),
(8, 22, 3, 2, 10, 12, 1, 3, ''),
(8, 7, 1, 0, 15, 16, 1, 3, ''),
(8, 8, 0, 2, 13, 14, 2, 3, ''),
(8, 15, 1, 3, 14, 16, 2, 3, ''),
(8, 16, 2, 1, 13, 15, 1, 3, ''),
(8, 23, 2, 3, 16, 13, 2, 3, ''),
(8, 24, 2, 1, 14, 15, 1, 3, ''),
(8, 25, 2, 1, 1, 5, 1, 3, 'QF'),
(8, 26, 3, 1, 6, 4, 1, 3, 'QF'),
(8, 27, 3, 2, 10, 13, 1, 3, 'QF'),
(8, 28, 3, 1, 14, 9, 1, 3, 'QF'),
(8, 29, 2, 1, 1, 6, 1, 3, 'SF'),
(8, 30, 2, 3, 10, 14, 2, 3, 'SF'),
(8, 31, 3, 1, 1, 14, 1, 3, 'FI'),
(9, 1, 0, 0, 1, 3, 3, 1, 'GS'),
(9, 2, 0, 0, 2, 4, 3, 1, 'GS'),
(9, 9, 0, 0, 3, 4, 3, 1, 'GS'),
(9, 10, 0, 0, 1, 2, 3, 1, 'GS'),
(9, 17, 0, 0, 4, 1, 3, 1, 'GS'),
(9, 18, 0, 0, 3, 2, 3, 1, 'GS'),
(9, 3, 0, 0, 6, 8, 3, 1, 'GS'),
(9, 4, 0, 0, 5, 7, 3, 1, 'GS'),
(9, 11, 0, 0, 7, 8, 3, 1, 'GS'),
(9, 12, 0, 0, 5, 6, 3, 1, 'GS'),
(9, 19, 0, 0, 8, 5, 3, 1, 'GS'),
(9, 20, 0, 0, 7, 6, 3, 1, 'GS'),
(9, 5, 0, 0, 12, 11, 3, 1, 'GS'),
(9, 6, 0, 0, 9, 10, 3, 1, 'GS'),
(9, 13, 0, 0, 10, 11, 3, 1, 'GS'),
(9, 14, 0, 0, 9, 12, 3, 1, 'GS'),
(9, 21, 0, 0, 11, 9, 3, 1, 'GS'),
(9, 22, 0, 0, 10, 12, 3, 1, 'GS'),
(9, 7, 0, 0, 15, 16, 3, 1, 'GS'),
(9, 8, 0, 0, 13, 14, 3, 1, 'GS'),
(9, 15, 0, 0, 14, 16, 3, 1, 'GS'),
(9, 16, 0, 0, 13, 15, 3, 1, 'GS'),
(9, 23, 0, 0, 16, 13, 3, 1, 'GS'),
(9, 24, 0, 0, 14, 15, 3, 1, 'GS'),
(9, 25, 1, 0, 3, 8, 1, 3, 'QF'),
(9, 26, 0, 1, 7, 1, 2, 3, 'QF'),
(9, 27, 1, 0, 9, 13, 1, 3, 'QF'),
(9, 28, 0, 1, 15, 12, 2, 3, 'QF'),
(9, 29, 1, 0, 3, 9, 1, 3, 'SF'),
(9, 30, 0, 1, 1, 12, 2, 3, 'SF'),
(9, 31, 1, 0, 3, 12, 1, 3, 'FI');

-- --------------------------------------------------------

--
-- Table structure for table `Results`
--

CREATE TABLE `Results` (
  `ID` int NOT NULL,
  `Code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Description` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Results`
--

INSERT INTO `Results` (`ID`, `Code`, `Description`) VALUES
(1, 'H', 'Home Win'),
(2, 'A', 'Away Win'),
(3, 'D', 'Draw'),
(4, 'E', 'Extra Time'),
(5, 'P', 'Penalities'),
(6, 'NP', 'Not Played Yet');

-- --------------------------------------------------------

--
-- Table structure for table `Rounds`
--

CREATE TABLE `Rounds` (
  `ID` int NOT NULL,
  `Code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Rounds`
--

INSERT INTO `Rounds` (`ID`, `Code`, `Description`) VALUES
(1, 'GS', 'Group Stage'),
(2, 'LS', 'Last Sixteen'),
(3, 'QF', 'Quarter Final'),
(4, 'SF', 'Semi Final'),
(5, 'FI', 'Final'),
(6, 'PL', 'Play Off');

-- --------------------------------------------------------

--
-- Table structure for table `Teams`
--

CREATE TABLE `Teams` (
  `ID` int NOT NULL,
  `GroupID` int NOT NULL,
  `Code` varchar(3) COLLATE utf8mb4_general_ci NOT NULL,
  `Team` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Ranking` int NOT NULL,
  `WikipediaLink` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Teams`
--

INSERT INTO `Teams` (`ID`, `GroupID`, `Code`, `Team`, `Ranking`, `WikipediaLink`) VALUES
(1, 1, 'ENG', 'England', 8, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#England'),
(2, 1, 'NOR', 'Norway', 12, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Norway'),
(3, 1, 'AUS', 'Austria', 21, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Austria'),
(4, 1, 'NIR', 'Northern Ireland', 48, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Northern_Ireland'),
(5, 2, 'GER', 'Germany', 3, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Germany'),
(6, 2, 'SPN', 'Spain', 10, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Spain'),
(7, 2, 'DEN', 'Denmark', 15, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Denmark'),
(8, 2, 'FIN', 'Finland', 25, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Finland'),
(9, 3, 'NER', 'Netherlands', 4, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Netherlands'),
(10, 3, 'SWE', 'Sweden', 2, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Sweden'),
(11, 3, 'SWZ', 'Switzerland', 20, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Switzerland'),
(12, 3, 'POR', 'Portugal', 29, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Portugal'),
(13, 4, 'FRA', 'France', 5, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#France'),
(14, 4, 'ITL', 'Italy', 14, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Italy'),
(15, 4, 'BEL', 'Belgium', 19, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Belgium'),
(16, 4, 'ICE', 'Iceland', 16, 'https://en.wikipedia.org/wiki/UEFA_Women%27s_Euro_2022_squads#Iceland'),
(17, 8, 'GAW', 'Winner GrpA', 0, ''),
(18, 8, 'GAR', 'Runnerup GrpA', 0, ''),
(19, 8, 'GBW', 'Winner GrpB', 0, ''),
(20, 8, 'GBR', 'Runnerup GrpB', 0, ''),
(21, 8, 'GCW', 'Winner GrpC', 0, ''),
(22, 8, 'GCR', 'Runnerup GrpC', 0, ''),
(23, 8, 'GDW', 'Winner GrpD', 0, ''),
(24, 8, 'GDR', 'Runnerup GrpD', 0, ''),
(25, 9, 'Q1W', 'Winner QF1', 0, ''),
(26, 9, 'Q2W', 'Winner QF2', 0, ''),
(27, 9, 'Q3W', 'Winner QF3', 0, ''),
(28, 9, 'Q4W', 'Winner QF4', 0, ''),
(29, 10, 'S1W', 'Winner SF1', 0, ''),
(30, 10, 'S2W', 'Winner SF2', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int NOT NULL,
  `UserName` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `UserEmail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `UserPass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `UserTeam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Predictions` tinyint(1) NOT NULL,
  `TopScorer` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `GoalsScored` tinyint NOT NULL,
  `Points` int NOT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `UserName`, `UserEmail`, `UserPass`, `UserTeam`, `CreatedDate`, `Predictions`, `TopScorer`, `GoalsScored`, `Points`, `FirstName`, `LastName`, `Phone`) VALUES
(1, 'mboomer', 'mark.boomer@9habu.com', '$2y$10$kPY4Jmj0G.RCZ9FHG2DR4OvnoxPV7bwCMZDs8e./CGjDl/tOmJZHS', '', '2022-06-12 14:41:09', 1, 'Beth Mead', 6, 20, NULL, NULL, NULL),
(2, 'mhillock', 'mariehillock@outlook.com', '$2y$10$csT0.JwCCwlD5TZ1VLmjUe2C/WGaj6JJCBw7bS8LKRDVCYtaqwKnu', '', '2022-06-21 07:18:05', 1, 'Ada Hegerberg', 10, 22, 'Marie', 'Hillock', '07740 587 269'),
(3, 'cbrown', 'caroline.brown@bjso.org.uk', '$2y$10$9ILr.FqylryKR7B7Jax8E.G8UcS54cATCcQJDI7jVawQFKnwmTMnu', '', '2022-06-23 07:33:17', 1, 'Tessa Wullaert', 10, 17, NULL, NULL, NULL),
(4, 'katherine', 'mark.boomer@9habu.com', '$2y$10$kPY4Jmj0G.RCZ9FHG2DR4OvnoxPV7bwCMZDs8e./CGjDl/tOmJZHS', '', '2022-07-02 18:19:16', 1, 'Mariona Caldentey', 6, 34, NULL, NULL, NULL),
(5, 'finola', 'mark.boomer@bjso.uk.org', '$2y$10$0VuPoMqHpRxBGp2CmjBJouqO8z.nvDP98n7FR9jCd9OjmkxKFDwvO', '', '2022-07-09 12:52:25', 1, 'Sanne Troelsgaard', 8, 15, NULL, NULL, NULL),
(6, 'aboomer', 'mark.boomer@9habu.com', '$2y$10$kPY4Jmj0G.RCZ9FHG2DR4OvnoxPV7bwCMZDs8e./CGjDl/tOmJZHS', '', '2022-07-10 11:37:35', 1, 'Kadidiatou Diani', 7, 18, NULL, NULL, NULL),
(7, 'ossian', 'ossian@early-years.com', '$2y$10$LCZvw.mIZFQGGI62usGvAuGCsLoNnhH3oPbye73kbeip95PSbAsRK', '', '2022-07-10 13:31:36', 1, 'Ellen White', 8, 17, NULL, NULL, NULL),
(8, 'jmcstrav', 'joe@olympia.co.uk', '$2y$10$HivSjYyPQ/QQSk9cLquSxuJlOJlMbR8/bCdEXN2YJCP1kaa2fmNrC', '', '2022-07-10 13:35:26', 1, 'Ellen White', 9, 28, NULL, NULL, NULL),
(9, 'jaker', 'jaker@olympia.com', '$2y$10$wafbpVp7yZLg3OB186IewOS6/CHaxvfGcmC3bZoHautbfkYom73tq', '', '2022-07-14 05:39:27', 1, 'Mariona Caldentey', 3, 11, NULL, NULL, NULL),
(10, 'hilo', 'mark.boomer@9habu.com', '$2y$10$wj7GaHJvkDuyjdHC4gg5jetGW2yFUZRlqHisC8M/c8rF3uyqXCcoC', '', '2022-07-27 05:53:59', 0, '', 0, 0, 'Sean', 'Hyland', '7875596206');

-- --------------------------------------------------------

--
-- Table structure for table `Venues`
--

CREATE TABLE `Venues` (
  `ID` int NOT NULL,
  `City` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Stadium` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Stadiums hosting the games';

--
-- Dumping data for table `Venues`
--

INSERT INTO `Venues` (`ID`, `City`, `Stadium`) VALUES
(1, 'Trafford', 'Old Trafford'),
(2, 'Southampton', 'St. Marys'),
(3, 'Milton Keynes', 'Stadium MK'),
(4, 'London', 'Brentford Community Stadium'),
(5, 'Wigan & Leigh', 'Leigh Sports Village'),
(6, 'Sheffield', 'Bramall Lane'),
(7, 'Manchester', 'Manchester City Academy Stadium'),
(8, 'Rotherham', 'New York Stadium'),
(9, 'London', 'Wembley Stadium'),
(10, 'Brighton & Hove', 'Brighton & Hove Community Stadium');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Fixtures`
--
ALTER TABLE `Fixtures`
  ADD UNIQUE KEY `FixtureNo` (`FixtureNo`);

--
-- Indexes for table `GoalsScored`
--
ALTER TABLE `GoalsScored`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `GroupStage`
--
ALTER TABLE `GroupStage`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Code` (`Code`);

--
-- Indexes for table `KnockOutStage`
--
ALTER TABLE `KnockOutStage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `PasswordReset`
--
ALTER TABLE `PasswordReset`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Results`
--
ALTER TABLE `Results`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Rounds`
--
ALTER TABLE `Rounds`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Teams`
--
ALTER TABLE `Teams`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Venues`
--
ALTER TABLE `Venues`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `GoalsScored`
--
ALTER TABLE `GoalsScored`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `GroupStage`
--
ALTER TABLE `GroupStage`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `KnockOutStage`
--
ALTER TABLE `KnockOutStage`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `PasswordReset`
--
ALTER TABLE `PasswordReset`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `Results`
--
ALTER TABLE `Results`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Rounds`
--
ALTER TABLE `Rounds`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Teams`
--
ALTER TABLE `Teams`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Venues`
--
ALTER TABLE `Venues`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
