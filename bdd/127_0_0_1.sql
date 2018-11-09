-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 31 août 2018 à 13:56
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `chapo` text NOT NULL,
  `content` text NOT NULL,
  `publication_date` datetime NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_article` (`author_id`),
  KEY `index_date_article` (`publication_date`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `chapo`, `content`, `publication_date`, `author_id`) VALUES
(1, 'L\'homme doit explorer, et c\'est l\'exploration à son meilleur', 'Les problèmes semblent puissants à partir de 150 miles', 'Lorem ipsum', '2018-04-19 00:00:00', 1),
(2, 'Je crois que chaque humain a un nombre fini de battements de coeur. Je n\'ai pas l\'intention de perdre l\'un des miens.', 'Lorem ipsum', 'lorem ipsum', '2018-04-20 00:00:00', 2),
(3, 'La science n\'a pas encore maîtrisé la prophétie', 'Nous prédisons trop pour l\'année prochaine et encore trop peu pour les dix prochaines.', 'Lorem ipsum', '2018-04-23 00:00:00', 1),
(4, 'L\'échec n\'est pas une option\r\n', 'Beaucoup disent que l\'exploration fait partie de notre destin, mais c\'est en fait notre devoir envers les générations futures.', 'Lorem ipsum', '2018-04-23 00:00:00', 2),
(5, 'test 2', 'test2', 'test 2', '2018-04-26 00:00:00', 1),
(6, 'test 3', 'test 3', 'test 3', '2018-04-26 00:00:00', 2),
(7, 'test 2', 'test 2', 'test 2', '2018-04-26 00:00:00', 1),
(8, 'test 3', 'test 3', 'test 3', '2018-04-26 00:00:00', 2),
(9, 'test 4', 'test 4', 'test 4', '2018-04-27 00:00:00', 1),
(10, 'test 5', 'test 5', 'test 5', '2018-04-27 00:00:00', 2),
(11, 'test 6', 'test 6', 'test 6', '2018-04-27 00:00:00', 1),
(12, 'test 7', 'test 7', 'test 7', '2018-04-27 00:00:00', 2),
(13, 'test 8', 'test 8', 'test 8', '2018-04-27 00:00:00', 1),
(15, 'test 5', 'test 5', 'test 5', '2018-04-27 00:00:00', 2),
(16, 'test 6', 'test 6', 'test 6', '2018-04-27 00:00:00', 1),
(17, 'test 7', 'test 7', 'test 7', '2018-04-27 00:00:00', 2),
(18, 'test 8', 'test 8', 'test 8', '2018-04-27 00:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comments` text NOT NULL,
  `author` varchar(45) NOT NULL,
  `comment_date` datetime NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_article_id_idx` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `comments`, `author`, `comment_date`, `article_id`) VALUES
(1, 'Test', 'test', '2018-04-25 00:00:00', 3),
(2, 'test', 'test', '2018-06-01 17:20:34', 9);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` char(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`) VALUES
(1, 'test', 'test@test.com', 'test'),
(2, 'test1', 'test1@test.com', 'test1');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_user_article` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
