-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 03 2018 г., 22:05
-- Версия сервера: 5.6.15-log
-- Версия PHP: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `loumamaison`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appartement`
--

CREATE TABLE IF NOT EXISTS `appartement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `options` varchar(1000) DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `descriptif` varchar(2000) NOT NULL,
  `montantParJour` float NOT NULL,
  `nbPersonnes` int(11) NOT NULL,
  `nbLits` int(11) NOT NULL,
  `nbChambres` int(11) NOT NULL,
  `photoPrincipale` varchar(255) NOT NULL,
  `noApt` varchar(25) DEFAULT NULL,
  `noCivique` int(11) NOT NULL,
  `rue` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT 'Montréal',
  `codePostal` varchar(255) NOT NULL,
  `id_typeApt` int(11) NOT NULL,
  `id_userProprio` varchar(255) NOT NULL,
  `id_nomQuartier` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_appartement_id_typeApt` (`id_typeApt`),
  KEY `FK_appartement_id_userProprio` (`id_userProprio`),
  KEY `FK_appartement_id_nomQuartier` (`id_nomQuartier`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `appartement`
--

INSERT INTO `appartement` (`id`, `actif`, `options`, `titre`, `descriptif`, `montantParJour`, `nbPersonnes`, `nbLits`, `nbChambres`, `photoPrincipale`, `noApt`, `noCivique`, `rue`, `ville`, `codePostal`, `id_typeApt`, `id_userProprio`, `id_nomQuartier`) VALUES
(1, 1, 'wifi=checked&cintres=checked', 'maison de bois', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 200, 2, 1, 1, './images/profil.jpg', '4', 11969, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 1),
(2, 1, 'wifi=checked&cintres=checked', 'maison en brique', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 50, 5, 2, 2, './images/profil.jpg', '300', 2030, 'Pie IX', 'Montréal', 'H1G 3V9', 2, 'yul', 4),
(3, 1, 'wifi=checked&cintres=checked', 'maison en paille', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 50, 2, 1, 6, './images/profil.jpg', '4', 11979, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 3),
(4, 1, 'wifi=checked&cintres=checked', 'maison en carton', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 100, 5, 6, 1, './images/profil.jpg', '302', 2030, 'bélanger', 'Montréal', 'H1G 3V9', 2, 'yul', 2),
(5, 1, 'wifi=checked&cintres=checked', 'maison de bois 2', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 200, 2, 1, 1, './images/profil.jpg', '4', 2030, 'bellechasse', 'Montréal', 'H1G 3V9', 1, 'nat', 1),
(6, 1, 'wifi=checked&cintres=checked', 'maison en brique 2', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 50, 5, 2, 2, './images/profil.jpg', '300', 4218, 'rudy', 'Montréal', 'H1G 3V9', 2, 'yul', 4),
(7, 1, 'wifi=checked&cintres=checked', 'maison en paille 2', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 50, 2, 1, 6, './images/profil.jpg', '4', 11979, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 3),
(8, 1, 'wifi=checked&cintres=checked', 'maison en carton 2', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 100, 5, 6, 1, './images/profil.jpg', '302', 11960, 'rolland', 'Montréal', 'H1G 3V9', 2, 'yul', 2),
(9, 1, 'wifi=checked&cintres=checked', 'maison de bois 3', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 200, 2, 1, 1, './images/profil.jpg', '4', 11969, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 1),
(10, 1, 'wifi=checked&cintres=checked', 'maison en brique 3', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 50, 5, 2, 2, './images/profil.jpg', '300', 11970, 'Pie IX', 'Montréal', 'H1G 3V9', 2, 'yul', 4),
(11, 1, 'wifi=checked&cintres=checked', 'maison en paille 3', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 50, 2, 1, 6, './images/profil.jpg', '4', 11979, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 3),
(12, 1, 'wifi=checked&cintres=checked', 'maison en carton 3', 'description de l''appartement bbbbabbabbababab ffff arrararara ssss.', 100, 5, 6, 1, './images/profil.jpg', '302', 11960, 'rolland', 'Montréal', 'H1G 3V9', 2, 'yul', 2),
(13, 1, 'wifi=checked&cintres=checked&fer+%C3%A0+repasser=checked', 'Le titre mmmmm', 'oooooo ooooo oo o ', 50, 2, 1, 1, './images/profil.jpg', NULL, 1025, 'DeBellechasse', 'Montréal', 'H2S1Y4', 1, 'salim', 14),
(14, 1, NULL, 'TTTTTTTTTT', 'oooooo ooo oo o o ', 70, 2, 1, 1, './images/profil.jpg', NULL, 32, 'Beaubien', 'Montréal', 'h2h2h2', 3, 'nat', 17),
(15, 1, 'Options-Associées', 'Superbe Loft disponible', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 123, 4, 2, 1, './images/apt01-01.png', '501', 51, 'St-Paul', 'Montréal', 'G1Q 1Q9', 1, 'renaud', 7),
(16, 1, 'Options-Associées', 'Merveilleux Condo', 'Nunc luctus enim ligula, a tincidunt nunc ultricies eget.', 98, 2, 1, 1, './images/apt02-01.png', '201', 781, 'Rue de la Commune', 'Montréal', 'H2G 3P5', 3, 'nat', 7),
(17, 1, 'Options-Associées', 'Loft affordant', 'Nam tincidunt ex turpis, in molestie ipsum pretium sed.', 87, 4, 2, 2, './images/apt03-01.png', '32', 448, 'Place Jacques-Cartier', 'Montréal', 'H1G 4L8', 1, 'yul', 7),
(18, 1, 'Options-Associées', 'Magnifique Condo', 'Quisque finibus, odio ac congue malesuada, mi lectus tempus mi, in condimentum sem justo feugiat lorem.', 63, 4, 2, 2, './images/apt04-01.png', '107', 3745, 'Rue Masson', 'Montréal', 'H1G 4L8', 1, 'salim', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `communication`
--

CREATE TABLE IF NOT EXISTS `communication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moyenComm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `communication`
--

