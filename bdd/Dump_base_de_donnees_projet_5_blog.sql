-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 19 avr. 2019 à 10:48
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

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
  `update_date` datetime DEFAULT NULL,
  `author_id` int(10) UNSIGNED DEFAULT NULL,
  `update_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_article` (`author_id`),
  KEY `index_date_article` (`publication_date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `chapo`, `content`, `publication_date`, `update_date`, `author_id`, `update_by`) VALUES
(16, 'Comment créer un blog gratuit', 'tutoriel pas à pas pour réussir !', 'Que vous envisagiez d’ouvrir votre blog ou d’améliorer le vôtre, il est temps pour vous de devenir de véritables experts dans le domaine. Pour y parvenir, vous n’avez qu’une solution: vous documenter sur le sujet. Puis expérimenter.Cette démarche scientifique, vous pouvez la réaliser tout seul dans votre coin. Ou bénéficier de nos propres conseils, études, remarques… et expériences! Bienvenue dans l’univers de la recherche internet 4.0! Le blog doit être pensé aujourd’hui comme un outil au service de votre business. Il permet de valoriser votre savoir-faire et votre expérience, tout en vous permettant de remonter dans les premiers résultats de Google sur des requêtes spécifiques. Source : Blog neocamino', '2019-04-16 14:05:54', NULL, 16, NULL),
(17, 'Quels outils pour développer', 'en PHP sous Windows ?', 'Les outils liés à la conception et aux développements informatiques sont légions. La composition de son environnement de travail &nbsp;est très importante puisque de la performance des outils dépendent la productivité et l’efficacité du développeur. Que vous ayez déjà vos outils ou que vous soyez en recherche des vôtres, cet article liste les principaux outils que j’utilise pour développer en PHP sous Windows.C’est la liste des logiciels gratuits et payants qui constituent mon poste de développement. N’hésitez pas à décrire vos outils de développement en commentaire, que vous soyez sous Windows, sous Mac ou sous Unix.Source : Blog PHP de Nicolas Hachet', '2019-04-19 11:30:57', NULL, 16, NULL);

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
  `validated` tinyint(3) UNSIGNED DEFAULT '0',
  `article_id` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_article_id_idx` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `comments`, `author`, `comment_date`, `validated`, `article_id`) VALUES
(2, 'test', 'test1', '2019-04-19 11:31:30', 1, 17);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `email_token` varchar(255) DEFAULT NULL,
  `password` char(255) NOT NULL,
  `register_at` datetime DEFAULT NULL,
  `connexion_at` datetime DEFAULT NULL,
  `rank` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `email_token`, `password`, `register_at`, `connexion_at`, `rank`) VALUES
(15, 'admin', 'test@yopmail.com', NULL, '$2y$12$1Ml36shti5Ds6IbYc9MYjOFsV.wb4Fykhd6I/bY6cqCRVq4G72qxa', '2019-04-15 15:09:41', NULL, 3),
(16, 'test1', 'test1@yopmail.com', NULL, '$2y$12$U.OXHzWlyHkCA.9e4/4WLeF/gqWzehPDPmE.YlUWKS95pMV5CGHHm', '2019-04-16 13:36:48', NULL, 2),
(17, 'test2', 'test2@yopmail.com', NULL, '$2y$12$Wg/YirBbv5HExPwMS5JpbOq//WTCqSzomOz2w2rGblrxp4xsNIi1a', '2019-04-18 11:44:55', NULL, 2),
(18, 'test3', 'test3@yopmail.com', NULL, '$2y$12$r6.1RwN3Ng7Yf8Rs/plC4ecnP6f/mBVLuOrFaIYYFwryrHDdK1Pt6', '2019-04-19 12:46:36', NULL, 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_user_article` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
