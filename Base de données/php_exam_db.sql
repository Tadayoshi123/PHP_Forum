-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 23 jan. 2022 à 19:41
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_exam_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `AdminId` int(11) NOT NULL,
  `AdminName` varchar(80) NOT NULL,
  `Password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`AdminId`, `AdminName`, `Password`) VALUES
(1, 'root', '$2y$10$CbhaIKx0C0C8rL1v/VsAQult6x5l96Q3ixG7dEG7zoiCeWjiA2nY2'),
(2, 'test', '$2y$10$sr604.MkU6cghpIXwT037eKiw1zxEZNZ.0FXWzDC0W08G5a7bbzKi'),
(3, 'test2', '$2y$10$nEUUFS5J0AWdjlsVZX.iROhdvLw/TxAXCVbQISi5E7q9QNJ2Q3Gpe'),
(4, 'test3', '$2y$10$Yfd8rAkZLJLFNJu/dEqc0.tcu4FeylCOjG.oXYz4GyOeci2q.Muv.');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `ArticleId` int(11) NOT NULL,
  `Title` varchar(80) NOT NULL,
  `Description` varchar(80) NOT NULL,
  `CreationDate` date NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`ArticleId`, `Title`, `Description`, `CreationDate`, `UserId`) VALUES
(11, 'titre2', 'test\r\n', '2022-01-12', 4),
(12, 'title1', 'description1', '2022-01-12', 4),
(13, 'title2', 'description2', '2022-01-12', 4),
(14, 'test3', 'desciption3\r\n', '2022-01-12', 4),
(16, 'test', 'test\r\n²', '2022-01-12', 3),
(25, 'fsefse', 'fsefsfe', '2022-01-23', 3),
(26, 'dzqdzqdqzddddddddddddddddddddddddddddddddddd', 'dqzdqzddqzd', '2022-01-23', 3),
(27, 'dqzd', 'dqzd', '2022-01-23', 3),
(28, 'dzqdqz', 'dqzdqz', '2022-01-23', 3);

-- --------------------------------------------------------

--
-- Structure de la table `favourites`
--

CREATE TABLE `favourites` (
  `FavouriteId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `ArticleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `favourites`
--

INSERT INTO `favourites` (`FavouriteId`, `UserId`, `ArticleId`) VALUES
(150, 5, 17),
(151, 5, 11),
(152, 5, 11),
(156, 4, 12),
(158, 3, 28),
(159, 3, 16);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `ImageId` int(11) NOT NULL,
  `ImageBlob` blob NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(80) NOT NULL,
  `Email` varchar(80) NOT NULL,
  `Password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `Email`, `Password`) VALUES
(3, 'test', 'test@test', '$2y$10$qH6JfsX0hzTKDyz4REmOLOAm525R8YHPu6DIZNn3xSn0xps8tIVIm'),
(4, 'test2', 'test2@test', '$2y$10$rUCvJ41H6sIX6ZH2fACAU.GTpCuAfPjcEP6z6FSolS79ZOyD6xqOu');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminId`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ArticleId`);

--
-- Index pour la table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`FavouriteId`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ImageId`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `ArticleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `FavouriteId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
