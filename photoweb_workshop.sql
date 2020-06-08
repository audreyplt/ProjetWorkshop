-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 11 jan. 2019 à 13:16
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `photoweb_workshop`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addTag` (IN `in_template` INT(11), IN `in_tag` VARCHAR(255))  NO SQL
BEGIN
	DECLARE ref INT(11);
	IF NOT EXISTS (SELECT * FROM pw_tag WHERE ta_libelle = in_tag) THEN
    	INSERT INTO pw_tag (ta_libelle) VALUES (in_tag);
    END IF;
    SELECT ta_ref INTO ref FROM pw_tag WHERE ta_libelle = in_tag;
    INSERT INTO pw_t_tag VALUES (in_template, ref);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteUser` (IN `in_id` INT(11))  NO SQL
BEGIN
	-- Suppression des favoris : CACADE
    -- Templates publics - passage en anonyme :
    UPDATE pw_template SET t_user = 2 WHERE t_user = in_id AND t_public = true;
    -- Templates privés - suppression :
    DELETE FROM pw_template WHERE t_user = in_id AND t_public = false;
    -- Suppression des notes : CASCADE
    -- Maj des commentaires - passage en anonyme :
    UPDATE pw_commentary SET c_user = 2 WHERE c_user = in_id;
    -- Suppression de l'utilisateur :
    DELETE FROM pw_user WHERE u_id = in_id;
END$$

--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `addAlbumTemplate` (`in_name` VARCHAR(255), `in_description` VARCHAR(255), `in_topic` VARCHAR(255), `in_public` BOOLEAN, `in_user` INT(11), `in_format` VARCHAR(255), `in_size` VARCHAR(255)) RETURNS INT(11) NO SQL
BEGIN
	DECLARE in_ref INT(11);
    SELECT addTemplate(in_name, in_description, in_topic, in_public, in_user) INTO in_ref;
    INSERT INTO pw_album_template VALUES (in_ref, in_format, in_size);
    RETURN in_ref;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `addTemplate` (`in_name` VARCHAR(255), `in_description` VARCHAR(255), `in_topic` VARCHAR(255), `in_public` BOOLEAN, `in_user` INT(11)) RETURNS INT(11) NO SQL
BEGIN
	DECLARE out_ref INT(11);
    INSERT INTO pw_template (t_name, t_description, t_publication_date, t_topic, t_public, t_user) VALUES (in_name, in_description, NOW(), in_topic, in_public, in_user);
    SELECT MAX(t_ref) INTO out_ref FROM pw_template;
    RETURN out_ref;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `addUser` (`in_login` VARCHAR(255), `in_password` VARCHAR(255), `in_email` VARCHAR(255), `in_pseudo` VARCHAR(255), `in_first_name` VARCHAR(255), `in_last_name` VARCHAR(255), `in_country` VARCHAR(255), `in_city` VARCHAR(255), `in_resume` TEXT) RETURNS INT(11) NO SQL
BEGIN
	DECLARE out_id INT(11);
    INSERT INTO pw_user (u_login, u_password, u_email, u_pseudo, u_first_name, u_last_name, u_country, u_city, u_resume) VALUES (in_login, in_password, in_email, in_pseudo, in_first_name, in_last_name, in_country, in_city, in_resume);
    SELECT MAX(u_id) INTO out_id FROM pw_user;
    RETURN out_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `pw_album_template`
--

