-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 juin 2024 à 18:10
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `upwork4`
--

-- --------------------------------------------------------

--
-- Structure de la table `filler`
--

CREATE TABLE `filler` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `date_created` varchar(255) DEFAULT NULL,
  `our_network` varchar(255) DEFAULT NULL,
  `client_network` varchar(255) DEFAULT NULL,
  `broker` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filler`
--

INSERT INTO `filler` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `country`, `date_created`, `our_network`, `client_network`, `broker`) VALUES
(3, 'AKKAK', 'KAKAKA', 'kamal@gmail.com', 'KAKAK', 'KAKAKAA', 'AKAK', 'KAKAK', 'KKAK', 'KAKKA');

-- --------------------------------------------------------

--
-- Structure de la table `ftd`
--

CREATE TABLE `ftd` (
  `fid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `extension` int(11) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `whatsapp` enum('Yes','No') DEFAULT NULL,
  `viber` enum('Yes','No') DEFAULT NULL,
  `messenger` enum('Yes','No') DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `date_created` varchar(255) DEFAULT NULL,
  `front_id` varchar(255) DEFAULT NULL,
  `back_id` varchar(255) DEFAULT NULL,
  `selfie_front` varchar(255) DEFAULT NULL,
  `selfie_back` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `our_network` varchar(255) DEFAULT NULL,
  `client_network` varchar(255) DEFAULT NULL,
  `broker` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `table_origin` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `for_day` varchar(255) DEFAULT NULL,
  `work_hours` varchar(255) DEFAULT NULL,
  `our_network_today` varchar(255) DEFAULT NULL,
  `client_network_today` varchar(255) DEFAULT NULL,
  `broker_today` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `table_origin`, `first_name`, `last_name`, `email`, `phone_number`, `country`, `for_day`, `work_hours`, `our_network_today`, `client_network_today`, `broker_today`) VALUES
(7, '2024-05-30', 'kaka', 'kakakl', 'akka', 'kamal@gmail.com', '6666666666', 'MOROCCO', '2024-06-21', '13H', 'x', 'x', 'x'),
(8, '2024-06-21', 'YAHYA', 'YAHAY', 'ka', 'kamal@gmail.com', '7777777777', 'MOROCCO', '2024-06-19', '13H', 'K', 'K', 'K');

-- --------------------------------------------------------

--
-- Structure de la table `traffic`
--

CREATE TABLE `traffic` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `date_created` varchar(255) DEFAULT NULL,
  `our_network` varchar(255) DEFAULT NULL,
  `client_network` varchar(255) DEFAULT NULL,
  `broker` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `traffic`
--

INSERT INTO `traffic` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `country`, `date_created`, `our_network`, `client_network`, `broker`) VALUES
(4, 'kamal', 'X', 'najikamal100@gmail.com', 'X', 'Maroc', 'kaka', 'kakakk', 'kala', 'kaka');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','order_admin','filler_admin','ftd_admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'kamal1', 'rajaraja', 'super_admin'),
(5, 'yahya', 'yahyayahya', 'filler_admin'),
(6, 'kamal3', 'kamalkamal', 'order_admin'),
(7, 'simo1', 'kamalkamal', 'ftd_admin'),
(8, 'lolo', 'lolololo', 'filler_admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `filler`
--
ALTER TABLE `filler`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ftd`
--
ALTER TABLE `ftd`
  ADD PRIMARY KEY (`fid`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `traffic`
--
ALTER TABLE `traffic`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `filler`
--
ALTER TABLE `filler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `traffic`
--
ALTER TABLE `traffic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
