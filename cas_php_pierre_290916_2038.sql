-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 29 Septembre 2016 à 18:37
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cas_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `difficulties`
--

CREATE TABLE `difficulties` (
  `id` int(11) NOT NULL,
  `differenceName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `eventcategory`
--

CREATE TABLE `eventcategory` (
  `idEventCategory` int(11) NOT NULL,
  `category` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `idEvent` int(11) NOT NULL,
  `description` text NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `maxParticipants` int(11) NOT NULL,
  `fk_idEventType` int(11) NOT NULL,
  `fk_idOwner` int(11) NOT NULL,
  `title` text NOT NULL,
  `fk_idEventCategory` int(11) NOT NULL,
  `fk_idDifficulty` int(11) NOT NULL,
  `fk_idPath` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `eventtypes`
--

CREATE TABLE `eventtypes` (
  `idEventType` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `eventusers`
--

CREATE TABLE `eventusers` (
  `fk_idEvent` int(11) NOT NULL,
  `fk_idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `password_change_requests`
--

CREATE TABLE `password_change_requests` (
  `idRequest` varchar(100) NOT NULL,
  `Time` datetime NOT NULL,
  `fk_idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `password_change_requests`
--

INSERT INTO `password_change_requests` (`idRequest`, `Time`, `fk_idUser`) VALUES
('7358b98cd217979862e1628a699c3003f804cae6', '2016-09-29 20:14:13', 1);

-- --------------------------------------------------------

--
-- Structure de la table `paths`
--

CREATE TABLE `paths` (
  `idPath` int(11) NOT NULL,
  `coordinatesJSON` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `pwd` varchar(256) NOT NULL,
  `fk_idUserTypes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUser`, `mail`, `firstname`, `lastname`, `tel`, `pwd`, `fk_idUserTypes`) VALUES
(1, 'lothgar_pgm@hotmail.com', 'Pierre', 'Baran', '793943353', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2),
(2, 'a@a', 'a', 'a', '041241', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2),
(4, 'pierre.baran@students.hevs.ch', 'a', 'a', '423423', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3);

-- --------------------------------------------------------

--
-- Structure de la table `usertypes`
--

CREATE TABLE `usertypes` (
  `idUserType` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `usertypes`
--

INSERT INTO `usertypes` (`idUserType`, `role`) VALUES
(1, 'nonMember'),
(2, 'member'),
(3, 'trailMaster');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `difficulties`
--
ALTER TABLE `difficulties`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `eventcategory`
--
ALTER TABLE `eventcategory`
  ADD PRIMARY KEY (`idEventCategory`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`idEvent`),
  ADD KEY `fk_idEventType` (`fk_idEventType`),
  ADD KEY `fk_idOwner` (`fk_idOwner`),
  ADD KEY `fk_idEventCategory` (`fk_idEventCategory`),
  ADD KEY `fk_idDifficulty` (`fk_idDifficulty`),
  ADD KEY `idPath` (`fk_idPath`);

--
-- Index pour la table `eventtypes`
--
ALTER TABLE `eventtypes`
  ADD PRIMARY KEY (`idEventType`);

--
-- Index pour la table `eventusers`
--
ALTER TABLE `eventusers`
  ADD PRIMARY KEY (`fk_idEvent`,`fk_idUser`),
  ADD KEY `fk_idEvent` (`fk_idEvent`),
  ADD KEY `fk_idUser` (`fk_idUser`);

--
-- Index pour la table `password_change_requests`
--
ALTER TABLE `password_change_requests`
  ADD PRIMARY KEY (`idRequest`),
  ADD KEY `fk_idUser` (`fk_idUser`);

--
-- Index pour la table `paths`
--
ALTER TABLE `paths`
  ADD PRIMARY KEY (`idPath`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `fk_idUserTypes` (`fk_idUserTypes`);

--
-- Index pour la table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`idUserType`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `difficulties`
--
ALTER TABLE `difficulties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `eventcategory`
--
ALTER TABLE `eventcategory`
  MODIFY `idEventCategory` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `idEvent` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `eventtypes`
--
ALTER TABLE `eventtypes`
  MODIFY `idEventType` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `paths`
--
ALTER TABLE `paths`
  MODIFY `idPath` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `idUserType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `Events_ibfk_1` FOREIGN KEY (`fk_idEventType`) REFERENCES `eventtypes` (`idEventType`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Events_ibfk_2` FOREIGN KEY (`fk_idOwner`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Events_ibfk_3` FOREIGN KEY (`fk_idEventCategory`) REFERENCES `eventcategory` (`idEventCategory`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Events_ibfk_4` FOREIGN KEY (`fk_idDifficulty`) REFERENCES `difficulties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Events_ibfk_5` FOREIGN KEY (`fk_idPath`) REFERENCES `paths` (`idPath`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `eventusers`
--
ALTER TABLE `eventusers`
  ADD CONSTRAINT `EventUsers_ibfk_1` FOREIGN KEY (`fk_idEvent`) REFERENCES `events` (`idEvent`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `EventUsers_ibfk_2` FOREIGN KEY (`fk_idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `password_change_requests`
--
ALTER TABLE `password_change_requests`
  ADD CONSTRAINT `password_change_requests_ibfk_1` FOREIGN KEY (`fk_idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_idUserTypes`) REFERENCES `usertypes` (`idUserType`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
