-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Št 05.Dec 2024, 17:07
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
(2, 'Cappuccino', 'Coffee', '15', '18', '-', '20'),
(3, 'Fresh Latte', 'Coffee', '10', '18', '-', '20'),
(4, 'Mocha', 'Coffee', '15', '18', '-', '20'),
(5, 'Espresso', 'Coffee', '10', '15', '-', '-'),
(6, 'Black Coffee', 'Coffee', '15', '-', '-', '-'),
(7, 'Double Shot Espresso', 'Coffee', '20', '20', '-', '-'),
(8, 'Pure White Milk', 'Tea', '5', '10', '-', '-'),
(9, 'Hong Kong Tea', 'Tea', '8', '12', '4', '-'),
(10, 'Taiwan Tea', 'Tea', '4', '10', '4', '-'),
(11, 'Bubble Tea', 'Tea', '8', '12', '-', '-'),
(12, 'Mixed Fruit Tea', 'Tea', '10', '15', '8', '-'),
(13, 'Black Tea', 'Tea', '15', '-', '3', '-'),
(14, 'Original Tea', 'Tea', '12.58', '14.75', '-', '-'),
(28, 'Test Tea', 'Tea', '5,54', '14', '8', '-'),
(29, 'Test Coffe', 'Coffee', '15', '23', '-', '20');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `nav_menu`
--

CREATE TABLE `nav_menu` (
  `id` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `class-a` varchar(50) NOT NULL,
  `href` varchar(50) NOT NULL,
  `style` varchar(200) DEFAULT NULL,
  `content` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `nav_menu`
--

INSERT INTO `nav_menu` (`id`, `class`, `class-a`, `href`, `style`, `content`) VALUES
(1, 'tm-nav-item', 'tm-nav-link', '#coffee-menu', 'color: #fff; text-decoration: none; font-size: 30px;', 'Coffee'),
(2, 'tm-nav-item', 'tm-nav-link', '#tea-menu', 'color: #fff; text-decoration: none; font-size: 30px;', 'Tea'),
(3, 'tm-nav-item', 'tm-nav-link', '#special-items', 'color: #fff; text-decoration: none; font-size: 30px;', 'Specials'),
(4, 'tm-nav-item', 'tm-nav-link', '#about-us', 'color: #fff; text-decoration: none; font-size: 30px;', 'About'),
(5, 'tm-nav-item', 'tm-nav-link', '#contact-us', 'color: #fff; text-decoration: none; font-size: 30px;', 'Contact'),
(6, 'tm-nav-item', 'tm-nav-link', 'login.php', 'color: #fff; text-decoration: none; font-size: 30px;', 'Login');

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
-- Indexy pre tabuľku `nav_menu`
--
ALTER TABLE `nav_menu`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primárny kľúč (jedinečný identifikátor).', AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pre tabuľku `nav_menu`
--
ALTER TABLE `nav_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pre tabuľku `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
