-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  jeu. 08 mars 2018 à 20:44
-- Version du serveur :  5.6.38
-- Version de PHP :  7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `loumamaison`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartement`
--

CREATE TABLE `appartement` (
  `id` int(11) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `options` varchar(1000) DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `descriptif` varchar(2000) NOT NULL,
  `montantParJour` float NOT NULL,
  `nbPersonnes` int(11) NOT NULL,
  `nbLits` int(11) NOT NULL,
  `nbChambres` int(11) NOT NULL,
  `photoPrincipale` varchar(255) DEFAULT NULL,
  `noApt` varchar(25) DEFAULT NULL,
  `noCivique` int(11) NOT NULL,
  `rue` varchar(255) NOT NULL,
  `ville` varchar(255) DEFAULT 'Montréal',
  `codePostal` varchar(255) NOT NULL,
  `id_typeApt` int(11) NOT NULL,
  `id_userProprio` varchar(255) NOT NULL,
  `id_nomQuartier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appartement`
--

INSERT INTO `appartement` (`id`, `actif`, `options`, `titre`, `descriptif`, `montantParJour`, `nbPersonnes`, `nbLits`, `nbChambres`, `photoPrincipale`, `noApt`, `noCivique`, `rue`, `ville`, `codePostal`, `id_typeApt`, `id_userProprio`, `id_nomQuartier`) VALUES
(1, 1, NULL, 'maison de bois', 'description de l\'appartement bbbbabbabbababab ffff arrararara ssss.', 200, 4, 1, 1, './images/nat_0_etoile1.jpg', '4448', 4448, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 1),
(3, 1, NULL, 'maison en paille de plastique', 'description de l\'appartement bbbbabbabbababab ffff arrararara ssss.', 50, 2, 1, 6, './images/0_nat_bouteille-histoire-plain.png', '4', 11979, 'rolland', 'Montréal', 'H1G 3V9', 1, 'nat', 3),
(5, 1, 'wifi=checked&cintres=checked', 'maison de bois 2', 'description de l\'appartement bbbbabbabbababab ffff arrararara ssss.', 200, 2, 1, 1, './images/0_nat_bouteille-histoire-plain.png', '4', 2030, 'bellechasse', 'Montréal', 'H1G 3V9', 1, 'nat', 1),
(28, 1, '2=checked&3=checked', 'ffafsf', 'ffaffsf', 67, 2, 2, 2, 'photo.jpg', '23', 23, 'bbbaeb', 'Montréal', 'h2h2h2', 2, 'nat', 16),
(52, 1, '2=checked&4=checked&5=checked&9=checked&11=checked&12=checked', 'Nouvel Appartement!', 'BBbabababgsgsgtetefffffee', 50, 2, 1, 1, './images/nat_0_bouteille-histoire-plain.png', '6-B', 20, 'Beaubien Est', 'Montréal', 'H2H 1G3', 3, 'nat', 14);

-- --------------------------------------------------------

--
-- Structure de la table `communication`
--

CREATE TABLE `communication` (
  `id` int(11) NOT NULL,
  `moyenComm` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `communication`
--

INSERT INTO `communication` (`id`, `moyenComm`) VALUES
(1, 'skype'),
(2, 'e-mail'),
(3, 'facebook'),
(4, 'texto');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

CREATE TABLE `disponibilite` (
  `id` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `disponibilite` tinyint(1) NOT NULL DEFAULT '1',
  `id_appartement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `disponibilite`
--

