-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 19 juin 2024 à 03:59
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
-- Structure de la table `brand_table`
--

CREATE TABLE `brand_table` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `aff_manager_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `brand_table`
--

INSERT INTO `brand_table` (`id`, `brand_name`, `aff_manager_id`) VALUES
(26, 'inwi', 15);

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
(103, 'John', 'Doe', 'johndoe@example.com', '1234567890', 'Spain', '2024-06-13', NULL, NULL, 'Broker 1'),
(104, 'Jane', 'Smith', 'janesmith@example.com', '9876543210', 'UK', '2024-06-12', NULL, NULL, 'Broker 2'),
(105, 'Alice', 'Johnson', 'alicejohnson@example.com', '4561237890', 'Ghana', '2024-06-11', NULL, NULL, 'Broker 3');

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

--
-- Déchargement des données de la table `ftd`
--

INSERT INTO `ftd` (`fid`, `email`, `email_password`, `extension`, `phone_number`, `whatsapp`, `viber`, `messenger`, `dob`, `address`, `country`, `date_created`, `front_id`, `back_id`, `selfie_front`, `selfie_back`, `remark`, `profile_picture`, `our_network`, `client_network`, `broker`) VALUES
('10', 'email@example.com', 'password', 1234, '555-1234', 'Yes', 'No', 'Yes', '1990-01-01', '123 Example St', 'Country', '2024-01-01', 'front_id_001', 'back_id_001', 'selfie_front_001', 'selfie_back_001', 'Some remark', 'profile_pic_001', NULL, NULL, 'broker_001'),
('12', 'email@example.com', 'password', 1234, '555-1234', 'Yes', 'No', 'Yes', '1990-01-01', '123 Example St', 'Spain', '2024-01-01', 'front_id_001', 'back_id_001', 'selfie_front_001', 'selfie_back_001', 'Some remark', 'profile_pic_001', 'X', 'CocaCola', 'broker_001'),
('14', 'email2@example.com', 'password2', 5678, '555-5678', 'No', 'Yes', 'No', '1992-02-02', '456 Example St', 'Country2', '2024-02-02', 'front_id_002', 'back_id_002', 'selfie_front_002', 'selfie_back_002', 'Another remark', 'profile_pic_002', NULL, NULL, 'broker_002'),
('18', 'email2@example.com', 'password2', 5678, '555-5678', 'No', 'Yes', 'No', '1992-02-02', '456 Example St', 'Country2', '2024-02-02', 'front_id_002', 'back_id_002', 'selfie_front_002', 'selfie_back_002', 'Another remark', 'profile_pic_002', NULL, NULL, 'broker_002'),
('19', 'email@example.com', 'password', 1234, '555-1234', 'Yes', 'No', 'Yes', '1990-01-01', '123 Example St', 'Country', '2024-01-01', 'front_id_001', 'back_id_001', 'selfie_front_001', 'selfie_back_001', 'Some remark', 'profile_pic_001', NULL, NULL, 'broker_001'),
('2', 'email2@example.com', 'password2', 5678, '555-5678', 'No', 'Yes', 'No', '1992-02-02', '456 Example St', 'Country2', '2024-02-02', 'front_id_002', 'back_id_002', 'selfie_front_002', 'selfie_back_002', 'Another remark', 'profile_pic_002', NULL, NULL, 'broker_002'),
('23', 'email@example.com', 'password', 1234, '555-1234', 'Yes', 'No', 'Yes', '1990-01-01', '123 Example St', 'Spain', '2024-01-01', 'front_id_001', 'back_id_001', 'selfie_front_001', 'selfie_back_001', 'Some remark', 'profile_pic_001', 'X', 'CocaCola', 'broker_001'),
('75', 'email2@example.com', 'password2', 5678, '555-5678', 'No', 'Yes', 'No', '1992-02-02', '456 Example St', 'Canada', '2024-02-02', 'front_id_002', 'back_id_002', 'selfie_front_002', 'selfie_back_002', 'Another remark', 'profile_pic_002', NULL, NULL, 'broker_002');

-- --------------------------------------------------------

--
-- Structure de la table `list_brand_name`
--

CREATE TABLE `list_brand_name` (
  `id` int(11) NOT NULL,
  `name_brand` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `list_brand_name`
--

INSERT INTO `list_brand_name` (`id`, `name_brand`) VALUES
(1, 'CocaCola'),
(4, 'inwi');

-- --------------------------------------------------------

--
-- Structure de la table `list_network`
--

CREATE TABLE `list_network` (
  `id` int(11) NOT NULL,
  `name_network` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `list_network`
--

INSERT INTO `list_network` (`id`, `name_network`) VALUES
(1, 'X'),
(2, 'Test');

-- --------------------------------------------------------

--
-- Structure de la table `list_type_order`
--

CREATE TABLE `list_type_order` (
  `id` int(11) NOT NULL,
  `name_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `list_type_order`
