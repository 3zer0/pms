-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2024 at 11:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_template`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clusters`
--

CREATE TABLE `clusters` (
  `id` int(11) NOT NULL,
  `cluster_name` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clusters`
--

INSERT INTO `clusters` (`id`, `cluster_name`) VALUES
(1, 'Employment and Human Resource Development Cluster'),
(2, 'Workers’ Welfare and Protection Cluster'),
(3, 'Labor Relations, Policy and International Affairs Cluster'),
(4, 'Legislative Liaison and Legal Affairs Cluster'),
(5, 'General Administration Cluster');

-- --------------------------------------------------------

--
-- Table structure for table `cluster_asecs`
--

CREATE TABLE `cluster_asecs` (
  `id` int(11) NOT NULL,
  `cluster_usec_id` int(11) NOT NULL DEFAULT 0,
  `employee_id` bigint(20) NOT NULL DEFAULT 0,
  `asec_name` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cluster_asecs`
--

INSERT INTO `cluster_asecs` (`id`, `cluster_usec_id`, `employee_id`, `asec_name`) VALUES
(1, 1, 0, 'Atty. Paul Vincent W. Añover'),
(2, 2, 0, 'Dominique Rubia-Tutay, CESO II'),
(3, 3, 0, 'Atty. Lennard Constantine C. Serrano'),
(4, 3, 0, 'Amuerfina R. Reyes'),
(5, 4, 0, 'Warren M. Miclat'),
(6, 5, 0, 'Warren M. Miclat');

-- --------------------------------------------------------

--
-- Table structure for table `cluster_usecs`
--

CREATE TABLE `cluster_usecs` (
  `id` int(11) NOT NULL,
  `cluster_id` int(11) NOT NULL DEFAULT 0,
  `employee_id` bigint(20) NOT NULL DEFAULT 0,
  `usec_name` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cluster_usecs`
--

INSERT INTO `cluster_usecs` (`id`, `cluster_id`, `employee_id`, `usec_name`) VALUES
(1, 1, 0, 'Carmela I. Torres'),
(2, 2, 0, 'Atty. Benjo Santos M. Benavidez'),
(3, 3, 0, 'Atty. Benedicto Ernesto R. Bitonio, Jr.'),
(4, 4, 0, 'Atty. Felipe N. Egargo, Jr.'),
(5, 5, 0, 'Atty. Felipe N. Egargo, Jr.');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL DEFAULT 0,
  `division_name` varchar(125) DEFAULT NULL,
  `abbre` varchar(25) DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL DEFAULT 0,
  `division_head` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `office_id`, `division_name`, `abbre`, `employee_id`, `division_head`) VALUES
(1, 1, 'Labor Market Information Division', 'LMID', 0, 'Grace A. Baldoza'),
(2, 1, 'Program Management Division', 'PMD', 0, 'Ana Liza M. Ragos'),
(3, 1, 'Policy Development Division', 'PDD', 0, 'Jerome P. Lucas (OIC)'),
(4, 2, 'Program Management and Technical Support Services Division', 'PM-TSSD', 0, 'Engr. Kristine Carol S. Ramos'),
(5, 2, 'Labor Standards Review and Appeals Division', 'LSRAD', 0, 'Atty. Judaline Alde-Campo'),
(6, 2, 'Policy and Program Development Division', 'PPDD', 0, 'Atty. Carlo S. Casabar (OIC)'),
(7, 3, 'Workers in the Informal Economy Development Division', 'WIEDD', 0, 'Zydney Lanz C. Cresino (OIC)'),
(8, 3, 'Workers Social Amelioration Development Division', 'WSADD', 0, 'Fe L. dela Cruz'),
(9, 3, 'Young Workers Development Division', 'YWDD', 0, 'Jerommel A. Gabriel'),
(10, 3, 'Women Workers Development Division', 'WWDD', 0, 'Carol Anne P. Resurreccion'),
(11, 3, 'Program Monitoring and Technical Support Services Division', 'PM-TSSD', 0, 'Elisa A. Cruz (OIC)'),
(12, 4, 'Union Registration and Workers\' Empowerment Division', 'URWED', 0, 'Marivic T. Villa'),
(13, 4, 'Program Management and Technical Support Services Division', 'PM-TSSD', 0, 'Ma. Loures R. Villafranca'),
(14, 4, 'Policy and Program Development Division', 'PPDD', 0, 'Glorializa V. delos Santosd'),
(15, 4, 'Appeals and Review Unit', 'ARU', 0, NULL),
(16, 5, 'Monitoring and Evaluation Division', 'MED', 0, 'Hannah Gale T. Perea (OIC)'),
(17, 5, 'Planning and Programming Division', 'PPD', 0, 'Immanuel C. Quiban (OIC)'),
(18, 5, 'Management and Information System Division', 'MISD', 0, 'Ronie U. Oracion (OIC)'),
(19, 6, 'Technical Support and Services Division - Labor Relations/Labor Standards', 'TSSD-LRLS', 0, 'Nelia M. Mungcal'),
(20, 6, 'Technical Support and Services Division - Employment Promotion and Workers Welfare', 'TSSD-EPWW', 0, 'Lorna R. Obedoza'),
(21, 6, 'Internal Management Services Division', 'IMSD', 2, 'Regienald S. Espaldon'),
(22, 6, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Cesar P. Petate'),
(23, 6, 'CAMANAVA Field Office', 'CFO', 0, 'Rowella V. Grande'),
(24, 6, 'Makati & Pasay Field Office', 'MPFO', 0, 'Atty. Gerald Peter C. Mariano (OIC)'),
(25, 6, 'Manila Field Office', 'MFO', 0, 'Atty. Joel P. Petaca'),
(26, 6, 'Muntaparlas Field Office', 'MTPLFO', 0, 'Leonides P. Castillon, Jr.'),
(27, 6, 'PAPAMAMARISAN Field Office', 'PFO', 0, 'Lilibeth T. Cagara'),
(28, 6, 'Quezon City Field Office', 'QCFO', 0, 'Engr. Martin T. Jequinto'),
(29, 7, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Anthonyy A. Wooden, JR.'),
(30, 7, 'Internal Management Services Division', 'IMSD', 0, 'Atty. Marina P. Cayabo (OIC)'),
(31, 7, 'Technical Support and Services Division', 'TSSD', 0, 'Rajan S. Gomuad (OIC)'),
(32, 7, 'Abra Field Offce', 'AFO', 0, 'Christopher B. Tugadi (OIC)'),
(33, 7, 'Baguio-Benguet Field Officer', 'BBFO', 0, 'Venus L. Guinjicna'),
(34, 7, 'Ifugao Field Office', 'IFO', 0, 'Isabelita M. Codamon'),
(35, 7, 'Kalinga Field Office', 'KFO', 0, 'Avelina D. Manganip'),
(36, 7, 'Mountain Province Field Office', 'MPFO', 0, 'George G. Lubin, Jr.'),
(37, 7, 'Apayao Field Office', 'ASO', 0, 'Jane Y. Adalan (OIC)'),
(38, 8, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Amado C. Gasmin'),
(39, 8, 'Technical Support and Services Division - Labor Relations/Labor Standards', 'TSSD-LRLS', 0, 'Atty. Amado C. Gasmin (OIC)'),
(40, 8, 'Technical Support and Services Division - Livelihood and Employment', 'TSSD-LE', 0, 'Teresita N. Bonavente'),
(41, 8, 'Internal Management Services Division', 'IMSD', 0, 'Ronaldo A. de Vera'),
(42, 8, 'La Union Field Office', 'LUFO', 0, 'Veronica A. Corsino'),
(43, 8, 'Eastern Pangasinan Field Office', 'EPFO', 0, 'Mary Antonette T. Avila'),
(44, 8, 'West Pangasinan Field Office', 'WPFO', 0, 'Darwin G. Hombrebueno'),
(45, 8, 'Central Pangasinan Field Office', 'CPFO', 0, 'Agnes B. Aguinaldo'),
(46, 8, 'Ilocos Norte Field Office', 'INFO', 0, 'Janelyn R. Martin (OIC)'),
(47, 8, 'Ilocos Sur Field Office', 'ISFO', 0, 'Charity A. Ubilas (OIC)'),
(48, 9, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Mary Gladys R. Paguirigan'),
(49, 9, 'Technical Support and Services Division', 'TSSD', 0, 'Laura B. Diciano'),
(50, 9, 'Internal Management Services Division', 'IMSD', 0, 'Reginald B. Estioco'),
(51, 9, 'Isabela Field Office', 'IFO', 0, 'Evelyn U. Yango'),
(52, 9, 'Nueva Vizcaya Field Office', 'NVFO', 0, 'Elizabeth U. Martinez'),
(53, 9, 'Quirino Field Office', 'QFO', 0, 'Geraldine B. Labayani'),
(54, 9, 'Batanes Satellite Office', 'BSO', 0, 'Ramoncito G. Ligayu'),
(55, 10, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Remedios T. Vegim-Teves'),
(56, 10, 'Technical Support and Services Division - Labor Relations/Labor Standards', 'TSSD-LRLS', 0, 'Maria Rima C. Hernandez'),
(57, 10, 'Technical Support and Services Division - EW', 'TSSD-EW', 0, 'Aurita L. Laxamana'),
(58, 10, 'Internal Management Services Division', 'IMSD', 0, 'Albert B. Manlapaz'),
(59, 10, 'Aurora Field Office', 'AFO', 0, 'Antonio M. Sicat, Jr. (OIC)'),
(60, 10, 'Bataan Field Office', 'BFO', 0, 'Leilani M. Reynoso'),
(61, 10, 'Bulacan Field Office', 'BULFO', 0, 'May Lynn C. Gozun'),
(62, 10, 'Nueva Ecija Field Office', 'NEFO', 0, 'Maylene L. Evangelista'),
(63, 10, 'Pampanga Field Office', 'PAMFO', 0, 'Alejandro V. Inza Cruz (OIC)'),
(64, 10, 'Clark Satellite Office', 'CRKSO', 0, 'Jason P. Ocampo (OIC)'),
(65, 10, 'Tarlac Field Office', 'TARFO', 0, 'Jose Roberto L. Navata'),
(66, 10, 'Zambales Field Office', 'ZAMFO', 0, 'Reynante N. Lugtu'),
(67, 11, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Rosita C. Villaluz\r\nAtty. Dennis R. Manzanero'),
(68, 11, 'Technical Support and Services Division - Labor Relations/Labor Standards', 'TSSD-LRLS', 0, 'Engr. Joseph P. Gacosta (OIC)'),
(69, 11, 'Technical Support and Services Division - EW', 'TSSD-EW', 0, 'Ma. Angelique Yaun (OIC)'),
(70, 11, 'Internal Management Services Division', 'IMSD', 0, 'Alvin G. Landicho (OIC)'),
(71, 11, 'Cavite Provincial Office', 'CPO', 0, 'Marivic B. Martinez'),
(72, 11, 'Laguna Provincial Office', 'LPO', 0, 'Guido R. Recio'),
(73, 11, 'Batangas Provincial Office', 'BPO', 0, 'Predelma M. Tan'),
(74, 11, 'Rizal Provincial Office', 'RPO', 0, 'Celia G. Ariola'),
(75, 11, 'Quezon Provincial Office', 'QPO', 0, 'Edwin T. Hernandez'),
(76, 12, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Shirley Marie C. Quiñones'),
(77, 12, 'Technical Support and Services Division', 'TSSD', 0, 'Marjun S. Moreno'),
(78, 12, 'Internal Management Services Division', 'IMSD', 0, 'Rosemarie C. Hupanda'),
(79, 12, 'Occidental Mindoro Provincial Office', 'OCCMINFO', 0, 'Peter James D. Cortazar (OIC)'),
(80, 12, 'Oriental Mindoro Provincial Office', 'ORMINFO', 0, 'Roderick F. Tamacay'),
(81, 12, 'Marinduque Provincial Office', 'MRQFO', 0, 'Philip T. Alano'),
(82, 12, 'Romblon Provincial Office', 'ROMFO', 0, 'Philip D. Ruga'),
(83, 12, 'Palawan Provincial Office', 'PALFO', 0, 'Carlo B. Villaflores'),
(84, 13, 'Technical Support and Services Division', 'TSSD', 0, 'Marilyn L. Luzuriaga'),
(85, 13, 'Internal Management Services Division', 'IMSD', 0, 'Eduardo Pedro V. Caño'),
(86, 13, 'Sorsogon Provincial Office', 'SFO', 0, 'Mary Jane L. Rolda'),
(87, 13, 'Albay Provincial Office', 'APFO', 0, 'Ching B. Banania'),
(88, 13, 'Masbate Provincial Office', 'MFO', 0, 'Lynette H. dela Fuente (OIC)'),
(89, 13, 'Catanduanes Provincial Office', 'CFO', 0, 'Eduardo C. Loverdorial (OIC)'),
(90, 13, 'Camarines Norte Provincial Office', 'CNFO', 0, 'Cherry B. Mosatalla'),
(91, 13, 'Camarines Sur Provincial Office', 'CSFO', 0, 'Ma. Ella E. Verano'),
(92, 14, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Divine Grace B. Gabunas'),
(93, 14, 'Technical Support and Services Division - Labor Relations/Labor Standards', 'TSSD-LRLS', 0, 'Atty. Ma. Ailyn P. Valaquio-Pueblo'),
(94, 14, 'Technical Support and Services Division - EW', 'TSSD-EW', 0, 'Melisa S. Navarra\r\n'),
(95, 14, 'Internal Management Services Division', 'IMSD', 0, 'Arlyn E. Siaotong'),
(96, 14, 'Aklan Field Office', 'AKFO', 0, 'Richie G. Buyco'),
(97, 14, 'Antique Field Office', 'ANFO', 0, 'Ma. Cecilia S. Acebuque'),
(98, 14, 'Capiz Field Office', 'CFO', 0, 'Joselito G. de la Banda'),
(99, 14, 'Guimaras Field Office', 'GFO', 0, 'Engr. Micheal Gison'),
(100, 14, 'Iloilo Field Office', 'IFO', 0, 'Amalia N. Judicpa'),
(101, 14, 'Negros Occidental Field Office', 'NOCCFO', 0, 'Carmela M. Abellar'),
(102, 15, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Lovely Aissa B. Velayo-Agliam'),
(103, 15, 'Technical Support and Services Division', 'TSSD', 0, 'Efren O. Vito'),
(104, 15, 'Internal Management Services Division', 'IMSD', 0, 'Joselita Remedios S. Bayalas'),
(105, 15, 'Tri-City Field Office', 'TCFO', 0, 'Marites G. Mercado'),
(106, 15, 'Cebu Field Office', 'CPFO', 0, 'Ma. Teresa D. Tanquiamco (OIC)'),
(107, 15, 'Bohol Field Office', 'BFO', 0, 'Maria Eloida O. Cantona'),
(108, 15, 'Negros Oriental Field Office', 'NORFO', 0, 'Vivencio E. Lagahid (OIC)'),
(109, 15, 'Siquijor Field Office', 'SFO', 0, 'Vivencio E. Lagahid (OIC)'),
(110, 16, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Cecilio I. Baleña'),
(111, 16, 'Technical Support and Services Division', 'TSSD', 0, 'Virgilio A. Doroja, Jr.'),
(112, 16, 'Internal Management Services Division', 'IMSD', 0, 'Marites Z. Vinas'),
(113, 16, 'North Leyte Field Office', 'NLFO', 0, 'Engr. Emmanuel Y. dela Cruz'),
(114, 16, 'Western Leyte Field Office', 'WLFO', 0, 'Edgar B. Tabuyan'),
(115, 16, 'Southern Leyte Field Office', 'SLFO', 0, 'Eden Ligaya Y. Golong (OIC)'),
(116, 16, 'Biliran Field Office', 'BFO', 0, 'Francisco A. Segovia, Jr. (OIC)'),
(117, 16, 'Samar Field Office', 'SFO', 0, 'Engr. Aleksei D. Abellar'),
(118, 16, 'Eastern Samar Field Office', 'ESFO', 0, 'Fe Norma D. Valuis'),
(119, 16, 'Northern Samar Field Office', 'NSFO', 0, 'Primo N. Guarin (OIC)'),
(120, 17, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Liza Ann Gagaracruz-Capin'),
(121, 17, 'Technical Support and Services Division', 'TSSD', 0, 'Engr. Wesley D. Tan'),
(122, 17, 'Internal Management Services Division', 'IMSD', 0, 'Elsa B. Tan'),
(123, 17, 'Isabelita City Field Office', 'ICFO', 0, 'Marlyn M. Anoos'),
(124, 17, 'Zamboanga City Field Office', 'ZCFO', 0, 'Maria Elena T. Alabata'),
(125, 17, 'Zamboanga del Norte Field Office', 'ZDNFO', 0, 'Aileen B. Mondejar'),
(126, 17, 'Zamboanga del Sur Field Office', 'ZDSFO', 0, 'Miraflor J. Casanes'),
(127, 17, 'Zamboanga Sibugay Field Office', 'ZSFO', 0, 'Elamsalih E. Ungad'),
(128, 18, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Amor Condeo T. Bajarla'),
(129, 18, 'Technical Support and Services Division', 'TSSD', 0, 'Atheneus A. Vasalla'),
(130, 18, 'Internal Management Services Division', 'IMSD', 0, 'Lucila S. Pulvera'),
(131, 18, 'Bukidnon Field Office', 'BUKFO', 0, 'Raul L. Valmores'),
(132, 18, 'Cagayan de Oro Field Office', 'CDOFO', 0, 'Emmanuel G. Toledo'),
(133, 18, 'Camiguin Provincial  Office', 'CFO', 0, 'Arlyn Z. Bael'),
(134, 18, 'Lanao del Norte Provincial Office', 'LDNFO', 0, 'Criste O. Perfecto'),
(135, 18, 'Misamis Occidental Field Office', 'MOCFO', 0, 'Ebba B. Acosta'),
(136, 18, 'Misamis Oriental Field Office', 'MORFO', 0, 'Jose Errol A. Natividad'),
(137, 19, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Connie Beb A. Torralba'),
(138, 19, 'Technical Support and Services Division', 'TSSD', 0, 'Paul V. Cruz (OIC)'),
(139, 19, 'Internal Management Services Division', 'IMSD', 0, 'Dimple T. Dumandagan (OIC)'),
(140, 19, 'Davao City Field Office', 'DCFO', 0, 'Henry O. Montilla'),
(141, 19, 'Davao del Sur Field Office', 'DSFO', 0, 'Leo Ariel A. Pepino'),
(142, 19, 'Davao Occidental Field Office', 'DOCFO', 0, 'Reynold H. Salmite (OIC)'),
(143, 19, 'Davao del Norte Field Office', 'DNFO', 0, 'Erlinda G. Mamitag'),
(144, 19, 'Davao de Oro Field Office', 'DORFO', 0, 'Neil Allan R. Baban'),
(145, 19, 'Davao Oriental Field Office', 'DOFO', 0, 'Rodolfo T. Castro, Jr.'),
(146, 20, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Jasmin Demetillo-Galvan'),
(147, 20, 'Technical Support and Services Division', 'TSSD', 0, 'Ruby B. Carrasco'),
(148, 20, 'Internal Management Services Division', 'IMSD', 0, 'Fatima Quorayce L. Bataga'),
(149, 20, 'General Santos City Field Office', 'GSCFO', 0, 'Domingo C. Baron'),
(150, 20, 'North Cotabato Field Office', 'NCFO', 0, 'Marjorie P. Latoja'),
(151, 20, 'Sarangani Field Office', 'SARFO', 0, 'Sheila Marie D. Dumalay'),
(152, 20, 'South Cotabato Field Office', 'SCFO', 0, 'Willie B. Concepcion'),
(153, 20, 'Sultan Kudarat Field Office', 'SKFO', 0, 'Mary Jane C. Hoksuan'),
(154, 21, 'Mediation Arbitration and Legal Services Unit', 'MALSU', 0, 'Atty. Rechell Bazar-Apao'),
(155, 21, 'Technical Support and Services Division', 'TSSD', 0, 'Annie C. Tangpos'),
(156, 21, 'Internal Management Services Division', 'IMSD', 0, 'Raymond Fel F. Sajor'),
(157, 21, 'Agusan del Norte Field Office', 'ADNFO', 0, 'Keith C. Duran'),
(158, 21, 'Agusan del Sur Field Office', 'ADSPO', 0, 'Buhawe C. Correa (OIC)'),
(159, 21, 'Surigao del Norte Field Office', 'SDMPO', 0, 'May C. Velonta'),
(160, 21, 'Surigao del Sur Field Office', 'SDSPO', 0, 'Genebelle B. Bal'),
(161, 21, 'Province of Dinagat Islands Satellite Office', 'PDISO', 0, 'Engr. John Ritche A. Tangpos (OIC)'),
(162, 22, 'Personnel Administration Division', 'PAD', 0, 'Arvin G. Carandang'),
(163, 22, 'Staff Development Division', 'SDD', 0, 'Aurea P. Espinosa (OIC)'),
(164, 23, 'Operations Audit Division', 'OAD', 0, 'Eva E. Gabon (OIC)'),
(165, 23, 'Management Audit Division', 'MAD', 0, 'Claro Emmanuel M. Lavado'),
(166, 24, 'Legal Representation Division', 'LRD', 0, 'Atty. Florence P. Daquioag'),
(167, 24, 'Legal Research and Assistance Division', 'LRAD', 0, 'Atty. Pedro G. Mabagos, Jr.'),
(168, 24, 'Case Review and Investigation Division', 'CRID', 0, 'Atty. Jal A. Marquez'),
(169, 25, 'General Services Division', 'GSD', 0, 'Desiree E. Estrella (OIC)'),
(170, 25, 'Property Division', 'PD', 0, 'Rafael R. Velasco, Jr.'),
(171, 25, 'Cash Division', 'CD', 0, 'Jomar B. Eguia (OIC)'),
(172, 26, 'Accounting Division', 'AD', 0, 'Jose B. Galano'),
(173, 26, 'Budget Division', 'BD', 0, 'Emelita L. Mercado'),
(174, 26, 'Management Division', 'MD', 0, 'Odette Leh V. Caragos'),
(175, 27, 'Media and External Relations Division', 'MERD', 0, 'Carla P. San Diego (OIC)'),
(176, 27, 'Information and Publication Division', 'IPD', 0, NULL),
(177, 6, 'Office of the Assistant Regional Director I', 'OARD-I', 0, 'Atty. Olivia  O. Obrero-Samson'),
(178, 6, 'Office of the Assistant Regional Director II', 'OARD-II', 0, 'Atty. Jude Thomas P. Trayvilla  '),
(179, 7, 'Office of the Assistant Regional Director', 'OARD', 0, 'Emerito A. Narag, Ph.D.'),
(180, 8, 'Office of the Assistant Regional Director', 'OARD', 0, 'Honorina Dian - Baga'),
(181, 9, 'Office of the Assistant Regional Director', 'OARD', 0, 'Atty. Nepomuceno A. Leaño II'),
(182, 10, 'Office of the Assistant Regional Director', 'OARD', 0, 'Alejandro Inza Cruz'),
(183, 11, 'Office of the Assistant Regional Director', 'OARD', 0, 'Atty. Marion S. Sevilla'),
(184, 12, 'Office of the Assistant Regional Director', 'OARD', 0, 'Nicanor V. Bon'),
(185, 13, 'Office of the Assistant Regional Director', 'OARD', 0, 'Imelda E. Romanillos'),
(186, 14, 'Office of the Assistant Regional Director', 'OARD', 0, 'Melisa S. Navarra, CPA - OIC'),
(187, 15, 'Office of the Assistant Regional Director', 'OARD', 0, 'Emmanuel Y. Ferrer - OIC'),
(188, 16, 'Office of the Assistant Regional Director', 'OARD', 0, 'Norman L. Uyvico - OIC'),
(189, 17, 'Office of the Assistant Regional Director', 'OARD', 0, 'Imelda F. Gatinao'),
(190, 18, 'Office of the Assistant Regional Director', 'OARD', 0, 'Atty. Russel A. Jallorina'),
(191, 19, 'Office of the Assistant Regional Director', 'OARD', 0, 'Atty. Jason P. Balais'),
(192, 20, 'Office of the Assistant Regional Director', 'OARD', 0, 'Arlene R. Bisnon'),
(193, 21, 'Office of the Assistant Regional Director', 'OARD', 0, 'Raymond Fel F. Sajor - OIC');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_27_015438_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `cluster_id` int(11) NOT NULL DEFAULT 0,
  `cluster_asec_id` int(11) NOT NULL DEFAULT 0,
  `office_name` varchar(125) DEFAULT NULL,
  `abbre` varchar(25) DEFAULT NULL,
  `employee_id` bigint(20) NOT NULL DEFAULT 0,
  `director_name` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `cluster_id`, `cluster_asec_id`, `office_name`, `abbre`, `employee_id`, `director_name`) VALUES
(1, 1, 1, 'Bureau of Local Employment', 'BLE', 0, 'Patrick P. Patriwirawan, Jr.'),
(2, 2, 2, 'Bureau of Working Conditions', 'BWC', 0, 'Atty. Alvin B. Curada'),
(3, 2, 2, 'Bureau of Workers with Special Concerns', 'BWSC', 0, 'Ahmma Charisma Lobrin-Satumba'),
(4, 3, 3, 'Bureau of Labor Relations', 'BLR', 0, 'Atty. Maria Consuelo S. Bacay (OIC)'),
(5, 3, 3, 'Planning Service', 'PS', 0, 'Adeline T. de Castro'),
(6, 3, 3, 'National Capital Region', 'NCR', 3, 'Atty. Sarah Buena S. Mirasol'),
(7, 3, 3, 'Cordillera Administrative Region', 'CAR', 0, 'Nathaniel V. Lacambra'),
(8, 3, 3, 'Regional Office I (Ilocos Region)', 'RO1', 0, 'Exequiel Ronie A. Guzman'),
(9, 3, 3, 'Regional Office II (Cagayan Valley)', 'RO2', 0, 'Jesus Elpidio B. Atal, Jr.'),
(10, 3, 3, 'Regional Office III (Central Luzon)', 'RO3', 0, 'Geraldine M. Panlilio'),
(11, 3, 3, 'Regional Office IV-A (CALABARZON)', 'RO4A', 0, 'Atty. Roy L. Buenafe'),
(12, 3, 3, 'MIMAROPA Region', 'MIMAROPA', 0, 'Naomi Lyn C. Abellana'),
(13, 3, 3, 'Regional Office V (Bicol Region)', 'RO5', 0, 'Imelda E. Romanillos (OIC-Regional Director)'),
(14, 3, 3, 'Regional Office VI (Western Visayas)', 'RO6', 0, 'Atty. Sixto T. Rodriguez, Jr.'),
(15, 3, 3, 'Regional Office VII (Central Visayas)', 'RO7', 0, 'Lilia A. Estillore'),
(16, 3, 3, 'Regional Office VIII (Easter Visayas)', 'RO8', 0, 'Atty. Dax B. Villaruel (OIC-Regional Director)'),
(17, 3, 3, 'Regional Office IX (Zamboanga Peninsula)', 'RO9', 0, 'Albert E. Gutib'),
(18, 3, 3, 'Regional Office X (Northern Mindanao)', 'RO10', 0, 'Atty. Erwin N. Aquino'),
(19, 3, 3, 'Regional Office XI (Davao Region)', 'RO11', 0, 'Atty. Randolf C. Pensoy'),
(20, 3, 3, 'Regional Office XII (SOCCSKSARGEN)', 'RO12', 0, 'Joel M. Gonzales'),
(21, 3, 3, 'Regional Office XIII (Caraga)', 'RO13', 0, 'Atty. Joffrey M. Suyao'),
(22, 3, 4, 'Human Resources Development Service', 'HRDS', 0, 'Brenalyn A. Peji'),
(23, 3, 4, 'Internal Audit Service', 'IAS', 0, 'Roderick D. Roldan (OIC)'),
(24, 4, 5, 'Legal Service', 'LS', 0, 'Atty. Gilbert D. Cacatian'),
(25, 5, 6, 'Administrative Service', 'AS', 0, 'Ina Lou B. Floirendo'),
(26, 5, 6, 'Financial and Management Service', 'FMS', 0, 'Edithliane P. Tadeo (OIC)'),
(27, 5, 6, 'Information and Publication Service', 'IPS', 0, 'Rosalinda P. Pineda (OIC)');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('blg1HyobRTr8GvcZJlN1t1xqmOlr8YqSGf4PIbc9', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2xDSjZjUmdCU3FWbTlYcHpGMWJwaXhiQ2s0T1k0UmVtWHhva25mVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1719480005);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `uniq_id` varchar(125) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(125) DEFAULT NULL,
  `designate` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `username` varchar(125) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `first_login` bit(1) NOT NULL DEFAULT b'0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uniq_id`, `firstname`, `lastname`, `designate`, `email`, `email_verified_at`, `mobile_no`, `username`, `password`, `remember_token`, `first_login`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'RrelA9BwrrHZwbcORrTzAQiIuY7fwHtx', 'General', 'Administrator', 'Senior Labor and Employment Officer', 'superadmin@email.com', '2024-06-27 04:04:25', '639123456789', 'generaladmin', '$2y$12$mQDSxpgb026HA43U3l4CFeNvtRBkuUqGNhOzg4C5He.IPHEd4oxrG', NULL, b'1', NULL, '2024-06-27 04:04:25', '2024-06-27 01:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_authenticates`
--

CREATE TABLE `user_authenticates` (
  `user_uniq_id` varchar(125) DEFAULT NULL,
  `token` varchar(125) NOT NULL,
  `code` varchar(15) NOT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_authenticates`
--

INSERT INTO `user_authenticates` (`user_uniq_id`, `token`, `code`, `expired_at`, `created_at`) VALUES
('RrelA9BwrrHZwbcORrTzAQiIuY7fwHtx', 'x6Kf6MnCqLcAAGyd4jvTfXaG3Q7LBklx9u1gSk24qKys9XmlaoPE3Ziftfc3AKHJ', '978462', '2024-06-26 23:52:00', '2024-06-26 23:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_jurisdictions`
--

CREATE TABLE `user_jurisdictions` (
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `cluster_id` int(11) NOT NULL DEFAULT 0,
  `office_id` int(11) NOT NULL DEFAULT 0,
  `division_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_jurisdictions`
--

INSERT INTO `user_jurisdictions` (`user_id`, `cluster_id`, `office_id`, `division_id`) VALUES
(1, 5, 25, 170);

-- --------------------------------------------------------

--
-- Table structure for table `user_privileges`
--

CREATE TABLE `user_privileges` (
  `user_id` bigint(20) NOT NULL,
  `user_view` bit(1) NOT NULL DEFAULT b'0',
  `user_add` bit(1) NOT NULL DEFAULT b'0',
  `user_edit` bit(1) NOT NULL DEFAULT b'0',
  `user_delete` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_privileges`
--

INSERT INTO `user_privileges` (`user_id`, `user_view`, `user_add`, `user_edit`, `user_delete`) VALUES
(1, b'1', b'1', b'1', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `clusters`
--
ALTER TABLE `clusters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cluster_asecs`
--
ALTER TABLE `cluster_asecs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cluster_usec_id` (`cluster_usec_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `cluster_usecs`
--
ALTER TABLE `cluster_usecs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cluster_id` (`cluster_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_id` (`office_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cluster_asec_id` (`cluster_asec_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `uniq_id` (`uniq_id`),
  ADD KEY `mobile_no` (`mobile_no`);

--
-- Indexes for table `user_authenticates`
--
ALTER TABLE `user_authenticates`
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_uniq_id` (`user_uniq_id`);

--
-- Indexes for table `user_jurisdictions`
--
ALTER TABLE `user_jurisdictions`
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `cluster_id` (`cluster_id`),
  ADD KEY `office_id` (`office_id`),
  ADD KEY `division_id` (`division_id`);

--
-- Indexes for table `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clusters`
--
ALTER TABLE `clusters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cluster_asecs`
--
ALTER TABLE `cluster_asecs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cluster_usecs`
--
ALTER TABLE `cluster_usecs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_jurisdictions`
--
ALTER TABLE `user_jurisdictions`
  ADD CONSTRAINT `user_jurisdictions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD CONSTRAINT `user_privileges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
