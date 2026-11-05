-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Des 2024 pada 06.08
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `casepose`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertProject` (IN `p_projectId` VARCHAR(20), IN `p_projectName` VARCHAR(255), IN `p_projectDescription` TEXT, IN `p_projectType` VARCHAR(255), IN `p_projectLink` VARCHAR(255), IN `p_projectDate` DATE, IN `p_name_file` VARCHAR(255), IN `p_projectTag` VARCHAR(255), IN `p_projectStatus` VARCHAR(255), IN `p_userId` VARCHAR(255))   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        -- Rollback transaksi jika terjadi error
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Terjadi kesalahan saat menyisipkan data';
    END;

    -- Validasi panjang projectName
    IF LENGTH(p_projectName) > 40 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Project name terlalu panjang, maksimal 40 karakter';
    END IF;

    -- Validasi prefix projectLink
    IF LEFT(p_projectLink, 8) <> 'https://' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Project link harus dimulai dengan "https://"';
    END IF;

    -- Validasi panjang projectTag
    IF LENGTH(p_projectTag) > 255 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Project tag terlalu panjang, maksimal 255 karakter';
    END IF;

    -- Mulai transaksi
    START TRANSACTION;

    -- Menyisipkan data ke dalam tabel project
    INSERT INTO project (projectId, projectName, projectType, projectDescription, projectLink, projectPicture, uploadDate, projectStatus, projectTag, userId)
    VALUES (p_projectId, p_projectName, p_projectType, p_projectDescription, p_projectLink, p_name_file, p_projectDate, p_projectStatus, p_projectTag, p_userId);

    -- Commit transaksi
    COMMIT;
END$$

--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `insert_user` (`p_firstname` VARCHAR(255), `p_lastname` VARCHAR(255), `p_email` VARCHAR(255), `p_password` VARCHAR(255)) RETURNS TINYINT(1)  BEGIN
    DECLARE last_id INT;
    DECLARE new_id VARCHAR(255);
    DECLARE hashed_password VARCHAR(255);

    -- Hitung ID pengguna terakhir
    SELECT COUNT(userId) INTO last_id FROM user;

    -- Buat ID pengguna baru
    SET new_id = CONCAT(p_firstname, last_id);

    -- Hash kata sandi
    SET hashed_password = SHA2(p_password, 256);

    -- Masukkan data pengguna ke dalam tabel user
    INSERT INTO user (userId, email, password, firstName, lastName)
    VALUES (new_id, p_email, hashed_password, p_firstname, p_lastname);

    -- Periksa apakah baris baru berhasil ditambahkan
    IF ROW_COUNT() > 0 THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `adminId` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`adminId`, `username`, `password`) VALUES
('1', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `adminprojectslogactivity`
--

CREATE TABLE `adminprojectslogactivity` (
  `adminId` varchar(255) NOT NULL,
  `projectId` varchar(255) NOT NULL,
  `logDate` date DEFAULT NULL,
  `projectStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `logactivity`
--

