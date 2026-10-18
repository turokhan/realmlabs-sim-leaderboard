-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Server version: 10.11.19-MariaDB-ubu2204
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sim_racing`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar_2024`
--

CREATE TABLE `calendar_2024` (
  `id` int(11) NOT NULL,
  `race_name` varchar(100) NOT NULL,
  `race_date` date NOT NULL,
  `location` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_2024`
--

INSERT INTO `calendar_2024` (`id`, `race_name`, `race_date`, `location`, `country`) VALUES
(34, 'Bahrain GP', '2024-03-02', 'Bahrain International Circuit', 'Bahrain'),
(35, 'Saudi Arabian GP', '2024-03-09', 'Jeddah Street Circuit', 'Saudi Arabia'),
(36, 'Australian GP', '2024-03-24', 'Albert Park', 'Australia'),
(37, 'Japanese GP', '2024-04-07', 'Suzuka Circuit', 'Japan'),
(38, 'Chinese GP', '2024-04-21', 'Shanghai International Circuit', 'China'),
(39, 'Miami GP', '2024-05-05', 'Miami International Autodrome', 'USA'),
(40, 'Emilia Romagna GP', '2024-05-19', 'Autodromo Enzo e Dino Ferrari', 'Italy'),
(41, 'Monaco GP', '2024-05-26', 'Circuit de Monaco', 'Monaco'),
(42, 'Canadian GP', '2024-06-09', 'Circuit Gilles Villeneuve', 'Canada'),
(43, 'Spanish GP', '2024-06-23', 'Circuit de Catalunya', 'Spain'),
(44, 'Austrian GP', '2024-06-30', 'Red Bull Ring', 'Austria'),
(45, 'British GP', '2024-07-07', 'Circuit Silverstone', 'United Kingdom'),
(46, 'Hungarian GP', '2024-07-21', 'Hungaroring', 'Hungary'),
(47, 'Belgian GP', '2024-07-28', 'Spa-Francorchamps', 'Belgium'),
(48, 'Dutch GP', '2024-08-25', 'Circuit Zandvoort', 'Netherlands'),
(49, 'Italian GP', '2024-09-01', 'Autodromo Nazionale Monza', 'Italy'),
(50, 'Azerbaijan GP', '2024-09-15', 'Baku City Circuit', 'Azerbaijan'),
(51, 'Singapore GP', '2024-09-22', 'Marina Bay Street Circuit', 'Singapore'),
(52, 'United States GP', '2024-10-20', 'Circuit of the Americas', 'USA'),
(53, 'Mexican GP', '2024-10-27', 'Autodromo Hermanos Rodriguez', 'Mexico'),
(54, 'Brazilian GP', '2024-11-03', 'Autodromo Jose Carlos Pace Interlagos', 'Brazil'),
(55, 'Las Vegas GP', '2024-11-24', 'Las Vegas Street Circuit', 'USA'),
(56, 'Lusail GP', '2024-12-01', 'Losail International Circuit', 'Qatar'),
(57, 'Abu Dhabi GP', '2024-12-08', 'Yas Marina Circuit', 'United Arab Emirates');

-- --------------------------------------------------------

--
-- Table structure for table `f1_2022`
--

CREATE TABLE `f1_2022` (
  `id` int(11) NOT NULL,
  `row_id` text NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- No legacy driver data included in the public release.
--

-- --------------------------------------------------------

--
-- Table structure for table `f1_leaderboards`
--

CREATE TABLE `f1_leaderboards` (
  `id` int(11) NOT NULL,
  `Player` varchar(255) DEFAULT NULL,
  `LapTime` varchar(255) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Track` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `f1_leaderboards`
--

-- --------------------------------------------------------

--
-- Table structure for table `gt7_entries`
--

CREATE TABLE `gt7_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player` varchar(100) NOT NULL,
  `track_id` int(10) UNSIGNED NOT NULL,
  `lap_time` varchar(12) NOT NULL,
  `lap_time_ms` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gt7_entries`
--

-- --------------------------------------------------------

--
-- Table structure for table `gt7_tracks`
--

CREATE TABLE `gt7_tracks` (
  `id` int(10) UNSIGNED NOT NULL,
  `track_name` varchar(200) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gt7_tracks`
--

INSERT INTO `gt7_tracks` (`id`, `track_name`, `sort_order`) VALUES
(1, '24 Heures du Mans Racing Circuit', 1),
(2, 'Alsace - Village', 2),
(3, 'Autódromo de Interlagos', 3),
(4, 'Autodrome Lago Maggiore - GP', 4),
(5, 'Autodromo Nazionale Monza', 5),
(6, 'Autopolis International Racing Course', 6),
(7, 'BB Raceway', 7),
(8, 'Blue Moon Bay Speedway', 8),
(9, 'Blue Moon Bay Speedway - Infield A', 9),
(10, 'Brands Hatch - Grand Prix Circuit', 10),
(11, 'Circuit de Barcelona-Catalunya - Grand Prix', 11),
(12, 'Circuit de Barcelona-Catalunya - Rallycross', 12),
(13, 'Circuit de Sainte-Croix - A', 13),
(14, 'Circuit de Sainte-Croix - C', 14),
(15, 'Circuit de Spa-Francorchamps', 15),
(16, 'Circuit Gilles-Villeneuve', 16),
(17, 'Colorado Springs - Lake', 17),
(18, 'Daytona International Speedway - Road Course', 18),
(19, 'Deep Forest Raceway', 19),
(20, 'Dragon Trail - Gardens', 20),
(21, 'Dragon Trail - Seaside', 21),
(22, 'Eiger Nordwand', 22),
(23, 'Fishermans Ranch', 23),
(24, 'Fuji International Speedway', 24),
(25, 'Goodwood Motor Circuit', 25),
(26, 'Grand Valley - Highway 1', 26),
(27, 'Grand Valley - South', 27),
(28, 'High Speed Ring', 28),
(29, 'Kyoto Driving Park - Yamagiwa', 29),
(30, 'Lake Louise - Long Track', 30),
(31, 'Michelin Raceway Road Atlanta', 31),
(32, 'Mount Panorama Motor Racing Circuit', 32),
(33, 'Northern Isle Speedway', 33),
(34, 'Nürburgring - GP', 34),
(35, 'Nürburgring - Nordschleife', 35),
(36, 'Nürburgring - Endurance II', 36),
(37, 'Red Bull Ring', 37),
(38, 'Sardegna - Road Track - A', 38),
(39, 'Sardegna - Windmills', 39),
(40, 'Suzuka Circuit', 40),
(41, 'Tokyo Expressway - Central', 41),
(42, 'Trial Mountain Circuit', 42),
(43, 'Tsukuba Circuit', 43),
(44, 'Watkins Glen International - Long Course', 44),
(45, 'WeatherTech Raceway Laguna Seca', 45),
(46, 'Willow Springs - Big Willow', 46),
(47, 'Willow Springs - Horse Thief Mile', 47),
(48, 'Willow Springs - Streets of Willow Springs', 48);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Player` text NOT NULL,
  `LapTime` text NOT NULL,
  `Track` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar_2024`
--
ALTER TABLE `calendar_2024`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f1_2022`
--
ALTER TABLE `f1_2022`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `f1_leaderboards`
--
ALTER TABLE `f1_leaderboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gt7_entries`
--
ALTER TABLE `gt7_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_gt7_track` (`track_id`),
  ADD KEY `idx_gt7_fastest` (`track_id`,`lap_time_ms`);

--
-- Indexes for table `gt7_tracks`
--
ALTER TABLE `gt7_tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_gt7_track_name` (`track_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar_2024`
--
ALTER TABLE `calendar_2024`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `f1_2022`
--
ALTER TABLE `f1_2022`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `f1_leaderboards`
--
ALTER TABLE `f1_leaderboards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gt7_entries`
--
ALTER TABLE `gt7_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gt7_tracks`
--
ALTER TABLE `gt7_tracks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gt7_entries`
--
ALTER TABLE `gt7_entries`
  ADD CONSTRAINT `fk_gt7_entries_track` FOREIGN KEY (`track_id`) REFERENCES `gt7_tracks` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
