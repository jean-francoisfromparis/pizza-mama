-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 05 nov. 2021 à 15:49
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pizza-mama`
--

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `description`, `price`, `photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Pizza Margherita', 'Sauce tomate San Marzano DOP, grana DOP, basilic frais, Mozzarella fior di latte d’Agerola', 990, '20210708121400-60e6ec088e838-20140712-spacca-napoli-margherita-pizza-617eaa5fa2e5e128014281.jpg', 1,                                                                                                   '', '', NULL),
(2, 1, 'Pizza N\'duja', 'Sauce tomate San Marzano DOP, Grana Padano DOP, basilic frais, Mozzarella fior di latte d’Agerola, Spianata Calabra, piments verts, N’duja di Spilinga', 1600, '20210705090703-60e2cbb7ef53e-pepperoni-617eab10d8c77000434419.png', 1,                                             '', '', NULL),
(3, 1, 'Pizza Prosciutto e Funghi', 'Sauce tomate San Marzano DOP, Grana Padano DOP, basilic frais, Mozzarella fior di latte d’Agerola, jambon blanc, champignons frais', 1500, '20210705085222-60e2c846345d3-prosciutto-fungi-617eab6d515c9092792848.png', 1,                                          '', '', NULL),
(4, 1, 'Pizza Calzone', 'Sauce tomate San Marzano DOP, Grana Padano DOP, basilic frais, ricotta, Mozzarella fior di latte d’Agerola', 1100, '20210705084941-60e2c7a506eed-calzone-617eabb87a0a7263799861.png', 1,                                                                                                                                     '', '', NULL),
(5, 1, 'Pizza Speck', 'Sauce tomate San Marzano DOP, Brie, Speck artisanal, origan, oignons rouges', 1600, '20210705090703-60e2cbb7ef53e-pepperoni-617eae2e90aa7056807992.png', 1,                                                                                                                                                                                          '', '', NULL),
(6, 1, 'Pizza Spéciale Tartuffo', 'Crème de truffe, Speck, Mozzarella fior di latte d’Agerola', 1800, '20210705085325-60e2c88503f04-tartuffo-617eaed20b9e7825662999.png', 1,                                                                                                                                                                                                                '', '', NULL),
(7, 1, 'Pizza 4 formaggi', 'Mozzarella fior di latte d’Agerola, basilic frais, Provola affumicata, Gorgonzola DOP, Brie, Grana Padano DOP', 1500, '4formaggi-617eaf1ace1e6207035656.png', 1,                                                                                                                                                                                          '', '', NULL),
(8, 1, 'Pizza picante', 'Sauce tomate San Marzano DOP, Spianata Calabra, Gorgonzola DOP, piments verts, Mozzarella fior di latte d’Agerola', 1600, '20210705084359-60e2c64f244fe-piccante-617eaf5806675122755428.png', 1,                                                                                                                  '', '', NULL),
(9, 1, 'Pizza napolitana', 'Sauce tomate San Marzano DOP, basilic frais, origan, olives, câpres PSF, filets d’anchois di Cetera', 1300, '20210705090602-60e2cb7a93871-napolitana-617eafc1a2561872995779.png', 1,                                                                                                                                                 '', '', NULL),
(10, 1, 'Pizza pepperoni', 'Double sauce tomate San Marzano DOP, Grana Padano DOP, basilic frais, Mozzarella fior di latte d’Agerola, double pepperoni', 1500, '20210705090703-60e2cbb7ef53e-pepperoni-617eb07cda455718291719.png', 1,                                                                                         '', '', NULL),
(11, 1, 'Pizza Parma', 'Sauce tomate San Marzano DOP, jambon de Parme DOP, origan, oignons rouges<br><br>', 1800, 'parma-617eb2e2679dc795099356.png', 1,                                                                                                                                                                                                                                             '', '', NULL),
(12, 1, 'Spaghettis di buffala', 'Des spaghettis cuitent al dente accompagnées d’une sauce à base de tomates cerises jaunes et de mozzarella de buffala DOP.', 1200, '20210709103440-60e826404b94c-spagetti-di-buffala-617eb411734f5629544847.png', 1,                                                             '', '', NULL),
(13, 2, 'Gnocchis al Pesto', 'Délicieuses gnocchis al pesto faîtes maison et sa sauce pesto à la genovese.', 1150, '20210709104127-60e827d760cd6-gnocchi-al-pesto-617eb46678671008098978.png', 1,                                                                                                                                                                         '', '', NULL),
(14, 2, 'Gnocchis al pomodorro', 'Gnocchis à la sauce tomate de marzano DOP.', 1200, '20210709104337-60e828590042d-gnocchi-al-pomodoro-617eb514a2e71222072843.png', 1,                                                                                                                                                                                                                '','', NULL),
(15, 2, 'Linguine al carbonara', 'Linguine accompagné d\'une onctueuse sauce à la crème et à la pancetta.', 1200, '20210709111629-60e8300dc2967-liguine-carbonara-617eb57b89042091976535.png', 1,                                                                                                                                                                     '', '', NULL),
(16, 2, 'Spaghettis à la bolognese', 'Spaghettis accompagnés d’une sauces de ragoût à la bolognaise (poitrine de porc, râble de lapin, collier de veau).', 1250, '20210709111855-60e8309f591ac-spagetti-bolognaise-617eb5f99e73e298081422.png', 1,                                                                              '', '', NULL),
(17, 2, 'Spaghettis frutti di mare', 'Spaghettis et sa sauce tomates di marzano DOP et ses fruits de mer (moules, palourdes, calamars et crevettes)', 1300, '20210709112056-60e83118ebda6-spaghetti-frutti-di-mare-617eb68bd728f932907189.png', 1,                                                                              '', '', NULL),
(18, 2, 'Tagliatelle 4 formaggi', 'Tagliatelle accompagnés de sa sauce crémeuse et onctueuse aux 4 fromages ~ grana padano DOP, Pecorino romano DOP, Mozzarella di Buffala DOP, Gorgonzola DOP ~', 1250, 'tagliatelle4formaggi60e823ea2e509-617eb7622f717837791267.png', 1,'', '', NULL),
(19, 2, 'Tagliatelle au saumon', 'Tagliatelle au saumon', 1100, 'tagliatelleausaumonbio60e82452082eb-617eb79a5a216954115298.png', 1,                                                                                                                                                                                            '', '', NULL),
(20, 3, 'Orangina', 'Boisson 33cl', 120, '20210705181226-60e34b8adda49-orangina-33cl-617eb7ddf3ba0746029921.png', 1,                                                                                                                                                                                            '', '', NULL),
(21, 4, 'Orangina 50cl', 'Boissons 50cl', 250, '20210705183005-60e34fad4ccc9-orangina-jaune-50-cl-02a19c8c8-617eb80f3b559650765599.jpg', 1,                                                                                                                                                                                             ', '', NULL),
(22, 3, 'Oasis', 'Oasis 33cl', 120, '20210706063641-60e3f9f98ea68-oasis-tropical-33-cl-617eb9a73ab86866564703.png', 1,                                                                                                                                                                                            '', '', NULL),
(23, 4, 'Oasis 50cl', 'Boisson 50cl', 250, '20210706063908-60e3fa8c56e1b-40410-617eba382b0dc698678411.jpg', 1,                                                                                                                                                                                             '', '', NULL),
(24, 4, 'coca zero 50cl', 'boisson 50cl', 250, '20210706064037-60e3fae5e95af-orig-cocacola-zero-50cl1-617ebd115a810554108112.jpg', 1,                                                                                                                                                                                            '', '', NULL),
(25, 4, 'eau minéral Evian 50cl', 'Boisson 50cl', 200, '20210706064158-60e3fb3630e0e-evian-617ebd420e56e511379184.jpg', 1,                                                                                                                                                                                             '', '', NULL),
(26, 4, 'eau minérale gazeuse Badoit 50cl', 'Boisson 50cl', 250, '20210706065217-60e3fda1c2a35-eau-badoit-20-bouteilles-de-50-cl-en-verre-617ebda50e3e1721388121.jpg', 1,                                                                                                                                                                                             '', '', NULL),
(27, 3, 'Cidre de pomme', 'Boisson 33cl', 250, '20210706071347-60e402ab65d14-ferme-de-billy-cidre-terroir-chic-brut-33cl-617ebdd803403353834741.jpg', 1,                                                                                                                                                                                            '', '', NULL),
(28, 3, 'jus de mangue', 'Boisson 33cl', 250, '20210706071510-60e402fe4a1d1-fruite-bio-mangue-33cl-1000x1000-617ebdf36a85f520424408.jpeg', 1,                                                                                                                                                                                             '', '', NULL),
(29, 3, 'jus d\'abricot', 'Boisson 33cl', 250, '20210706071622-60e40346678a4-jus-abricot-20-617ebe0ea9439977832511.png', 1,                                                                                                                                                                                             '', '', NULL),
(30, 3, 'Jus de poire', 'Boisson 33cl', 250, '20210706071715-60e4037b8dbd0-jus-de-poire-coteaux-nantais-bio-75-cl-617ebe346fce6333848578.png', 1,                                                                                                                                                                                            '', '', NULL),
(31, 3, 'Jus de raisin', 'Boisson 33cl', 250, '20210706071807-60e403af73f0e-jus-de-raisin-noir-100-pur-jus-75-cl-617ebe6000f83085577559.jpg', 1,                                                                                                                                                                                            '', '', NULL),
(32, 3, 'Jus de pomme', 'Boisson 33cl', 250, '20210706071926-60e403fe44538-le-coq-toque-pommevanillebio-25cl-617ebea8691b8202486496.jpg', 1,                                                                                                                                                                                            '', '', NULL),
(33, 3, 'Vin rouge 25cl', 'Boisson 25cl', 250, '20210706082107-60e412738ad9e-1971-vin-rouge-martinay-25cl-1-617ebeda8de81544607641.jpg', 1,                                                                                                                                                                                             '', '', NULL),
(34, 3, 'Tourtel sans alcool 33cl', 'Boisson 33cl', 220, '20210706082203-60e412ab84688-4ff7e1de-852c-4c5a-b482-3cd73b471d86-617ebf0378ef1742892488.jpg', 1,                                                                                                                                                                                            '', '', NULL),
(35, 3, 'Heineken 33cl', 'Boisson 33cl', 230, '20210706184822-60e4a576ae8a2-33cl-hei-0-0-bottle-canada-2017-pa-1-617eccf754e34474610722.png', 1,                                                                                                                                                                                            '', '', NULL),
(36, 5, 'Tiramisu', 'Composé de couches de biscuits (boudoir, biscuit à la cuiller) imbibés de café et de liqueur (amaretto) recouvert de mascarpone et nappé de cacao.', 700, '20210707103206-60e582a696d69-th-617ecf4c3e099918450132.jpg', 1,                                                                                                                                                                                             '', '', NULL),
(37, 5, 'Biscuit à la ricotta', 'Part de biscuit à la ricotta', 700, '20210707105443-60e587f3bc6d3-640036-617ed026d9ec1992502101.jpg', 1,                                                                                                       '', '', NULL),
(38, 5, 'Cannolo', 'Succulent dessert sicilien aromatisé au citron saupoudré de sucre glace.', 600, '20210707105908-60e588fc4b2b7-cannoli-617ed1218875d365945365.jpg', 1,                                                                                                      '', '', NULL),
(39, 5, 'Tiramisu nutella', 'Tiramisu nutella', 800, '20210707110048-60e58960c1740-10-italian-desserts-we-love-617ed15ada8ed734617674.jpg', 1, '',                                                                                                      '', NULL),
(40, 5, 'Panacotta caramel', 'Crème de panacotta et son coulis de caramel', 600, '20210707110206-60e589ae0c1b1-pannacotta-617ed194cc313997288083.jpg', 1,                                                                                                       '', '', NULL),
(41, 5, 'Panacotta fruit rouge', 'Crème de panacotta et son coulis de fruit rouge', 600, '20210707110353-60e58a19e6baf-panna-cotta-7-617ed1d0b9205838070820.jpg', 1,                                                                                                      '', '', NULL),
(42, 5, 'Panacotta mangue', 'Crème de panacotta et son coulis de mangue', 700, '20210707110825-60e58b2917aca-pannacottacocomangue-c-alinecookco-617ed24f756ba739239009.jpg', 1,                                                                                                       '', '', NULL),
(43, 5, 'Panacotta à la fraise', 'Crème de panacotta et son coulis de fraise', 750, '20210707110942-60e58b769d002-panna-cotta-mit-erdbeeren-shutterstock-406753951-617ed286ee14d825693359.jpg', 1, '', '', NULL),
(44, 5, 'Panettone', 'Brioche de panettone aux fruits secs aromatisé à la fleur d\'orangé', 600, '20210707111220-60e58c14940ce-italian-desserts-panettone-617ed2d097fec218937079.jpg', 1, '', '', NULL),
(45, 5, 'Cassata', 'Biscuit de ricotta aromatisé à l\'amande et fruits sec.', 600, '20210707111332-60e58c5c24ca6-ob-0f45cf-cassata-sicilienne-617ed3667dc99981902419.jpg', 1, '', '', NULL);

