-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 06:03 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `verified` tinyint(4) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `verified`, `token`, `password`) VALUES
(27, 'Teo', 'teobdica@gmail.com', 0, 'c71e8b623a303441cb2f71beaac503e1f6e01172074cf81abf03718c82281b43768eb28c7644a9514fa9aef2813607708b5b', '$2y$10$p2w3Pksqp0hmisumiMNLP.l3iHwmIpf74rjR8L316N200Xlb5W6Ka'),
(28, 'Warriors_Sami', 'sami.barbut-dica@licalafat.ro', 0, 'fa052346c3b0a8141fcde745318fcc2a9f678b5a30e46b1459f50fb810ab29cce2df665b6f36b79280c34d43a22a229760dc', '$2y$10$ngOKSBUXDRMMMchW654bJOEy/c1WD7BpQ6/Oio0Xs9Zxy9NtJp9kK'),
(29, 'alex', 'admin@kilonova.ro', 0, '52ed22bd519507b6a4d777cff8c0140a98f3e0e69d1af1cb4bd9af9113e643804abb2c84288b6fabb7f505af2fbc2eae1327', '$2y$10$Nl/Y0e/NSdBGf87uCUwsFO26D8MvfRh6JoIeiMJ9me8P0dcQHtmfm'),
(31, 'iustin', 'pmarianjustin@gmail.com', 0, 'ac2338be9ec70daca16eae28e47dcc868c964c12bb2d360237608050b5c5fda32440ef7ae08c4cbec90e007862a1d4e47064', '$2y$10$vjfna3h/UhULjlr6as1Dw.qx3lJgfmQiD/3eiryIwvp5txIS/xkN2'),
(33, 'Sami', 'barbutdicas@gmail.com', 1, '01192de730c7755da85ad206a4c9669a3271cd432e1263c41f437113b73bbd566ab780f462d9dc96a9465b729a4058639105', '$2y$10$G.A74eqDImkV5mwF0ImMh.aH2zUyK3jhK9H/JBNuyXEUllBQOhYp2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
