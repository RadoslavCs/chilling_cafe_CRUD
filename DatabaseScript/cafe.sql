-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Po 02.Dec 2024, 21:54
-- Verzia serveru: 10.4.32-MariaDB
-- Verzia PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `cafe`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `menu_table`
--

CREATE TABLE `menu_table` (
  `id` int(11) NOT NULL COMMENT 'Primárny kľúč (jedinečný identifikátor).',
  `name` varchar(30) NOT NULL COMMENT 'Názov nápoja (napríklad Americano, Cappuccino, Pure White Milk, atď.).',
  `drink_type` varchar(20) NOT NULL COMMENT 'Typ nápoja (buď "Coffee" alebo "Tea").',
  `hot_price` varchar(10) NOT NULL COMMENT 'Cena pre typ "Hot".',
  `iced_price` varchar(10) NOT NULL COMMENT 'Cena pre typ "Iced".',
  `addon_price` varchar(10) NOT NULL COMMENT 'Cena prídavného doplnku pre čajové nápoje (ak sa použije, inak "-").',
  `blended_price` varchar(10) NOT NULL COMMENT 'Cena pre typ "Blended" (pre kávu, ak je relevantné).'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `menu_table`
--

INSERT INTO `menu_table` (`id`, `name`, `drink_type`, `hot_price`, `iced_price`, `addon_price`, `blended_price`) VALUES
(1, 'Americano', 'Coffee', '10', '15', '-', '-'),
(3, 'Cappuccino', 'Coffee', '15', '18', '-', '20'),
(5, 'Fresh Latte', 'Coffee', '10', '18', '-', '21'),
(7, 'Mocha', 'Coffee', '15', '18', '-', '20'),
(9, 'Espresso', 'Coffee', '10', '15', '-', '-'),
(10, 'Black Coffee', 'Coffee', '15', '-', '-', '-'),
(11, 'Double Shot Espresso', 'Coffee', '20', '20', '-', '-'),
(12, 'Pure White Milk', 'Tea', '5', '10', '-', '-'),
(13, 'Hong Kong Tea', 'Tea', '8', '12', '4', '-'),
(14, 'Taiwan Tea', 'Tea', '4', '10', '4', '-'),
(15, 'Bubble Tea', 'Tea', '8', '12', '-', '-'),
(16, 'Mixed Fruit Tea', 'Tea', '12.50', '16', '8', '-'),
(18, 'Original Tea', 'Tea', '12', '14', '3', '-'),
(20, 'Black Tea', 'Tea', '5,54', '12', '-', '-'),
(23, 'Test Tea', 'Tea', '12', '12', '4', '-'),
(24, 'Test Coffe', 'Coffee', '2', '23.40', '-', '20');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `heslo` varchar(150) NOT NULL,
  `rola` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `heslo`, `rola`) VALUES
(1, 'Rado', '1980radoslavtoth@gmail.com', '$2y$10$I8R0URGv4nkDhLRQ57rOCeenvdo.IntkvZ/GCUdEcVhyb1dkobxPi', 'admin'),
(2, 'Tester', 'radoslav.toth.service@gmail.com', '$2y$10$Sn75SOLjBkXXmSRWW/FGfep0brA5S/rS4mgKEA8ZOfgJWpaPxPrXe', 'admin'),
(3, 'megapixel', 'radoslav.toth@student.ukf.sk', '$2y$10$qEkjXykEJ5FFWEpBeYDzbeqSJMFatr2Evll7gV1837dI4oYicgMjy', 'admin'),
(4, 'Tester1', 'e.novak@gmail.com', '$2y$10$4.0VudGtObbsM7RiQsXCTuhjZmQofKyH58pTx074vNv5ZZXHSE20G', 'admin');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `menu_table`
--
ALTER TABLE `menu_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `menu_table`
--
ALTER TABLE `menu_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primárny kľúč (jedinečný identifikátor).', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pre tabuľku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
