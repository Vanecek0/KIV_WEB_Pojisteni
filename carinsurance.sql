-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 02. bře 2026, 10:25
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `carinsurance`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `contracts`
--

CREATE TABLE `contracts` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `vehicle_id` int(10) UNSIGNED NOT NULL,
  `type` set('KOMFORT','PLUS','EXTRA','MAX') NOT NULL,
  `price` decimal(30,0) DEFAULT 0,
  `payment_state` set('NEZAPLACENO','ČEKAJÍCÍ','ZAMÍTNUTA','ZAPLACENO') NOT NULL DEFAULT 'ČEKAJÍCÍ',
  `valid_from` date NOT NULL DEFAULT '1900-01-01',
  `valid_to` date NOT NULL DEFAULT '1900-01-01',
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `contracts`
--

INSERT INTO `contracts` (`id`, `client_id`, `vehicle_id`, `type`, `price`, `payment_state`, `valid_from`, `valid_to`, `notes`) VALUES
(4, 14, 3, 'EXTRA', 10350, 'ČEKAJÍCÍ', '2026-03-03', '2027-03-03', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `contract_id` int(10) UNSIGNED NOT NULL,
  `accident_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `accident_place` text NOT NULL,
  `accident_description` varchar(255) NOT NULL,
  `estimated_damage_amount` varchar(255) NOT NULL,
  `culprit_firstname` varchar(255) DEFAULT NULL,
  `culprit_lastname` varchar(255) DEFAULT NULL,
  `culprit_phone` varchar(255) DEFAULT NULL,
  `culprit_email` varchar(255) DEFAULT NULL,
  `culprit_city` varchar(255) DEFAULT NULL,
  `culprit_street` varchar(255) DEFAULT NULL,
  `culprit_psc` int(11) DEFAULT NULL,
  `culprit_spz` varchar(255) DEFAULT NULL,
  `culprit_vehicle` varchar(255) DEFAULT NULL,
  `culprit_insurance` varchar(255) DEFAULT NULL,
  `report_state` set('PROBÍHÁ','ZAMÍTNUTO','UZAVŘENO') NOT NULL DEFAULT 'PROBÍHÁ',
  `closed_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `reports`
--

INSERT INTO `reports` (`id`, `contract_id`, `accident_datetime`, `accident_place`, `accident_description`, `estimated_damage_amount`, `culprit_firstname`, `culprit_lastname`, `culprit_phone`, `culprit_email`, `culprit_city`, `culprit_street`, `culprit_psc`, `culprit_spz`, `culprit_vehicle`, `culprit_insurance`, `report_state`, `closed_datetime`, `images`) VALUES
(22, 4, '0000-00-00 00:00:00', '50.08621752487202,14.421990156224485', 'Nehoda', '50000', 'Jan', 'Novák', '123456789', 'jan@novak.cz', 'Praha', 'Praha', 0, '1US3456', 'Audi A4', 'Generali', 'PROBÍHÁ', '2026-03-02 10:24:25', '[\"uploads\\/reports\\/22\\/22_69a55749c3d67_1772443465.jpg\"]');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birth` date NOT NULL DEFAULT '1900-01-01',
  `birth_number` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `psc` int(11) NOT NULL DEFAULT 0,
  `role` tinyint(3) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `phone`, `email`, `birth`, `birth_number`, `city`, `street`, `psc`, `role`) VALUES
(14, 'user', '$2y$10$HEG6cSS51vSnADxf2GEoXOz4CVbTZS18HB2MiRKiaN2VAxpYXVp36', 'User', 'User', '123456789', 'user@user.cz', '2026-03-02', '0000000000', 'Praha', 'Praha', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `engine_power` int(11) NOT NULL,
  `engine_capacity` int(11) NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `manufacture_year` year(4) DEFAULT 2000,
  `registration_date` date NOT NULL,
  `vin` varchar(255) NOT NULL,
  `spz` varchar(255) NOT NULL,
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `brand`, `model`, `engine_power`, `engine_capacity`, `fuel_type`, `manufacture_year`, `registration_date`, `vin`, `spz`, `images`) VALUES
(3, 14, 'Škoda', 'Octavia RS', 220, 1984, 'Natural 95', '2013', '2026-03-02', '000', '1A29088', '[\"uploads\\/vehicles\\/3\\/3_69a556f25dd50_1772443378.jpg\"]');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN_client_id` (`client_id`),
  ADD KEY `FOREIGN_vehicle_id` (`vehicle_id`);

--
-- Indexy pro tabulku `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN_contract_id` (`contract_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexy pro tabulku `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FOREIGN_user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `FOREIGN_client_id` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FOREIGN_vehicle_id` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FOREIGN_contract_id` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