INSERT INTO `disponibilite` (`id`, `dateDebut`, `dateFin`, `disponibilite`, `id_appartement`) VALUES
(2, '2018-03-25', '2018-03-31', 0, 1),
(3, '2018-03-18', '2018-03-24', 0, 1),
(4, '2018-03-18', '2018-04-28', 1, 28),
(9, '2018-03-11', '2018-03-17', 1, 5),
(11, '2018-03-25', '2018-03-31', 1, 5),
(12, '2018-03-25', '2018-03-31', 0, 52),
(16, '2018-03-25', '2018-03-26', 1, 52),
(17, '2018-03-29', '2018-03-31', 1, 52),
(18, '2018-03-18', '2018-03-24', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `commentaire` text,
  `dateNotif` datetime NOT NULL,
  `id_appartement` int(11) NOT NULL,
  `id_username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `rating`, `commentaire`, `dateNotif`, `id_appartement`, `id_username`) VALUES
(1, 10, NULL, '2018-02-28 00:00:00', 1, 'nat'),
(2, 5, NULL, '2018-02-27 00:00:00', 1, 'renaud'),
(9, 4, NULL, '2018-02-23 00:00:00', 5, 'salim'),
(11, 9, 'Ceci est un commentaire test', '2018-03-02 00:00:00', 28, 'nat'),
(12, 6, 'uuauuusususu', '2018-03-02 13:40:43', 1, 'nat'),
(13, 10, NULL, '2018-03-02 13:41:21', 28, 'nat'),
(14, 10, '', '2018-03-02 13:43:57', 28, 'nat'),
(15, 9, '', '2018-03-02 13:44:59', 1, 'nat'),
(16, 9, NULL, '2018-03-02 13:46:16', 28, 'nat'),
(17, 9, NULL, '2018-03-02 13:59:14', 1, 'nat'),
(18, 5, 'ggag  s sggsgd@@ 9(0..\"\"$%.', '2018-03-02 13:59:59', 28, 'nat'),
(19, 5, 'ggag  s sggsgd@@ 9(0..\"\"$%.', '2018-03-02 14:26:19', 28, 'nat'),
(20, 9, 'C\'était vraiment extra! La seule chose, les voisins sont bruyants...', '2018-03-03 09:37:36', 52, 'nat'),
(21, 6, NULL, '2018-03-04 12:30:39', 52, 'yul'),
(22, 6, NULL, '2018-03-04 12:30:56', 52, 'yul'),
(23, 6, NULL, '2018-03-04 12:36:09', 52, 'yul');

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `valideParPrestataire` tinyint(1) NOT NULL DEFAULT '0',
  `validePaiement` tinyint(1) NOT NULL DEFAULT '0',
  `id_userClient` varchar(255) NOT NULL,
  `id_appartement` int(11) NOT NULL,
  `nbPersonnes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id`, `dateDebut`, `dateFin`, `valideParPrestataire`, `validePaiement`, `id_userClient`, `id_appartement`, `nbPersonnes`) VALUES
(1, '2018-03-11', '2018-03-17', 0, 0, 'nat', 3, 0),
(2, '2018-03-11', '2018-03-17', 0, 0, 'nat', 5, 0),
(3, '2018-03-18', '2018-03-24', 0, 0, 'nat', 5, 0),
(4, '2018-03-18', '2018-03-24', 0, 0, 'salim', 1, 2),
(5, '2018-03-25', '2018-03-31', 0, 0, 'yul', 1, 2),
(6, '2018-03-27', '2018-03-28', 0, 0, 'yul', 52, 1);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `sujet` varchar(2000) NOT NULL,
  `dateHeure` datetime NOT NULL,
  `id_userEmetteur` varchar(255) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `titre`, `sujet`, `dateHeure`, `id_userEmetteur`, `archive`) VALUES
(1, '1111111', '1111111', '2018-03-01 00:00:00', 'nat', 0),
(2, '222222222222222', '222222222222222', '2018-03-09 00:00:00', 'Nouveau00', 0),
(3, 're: 1111111', 'zzzzzzzzzz', '2018-03-02 14:39:27', 'salim', 1),
(4, 're: 1111111', 'wwwwwwwwwww', '2018-03-02 14:41:58', 'salim', 1),
(5, 're: 1111111', '22222222222222222222', '2018-03-02 14:42:25', 'salim', 1),
(6, 'rrrrrrrrrrrrrr', '333333333', '2018-03-02 14:43:14', 'salim', 0),
(7, 'sadaddd', 'rrrrrrrrrrrrrrrrrrr', '2018-03-02 14:46:13', 'salim', 1),
(8, 'rien', 'rienssssssssss', '2018-03-02 20:00:18', 'salim', 0),
(9, 'gggggg', 'rrrrrggggg', '2018-03-03 01:26:03', 'salim', 1),
(10, 're: re: 1111111', 'ssssssssssssssssssssssssss', '2018-03-03 01:26:32', 'salim', 1),
(11, 're: sadaddd', 'assssssssssss', '2018-03-03 01:27:08', 'salim', 1),
(12, 're: re: 1111111', 'hhhhhhhhhhhh', '2018-03-03 01:40:25', 'salim', 1),
(13, '54', 'asssasas', '2018-03-03 01:40:53', 'salim', 1),
(14, 'trien', 'trien', '2018-03-03 01:51:58', 'salim', 0),
(15, 'sadaddd', 'rhrfhfh', '2018-03-03 02:03:56', 'salim', 0),
(16, 'rrrrrrrrrrrrrr', 'sfsfsfsfsfsf', '2018-03-03 02:05:48', 'salim', 0),
(17, 'dgdgdg', 'dgdgdgdgdg', '2018-03-03 02:07:18', 'salim', 0),
(18, 'rrrrrrrrrrrrrr', 'cxvsxvxvxv', '2018-03-03 02:08:02', 'salim', 0),
(19, 'teeeest', 'teessst', '2018-03-03 11:16:21', 'salim', 0),
(20, 'salut', 'salut le terrien', '2018-03-03 11:25:43', 'salim', 0),
(21, 'Test sur les messages à envoyer', 'bbabababbsbbbs', '2018-03-04 11:15:58', 'nat', 0),
(22, 'nouvel essaie....', 'mmmmmm?', '2018-03-04 11:17:51', 'nat', 0),
(23, 'ça va?', 'nnnnnnsnsnssndn d d d', '2018-03-04 11:18:21', 'nat', 1),
(24, 'gggggg', 'hhhhhh', '2018-03-04 11:18:49', 'nat', 1),
(25, 'Allo?', 'nnansnnsanns', '2018-03-04 11:19:59', 'salim', 0),
(26, 're: Allo?', 'Ça marche :)', '2018-03-04 11:20:47', 'nat', 0),
(27, 'ddfdfdf', 'dsdsdsd', '2018-03-04 22:18:25', 'nat', 0);

-- --------------------------------------------------------

--
-- Structure de la table `message_user`
--

CREATE TABLE `message_user` (
  `id_message` int(11) NOT NULL,
  `id_username` varchar(255) NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT '0',
  `supprime` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `message_user`
--

INSERT INTO `message_user` (`id_message`, `id_username`, `statut`, `supprime`) VALUES
(1, 'salim', 0, 0),
(2, 'salim', 0, 0),
(3, 'salim', 1, 1),
(4, 'salim', 0, 1),
(5, 'salim', 1, 0),
(6, 'salim', 1, 1),
(7, 'salim', 1, 0),
(8, 'yul', 1, 1),
(9, 'yul', 1, 0),
(10, 'salim', 0, 1),
(11, 'salim', 0, 0),
(12, 'salim', 1, 0),
(13, 'yul', 0, 1),
(14, 'yul', 0, 0),
(15, 'yul', 0, 1),
(16, 'yul', 0, 0),
(17, 'yul', 0, 0),
(18, 'yul', 0, 0),
(19, 'renaud', 0, 0),
(20, 'renaud', 0, 0),
(21, 'salim', 0, 0),
(22, 'salim', 0, 0),
(23, 'yul', 0, 0),
(24, 'yul', 0, 0),
(25, 'nat', 1, 0),
(26, 'salim', 1, 0),
(27, 'nat', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `modePaiement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `modePaiement`) VALUES
(1, 'paypal'),
(2, 'chèque'),
(3, 'virement interact');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `photoSupp` varchar(255) NOT NULL,
  `id_appartement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id`, `photoSupp`, `id_appartement`) VALUES
