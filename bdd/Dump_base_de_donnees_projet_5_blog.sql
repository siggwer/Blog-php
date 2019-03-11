-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 11 mars 2019 à 12:49
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
  `update_date` datetime DEFAULT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_article` (`author_id`),
  KEY `index_date_article` (`publication_date`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `chapo`, `content`, `publication_date`, `update_date`, `author_id`, `update_by`) VALUES
(1, 'L&#39;homme doit explorer, et c&#39;est l&#39;exploration à son meilleur', 'Les problèmes semblent puissants à partir de 150 miles', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec suscipit neque id diam convallis consectetur. In hac habitasse platea dictumst. Praesent commodo est nisl, a mattis velit dignissim non. Proin ultricies arcu sit amet finibus gravida. Quisque porta leo accumsan accumsan efficitur. Sed metus libero, suscipit vitae interdum a, suscipit pellentesque lacus. Sed ac augue eu quam scelerisque ornare. Aliquam sed tellus lobortis, mattis turpis sed, consequat ipsum. Vivamus rutrum neque nibh, non gravida velit semper ut.', '2019-02-27 16:25:46', NULL, 13, NULL);

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
  `article_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_article_id_idx` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `email_token`, `password`, `register_at`, `connexion_at`, `rank`) VALUES
(4, 'admin', 'admin@yostmail.com', NULL, '$2y$12$255mUws1dmzCIGPat1a2TuxPZqk6KZXSnIWscV2mzZfbqQ58dciB.', '2019-01-18 21:10:00', NULL, 2),
(13, 'test4', 'test4@yopmail.com', NULL, '$2y$12$JLK/.vZ8bFDxlVzsB6qTneIMNZ3ZoAOX4aW84GUIANSveZ3tlNftW', '2019-02-21 16:25:44', NULL, 2);

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