INSERT INTO `communication` (`id`, `moyenComm`) VALUES
(1, 'skype'),
(2, 'e-mail'),
(3, 'facebook'),
(4, 'texto');

-- --------------------------------------------------------

--
-- Структура таблицы `disponibilite`
--

CREATE TABLE IF NOT EXISTS `disponibilite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `disponibilite` tinyint(1) NOT NULL DEFAULT '1',
  `id_appartement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_disponibilite_id_appartement` (`id_appartement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `disponibilite`
--

INSERT INTO `disponibilite` (`id`, `dateDebut`, `dateFin`, `disponibilite`, `id_appartement`) VALUES
(1, '2018-02-23', '2018-03-04', 1, 18),
(2, '2018-02-23', '2018-03-31', 1, 17),
(3, '2018-02-23', '2018-03-31', 1, 16),
(4, '2018-02-23', '2018-03-31', 1, 15);

-- --------------------------------------------------------

--
-- Структура таблицы `evaluation`
--

CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` int(11) NOT NULL,
  `commentaire` text,
  `dateNotif` date NOT NULL,
  `id_appartement` int(11) NOT NULL,
  `id_username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_evaluation_id_appartement` (`id_appartement`),
  KEY `FK_evaluation_id_username` (`id_username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `evaluation`
--

INSERT INTO `evaluation` (`id`, `rating`, `commentaire`, `dateNotif`, `id_appartement`, `id_username`) VALUES
(1, 10, NULL, '2018-02-28', 1, 'nat'),
(2, 10, NULL, '2018-02-27', 18, 'renaud'),
(3, 7, NULL, '2018-02-25', 2, 'salim'),
(4, 1, NULL, '2018-02-28', 3, 'salim'),
(5, 8, NULL, '2018-02-18', 17, 'renaud'),
(6, 5, NULL, '2018-02-24', 4, 'yul'),
(9, 4, NULL, '2018-02-23', 5, 'salim'),
(10, 7, NULL, '2018-02-24', 15, 'renaud');

-- --------------------------------------------------------