(40, './images/1_nat_invader2.png', 3),
(41, './images/2_nat_invader4.png', 3),
(42, './images/3_nat_invader5.png', 3),
(43, './images/2_nat_tallyho.jpg', 5),
(44, './images/1_nat_invader3.png', 5),
(45, './images/1_nat_nouveaute4.jpg', 5),
(46, './images/1_nat_invader4.png', 5),
(47, './images/1_nat_invader5.png', 5),
(74, './images/nat_0_nouveaute1.jpg', 52),
(75, './images/nat_0_nouveaute2.jpg', 52),
(76, './images/nat_1_invader2.png', 52),
(77, './images/nat_0_invader4.png', 52),
(78, './images/nat_1_LogoKINGYOnoir.png', 52),
(79, './images/nat_0_carafe.png', 52),
(80, './images/nat_1_nouveaute4.jpg', 52);

-- --------------------------------------------------------

--
-- Structure de la table `quartier`
--

CREATE TABLE `quartier` (
  `id` int(11) NOT NULL,
  `nomQuartier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quartier`
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
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nomRole` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nomRole`) VALUES
(1, 'super admin'),
(2, 'admin'),
(3, 'proprio '),
(4, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

CREATE TABLE `role_user` (
  `id_username` varchar(255) NOT NULL,
  `id_nomRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`id_username`, `id_nomRole`) VALUES
('salim', 1),
('nat', 2),
('Nouveau00', 2),
('renaud', 2),
('Maaarras4', 3),
('MMmammamma', 3),
('nat', 3),
('Natasha22', 3),
('Nouveau10', 3),
('Nouveau11', 3),
('Nouveau12', 3),
('Nouveau13', 3),
('Nouveau14', 3),
('Nouveau33', 3),
('Nouveau7', 3),
('Nouveau8', 3),
('Nouveau9', 3),
('Nouveaute1', 3),
('oooooooOOOOO', 3),
('reeerererere6', 3),
('renaud', 3),
('salim', 3),
('test000000', 3),
('Usager444', 3),
('Utilisateur', 3),
('uuuuuu33333', 3),
('yul', 3),
('Client000', 4),
('Maaarras4', 4),
('MMmammamma', 4),
('nat', 4),
('Nouveau00', 4),
('Nouveau10', 4),
('Nouveau11', 4),
('Nouveau12', 4),
('Nouveau13', 4),
('Nouveau33', 4),
('Nouveau9', 4),
('Nouveaucccc', 4),
('Nouveaute1', 4),
('oooooooOOOOO', 4),
('reeerererere6', 4),
('test000000', 4),
('Utilisateur', 4),
('yul', 4);

-- --------------------------------------------------------

--
-- Structure de la table `type_apt`
--

CREATE TABLE `type_apt` (
  `id` int(11) NOT NULL,
  `typeApt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_apt`
--

INSERT INTO `type_apt` (`id`, `typeApt`) VALUES
(1, 'Loft'),
(2, 'Chalet'),
(3, 'Appartement'),
(4, 'Chambre'),
(5, 'Maison');

-- --------------------------------------------------------

--
-- Structure de la table `usager`
--

CREATE TABLE `usager` (
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
  `id_adminValid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `usager`
--

INSERT INTO `usager` (`username`, `nom`, `prenom`, `photo`, `adresse`, `telephone`, `motDePasse`, `valideParAdmin`, `banni`, `id_moyenComm`, `coor_moyenComm`, `id_modePaiement`, `id_adminBan`, `id_adminValid`) VALUES
('Client000', 'cli', 'ent', 'profil.jpg', '32 rue DuPont', '222-222-2222', 'AAAAaaaa', 0, 1, 1, 'client', 3, 'nat', 'nat'),
('iiiiiiiii0', 'ii', 'oo', './images/profil.jpg', '889', '0000000999', 'ppppppp0', 0, 0, 4, 'jj', NULL, NULL, NULL),
('Maaarras4', 'mm', 'mm', './images/Maaarras4_0_etoile1.jpg', '22', '4444444444', 'ggggg444', 0, 0, 4, 're', 1, NULL, NULL),
('MMmammamma', 're', 're', './images/profil.jpg', 'pp', '55555555555', 'ooooo00000', 0, 0, 2, 're', 1, NULL, NULL),
('nat', 'nat', 'nat', './images/nat_0_logo1.png', 'nat', '556 666 6666', '12345iii', 1, 0, 1, 'coordonnée MC', 1, 'salim', 'salim'),
('Natasha22', 'ff', 'ff', './images/Natasha22_0_lamb1.jpg', 'ff', '1111111111', 'ttttttt5', 0, 0, 2, 'll', NULL, NULL, NULL),
('Nouveau00', 'no', 'no', 'profil.jpg', '32 rue du Moulin, Mtl', '222-222-2222', 'AAAAaaaa', 1, 0, 1, 'skss', 3, NULL, 'salim'),
('Nouveau1', 'nn', 'nn', './images/profil.jpg', 'nn', '99999999999', 'ooooOOOO', 0, 0, 2, 'adadada', NULL, NULL, NULL),
('Nouveau10', 'nn', 'nn', './images/0_Nouveau10_LogoKINGYOblanc.png', 'nn', '8888888888', 'iiiiiii8', 1, 0, 2, 'kk', 2, NULL, 'nat'),
('Nouveau11', 'nn', 'nn', './images/0_Nouveau11_nouveaute2.jpg', 'nn', '9999999999', 'iiiiiii8', 1, 0, 2, 'mm', 2, NULL, 'nat'),
('Nouveau12', 'nn', 'nn', './images/0_Nouveau12_images.jpg', 'nn', '5555555555', 'uuuuuuu7', 0, 1, 2, 'll', 2, 'nat', NULL),
('Nouveau13', 'nn', 'nn', './images/0_Nouveau13_tallyho.jpg', 'nn', '8888888888', 'jjjjjjjj8', 0, 0, 2, 'll', 2, NULL, NULL),
('Nouveau14', 'mm', 'mm', './images/profil.jpg', '12 rue ddd', '11111111111', 'ttttttt5', 0, 0, 2, 'rerere', NULL, NULL, NULL),
('Nouveau2', 'nn', 'nn', './images/profil.jpg', 'nn', '9999999999', 'ooooOOOO', 0, 0, 3, 'jjjj', NULL, NULL, NULL),
('Nouveau3', 'nn', 'nn', './images/profil.jpg', 'nn', '0000000009', 'ooooOOOO', 0, 0, 2, 'oo', NULL, NULL, NULL),
('Nouveau33', 'mm', 'mm', './images/profil.jpg', '21', '2222222222', 'bbbbbbb1', 0, 0, 3, 'ee', 1, NULL, NULL),
('Nouveau6', 'uu', 'uu', './images/profil.jpg', 'uu', '9998777777', 'ppppppp0', 0, 0, 2, 'oo', NULL, NULL, NULL),
('Nouveau7', 'nn', 'nn', './images/profil.jpg', 'nn', '8888888888', 'uuuuuuu7', 0, 0, 2, 'pp', NULL, NULL, NULL),
('Nouveau8', 'nn', 'nn', './images/0__bouteille-histoire-plain.png', 'nn', '9999999999', 'iiiiiii8', 0, 0, 2, 'kk', NULL, NULL, NULL),
('Nouveau9', 'nn', 'nn', './images/0__LogoKINGYOnoir.png', 'nn', '9999999999', 'ooooooo9', 0, 0, 2, 'iii', 2, NULL, NULL),
('Nouveaucccc', 'cc', 'cc', './images/profil.jpg', '12 rue mmmm', '1111111111', 'ddddDDDD', 0, 0, 2, 'dd', 2, NULL, NULL),
('Nouveaute1', 'ee', 'ee', './images/profil.jpg', '56', '1111111111', 'uuuuuuu8', 0, 0, 2, 'ee', 1, NULL, NULL),
('OOOOoooo', 'bb', 'bb', './images/profil.jpg', 'bb', '9999999999', 'oooooooo9', 0, 0, 2, 'jj', NULL, NULL, NULL),
('oooooooOOOOO', 'oo', 'oo', './images/profil.jpg', '54', '5555555555', 'nnnn1111', 0, 0, 2, 'gfgfg', 2, NULL, NULL),
('reeerererere6', 'rr', 'rr', './images/profil.jpg', 'r1', '3333333333', 'ppppppp0', 0, 0, 2, 're', 1, NULL, NULL),
('renaud', 'renaud', 'renaud', NULL, 'renaud', '778787', '12345', 0, 0, 1, 'coordonnée MC', 1, 'salim', 'salim'),
('salim', 'salim', 'salim', 'Wall-E4.png', 'salim', '44', '12345', 1, 0, 1, 'coordonnée MC', 1, NULL, NULL),
('test000000', 'oo', 'oo', './images/test000000_0_logo1.png', '74 rue du Bois', '514-522-5656', 'bbbb2222', 0, 0, 3, 're', 1, NULL, NULL),
('Usager444', 'mm', 'mm', './images/profil.jpg', '12 rue FF', '11111111111', 'qqqqqqq1', 0, 0, 1, 're', NULL, NULL, NULL),
('Utilisateur', 'see', 'ee', './images/Utilisateur_0_etoile2.jpg', 'ee', '5555555555555', 'oooo0000', 0, 0, 2, 'sasasa', 2, NULL, NULL),
('uuuuuu33333', 'jj', 'jj', './images/profil.jpg', 'jjj', '55555555555', 'mmmmm111', 0, 0, 2, 'trtrt', NULL, NULL, NULL),
('yul', 'yul', 'yul', './images/0_yul_degas-nu-baignoire2.jpg', 'yul', '5454', '12345', 1, 0, 1, 'coordonnée MC', 1, 'salim', '\'nat\'');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartement`
--
ALTER TABLE `appartement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_appartement_id_typeApt` (`id_typeApt`),
  ADD KEY `FK_appartement_id_userProprio` (`id_userProprio`),
  ADD KEY `FK_appartement_id_nomQuartier` (`id_nomQuartier`);

--
-- Index pour la table `communication`
--
ALTER TABLE `communication`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_disponibilite_id_appartement` (`id_appartement`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_evaluation_id_appartement` (`id_appartement`),
  ADD KEY `FK_evaluation_id_username` (`id_username`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_location_id_userClient` (`id_userClient`),
  ADD KEY `FK_location_id_appartement` (`id_appartement`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_message_id_userEmetteur` (`id_userEmetteur`);

--
-- Index pour la table `message_user`
--
ALTER TABLE `message_user`
  ADD PRIMARY KEY (`id_message`,`id_username`),
  ADD KEY `FK_message_user_id_username` (`id_username`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_photo_id_appartement` (`id_appartement`);

--
-- Index pour la table `quartier`
--
ALTER TABLE `quartier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id_username`,`id_nomRole`),
  ADD KEY `FK_role_user_id_nomRole` (`id_nomRole`);

--
-- Index pour la table `type_apt`
--
ALTER TABLE `type_apt`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `usager`
--
ALTER TABLE `usager`
  ADD PRIMARY KEY (`username`),
  ADD KEY `FK_usager_id_moyenComm` (`id_moyenComm`),
  ADD KEY `FK_usager_id_modePaiement` (`id_modePaiement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appartement`
--
ALTER TABLE `appartement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `communication`
--
ALTER TABLE `communication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `quartier`
--
ALTER TABLE `quartier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_apt`
--
ALTER TABLE `type_apt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartement`
--
ALTER TABLE `appartement`
  ADD CONSTRAINT `FK_appartement_id_nomQuartier` FOREIGN KEY (`id_nomQuartier`) REFERENCES `quartier` (`id`),
  ADD CONSTRAINT `FK_appartement_id_typeApt` FOREIGN KEY (`id_typeApt`) REFERENCES `type_apt` (`id`),
  ADD CONSTRAINT `FK_appartement_id_userProprio` FOREIGN KEY (`id_userProprio`) REFERENCES `usager` (`username`);

--
-- Contraintes pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `FK_disponibilite_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`);

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `FK_evaluation_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`),
  ADD CONSTRAINT `FK_evaluation_id_username` FOREIGN KEY (`id_username`) REFERENCES `usager` (`username`);

--
-- Contraintes pour la table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `FK_location_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`),
  ADD CONSTRAINT `FK_location_id_userClient` FOREIGN KEY (`id_userClient`) REFERENCES `usager` (`username`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_message_id_userEmetteur` FOREIGN KEY (`id_userEmetteur`) REFERENCES `usager` (`username`);

--
-- Contraintes pour la table `message_user`
--
ALTER TABLE `message_user`
  ADD CONSTRAINT `FK_message_user_id_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `FK_message_user_id_username` FOREIGN KEY (`id_username`) REFERENCES `usager` (`username`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_photo_id_appartement` FOREIGN KEY (`id_appartement`) REFERENCES `appartement` (`id`);

--
-- Contraintes pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `FK_role_user_id_nomRole` FOREIGN KEY (`id_nomRole`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `FK_role_user_id_username` FOREIGN KEY (`id_username`) REFERENCES `usager` (`username`);

--
-- Contraintes pour la table `usager`
--
ALTER TABLE `usager`
  ADD CONSTRAINT `FK_usager_id_modePaiement` FOREIGN KEY (`id_modePaiement`) REFERENCES `paiement` (`id`),
  ADD CONSTRAINT `FK_usager_id_moyenComm` FOREIGN KEY (`id_moyenComm`) REFERENCES `communication` (`id`);