--

INSERT INTO `list_type_order` (`id`, `name_type`) VALUES
(1, 'Y');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `for_day` varchar(255) DEFAULT NULL,
  `work_hours` varchar(255) DEFAULT NULL,
  `our_network_today` varchar(255) DEFAULT NULL,
  `approval` enum('Yes','No','Waiting') DEFAULT 'Waiting',
  `type_order` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `capps` int(11) DEFAULT NULL,
  `ftds` int(11) DEFAULT NULL,
  `aff_manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `country`, `for_day`, `work_hours`, `our_network_today`, `approval`, `type_order`, `brand_name`, `capps`, `ftds`, `aff_manager_id`) VALUES
(53, '2024-06-26', 'Australia', '2024-06-27', '10:00 - 20:00 (GMT +3)', 'X', 'Waiting', 'Y', 'CocaCola', 6, 3, 15);

-- --------------------------------------------------------

--
-- Structure de la table `orders_injection`
--

CREATE TABLE `orders_injection` (
  `id` int(11) NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `table_origin` enum('ftd','filler') DEFAULT NULL,
  `f_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `aff_manager_id` int(11) DEFAULT NULL,
  `for_day` varchar(255) DEFAULT NULL,
  `work_hours` varchar(255) DEFAULT NULL,
  `our_network_today` varchar(255) DEFAULT NULL,
  `client_network_today` varchar(255) DEFAULT NULL,
  `broker_today` varchar(255) DEFAULT NULL,
  `category_lead` enum('ftd','filler') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders_injection`
--

INSERT INTO `orders_injection` (`id`, `order_date`, `table_origin`, `f_id`, `first_name`, `last_name`, `email`, `phone_number`, `country`, `aff_manager_id`, `for_day`, `work_hours`, `our_network_today`, `client_network_today`, `broker_today`, `category_lead`) VALUES
(34, '2024-06-26', 'ftd', 12, '', '', '', '', 'Spain', 15, '2024-06-27', '10:00 - 20:00 (GMT +3)', 'X', 'CocaCola', '', NULL),
(35, '2024-06-26', 'ftd', 23, '', '', '', '', 'Spain', 15, '2024-06-27', '10:00 - 20:00 (GMT +3)', 'X', 'CocaCola', '', NULL);

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
(5, 'kamal', 'x', 'x@gmail.com', 'x', 'x', 'x', 'x', 'x', 'x');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','affiliate_manager','order_admin','filler_admin','ftd_admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(6, 'kamal3', 'kamalkamal', 'super_admin'),
(7, 'simo1', 'kamalkamal', 'ftd_admin'),
(8, 'lolo', 'lolololo', 'filler_admin'),
(11, 'wahid', 'hahahah', 'filler_admin'),
(12, 'wahid', 'yayayay', 'filler_admin'),
(14, 'popo', 'rajaraja', 'affiliate_manager'),
(15, 'toto', 'rajaraja', 'affiliate_manager'),
(16, 'lala', 'kamalkamal', 'order_admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `brand_table`
--
ALTER TABLE `brand_table`
  ADD PRIMARY KEY (`id`);

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
-- Index pour la table `list_brand_name`
--
ALTER TABLE `list_brand_name`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `list_network`
--
ALTER TABLE `list_network`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `list_type_order`
--
ALTER TABLE `list_type_order`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders_injection`
--
ALTER TABLE `orders_injection`
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
-- AUTO_INCREMENT pour la table `brand_table`
--
ALTER TABLE `brand_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `filler`
--
ALTER TABLE `filler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `list_brand_name`
--
ALTER TABLE `list_brand_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `list_network`
--
ALTER TABLE `list_network`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `list_type_order`
--
ALTER TABLE `list_type_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `orders_injection`
--
ALTER TABLE `orders_injection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `traffic`
--
ALTER TABLE `traffic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
