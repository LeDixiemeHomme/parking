-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 26 Mai 2019 à 15:42
-- Version du serveur :  5.7.26-0ubuntu0.16.04.1
-- Version de PHP :  7.0.33-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `parking`
--

-- --------------------------------------------------------

--
-- Structure de la table `duree_reservation`
--

CREATE TABLE `duree_reservation` (
  `duree` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `duree_reservation`
--

INSERT INTO `duree_reservation` (`duree`) VALUES
('PT3H');

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

CREATE TABLE `place` (
  `id_p` int(11) NOT NULL,
  `num_p` varchar(255) DEFAULT NULL,
  `etat_p` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `place`
--

INSERT INTO `place` (`id_p`, `num_p`, `etat_p`) VALUES
(1, 'n°1', 1),
(2, 'n°2', 1),
(3, 'n°3', 1),
(4, 'n°4', 1),
(6, 'n°6', 1),
(7, 'n°7', 1),
(8, 'n°8', 1),
(9, 'n°9', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_r` int(11) NOT NULL,
  `date_resa` datetime DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `id_u` int(11) DEFAULT NULL,
  `id_p` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reservation`
--

INSERT INTO `reservation` (`id_r`, `date_resa`, `date_debut`, `date_fin`, `id_u`, `id_p`) VALUES
(3, '2019-05-23 11:03:25', '2019-05-23 11:03:25', '2019-05-23 13:03:25', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_u` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `niveau` int(1) DEFAULT '1',
  `etat_u` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_u`, `nom`, `prenom`, `mail`, `mdp`, `niveau`, `etat_u`) VALUES
(1, 'nom_admin', 'pre_admin', 'admin@admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 3, 1),
(2, 'n_uti_1', 'p_uti_1', 'mail1@mail1', '7373c4286633127542e5c2be2e032aa0498d80b2', 2, 1),
(3, 'n_uti_2', 'p_uti_2', 'mail2@mail2', 'f747c08c69f65afea969fe3f2da053a192f01d81', 2, 1),
(4, 'n_uti_3', 'p_uti_3', 'mail3@mail3', '06c5e5c9547af51d43aad1d6402bf4d2ae3ccc37', 2, 1),
(5, 'n_util_4', 'p_uti_4', 'mail4@mail4', 'f886993e9b022adcde7a2f1d7e26db221b91a9cc', 2, 1),
(6, 'n_util_5', 'p_uti_5', 'mail5@mail5', '8a587d3287cc27b6802b5bc49c46ef780623a178', 2, 1),
(7, 'benoit', 'valle', 'ben@valle', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 1, 1),
(8, 'n_util_7', 'p_util_7', 'mail7@mail7', '9931b971b844289e40880a607b990aea708480db', 0, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id_p`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_r`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `id_p` (`id_p`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_u`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `place`
--
ALTER TABLE `place`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_r` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `users` (`id_u`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_p`) REFERENCES `place` (`id_p`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