--
-- Структура таблицы `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `valideParPrestataire` tinyint(1) NOT NULL DEFAULT '0',
  `validePaiement` tinyint(1) NOT NULL DEFAULT '0',
  `id_userClient` varchar(255) NOT NULL,
  `id_appartement` int(11) NOT NULL,
  `nbPersonnes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_location_id_userClient` (`id_userClient`),
  KEY `FK_location_id_appartement` (`id_appartement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `sujet` varchar(2000) NOT NULL,
  `dateHeure` datetime NOT NULL,
  `id_userEmetteur` varchar(255) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_message_id_userEmetteur` (`id_userEmetteur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `titre`, `sujet`, `dateHeure`, `id_userEmetteur`, `archive`) VALUES
(1, '1111111', '1111111', '2018-03-01 00:00:00', 'nat', 0),
(2, '222222222222222', '222222222222222', '2018-03-09 00:00:00', 'Nouveau00', 0),
(29, 're: 1111111', 'zzzzzzzzzz', '2018-03-02 14:39:27', 'salim', 1),
(30, 're: 1111111', 'wwwwwwwwwww', '2018-03-02 14:41:58', 'salim', 1),
(31, 're: 1111111', '22222222222222222222', '2018-03-02 14:42:25', 'salim', 1),
(32, 'rrrrrrrrrrrrrr', '333333333', '2018-03-02 14:43:14', 'salim', 0),
(33, 'sadaddd', 'rrrrrrrrrrrrrrrrrrr', '2018-03-02 14:46:13', 'salim', 1),
(35, 'rien', 'rienssssssssss', '2018-03-02 20:00:18', 'salim', 0),
(39, 'gggggg', 'rrrrrggggg', '2018-03-03 01:26:03', 'salim', 1),
(40, 're: re: 1111111', 'ssssssssssssssssssssssssss', '2018-03-03 01:26:32', 'salim', 1),
(41, 're: sadaddd', 'assssssssssss', '2018-03-03 01:27:08', 'salim', 1),
(42, 're: re: 1111111', 'hhhhhhhhhhhh', '2018-03-03 01:40:25', 'salim', 1),
(43, '54', 'asssasas', '2018-03-03 01:40:53', 'salim', 1),
(44, 'trien', 'trien', '2018-03-03 01:51:58', 'salim', 0),
(45, 'sadaddd', 'rhrfhfh', '2018-03-03 02:03:56', 'salim', 0),
(46, 'rrrrrrrrrrrrrr', 'sfsfsfsfsfsf', '2018-03-03 02:05:48', 'salim', 0),
(47, 'dgdgdg', 'dgdgdgdgdg', '2018-03-03 02:07:18', 'salim', 0),
(48, 'rrrrrrrrrrrrrr', 'cxvsxvxvxv', '2018-03-03 02:08:02', 'salim', 0),
(49, 'teeeest', 'teessst', '2018-03-03 11:16:21', 'salim', 0),
(50, 'salut', 'salut le terrien', '2018-03-03 11:25:43', 'salim', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `message_user`
--

CREATE TABLE IF NOT EXISTS `message_user` (
  `id_message` int(11) NOT NULL,
  `id_username` varchar(255) NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT '0',
  `supprime` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message`,`id_username`),
  KEY `FK_message_user_id_username` (`id_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message_user`
--

INSERT INTO `message_user` (`id_message`, `id_username`, `statut`, `supprime`) VALUES
(1, 'salim', 0, 0),
(2, 'salim', 0, 0),
(29, 'salim', 1, 1),
(30, 'salim', 0, 1),
(31, 'salim', 1, 0),
(32, 'salim', 1, 1),
(33, 'salim', 1, 0),
(35, 'yul', 0, 0),
(39, 'yul', 0, 0),
(40, 'salim', 0, 1),
(41, 'salim', 0, 0),
(42, 'salim', 1, 0),
(43, 'yul', 0, 0),
(44, 'yul', 0, 0),
(45, 'yul', 0, 0),
(46, 'yul', 0, 0),
(47, 'yul', 0, 0),
(48, 'yul', 0, 0),
(49, 'renaud', 0, 0),
(50, 'renaud', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `paiement`
--

CREATE TABLE IF NOT EXISTS `paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modePaiement` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `paiement`
--

INSERT INTO `paiement` (`id`, `modePaiement`) VALUES
(1, 'paypal'),
(2, 'chèque'),
(3, 'virement interact');

-- --------------------------------------------------------

--
-- Структура таблицы `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photoSupp` varchar(255) NOT NULL,
  `id_appartement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_photo_id_appartement` (`id_appartement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Дамп данных таблицы `photo`
--

INSERT INTO `photo` (`id`, `photoSupp`, `id_appartement`) VALUES
(1, './images/apt01-01.png', 15),
(2, './images/apt01-02.png', 15),
(3, './images/apt01-03.png', 15),
(4, './images/apt01-04.png', 15),
(5, './images/apt01-05.png', 15),
(6, './images/apt01-06.png', 15),
(7, './images/apt01-07.png', 15),
(8, './images/apt01-08.png', 15),
(9, './images/apt01-09.png', 15),
(10, './images/apt01-10.png', 15),
(11, './images/apt02-01.png', 16),
(12, './images/apt02-02.png', 16),
(13, './images/apt02-03.png', 16),
(14, './images/apt02-04.png', 16),
(15, './images/apt02-05.png', 16),
(16, './images/apt02-06.png', 16),
(17, './images/apt02-07.png', 16),
(18, './images/apt02-08.png', 16),
(19, './images/apt02-09.png', 16),
(20, './images/apt02-10.png', 16),
(21, './images/apt03-01.png', 17),
(22, './images/apt03-02.png', 17),
(23, './images/apt03-03.png', 17),
(24, './images/apt03-04.png', 17),
(25, './images/apt03-05.png', 17),
(26, './images/apt03-06.png', 17),
(27, './images/apt03-07.png', 17),
(28, './images/apt03-08.png', 17),
(29, './images/apt03-09.png', 17),
(30, './images/apt03-10.png', 17),
(31, './images/apt04-01.png', 18),
(32, './images/apt04-02.png', 18),
(33, './images/apt04-03.png', 18),
(34, './images/apt04-04.png', 18),
(35, './images/apt04-05.png', 18),
(36, './images/apt04-06.png', 18),
(37, './images/apt04-07.png', 18),
(38, './images/apt04-08.png', 18),
(39, './images/apt04-09.png', 18),
(40, './images/apt04-10.png', 18);

-- --------------------------------------------------------

--
-- Структура таблицы `quartier`
--

CREATE TABLE IF NOT EXISTS `quartier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomQuartier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `quartier`
--

INSERT INTO `quartier` (`id`, `nomQuartier`) VALUES
(1, 'Ahuntsic-Cartierville'),
(2, 'Anjou'),
(3, 'Côte-des-Neiges–N-D-de-Grâce'),
(4, 'Lachine'),
(5, ' LaSalle'),
(6, 'Le Plateau-Mont-Royal'),
(7, ' Le Sud-Ouest'),
(8, 'Île-Bizard–Sainte-Geneviève'),
(9, 'Mercier–Hochelaga-Maisonneuve'),
(10, 'Montréal-Nord'),
(11, 'Outremont'),
(12, 'Pierrefonds-Roxboro'),
(13, '  Rivière-des-Prairies–Pointe-aux-Trembles'),
(14, 'Rosemont–La Petite-Patrie'),
(15, 'Saint-Laurent'),
(16, 'Saint-Léonard'),
(17, 'Verdun'),
(18, '  Ville-Marie'),
(19, '  Villeray–Saint-Michel–Parc-Extension');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomRole` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `nomRole`) VALUES
(1, 'super admin'),
(2, 'admin'),
(3, 'proprio '),
(4, 'client');

-- --------------------------------------------------------

--
-- Структура таблицы `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id_username` varchar(255) NOT NULL,
  `id_nomRole` int(11) NOT NULL,
  PRIMARY KEY (`id_username`,`id_nomRole`),
  KEY `FK_role_user_id_nomRole` (`id_nomRole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role_user`
--

INSERT INTO `role_user` (`id_username`, `id_nomRole`) VALUES
('salim', 1),
('nat', 2),
('renaud', 2),
('nat', 3),
('renaud', 3),
('salim', 3),
('nat', 4),
('Nouveau00', 4),
('yul', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `type_apt`
--

CREATE TABLE IF NOT EXISTS `type_apt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeApt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `type_apt`
--

INSERT INTO `type_apt` (`id`, `typeApt`) VALUES
(1, 'Loft'),
(2, 'Chalet'),
(3, 'Appartement'),
(4, 'Chambre'),
(5, 'Maison');

-- --------------------------------------------------------

--
-- Структура таблицы `usager`
--

CREATE TABLE IF NOT EXISTS `usager` (
  `username` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `valideParAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `banni` tinyint(1) NOT NULL DEFAULT '0',
  `id_moyenComm` int(11) NOT NULL,
  `coor_moyenComm` varchar(255) NOT NULL,
  `id_modePaiement` int(11) DEFAULT NULL,
  `id_adminBan` varchar(255) DEFAULT NULL,
  `id_adminValid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `FK_usager_id_moyenComm` (`id_moyenComm`),
  KEY `FK_usager_id_modePaiement` (`id_modePaiement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `usager`
--

INSERT INTO `usager` (`username`, `nom`, `prenom`, `photo`, `adresse`, `telephone`, `motDePasse`, `valideParAdmin`, `banni`, `id_moyenComm`, `coor_moyenComm`, `id_modePaiement`, `id_adminBan`, `id_adminValid`) VALUES
('nat', 'nat', 'nat', './images/profilN.png', 'nat', '55', '12345', 1, 0, 1, 'coordonnée MC', 1, 'salim', 'salim'),
('Nouveau00', 'no', 'no', 'profil.jpg', '32 rue du Moulin, Mtl', '222-222-2222', 'AAAAaaaa', 1, 0, 1, 'skss', 3, 'salim', 'salim'),
('renaud', 'renaud', 'renaud', './images/profilR.png', 'renaud', '778787', '12345', 1, 0, 1, 'coordonnée MC', 1, 'salim', 'salim'),
('salim', 'salim', 'Salim', './images/profilS.png', 'Montreal', '514 055 5050', '12345', 1, 0, 1, 'coordonnée MC', 1, NULL, NULL),
('yul', 'Romodina', 'Yuliya', './images/profilY.png', 'Montreal', '514 827 0000', '12345AAA', 1, 0, 1, 'coordonnée MC', 1, 'salim', 'salim');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `appartement`
--
ALTER TABLE `appartement`
  ADD CONSTRAINT `FK_appartement_id_nomQuartier` FOREIGN KEY (`id_nomQuartier`) REFERENCES `quartier` (`id`),
  ADD CONSTRAINT `FK_appartement_id_typeApt` FOREIGN KEY (`id_typeApt`) REFERENCES `type_apt` (`id`),
  ADD CONSTRAINT `FK_appartement_id_userProprio` FOREIGN KEY (`id_userProprio`) REFERENCES `usager` (`username`);

--
-- Ограничения внешнего ключа таблицы `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `FK_disponibilite_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`);

--
-- Ограничения внешнего ключа таблицы `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `FK_evaluation_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`),
  ADD CONSTRAINT `FK_evaluation_id_username` FOREIGN KEY (`id_username`) REFERENCES `usager` (`username`);

--
-- Ограничения внешнего ключа таблицы `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `FK_location_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`),
  ADD CONSTRAINT `FK_location_id_userClient` FOREIGN KEY (`id_userClient`) REFERENCES `usager` (`username`);

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_message_id_userEmetteur` FOREIGN KEY (`id_userEmetteur`) REFERENCES `usager` (`username`);

--
-- Ограничения внешнего ключа таблицы `message_user`
--
ALTER TABLE `message_user`
  ADD CONSTRAINT `FK_message_user_id_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `FK_message_user_id_username` FOREIGN KEY (`id_username`) REFERENCES `usager` (`username`);

--
-- Ограничения внешнего ключа таблицы `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_photo_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`);

--
-- Ограничения внешнего ключа таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `FK_role_user_id_nomRole` FOREIGN KEY (`id_nomRole`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `FK_role_user_id_username` FOREIGN KEY (`id_username`) REFERENCES `usager` (`username`);

--
-- Ограничения внешнего ключа таблицы `usager`
--
ALTER TABLE `usager`
  ADD CONSTRAINT `FK_usager_id_modePaiement` FOREIGN KEY (`id_modePaiement`) REFERENCES `paiement` (`id`),
  ADD CONSTRAINT `FK_usager_id_moyenComm` FOREIGN KEY (`id_moyenComm`) REFERENCES `communication` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
