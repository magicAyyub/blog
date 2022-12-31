-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 30 déc. 2022 à 23:30
-- Version du serveur : 8.0.31
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`) VALUES
(2, 'L&eacute;gumes', 'Ceci est la cat&eacute;gorie d&eacute;di&eacute;e aux articles li&eacute;s aux l&eacute;gumes'),
(3, 'Sport', 'Cette cat&eacute;gorie concerne tous post en rapport avec le sport.'),
(4, 'Intelligence Artificiel', 'Cette cat&eacute;gorie concerne tous les articles en rapport avec l&#039;IA'),
(5, 'Sant&eacute;', 'Cette cat&eacute;gorie concerne tous les articles en rapport avec la sant&eacute;'),
(6, 'autres', 'cette cat&eacute;gorie concerne tous les posts qui n&#039;ont pas &eacute;t&eacute; class&eacute; dans des cat&eacute;gories'),
(7, 'V&ecirc;tements', 'Cette cat&eacute;gorie concerne tous les posts qui concerne les v&ecirc;tements, le fashion...');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `thumbnail`, `date_time`, `category_id`, `user_id`, `is_featured`) VALUES
(13, 'Test', 'ceci est un test', '1670354835home.png', '2022-12-06 19:27:15', 2, 2, 0),
(16, 'Faire &ccedil;a &agrave; un joueur qui a tant donn&eacute; pour son pays une honte pour le portugal', 'Une honte pour les portugais, d&eacute;nigr&eacute; &agrave; ce point un joeur exceptionnel qui a tant donn&eacute; pour son &eacute;quipe :(', '1670793251ronaldo.png', '2022-12-11 21:14:11', 3, 2, 1),
(17, 'Python &eacute;crase tous ses concurrents ce g&eacute;ant ne finit pas de nous impressionn&eacute;', 'Python cette fois &agrave; compl&egrave;tement explos&eacute; les records. Il est le langage le plus utilis&eacute; par les data scientists et est entrain de s&#039;imisser dans tous les domaines. tant t&ocirc;t dans le web, le developpement mobile, logiciel et bien d&#039;autres.', '1670794242python.png', '2022-12-11 21:30:42', 4, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `avatar`, `is_admin`) VALUES
(2, 'ayyub', 'ayoub', 'ayyub', 'ayouba@gmail.com', '$2y$10$oSgQ.8gowot7I3b/6NxBZOqgSrfAlmxa1N2c7wVCbGpTuO3N185u6', '1670254392fox.png', 1),
(5, 'jigen', 'jigen', 'jigen', 'jigen01@gmail.com', '$2y$10$5xPImPBYvHN0oe8HvEcAzu7beXiDMrBc5czNr5B.Q/nRHWnFITQtC', '1670355829WhatsApp Image 2022-11-17 à 02.31.20.jpg', 0),
(6, 'impact', 'Genshin', 'juju', 'GenshinImpact@gmail.com', '$2y$10$Kzd92nxVnA0hpHcLoXcUmexM87g3hu53EelHYZ7jkZKbf699jOysK', '1670425565js.png', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
