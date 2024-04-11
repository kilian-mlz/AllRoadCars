-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 07 avr. 2024 à 13:55
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum1`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'DISTRIBUTION'),
(2, 'PNEUMATIQUE'),
(3, 'ECLAIRAGE'),
(4, 'TRANSMISSION'),
(5, 'VIDANGE'),
(6, 'SURALIMENTATION'),
(7, 'FAP'),
(8, 'ÉCHAPPEMENT'),
(9, 'ÉLECTRONIQUE'),
(10, 'ALLUMAGE'),
(11, 'ESSUIE-GLACE'),
(12, 'FREINAGE'),
(13, 'REFROIDISSEMENT');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_name`, `topic_id`, `content`, `created_at`) VALUES
(51, 'Enzo', 76, 'Yes je peux t\'aider', '2024-04-07 13:31:00'),
(52, 'Jean', 76, 'Super ça, l\'ancien proprio m\'a dit qu\'il fallait le refaire de A à Z c\'est sur un moteur célon 1.1', '2024-04-07 13:34:16');

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id`, `user_name`, `name`, `category`, `description`, `brand`, `created_at`) VALUES
(75, 'Enzo', 'Probleme turbo 335d e92', 'DISTRIBUTION', 'Lors de l\'accélération mon turbo ne tourne pas ', 'BMW', '2024-04-06 08:17:27'),
(76, 'Jean', 'BESOIN AIDE ALLUMAGE 4L', 'ALLUMAGE', 'Bonjour je viens d\'acheter une 4L, mais j\'ai besoin de refaire l\'allumage. J\'ai besoin de votre aide merci.', 'Renault', '2024-04-07 13:28:35'),
(77, 'Jean', 'Filtre à huile', 'VIDANGE', 'Bonjour quel est le meilleur filtre à huile pour une audi A4 2.0 TDI? ', 'Audi', '2024-04-07 13:30:14'),
(78, 'Enzo', 'PROJET TURBO SUR TWINGO 2 RS', 'SURALIMENTATION', 'Bonjour je possède une T2 RS et je souhaite faire un projet turbo dessus, j\'ai quelques questions à ce sujet...', 'Renault', '2024-04-07 13:32:24');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `status`) VALUES
(17, 'Kilian', 'kilian@kilian.net', '$2y$10$K4aKxJApKm1asuTz5LcPPeHXTTSTqwgXNGvl.2DHzWxKSmU5kI1V2', '2024-04-04 11:22:50', 1),
(18, 'Enzo', 'enzo@enzo.net', '$2y$10$BE6jK2FxoXpiQXfVMMUEw.B43t6Y6hgPHIH4y9yDly9DKsOeEfTdy', '2024-04-04 12:32:17', 0),
(19, 'Jean', 'jean@jean.net', '$2y$10$ADlKvIa9N1Fmz6yDFH910.Xs7fv/aHUdQ.pcv12EktKlhYLuu/k4a', '2024-04-07 13:27:10', 0);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `brand`) VALUES
(1, 'Abarth'),
(2, 'AC\r\n'),
(3, 'Acura\r\n'),
(4, 'Aixam\r\n'),
(5, 'Alfa Romeo\r\n'),
(6, 'Alpina'),
(7, 'Aston Martin'),
(8, 'Audi'),
(9, 'Austin'),
(10, 'Bentley'),
(11, 'BMW'),
(12, 'Cadillac'),
(13, 'Caterham'),
(14, 'Chevrolet'),
(15, 'Chrysler'),
(16, 'Citroën'),
(17, 'Cupra'),
(18, 'Dacia'),
(19, 'Dodge'),
(20, 'DS'),
(21, 'Ferrari'),
(22, 'Fiat'),
(23, 'Ford'),
(24, 'GMC'),
(25, 'Honda'),
(26, 'Hyundai'),
(27, 'Infiniti'),
(28, 'Isuzu'),
(29, 'Jaguar'),
(30, 'Jeep'),
(31, 'KIA'),
(32, 'KTM'),
(33, 'Lada'),
(34, 'Lamborghini'),
(35, 'Lancia'),
(36, 'Land Rover'),
(37, 'Lexus'),
(38, 'Lotus'),
(39, 'Maserati'),
(40, 'Mazda'),
(41, 'Mercedes-Benz'),
(42, 'MG'),
(43, 'Mini'),
(44, 'Mitsubishi'),
(45, 'Nissan'),
(46, 'Opel'),
(47, 'Peugeot'),
(48, 'Pontiac'),
(49, 'Porsche'),
(50, 'Renault'),
(51, 'Rolls-Royce'),
(52, 'Rover'),
(53, 'Saab'),
(54, 'Seat'),
(55, 'Skoda'),
(56, 'Smart'),
(57, 'Subaru'),
(58, 'Suzuki'),
(59, 'Tesla'),
(60, 'Toyota'),
(61, 'TVR'),
(62, 'Vauxhall'),
(63, 'Volvo'),
(64, 'Volkswagen');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Index pour la table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `REL_TOPIC` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