CREATE TABLE `pw_album_template` (
  `t_template` int(11) NOT NULL,
  `at_format` varchar(255) DEFAULT NULL,
  `at_size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les informations spécifiques aux albums';

--
-- Déchargement des données de la table `pw_album_template`
--

INSERT INTO `pw_album_template` (`t_template`, `at_format`, `at_size`) VALUES
(1, 'Paysage', 'S'),
(2, 'Paysage', 'S'),
(3, 'Paysage', 'S'),
(4, 'Portrait', 'S'),
(5, 'Portrait', 'M'),
(6, 'Portrait', 'M'),
(7, 'Paysage', 'M'),
(8, 'Paysage', 'L'),
(9, 'Paysage', 'L'),
(10, 'Paysage', 'L'),
(11, 'Carré', 'M'),
(12, 'Carré', 'L'),
(13, 'Carré', 'S'),
(14, 'Portrait', 'L'),
(15, 'Portrait', 'L'),
(16, 'Paysage', 'L'),
(17, 'Paysage', 'M'),
(18, 'Paysage', 'M'),
(19, 'Carré', 'S'),
(20, 'Carré', 'S'),
(21, 'Portrait', 'L'),
(24, 'Portrait', 'S');

-- --------------------------------------------------------

--
-- Structure de la table `pw_badge`
--

CREATE TABLE `pw_badge` (
  `b_id` int(11) NOT NULL,
  `b_name` varchar(255) NOT NULL,
  `b_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les badges';

--
-- Déchargement des données de la table `pw_badge`
--

INSERT INTO `pw_badge` (`b_id`, `b_name`, `b_description`) VALUES
(1, 'ALTRUISTE', 'Vous avez entièrement rempli votre profil.'),
(2, 'GUIDE', 'Un de vos commentaires a été aimé 80 fois.'),
(3, 'INFLUENCEUR', 'Un de vos commentaires a été aimé 250 fois.'),
(4, 'TOP COMMENTAIRE', 'Un de vos commentaires a été aimé 800 fois.'),
(5, 'GRIBOUILLEUR', 'Vous avez publié votre premier template.'),
(6, 'ARTISTE AMATEUR', 'Vous avez publié 10 templates.'),
(7, '???', 'Vous avez publié 40 templates.'),
(8, 'GALERISTE', 'Vous avez publié 100 templates.'),
(9, 'FIRST !', 'Vous avez publié votre premier commentaire.'),
(10, 'LICENCE', 'Vous avez publié 100 commentaires.'),
(11, 'MASTER', 'Vous avez publié 400 commentaires.'),
(12, 'DOCTORAT', 'Vous avez publié 1000 commentaires.'),
(13, 'PERFORMEUR', 'Vous avez accumulé 5000 notes sur l\'ensemble de vos templates.'),
(14, 'CELEBRITE', 'Un de vos templates a été aimé 250 fois.'),
(15, 'STAR', 'Un de vos templates a été aimé 600 fois.'),
(16, 'BUZZER', 'Un de vos templates a été aimé 1500 fois.'),
(17, '???', 'Vous avez noté votre premier template.'),
(18, '???', 'Vous avez noté 300 templates.'),
(19, '???', 'Vous avez noté 1200 templates.'),
(20, 'MECENE', 'Vous avez noté 3000 templates.'),
(21, 'PIONNIER', 'Vous vous êtes inscrit la première année de création du Workshop. Merci à vous !');

-- --------------------------------------------------------

--
-- Structure de la table `pw_b_usr`
--

CREATE TABLE `pw_b_usr` (
  `bu_user` int(11) NOT NULL,
  `bu_badge` int(11) NOT NULL,
  `date_obtention` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les associations User - Badge';

--
-- Déchargement des données de la table `pw_b_usr`
--

INSERT INTO `pw_b_usr` (`bu_user`, `bu_badge`, `date_obtention`) VALUES
(3, 21, '2019-01-10'),
(4, 21, '2019-01-10'),
(5, 21, '2019-01-10'),
(6, 21, '2019-01-10'),
(7, 21, '2019-01-10'),
(8, 21, '2019-01-10'),
(9, 21, '2019-01-10');

-- --------------------------------------------------------

--
-- Structure de la table `pw_commentary`
--

CREATE TABLE `pw_commentary` (
  `c_ref` int(11) NOT NULL,
  `c_user` int(11) NOT NULL,
  `c_template` int(11) NOT NULL,
  `c_publication_date` date DEFAULT NULL,
  `c_text` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les commentaires des utilisateurs';

--
-- Déchargement des données de la table `pw_commentary`
--

INSERT INTO `pw_commentary` (`c_ref`, `c_user`, `c_template`, `c_publication_date`, `c_text`) VALUES
(3, 5, 2, '2018-12-23', 'Commentaire Test N°3'),
(4, 6, 2, '2018-12-23', 'Commentaire Test N°4'),
(5, 7, 3, '2018-12-23', 'Commentaire Test N°5'),
(6, 8, 3, '2018-12-23', 'Commentaire Test N°6'),
(7, 9, 4, '2018-12-23', 'Commentaire Test N°7'),
(8, 3, 4, '2018-12-23', 'Commentaire Test N°8'),
(9, 4, 6, '2018-12-23', 'Commentaire Test N°9'),
(10, 5, 5, '2018-12-23', 'Commentaire Test N°10'),
(11, 6, 6, '2018-12-23', 'Commentaire Test N°11'),
(12, 7, 6, '2018-12-23', 'Commentaire Test N°12'),
(13, 8, 7, '2018-12-23', 'Commentaire Test N°13'),
(14, 9, 7, '2018-12-23', 'Commentaire Test N°14'),
(15, 3, 8, '2018-12-23', 'Commentaire Test N°15'),
(16, 4, 8, '2018-12-23', 'Commentaire Test N°16'),
(17, 5, 9, '2018-12-23', 'Commentaire Test N°17'),
(18, 6, 9, '2018-12-23', 'Commentaire Test N°18'),
(19, 4, 9, '2019-01-09', 'Commentaire Test N°19'),
(20, 9, 9, '2018-12-23', 'Commentaire Test N°20');

-- --------------------------------------------------------

--
-- Structure de la table `pw_favorite`
--

CREATE TABLE `pw_favorite` (
  `f_user` int(11) NOT NULL,
  `f_template` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les favoris des utilisateurs';

--
-- Déchargement des données de la table `pw_favorite`
--

INSERT INTO `pw_favorite` (`f_user`, `f_template`) VALUES
(3, 8),
(4, 9),
(6, 4),
(7, 5),
(8, 6),
(9, 7);

-- --------------------------------------------------------

--
-- Structure de la table `pw_rate`
--

CREATE TABLE `pw_rate` (
  `r_user` int(11) NOT NULL,
  `r_template` int(11) NOT NULL,
  `r_nb_star` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les notes des utilisateurs';

--
-- Déchargement des données de la table `pw_rate`
--

INSERT INTO `pw_rate` (`r_user`, `r_template`, `r_nb_star`) VALUES
(3, 4, 0),
(3, 8, 4),
(4, 5, 5),
(4, 8, 5),
(5, 2, 2),
(5, 5, 0),
(5, 9, 1),
(6, 2, 2),
(6, 6, 1),
(6, 9, 5),
(7, 3, 2),
(7, 6, 0),
(8, 3, 4),
(8, 7, 5),
(9, 4, 3),
(9, 7, 5);

-- --------------------------------------------------------

--
-- Structure de la table `pw_tag`
--

CREATE TABLE `pw_tag` (
  `ta_ref` int(11) NOT NULL,
  `ta_libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tables stockant les tags des templates';

--
-- Déchargement des données de la table `pw_tag`
--

INSERT INTO `pw_tag` (`ta_ref`, `ta_libelle`) VALUES
(1, 'test1'),
(2, 'test2'),
(3, 'test3');

-- --------------------------------------------------------

--
-- Structure de la table `pw_template`
--

CREATE TABLE `pw_template` (
  `t_ref` int(11) NOT NULL,
  `t_name` varchar(255) DEFAULT NULL,
  `t_description` mediumtext,
  `t_publication_date` date DEFAULT NULL,
  `t_topic` varchar(255) DEFAULT NULL,
  `t_public` tinyint(1) DEFAULT NULL,
  `t_user` int(11) DEFAULT NULL,
  `t_preview` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les informations générales des templates';

--
-- Déchargement des données de la table `pw_template`
--

INSERT INTO `pw_template` (`t_ref`, `t_name`, `t_description`, `t_publication_date`, `t_topic`, `t_public`, `t_user`, `t_preview`) VALUES
(1, 'A First Template', 'This is a first template.', '2018-12-31', 'Testing', 0, 9, 'template4.png'),
(2, 'A Second Template', 'This is a second template.', '2018-12-30', 'Testing', 0, 3, 'template5.png'),
(3, 'A Third Template', 'This is a third template.', '2018-12-29', 'Testing', 0, 8, 'template6.png'),
(4, 'A Fourth Template', 'This is a fourth template.', '2018-12-28', 'Voyage', 1, 5, 'template8.png'),
(5, 'A Fifth Template Edit', 'This is a fifth template.', '2018-12-27', 'Testing', 1, 4, 'template20.png'),
(6, 'A Sixth Template', 'This is a sixth template.', '2018-12-26', 'Voyage', 1, 6, 'template13.png'),
(7, 'A Seventh Template', 'This is a seventh template.', '2018-12-25', 'Voyage', 1, 7, 'template19.png'),
(8, 'A Eighth Template', 'This is a eight template.', '2018-12-24', 'Testing', 1, 2, 'template9.png'),
(9, 'A Ninth Template', 'This is a ninth template.', '2018-12-23', 'Enfant', 1, 2, 'template16.png'),
(10, 'Template n°10', 'Voici le template 10', '2019-01-09', 'Testing', 1, 2, 'template11.png'),
(11, 'Template n°11', 'Voici le template 11', '2019-01-09', 'Mariage', 1, 2, 'template2.png'),
(12, 'Template n°12', 'Voici le template 12', '2019-01-09', 'Mariage', 1, 2, 'template10.png'),
(13, 'Template n°13', 'Voici le template 13', '2019-01-09', 'Voyage', 1, 2, 'template18.png'),
(14, 'Template n°14', 'Voici le template 14', '2019-01-09', 'Testing', 1, 2, 'template12.png'),
(15, 'Template n°15', 'Voici le template 15', '2019-01-09', 'Mariage', 1, 2, 'template7.png'),
(16, 'Template n°16', 'Voici le template 16', '2019-01-09', 'Noël', 1, 2, 'template1.png'),
(17, 'Template n°17', 'Voici le template 17', '2019-01-09', 'Testing', 1, 2, 'template14.png'),
(18, 'Template n°18', 'Voici le template 18', '2019-01-09', 'Pâques', 1, 2, 'template3.png'),
(19, 'Template n°19', 'Voici le template 19', '2019-01-09', 'Testing', 1, 2, 'template15.png'),
(20, 'Template n°20', 'Voici le template 20', '2019-01-09', 'Testing', 1, 2, 'template17.png'),
(21, 'Voltariuss\'s template creation', 'Ceci est un template.', '2019-01-11', 'Voyage', 1, 4, NULL),
(24, 'test2', 'test2', '2019-01-11', 'Pâques', 0, 4, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `pw_t_tag`
--

CREATE TABLE `pw_t_tag` (
  `tt_template` int(11) NOT NULL,
  `tt_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table d''association Template - Tag';

--
-- Déchargement des données de la table `pw_t_tag`
--

INSERT INTO `pw_t_tag` (`tt_template`, `tt_tag`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3);

-- --------------------------------------------------------

--
-- Structure de la table `pw_user`
--

CREATE TABLE `pw_user` (
  `u_id` int(11) NOT NULL,
  `u_login` varchar(255) DEFAULT NULL,
  `u_password` varchar(255) DEFAULT NULL,
  `u_email` varchar(255) DEFAULT NULL,
  `u_pseudo` varchar(255) DEFAULT NULL,
  `u_first_name` varchar(255) DEFAULT NULL,
  `u_last_name` varchar(255) DEFAULT NULL,
  `u_country` varchar(255) DEFAULT NULL,
  `u_city` varchar(255) DEFAULT NULL,
  `u_resume` mediumtext,
  `u_avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table stockant les utilisateurs';

--
-- Déchargement des données de la table `pw_user`
--

INSERT INTO `pw_user` (`u_id`, `u_login`, `u_password`, `u_email`, `u_pseudo`, `u_first_name`, `u_last_name`, `u_country`, `u_city`, `u_resume`, `u_avatar`) VALUES
(1, 'root', 'rootequipedeux', 'admin.root@workshop.com', 'Admin', 'Admin', 'Root', 'France', 'Grenoble', 'Admin account', NULL),
(2, 'anonymous', 'anonymous', 'anonymous@workshop.com', 'Anonymous', 'the', 'anonymous', '???', '???', 'The anonymous user.', NULL),
(3, 'aymerick', 'admin1', 'aymerick.dieuaide@workshop.com', 'SkilzBeater', 'Aymerick', 'Dieuaide', 'France', 'Grenoble', 'First Admin', NULL),
(4, 'loic', 'admin2', 'loic.dubois-termoz@workshop.com', 'Voltariuss', 'Loïc', 'Dubois-Termoz', 'France', 'Grenoble', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', NULL),
(5, 'gergely', 'admin3', 'gergely.fodor@workshop.com', 'Greg', 'Gergely', 'Fodor', 'France', 'Grenoble', 'The Third Admin', NULL),
(6, 'nicolas', 'admin4', 'nicolas.pandraud@workshop.com', 'Nysis', 'Nicolas', 'Pandraud', 'France', 'Grenoble', 'The Fourth Admin', NULL),
(7, 'sullivan', 'admin5', 'sullivan.collomb@orkshop.com', 'Steila27', 'Sullivan', 'Collomb', 'France', 'Grenoble', 'The Fifth Admin', NULL),
(8, 'camille', 'admin6', 'camille.mazzoletti@wokshop.com', 'Neophysis', 'Camille', 'Mazzoletti', 'France', 'Grenoble', 'The Sixth Admin', NULL),
(9, 'audrey', 'admin7', 'audrey.piollet@workshop.com', 'Audrey', 'Audrey', 'Piollet', 'France', 'Grenoble', 'The Seventh Admin', 'img_audrey.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `pw_album_template`
--
ALTER TABLE `pw_album_template`
  ADD PRIMARY KEY (`t_template`);

--
-- Index pour la table `pw_badge`
--
ALTER TABLE `pw_badge`
  ADD PRIMARY KEY (`b_id`);

--
-- Index pour la table `pw_b_usr`
--
ALTER TABLE `pw_b_usr`
  ADD PRIMARY KEY (`bu_user`,`bu_badge`),
  ADD KEY `C_FK_BU_BDG` (`bu_badge`);

--
-- Index pour la table `pw_commentary`
--
ALTER TABLE `pw_commentary`
  ADD PRIMARY KEY (`c_ref`),
  ADD KEY `C_FK_COM_USR` (`c_user`),
  ADD KEY `C_FK_COM_TMP` (`c_template`);

--
-- Index pour la table `pw_favorite`
--
ALTER TABLE `pw_favorite`
  ADD PRIMARY KEY (`f_user`,`f_template`),
  ADD KEY `C_FK_FVT_TMP` (`f_template`);

--
-- Index pour la table `pw_rate`
--
ALTER TABLE `pw_rate`
  ADD PRIMARY KEY (`r_user`,`r_template`),
  ADD KEY `C_FK_R_TMP` (`r_template`);

--
-- Index pour la table `pw_tag`
--
ALTER TABLE `pw_tag`
  ADD PRIMARY KEY (`ta_ref`) USING BTREE;

--
-- Index pour la table `pw_template`
--
ALTER TABLE `pw_template`
  ADD PRIMARY KEY (`t_ref`),
  ADD KEY `C_FK_TMP_USR` (`t_user`);

--
-- Index pour la table `pw_t_tag`
--
ALTER TABLE `pw_t_tag`
  ADD PRIMARY KEY (`tt_template`,`tt_tag`),
  ADD KEY `C_FK_TT_TA` (`tt_tag`);

--
-- Index pour la table `pw_user`
--
ALTER TABLE `pw_user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `pw_badge`
--
ALTER TABLE `pw_badge`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `pw_commentary`
--
ALTER TABLE `pw_commentary`
  MODIFY `c_ref` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `pw_tag`
--
ALTER TABLE `pw_tag`
  MODIFY `ta_ref` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `pw_template`
--
ALTER TABLE `pw_template`
  MODIFY `t_ref` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `pw_user`
--
ALTER TABLE `pw_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `pw_album_template`
--
ALTER TABLE `pw_album_template`
  ADD CONSTRAINT `C_FK_AT_T` FOREIGN KEY (`t_template`) REFERENCES `pw_template` (`t_ref`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pw_b_usr`
--
ALTER TABLE `pw_b_usr`
  ADD CONSTRAINT `C_FK_BU_BDG` FOREIGN KEY (`bu_badge`) REFERENCES `pw_badge` (`b_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `C_FK_BU_USR` FOREIGN KEY (`bu_user`) REFERENCES `pw_user` (`u_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pw_commentary`
--
ALTER TABLE `pw_commentary`
  ADD CONSTRAINT `C_FK_COM_TMP` FOREIGN KEY (`c_template`) REFERENCES `pw_template` (`t_ref`) ON DELETE CASCADE,
  ADD CONSTRAINT `C_FK_COM_USR` FOREIGN KEY (`c_user`) REFERENCES `pw_user` (`u_id`);

--
-- Contraintes pour la table `pw_favorite`
--
ALTER TABLE `pw_favorite`
  ADD CONSTRAINT `C_FK_FVT_TMP` FOREIGN KEY (`f_template`) REFERENCES `pw_template` (`t_ref`) ON DELETE CASCADE,
  ADD CONSTRAINT `C_FK_FVT_USR` FOREIGN KEY (`f_user`) REFERENCES `pw_user` (`u_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pw_rate`
--
ALTER TABLE `pw_rate`
  ADD CONSTRAINT `C_FK_R_TMP` FOREIGN KEY (`r_template`) REFERENCES `pw_template` (`t_ref`) ON DELETE CASCADE,
  ADD CONSTRAINT `C_FK_R_USR` FOREIGN KEY (`r_user`) REFERENCES `pw_user` (`u_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pw_template`
--
ALTER TABLE `pw_template`
  ADD CONSTRAINT `C_FK_TMP_USR` FOREIGN KEY (`t_user`) REFERENCES `pw_user` (`u_id`);

--
-- Contraintes pour la table `pw_t_tag`
--
ALTER TABLE `pw_t_tag`
  ADD CONSTRAINT `C_FK_TT_T` FOREIGN KEY (`tt_template`) REFERENCES `pw_template` (`t_ref`) ON DELETE CASCADE,
  ADD CONSTRAINT `C_FK_TT_TA` FOREIGN KEY (`tt_tag`) REFERENCES `pw_tag` (`ta_ref`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
