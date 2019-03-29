-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 29 mars 2019 à 15:02
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `chapo`, `content`, `publication_date`, `update_date`, `author_id`, `update_by`) VALUES
(2, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel tellus et quam eleifend aliquet at a leo. Praesent feugiat fringilla risus, non gravida quam bibendum ut.', 'Vivamus non scelerisque sem. Ut aliquam sem sapien, et egestas nulla vestibulum vel. Nunc maximus imperdiet posuere. Donec consectetur risus et mattis vehicula. Maecenas efficitur enim placerat, feugiat metus sit amet, consequat nulla. Phasellus tristique sapien eu congue placerat. Duis consectetur semper ligula mollis pretium. Sed at ex nunc. Integer eu nunc quis arcu rhoncus feugiat quis quis augue. Ut suscipit metus ut velit rhoncus, eu rutrum elit varius. Ut vestibulum dui id ante convallis, interdum blandit diam ullamcorper.&nbsp;', '2019-03-13 13:29:50', NULL, 13, NULL),
(8, 'Lorem Ipsum test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mollis euismod nulla, quis rhoncus mauris tincidunt in. In egestas pretium mauris, in luctus sapien bibendum non. Aenean consectetur, leo a tincidunt vestibulum, diam mauris finibus mi, ac malesuada lorem ligula at justo. Test.', 'Proin semper blandit justo. Nullam a posuere nisl, ut porttitor nisl. Nulla euismod aliquam eleifend. Nunc tortor nunc, mattis a consectetur lobortis, pellentesque vitae mauris. Donec eget justo augue. Suspendisse convallis mauris a purus bibendum faucibus. Aenean vitae dui lacinia, laoreet diam vel, finibus risus. Quisque ut metus nisl. Suspendisse mauris quam, finibus eu purus sed, congue porta metus. Test.', '2019-03-22 12:55:58', NULL, 13, NULL),
(9, 'test', 'test', 'test', '2019-03-22 00:00:00', NULL, 13, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `comments`, `author`, `comment_date`, `validated`, `article_id`) VALUES
(1, 'test', 'test', '2019-03-15 15:55:55', 0, 2),
(6, 'test', 'test4', '2019-03-27 00:00:00', 0, 9),
(8, 'test', 'test4', '2019-03-27 00:00:00', 0, 8);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `email_token`, `password`, `register_at`, `connexion_at`, `rank`) VALUES
(13, 'test4', 'test4@yopmail.com', NULL, '$2y$12$JLK/.vZ8bFDxlVzsB6qTneIMNZ3ZoAOX4aW84GUIANSveZ3tlNftW', '2019-02-21 16:25:44', NULL, 2),
(14, 'admin', 'admin@yostmail.com', NULL, '$2y$12$IHn17ojgnBmrVkxLryKYmeQGBU0MQAE90SmdoDhnSGSp2CdCS3LS2', '2019-03-20 14:58:57', NULL, 3);

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