CREATE TABLE `logactivity` (
  `id` int(11) NOT NULL,
  `tableName` varchar(255) DEFAULT NULL,
  `actionType` varchar(50) DEFAULT NULL,
  `actionTimestamp` date NOT NULL DEFAULT current_timestamp(),
  `actionDetail` varchar(255) NOT NULL,
  `userId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `logactivity`
--

INSERT INTO `logactivity` (`id`, `tableName`, `actionType`, `actionTimestamp`, `actionDetail`, `userId`) VALUES
(13, 'user', 'UPDATE', '2024-06-10', 'Other changes made in user table', 'Riversone6'),
(14, 'user', 'UPDATE', '2024-06-10', 'Other changes made in user table', 'Riversone6'),
(15, 'user', 'UPDATE', '2024-06-10', 'Other changes made in user table', 'Riversone6'),
(16, 'user', 'You change your Profile', '2024-06-10', 'You changed your First Name', 'Riversone6'),
(17, 'project', 'you deleted your Project ', '2024-06-10', 'A project has been deleted', 'Riversone6'),
(18, 'user', 'You change your Profile', '2024-06-10', 'You changed your Instagram Link', 'Riversone6'),
(19, 'project', 'You change your Project', '2024-06-10', 'Project name changed', 'Riversone6'),
(20, 'project', 'You change your Project', '2024-06-10', 'Project name changed', 'Riversone6'),
(21, 'user', 'You change your Profile', '2024-06-10', 'You changed your First Name', '2'),
(22, 'user', 'You change your Profile', '2024-06-12', 'You changed your First Name', 'Riversone6'),
(23, 'user', 'You change your Profile', '2024-06-12', 'You changed your Last Name', '2'),
(24, 'project', 'You change your Project', '2024-06-12', 'Project name changed', '2'),
(25, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(26, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', NULL),
(27, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(28, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(29, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', NULL),
(30, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', NULL),
(31, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(32, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', NULL),
(33, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', '2'),
(34, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', 'supercell6'),
(35, 'user', 'You change your Profile', '2024-06-12', 'You changed your Description', 'supercell6'),
(36, 'user', 'You change your Profile', '2024-06-12', 'You changed your First Name', '2'),
(37, 'project', 'you insert new Project', '2024-06-12', 'A new project has been added', '2'),
(38, 'project', 'you insert new Project', '2024-06-12', 'A new project has been added', NULL),
(39, 'project', 'you deleted your Project ', '2024-06-12', 'A project has been deleted', '2'),
(40, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', '2'),
(41, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(42, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', NULL),
(43, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(44, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(45, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(46, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(47, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(48, 'user', 'You change your Profile', '2024-06-12', 'Other changes made in user table', NULL),
(49, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', '2'),
(50, 'user', 'You change your Profile', '2024-06-12', 'You changed your Profile Picture', '2'),
(51, 'user', 'You change your Profile', '2024-06-12', 'You changed your Password', 'raya9'),
(52, 'user', 'You change your Profile', '2024-06-12', 'You changed your Password', 'raya9'),
(53, 'user', 'You change your Profile', '2024-06-13', 'You changed your Last Name', '2'),
(54, 'project', 'You change your Project', '2024-06-13', 'Project name changed', '2'),
(55, 'user', 'You change your Profile', '2024-06-13', 'You changed your Profile Picture', '2'),
(56, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(57, 'user', 'You change your Profile', '2024-06-13', 'You changed your Profile Picture', NULL),
(58, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(59, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(60, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(61, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(62, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(63, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(64, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', NULL),
(65, 'user', 'You change your Profile', '2024-06-13', 'Other changes made in user table', '2'),
(66, 'project', 'you insert new Project', '2024-06-13', 'A new project has been added', NULL),
(67, 'project', 'You change your Project', '2024-06-13', 'Project name changed', '2'),
(68, 'project', 'you deleted your Project ', '2024-06-13', 'A project has been deleted', '2'),
(69, 'user', 'You change your Profile', '2024-06-13', 'You changed your Profile Picture', '2'),
(70, 'user', 'You change your Profile', '2024-06-13', 'You changed your Password', '2'),
(71, 'project', 'You change your Project', '2024-06-13', 'Project tag changed', '2'),
(72, 'user', 'You change your Profile', '2024-11-21', 'You changed your First Name', '1'),
(73, 'user', 'You change your Profile', '2024-12-27', 'You changed your Profile Picture', '2'),
(74, 'project', 'You change your Project', '2024-12-27', 'Project name changed', '2'),
(75, 'project', 'You change your Project', '2024-12-27', 'Project name changed', '2'),
(76, 'project', 'You change your Project', '2024-12-27', 'Project description changed', '2'),
(77, 'project', 'You change your Project', '2024-12-27', 'Project description changed', '2'),
(78, 'project', 'You change your Project', '2024-12-27', 'Project description changed', '2'),
(79, 'project', 'You change your Project', '2024-12-27', 'Project description changed', '2'),
(80, 'user', 'You change your Profile', '2024-12-28', 'You changed your Profile Picture', 'Riversone6'),
(81, 'user', 'You change your Profile', '2024-12-28', 'Other changes made in user table', 'Riversone6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pricing`
--

CREATE TABLE `pricing` (
  `pricingId` int(11) NOT NULL,
  `pricingPackage` varchar(255) DEFAULT NULL,
  `dateExpired` date NOT NULL,
  `payment` varchar(10) NOT NULL,
  `projectId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pricing`
--

INSERT INTO `pricing` (`pricingId`, `pricingPackage`, `dateExpired`, `payment`, `projectId`) VALUES
(1, '2', '2024-07-06', 'DANA', '12'),
(2, '2', '2024-07-06', 'DANA', '11'),
(4, '3', '2025-06-06', 'GO-PAY', '9'),
(5, '2', '2024-07-08', 'DANA', '18'),
(6, '2', '2024-07-08', 'SHOPEE-PAY', '17'),
(7, '2', '2024-07-08', 'DANA', '16'),
(8, '3', '2025-06-08', 'DANA', '15'),
(9, '2', '2024-07-09', 'GO-PAY', '13'),
(10, '2', '2024-07-09', 'SHOPEE-PAY', '1'),
(12, '3', '2024-07-10', 'DANA', 'Instagram19'),
(13, '2', '2024-07-10', 'GO-PAY', 'BDTA19'),
(14, '2', '2024-07-10', 'DANA', '16'),
(15, '3', '2024-07-12', 'GO-PAY', '4'),
(16, '3', '2024-07-12', 'DANA', '2'),
(17, '3', '2024-07-12', 'GO-PAY', 'Clash of Clans 19'),
(18, '3', '2024-07-13', 'DANA', '3'),
(19, '3', '2024-07-13', 'DANA', 'Health19'),
(20, '3', '2024-07-13', 'DANA', 'Maniac Wars31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `projectId` varchar(255) NOT NULL,
  `projectName` varchar(255) DEFAULT NULL,
  `projectType` varchar(255) DEFAULT NULL,
  `projectDescription` text DEFAULT NULL,
  `projectLink` varchar(255) DEFAULT NULL,
  `projectPicture` varchar(255) DEFAULT NULL,
  `uploadDate` date DEFAULT NULL,
  `projectStatus` varchar(255) DEFAULT NULL,
  `projectTag` varchar(255) NOT NULL,
  `userId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`projectId`, `projectName`, `projectType`, `projectDescription`, `projectLink`, `projectPicture`, `uploadDate`, `projectStatus`, `projectTag`, `userId`) VALUES
('1', 'Dashboard Universitas Budi Luhur', 'WEBSITE', 'Dashboard Universitas Budi Luhur merupakan salah satu website untuk mahasiswa mengakses informasi seputar perkuliahan.', 'www.budiluhur.com', 'card3.png', '2024-05-08', 'FINISHED', '', '1'),
('11', 'Analystic Apps', 'MOBILE', 'analistic apps', 'https://analisis.com', 'Analistic Apps.png', '2024-06-06', 'FINISHED', 'analisis apps', 'Riversone6'),
('12', 'Aspen', 'MOBILE', 'aplikasi travel', 'https://aspen.com', 'aspen.png', '2024-06-06', 'FINISHED', 'aspen travel', 'Riversone6'),
('13', 'Hire Cup', 'WEBSITE', 'aplikasi pencari pekerjaan', 'https://hirecup.com', 'hire cup.png', '2024-06-08', 'FINISHED', 'pekerjaan mencari job freelance karyawan boss ', '1'),
('14', 'The 20', 'WEBSITE', 'Let Us Handle Your IT Service', 'https://the20.com', 'the 20.png', '2024-06-08', 'FINISHED', 'it service computer relax', '1'),
('15', 'Orbit', 'WEBSITE', 'Orbiit merupakan aplikasi perusahaan ', 'https://orbit.com', 'orbit.png', '2024-06-08', 'FINISHED', 'company orbit', '1'),
('16', 'Chat GPT', 'AI', 'AI yang dapat memudahkan anda dalam mencari informasi melalui chat', 'https://chatgpt.com', 'chatgpt.png', '2024-06-08', 'FINISHED', 'chatgpt gpt chat ai artifiicial intelegen ', '1'),
('17', 'Bing AI', 'AI', 'Ai yang dibuat oleh Microsoft yang dapat mempermudah pekerjaan anda sehari-hari', 'https://bing.com', 'bingai.png', '2024-06-08', 'FINISHED', 'bing ai bingai articial intelegence microsoft', '1'),
('18', 'Midjourney', 'AI', 'AI untuk membuat gambar sesuai deskripsi yang anda berikan', 'https://www.imagine.art', 'midjourney.png', '2024-06-08', 'FINISHED', 'ai gambar gambarai create gambar ai artificial intelegen', '1'),
('2', 'Canin', 'WEBSITE', '<p>canin merupakan project tugas yang dibuat oleh kelompok 7 RKPL di Semester 2</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'https://www.bsafe.com', 'can-in.png', '2024-05-08', 'FINISHED', 'makanan kantin pembelian kasir ', '2'),
('3', 'Jaws.ai', 'WEBSITE', 'Jaws.ai merupakan artificial intelegent yang beguna sekalai untuk kehidupan anda sebgaia seorang pekerja lepas ', NULL, 'card4.png', '2024-05-08', 'FINISHED', 'Akmal Farhan ', '2'),
('4', 'Bsafe', 'MOBILE', 'Bsafe Merupakan aplikasi mobile untuk membuat laporan pelecehan seksual secara langsung , aplikasi ini dapat membantu para korban pelecehan seksual apabila mereka mengalami kejadian yang perlu ditindak secara cepat', 'https://Bsafe.com', 'Poster-Bsafe.jpg', '2024-06-02', 'FINISHED', 'pelecehan seksual laporan pengaduan mobile upi rekayasa perangkat lunak ', '2'),
('5', 'Purity', 'E-COMMERCE', 'Purity merupakan aplikasi E - Commerce yang menjual barang - barang untuk perawatan kecantikan seperti skincare dan sebagainya , disini bukan hanya untuk wanita saja tapi untuk pria pun ada loh , kunjungi websitenya di atas kanan tulisan ini ya', 'https://purity.com', 'purity.png', '2024-06-02', 'FINISHED', 'kecantikan skincare wajah glowing cerah ganteng handsome beautiful ', 'Riversone6'),
('6', 'Can-In', 'MOBILE', 'aplikasi pemesanan makanan', 'https://can-in.com', 'can-in.png', '2024-06-06', 'FINISHED', 'makanan pemesanan aplikasi mobile  ', 'Riversone6'),
('7', 'kety', 'MOBILE', 'E-commerce alat alat kecantikan yang dapat memenuhi kebutuhan kecantikan anda', 'https://kety.com', 'kety.png', '2024-06-06', 'FINISHED', 'kecantikan makeup lipstik softlense bedak', 'Riversone6'),
('9', 'No Black', 'WEBSITE', 'investment project', 'https://noblack.com', 'noblack.png', '2024-06-06', 'FINISHED', 'investment timoty ronald', 'Riversone6'),
('BDTA19', 'BDTA', 'DESKTOP', 'Desktop', 'https://BDTA.com', 'BDTA.png', '2024-06-10', 'FINISHED', 'company desktop java design', 'Riversone6'),
('Cardano19', 'Cardano', 'MOBILE', 'Aplikasi E-Money', 'https://farhan.com', 'Cardano.png', '2024-06-10', 'FINISHED', 'uang e-money dompet digital website mobile duit ', 'Riversone6'),
('Clash of Clans 19', 'Clash of Clans ', 'GAME', 'Clash of clan merupakan game yang diciptakan pada tahun 2013', 'https://supercell.com/en/games/clashofclans/', 'coc.png', '2024-06-10', 'FINISHED', 'game coc clash of clans strategi war barbarian pekka witch king queen', 'supercell6'),
('Clash Royale19', 'Clash Royale', 'GAME', 'Game strategi 1 v 1 yang menyenangkan', 'https://supercell.com/en/games/clashroyale/', 'cr.png', '2024-06-10', 'FINISHED', 'clash royale strategi game seru 1v1 onebyone supercell barbarian ', 'supercell6'),
('Faceboook19', 'Faceboook', 'SOCIAL MEDIA', 'The King of Social media', 'https://facebook.com', 'facebook.png', '2024-06-10', 'FINISHED', 'social media facebook sosial berteman chat game ', 'Meta8'),
('GoTalk19', 'GoTalk', 'COMMUNICATION', 'Aplikasi chat', 'https://gotalk.com', 'letsChat.png', '2024-06-10', 'FINISHED', 'talk chat komunikasi whatsapp wa massanger sms pesan informasi facebook', 'Riversone6'),
('Health19', 'Health', 'DESKTOP', 'health', 'https://health.com', 'Health.png', '2024-06-10', 'FINISHED', 'kesehatan healty dokter kecantikan sehat', '2'),
('insect1', 'Insect', 'WEBSITE', 'website', 'https://insect.com', 'insect.png', '2024-06-10', 'FINISHED', 'asda asd asd asd asd asd ', 'Riversone6'),
('Instagram19', 'Instagram', 'SOCIAL MEDIA', 'Social media terlaris 2024', 'https://instagram.com', 'Instagram.png', '2024-06-10', 'FINISHED', 'instagram social media friens follow selebgram', 'Meta8'),
('Maniac Wars31', 'Maniac Wars', 'Game', 'game mobile terbaik sepanjang masa', 'https://maniac.wars.com', 'Maniac Wars.png', '2024-06-12', 'FINISHED', 'game qwertyuiop', '2'),
('Massengger19', 'Massengger', 'COMMUNICATION', 'Aplikasi Chat', 'https://www.messenger.com/', 'massangger.png', '2024-06-10', 'FINISHED', 'chat komunikasi massanger facebook instagram whatsapps meta  ', 'Meta8'),
('Minecraft 19', 'Minecraft ', 'GAME', 'game terbaik sepanjang masa', 'https://www.minecraft.net/en-us', 'mcpe.png', '2024-06-10', 'FINISHED', 'game minecraft balok creative mode survival create home ', 'Mojang7'),
('Move Services19', 'Move Services', 'DESKTOP', 'Software Testing', 'https://moveservices.com', 'moveservices.png', '2024-06-10', 'FINISHED', 'move services desktop java html php aplikasi ', 'Riversone6'),
('Squad Buster19', 'Squad Buster', 'GAME', 'game mabar dari supercell ini dirilis pada tahun 2024 ', 'https://squadbusters.supercell.com/', 'squad buster.png', '2024-06-10', 'FINISHED', 'squad buster game mabar supercell mobile ', 'supercell6'),
('WhatsApp19', 'WhatsApp', 'SOCIAL MEDIA', 'mendekatkan yang jauh menjauhkan yang dekat', 'https://www.whatsapp.com/', 'wa.png', '2024-06-10', 'FINISHED', 'whatsapp chat komunikasi hijau sw status social media meta', 'Meta8');

--
-- Trigger `project`
--
DELIMITER $$
CREATE TRIGGER `project_delete_trigger` AFTER DELETE ON `project` FOR EACH ROW BEGIN
    -- Adding record to logactivity for project deletion
    INSERT INTO logactivity (tableName, actionType, actionDetail)
    VALUES (
        'project', 
        'you deleted your Project ', 
        'A project has been deleted'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `project_insert_trigger` AFTER INSERT ON `project` FOR EACH ROW BEGIN
    -- Adding record to logactivity for project insertion
    INSERT INTO logactivity (tableName, actionType, actionDetail)
    VALUES (
        'project', 
        'you insert new Project', 
        'A new project has been added'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `project_update_trigger` AFTER UPDATE ON `project` FOR EACH ROW BEGIN
    DECLARE actionDetail TEXT;

    -- Checking for changes in each column
    IF OLD.projectName != NEW.projectName THEN
        SET actionDetail = 'Project name changed';
    ELSEIF OLD.projectType != NEW.projectType THEN
        SET actionDetail = 'Project type changed';
    ELSEIF OLD.projectDescription != NEW.projectDescription THEN
        SET actionDetail = 'Project description changed';
    ELSEIF OLD.projectLink != NEW.projectLink THEN
        SET actionDetail = 'Project link changed';
    ELSEIF OLD.projectPicture != NEW.projectPicture THEN
        SET actionDetail = 'Project picture changed';
    ELSEIF OLD.uploadDate != NEW.uploadDate THEN
        SET actionDetail = 'Project upload date changed';
    ELSEIF OLD.projectStatus != NEW.projectStatus THEN
        SET actionDetail = 'Project status changed';
    ELSEIF OLD.projectTag != NEW.projectTag THEN
        SET actionDetail = 'Project tag changed';
    ELSE
        SET actionDetail = 'Other changes made in project table';
    END IF;

    -- Adding record to logactivity
    INSERT INTO logactivity (tableName, actionType, actionDetail)
    VALUES (
        'project', 
        'You change your Project', 
        actionDetail
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_type`
--

CREATE TABLE `project_type` (
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `project_type`
--

INSERT INTO `project_type` (`nama`) VALUES
('WEBSITE'),
('DESKTOP'),
('MOBILE'),
('GAME'),
('SOCIAL MEDIA'),
('E-COMMERCE'),
('COMMUNICATION'),
('AI'),
('iot'),
('iot'),
('web'),
('AR'),
('SHOW ALL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `report`
--

CREATE TABLE `report` (
  `reportId` int(255) NOT NULL,
  `reportType` varchar(255) DEFAULT NULL,
  `reportDescription` text DEFAULT NULL,
  `reportStatus` varchar(255) DEFAULT NULL,
  `projectId` varchar(255) DEFAULT NULL,
  `userId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `report`
--

INSERT INTO `report` (`reportId`, `reportType`, `reportDescription`, `reportStatus`, `projectId`, `userId`) VALUES
(18, 'Misinformation', 'chat gpt punya elon', 'ON RIVIEW', '16', '2'),
(19, 'Harmful or Illegal', '', 'ON RIVIEW', '1', '2'),
(20, 'Misinformation', 'gatau', 'ON RIVIEW', '15', '2'),
(21, 'Misinformation', '', 'ON RIVIEW', 'Health19', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscribe`
--

CREATE TABLE `subscribe` (
  `purchaseId` varchar(255) NOT NULL,
  `subscribePackage` varchar(255) NOT NULL,
  `userId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tag`
--

CREATE TABLE `tag` (
  `nama` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tag`
--

INSERT INTO `tag` (`nama`) VALUES
('WEBSITE'),
('APPLICATION'),
('DESKTOP'),
('GAME');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userId` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePicture` varchar(255) DEFAULT NULL,
  `personalWeb` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `medium` varchar(255) DEFAULT NULL,
  `x` varchar(255) DEFAULT NULL,
  `about_me` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `email`, `password`, `profilePicture`, `personalWeb`, `instagram`, `linkedin`, `github`, `medium`, `x`, `about_me`) VALUES
('1', 'Leonardo', 'Da Vinci', 'leonardo@upi.edu', 'leonardo', '', 'https://akmal.com', '', '', '', '', '', 'I’m a student of Software Engineering at Universitas Pendidikan Indonesia (UPI), Bandung, Indonesia. I’m very interested with front-end developer. Also, i usually use framework Bootstrap and Tailwind for my entire projects. Let’s get in touch with me through social media.'),
('2', 'Farhan', 'Angga Riyanto', 'farhanangga8900@upi.edu', 'qwertyuiop', 'WhatsApp Image 2024-10-29 at 22.28.20_936114e3.jpg', 'https://farhanangga.com', 'https://instagram.com/frhnanggaa_', 'https://lingkedin/farhanangga', 'https://github.com/farhanangga', NULL, 'https://twitter.com/farhanangga', 'Halo semuanya Nama Saya Farhan Angga riyanto saya merupakan mahasiswa Rekayasa Perangkat Lunak Semester 4 , saya lahir di Kota Cirebon 11 Oktober 2003 . saya sangat senang sekali membuat website hehe'),
('3', 'nadia', 'aqmarina', 'nadiaaqmarina@upi.edu', 'leonardo', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('asd11', 'asd', 'asd', 'asdf@upi.edu', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cvb5', 'cvb', 'cvb', 'cvb@upi.edu', 'leonardo', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('farhan10', 'farhan', 'angga', 'farhan@upi.edu', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('farhan12', 'farhan', 'angga', 'aasddewq@upi.edu', '9e69e7e29351ad837503c44a5971edebc9b7e6d8601c89c284b1b59bf37afa80', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Meta8', 'Meta', 'ID', 'meta@upi.edu', '123', '', 'https://business.facebook.com/', '', '', '', '', '', 'Developer'),
('Mojang7', 'Mojang', 'id', 'mojang@upi.edu', '123', '', NULL, NULL, NULL, NULL, NULL, NULL, 'Game Developer'),
('qwe4', 'qwe', 'qwe', 'qwe@upi.edu', 'leonardo', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('raya9', 'raya', 'satriatama', 'raya@upi.edu', '123', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Riversone6', 'Riversonee', 'Here', 'riversone8900@upi.edu', '123', 'SaveInsta.App_455136007_18454086076039015_1439393058452189109_n (1).jpg', 'https://akmal.com', 'https://instagram.com/frhnanggaa_', '', '', '', '', 'hallo semuanya saya riversone'),
('supercell6', 'supercell', 'id', 'supercell@upi.edu', '123', '', 'https://supercell.com/', 'https://www.instagram.com/supercell/?hl=en', '', '', '', '', 'Game Developer  since 2004');

--
-- Trigger `user`
--
DELIMITER $$
CREATE TRIGGER `user_update_trigger` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
    DECLARE actionDetail TEXT;

    -- Memeriksa perubahan pada masing-masing kolom
    IF OLD.firstName != NEW.firstName THEN
        SET actionDetail = 'You changed your First Name';
    ELSEIF OLD.lastName != NEW.lastName THEN
        SET actionDetail = 'You changed your Last Name';
    ELSEIF OLD.email != NEW.email THEN
        SET actionDetail = 'You changed your Email';
    ELSEIF OLD.password != NEW.password THEN
        SET actionDetail = 'You changed your Password';
    ELSEIF OLD.profilePicture != NEW.profilePicture THEN
        SET actionDetail = 'You changed your Profile Picture';
    ELSEIF OLD.personalWeb != NEW.personalWeb THEN
        SET actionDetail = 'You changed your Personal Website Link';
    ELSEIF OLD.instagram != NEW.instagram THEN
        SET actionDetail = 'You changed your Instagram Link';
    ELSEIF OLD.linkedin != NEW.linkedin THEN
        SET actionDetail = 'You changed your LinkedIn Link';
    ELSEIF OLD.github != NEW.github THEN
        SET actionDetail = 'You changed your GitHub Link';
    ELSEIF OLD.medium != NEW.medium THEN
        SET actionDetail = 'You changed your Medium Link';
    ELSEIF OLD.x != NEW.x THEN
        SET actionDetail = 'You changed your X';
    ELSEIF OLD.about_me != NEW.about_me THEN
        SET actionDetail = 'You changed your Description';
    ELSE
        SET actionDetail = 'Other changes made in user table';
    END IF;

    -- Menambahkan catatan ke logactivity
    INSERT INTO logactivity (tableName, actionType, actionDetail)
    VALUES (
        'user', 
        'You change your Profile', 
        actionDetail
    );
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `adminprojectslogactivity`
--
ALTER TABLE `adminprojectslogactivity`
  ADD PRIMARY KEY (`adminId`,`projectId`),
  ADD KEY `projectId` (`projectId`);

--
-- Indeks untuk tabel `logactivity`
--
ALTER TABLE `logactivity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userId` (`userId`);

--
-- Indeks untuk tabel `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`pricingId`),
  ADD KEY `projectId` (`projectId`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`projectId`),
  ADD KEY `userId` (`userId`);

--
-- Indeks untuk tabel `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `projectId` (`projectId`);

--
-- Indeks untuk tabel `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`purchaseId`),
  ADD KEY `userId` (`userId`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `logactivity`
--
ALTER TABLE `logactivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `pricing`
--
ALTER TABLE `pricing`
  MODIFY `pricingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `report`
--
ALTER TABLE `report`
  MODIFY `reportId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `adminprojectslogactivity`
--
ALTER TABLE `adminprojectslogactivity`
  ADD CONSTRAINT `adminprojectslogactivity_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admin` (`adminId`),
  ADD CONSTRAINT `adminprojectslogactivity_ibfk_2` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`);

--
-- Ketidakleluasaan untuk tabel `logactivity`
--
ALTER TABLE `logactivity`
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Ketidakleluasaan untuk tabel `pricing`
--
ALTER TABLE `pricing`
  ADD CONSTRAINT `pricing_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`);

--
-- Ketidakleluasaan untuk tabel `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Ketidakleluasaan untuk tabel `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`);

--
-- Ketidakleluasaan untuk tabel `subscribe`
--
ALTER TABLE `subscribe`
  ADD CONSTRAINT `subscribe_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
