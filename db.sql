-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 06, 2018 at 06:10 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `familap1_db`
--

DELIMITER $$
--
-- Procedures
--
$$

$$

$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `describe` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `admin_type` bigint(20) UNSIGNED DEFAULT '0' COMMENT 'آی دی والد . کسی که او را ایجاد کرده و توان تغییر او را دارد',
  `mobile` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `date` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ ایجاد پروفایل',
  `credit` double NOT NULL DEFAULT '0',
  `sdk` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `model` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `line` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `softversion` int(11) DEFAULT '0',
  `is_vip` int(11) DEFAULT '0',
  `chat_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `chat_state` int(11) DEFAULT '0',
  `chat_data` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_block` tinyint(4) DEFAULT '0',
  `blockdesc` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL,
  `block_date` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول ثبت مدیران سیستم و اپراتور ها';

--
-- Dumping data for table `admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `adslog`
--

CREATE TABLE `adslog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `telgroup_id` bigint(20) DEFAULT NULL,
  `registered_plan_id` bigint(20) DEFAULT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `part` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `price` double DEFAULT '0',
  `count` bigint(20) DEFAULT '0',
  `totoal_price` double DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adsvisit`
--

CREATE TABLE `adsvisit` (
  `id` bigint(20) NOT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `referrer` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
  `device` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `screen` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `admin` bigint(20) DEFAULT NULL,
  `os` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
  `browser` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_mobile` int(1) DEFAULT '1',
  `part` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `data` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_ads` tinyint(4) DEFAULT '0',
  `plan_registered_id` bigint(20) DEFAULT NULL,
  `price` int(11) DEFAULT '0',
  `is_calc` tinyint(3) UNSIGNED DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8,
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_type` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `accepted` tinyint(11) DEFAULT '0',
  `readed` tinyint(4) DEFAULT '0',
  `softversion` int(11) UNSIGNED DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL,
  `photos` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `shajarename_id` bigint(20) DEFAULT NULL,
  `member_index` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `geraph`
--

CREATE TABLE `geraph` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shajarename_id` bigint(20) DEFAULT NULL,
  `create_date` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ip` varchar(40) COLLATE utf8_persian_ci DEFAULT NULL,
  `geraph_date` text COLLATE utf8_persian_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='داده های گراف شجره نامه ها برای نمایش آنلاین';

--
-- Dumping data for table `geraph`
--

-- --------------------------------------------------------

--
-- Table structure for table `itransaction`
--

CREATE TABLE `itransaction` (
  `id` bigint(20) NOT NULL,
  `res_num` varchar(100) DEFAULT NULL COMMENT 'کد تراکنشی که با متصل شدن به بانک داده میشود',
  `ref_num` varchar(100) DEFAULT NULL COMMENT 'کد پیگیری بعد از موفقیت آمیز بودن عملیات',
  `total_amount` double DEFAULT NULL,
  `payment` varchar(50) DEFAULT NULL,
  `date_start` varchar(50) DEFAULT NULL,
  `last_url` varchar(1000) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `time_start` timestamp NULL DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `comment` text,
  `facture_id` bigint(20) DEFAULT '0',
  `temp_credit` double DEFAULT NULL,
  `payload` varchar(200) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `plan_id` varchar(30) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `is_accept` tinyint(1) UNSIGNED DEFAULT NULL,
  `acceptor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date_accept` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shajarename_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `family` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
  `birthdate` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `index` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_male` tinyint(4) DEFAULT NULL,
  `is_died` tinyint(4) DEFAULT NULL,
  `phone_number` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `partners` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL,
  `father_id` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `mother_id` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `childs` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_persian_ci,
  `died_date` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `photo_path` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `photos` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `describtion` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `member`
--

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE `option` (
  `option_id` bigint(20) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`option_id`, `key`, `value`) VALUES
(1, 'theme', 'familapp'),
(3, 'theme_active', 'familapp'),
(23, 'photo_resize', 'on'),
(24, 'photo_archive_path', 'archive'),
(25, 'photo_width', '800'),
(26, 'photo_height', '600'),
(27, 'photo_small_width', '100'),
(28, 'photo_small_height', '80');

-- --------------------------------------------------------

--
-- Table structure for table `ostan`
--

CREATE TABLE `ostan` (
  `name` varchar(100) NOT NULL,
  `id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ostan`
--

INSERT INTO `ostan` (`name`, `id`) VALUES
('آذربايجان شرقي', 1),
('آذربايجان غربي', 2),
('اردبيل', 3),
('اصفهان', 4),
('ايلام', 5),
('بوشهر', 6),
('تهران', 7),
('چهارمحال وبختياري', 8),
('خراسان جنوبي', 9),
('خراسان رضوي', 10),
('خراسان شمالي', 11),
('خوزستان', 12),
('زنجان', 13),
('سمنان', 14),
('سيستان و بلوچستان', 15),
('فارس', 17),
('قزوين', 18),
('قم', 19),
('كردستان', 20),
('كرمان', 21),
('كرمانشاه', 22),
('كهگيلويه وبوير احمد', 23),
('گلستان', 24),
('گيلان', 25),
('لرستان', 26),
('مازندران', 27),
('مركزي', 28),
('هرمزگان', 29),
('همدان', 30),
('يزد', 31);

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `description` text,
  `picture_path` varchar(1000) DEFAULT NULL,
  `create_date` varchar(30) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `like_count` bigint(20) DEFAULT '0',
  `view_count` bigint(20) DEFAULT '0',
  `item_type` varchar(20) DEFAULT NULL,
  `shajarename_id` bigint(20) DEFAULT NULL,
  `member_index` varchar(30) DEFAULT NULL,
  `accepted` tinyint(4) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picture`
--



-- --------------------------------------------------------

--
-- Table structure for table `shahr`
--

CREATE TABLE `shahr` (
  `name` varchar(100) NOT NULL,
  `ostan_id` bigint(20) UNSIGNED NOT NULL,
  `id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shahr`
--

INSERT INTO `shahr` (`name`, `ostan_id`, `id`) VALUES
('ابرکوه', 31, 1),
('ابوموسي', 29, 2),
('اراک', 28, 3),
('اردبيل', 3, 4),
('اردستان', 4, 5),
('پارس آباد', 3, 6),
('اروميه', 2, 7),
('ازنا', 26, 8),
('آباده\r\nاصفهان\r\n\r\n', 17, 9),
('اصفهان', 4, 10),
('اصفهان - شرق', 4, 11),
('اقليد', 17, 12),
('الاشت', 27, 13),
('الشتر', 26, 14),
('اليگودرز', 26, 15),
('اميديه', 12, 16),
('انار', 21, 17),
('اهر', 1, 18),
('اهواز', 12, 19),
('ايذه', 12, 20),
('ايرانشهر', 15, 21),
('ايزدخواست', 17, 22),
('ايلام', 5, 23),
('ايوان', 5, 24),
('آبادان', 12, 25),
('آباده', 17, 26),
('آب بر', 13, 27),
('آبعلي', 7, 28),
('آستارا', 25, 29),
('آلودگي', 7, 30),
('آمل', 27, 31),
('آوج', 18, 32),
('بابلسر', 27, 33),
('بافت', 21, 34),
('بافق', 31, 35),
('بانه', 20, 36),
('رشت', 25, 37),
('بجنورد', 11, 38),
('بدرآباد', 22, 39),
('بروجرد', 26, 40),
('بروجن', 8, 41),
('بستان', 12, 42),
('بشرويه', 9, 43),
('رامهرمز', 12, 44),
('رباط پشت بادام', 31, 45),
('بم', 21, 46),
('بناب', 1, 47),
('بندر دير', 6, 48),
('بندر ديلم', 6, 49),
('بندر عباس', 29, 50),
('بندر لنگه', 29, 51),
('بندر ماهشهر', 12, 52),
('بندرانزلي', 25, 53),
('بهبهان', 12, 54),
('بوانات', 17, 55),
('بوشهر', 6, 56),
('بوکان', 2, 57),
('بيارجمند', 14, 58),
('بيجار', 20, 59),
('بيرجند', 9, 60),
('بيله سوار', 3, 61),
('پل دختر', 22, 62),
('رامسر', 27, 63),
('پل سفيد', 27, 64),
('پيرانشهر', 2, 65),
('تاكستان', 18, 66),
('تبريز', 1, 67),
('تربت جام', 10, 68),
('تربت حيدريه', 10, 69),
('تفرش', 28, 70),
('تهران', 7, 71),
('تهران - فرودگاه امام', 7, 72),
('تهران (شمال)', 7, 73),
('تکاب', 2, 74),
('بندر جاسك', 29, 75),
('جلفا', 1, 76),
('جم توحيد', 6, 77),
('چابهار', 15, 78),
('چالدران', 1, 79),
('حاجي آباد', 29, 80),
('حسينيه', 12, 81),
('خارک', 6, 82),
('خاش', 15, 83),
('خدابنده', 13, 84),
('خرم آباد', 26, 85),
('خرمدره', 13, 86),
('خلخال', 3, 87),
('خمين', 28, 88),
('خور بيابانک', 4, 89),
('خوي', 2, 90),
('داراب', 17, 91),
('داران', 4, 92),
('دامغان', 14, 93),
('دره شهر', 5, 94),
('درود', 4, 95),
('دزفول', 12, 96),
('دليجان', 28, 97),
('دهداز', 12, 98),
('دهلران', 5, 99),
('دوگنبدان', 23, 100),
('شهرري', 7, 101),
('رفسنجان', 21, 102),
('روانسر', 22, 103),
('زابل', 15, 104),
('زاهدان', 15, 105),
('زاهك زابل ', 15, 106),
('زرقان', 17, 107),
('زرند', 21, 108),
('زرينه اوباتو', 20, 109),
('زنجان', 13, 110),
('ساري\r\n\r\n', 27, 111),
('سامان', 8, 112),
('ساوه', 28, 113),
('سبزوار', 10, 114),
('سد دروزن', 17, 115),
('سر پل ذهاب', 22, 116),
('سراب', 1, 117),
('سراوان', 15, 118),
('سرخس', 10, 119),
('سردشت', 2, 120),
('سرعين', 3, 121),
('سقز', 20, 122),
('سلفچگان', 19, 123),
('سلماس', 2, 124),
('سمنان', 14, 125),
('سميرم', 4, 126),
('سنقر', 22, 127),
('سنندج', 20, 128),
('سهند', 1, 129),
('سيرجان', 21, 130),
('شاهرود', 14, 131),
('شهداد', 21, 132),
('شهربابك', 21, 133),
('شهرضا', 4, 134),
('شهرکرد', 8, 135),
('شوشتر', 12, 136),
('شيراز', 17, 137),
('صفي آباد', 10, 138),
('طبس', 9, 139),
('عقدا', 31, 140),
('غريز', 31, 141),
('فردوس', 9, 142),
('فسا', 17, 143),
('فيروزکوه', 7, 144),
('قائن', 9, 145),
('قراخيل', 27, 146),
('قره ضياءالدين', 2, 147),
('قروه', 20, 148),
('قزوين', 18, 149),
('قشم', 29, 150),
('قصر شيرين', 22, 151),
('قم', 19, 152),
('قوچان', 10, 153),
('کاشان', 4, 154),
('کاشمر', 10, 155),
('کرج', 7, 156),
('کرمان', 21, 157),
('کرمانشاه', 22, 158),
('کلاله', 24, 159),
('کليبر', 1, 160),
('کميجان', 28, 161),
('کنارک چابهار', 15, 162),
('کنگاور', 22, 163),
('كهنوج', 21, 164),
('کوهدشت', 26, 165),
('کوهرنگ', 8, 166),
('کياسر', 27, 167),
('کيش', 29, 168),
('پارسيان', 29, 169),
('گرگان', 24, 170),
('گرمسار', 14, 171),
('گلپايگان', 4, 172),
('گلمگان', 10, 173),
('گناباد', 10, 174),
('گنبد کاووس', 24, 175),
('لار', 17, 176),
('لاله زار', 21, 177),
('لامرد', 17, 178),
('لاهيجان', 25, 179),
('لردگان', 8, 180),
('ماه نشان', 13, 181),
('ماکو', 2, 182),
('مراغه', 1, 183),
('مراوه تپه', 24, 184),
('مرند', 1, 185),
('مروست', 31, 186),
('مريوان', 20, 187),
('مسجد سليمان', 12, 188),
('مشهد', 10, 189),
('مشکين شهر', 3, 190),
('معلم کلايه', 18, 191),
('ملاير', 30, 192),
('منجيل', 25, 193),
('مهاباد', 2, 194),
('مهريز', 31, 195),
('مورچه خورت', 4, 196),
('ميانده جيرفت', 21, 197),
('مياندوآب', 2, 198),
('ميانه', 1, 199),
('ميبد', 31, 200),
('ميمه', 5, 201),
('ميناب', 29, 202),
('نايين', 4, 203),
('نجف آباد', 4, 204),
('نطنز', 4, 205),
('نقده', 2, 206),
('نهاوند', 30, 207),
('نهبندان', 9, 208),
('نورآباد', 17, 209),
('نوشهر', 27, 210),
('نيريز', 17, 211),
('نيشابور', 10, 212),
('نيک شهر', 15, 213),
('همدان', 30, 214),
('هنديجان', 12, 215),
('ورامين', 7, 216),
('ياسوج', 23, 217),
('يزد', 31, 218),
('قشلاق دشت', 3, 219),
('اصلاندوز', 3, 220),
('نير', 3, 221),
('نمين', 3, 222),
('گرمي', 3, 223),
('كوثر', 3, 224),
('بستان آباد', 1, 225),
('آذرشهر', 1, 226),
('شبستر', 1, 227),
('ملكان', 1, 228),
('ورزقان', 1, 229),
('اسكو', 1, 230),
('عجب شير', 1, 231),
('هريس', 1, 232),
('هشترود', 1, 233),
('شيروان', 11, 234),
('مباركه', 4, 235),
('خميني شهر', 4, 236),
('مهران', 5, 237),
('آبدانان', 5, 238),
('جيرفت', 21, 239),
('جازموريان', 21, 240),
('بردسير', 21, 241),
('ريقان', 21, 242),
('راور', 21, 243),
('رودبار', 21, 244),
('ابهر', 13, 245),
('رباط كريم', 7, 246),
('بابل', 27, 247),
('اسلامشهر', 7, 248),
('شهريار', 7, 249),
('ايلخچي', 1, 250),
('خامنه', 1, 251),
('تسوج', 1, 252),
('صوفيان', 1, 253),
('ممقان', 1, 254),
('ترکمانچاي', 1, 255),
('هادي شهر', 1, 256),
('شاهين دژ', 2, 257),
('زواره', 4, 258),
('هرند', 4, 259),
('دولت آباد', 4, 260),
('دهاقان', 4, 261),
('سده لنجان', 4, 262),
('قاينات', 9, 263),
('شهر مجلسي', 4, 264),
('فلاورجان', 4, 265),
('ميمه', 4, 266),
('بردسکن', 10, 267),
('دلوار', 6, 268),
('خورموج', 6, 269),
('دشتستان', 6, 270),
('تايباد', 10, 271),
('درگز', 10, 272),
('اسفراين', 11, 273),
('خرمشهر', 12, 274),
('ماه شهر', 12, 275),
('اشنويه', 2, 276),
('تكاب', 2, 277),
('سيه چشمه', 2, 278),
('شوط', 2, 279),
('فيرورق', 2, 280),
('تازه كند انگوت', 3, 281),
('آران و بيدگل', 4, 282),
('تيران', 4, 283),
('خوانسار', 4, 284),
('زرين شهر', 4, 285),
('شاهين شهر', 4, 286),
('فريدون شهر', 4, 287),
('كوهپايه', 4, 288),
('وزوان', 4, 289),
('باغ بهادران', 4, 290),
('برزك', 4, 291),
('بهارستان', 4, 292),
('پيربكران', 4, 293),
('تودشك', 4, 294),
('چادگان', 4, 295),
('حسن آباد', 4, 296),
('دهق', 4, 297),
('زاينده رود', 4, 298),
('علويجه', 4, 299),
('فولادشهر', 4, 300),
('قمصر', 4, 301),
('قهدريجان', 4, 302),
('گز', 4, 303),
('نوش آباد', 4, 304),
('ورزنه', 4, 305),
('بدره', 5, 306),
('چوار', 5, 307),
('سر آبله', 5, 308),
('برازجان', 6, 309),
('اهرم', 6, 310),
('بندر كنگان', 6, 311),
('بندر گناوه', 6, 312),
('جم', 6, 313),
('عسلويه', 6, 314),
('شبانكاره', 6, 315),
('پاكدشت', 7, 316),
('دماوند', 7, 317),
('آبسرد', 7, 318),
('اشتهارد', 7, 319),
('هشتگرد', 7, 320),
('نظر آباد', 7, 321),
('ملارد', 7, 322),
('ماهدشت', 7, 323),
('لواسانات', 7, 324),
('گرمدره', 7, 325),
('كهريزك', 7, 326),
('طالقان', 7, 327),
('شهر قدس', 7, 328),
('پرديس', 7, 329),
('رودهن', 7, 330),
('چهاردانگه', 7, 331),
('جاجرود', 7, 332),
('پرند', 7, 333),
('بومهن', 7, 334),
('باقر شهر', 7, 335),
('اردل', 8, 336),
('جونقان', 8, 337),
('فرخ شهر', 8, 338),
('گندمان', 8, 339),
('اسديه', 9, 340),
('خضري', 9, 341),
('روم', 9, 342),
('فريمان', 10, 343),
('بجستان', 10, 344),
('جغتاي', 10, 345),
('جوين', 10, 346),
('چناران', 10, 347),
('خواف', 10, 348),
('رشتخوار', 10, 349),
('درود', 10, 350),
('آشخانه', 11, 351),
('الوان', 12, 352),
('بندر امام خميني', 12, 353),
('سوسنگرد', 12, 354),
('شادگان', 12, 355),
('آغاجاري', 12, 356),
('انديكا', 12, 357),
('انديمشك', 12, 358),
('باغ ملك', 12, 359),
('تركالكي', 12, 360),
('رامشير', 12, 361),
('شوش', 12, 362),
('گتوند', 12, 363),
('لالي', 12, 364),
('هفتگل', 12, 365),
('هويزه', 12, 366),
('سلطانيه', 13, 367),
('ايجرود', 13, 368),
('آرادان', 14, 369),
('ايوانكي', 14, 370),
('مهدي شهر', 14, 371),
('سوران', 15, 372),
('راسك', 15, 373),
('استهبان', 17, 374),
('اوز', 17, 375),
('خرامه', 17, 376),
('صفا شهر', 17, 377),
('فيروزآباد', 17, 378),
('كازرون', 17, 379),
('آباده طشك', 17, 380),
('ارسنجان', 17, 381),
('بيرم', 17, 382),
('بيضا', 17, 383),
('جهرم', 17, 384),
('خنج', 17, 385),
('خاوران', 17, 386),
('زاهدشهر', 17, 387),
('سپيدان', 17, 388),
('سروستان', 17, 389),
('سعادت شهر', 17, 390),
('قره بلاغ', 17, 391),
('فراشبند', 17, 392),
('قير وكارزين', 17, 393),
('گوار', 17, 394),
('مرودشت', 17, 395),
('مهر', 17, 396),
('آبيك', 18, 397),
('بوئين زهرا', 18, 398),
('جعفريه', 19, 399),
('دستجرد', 19, 400),
('كهك', 19, 401),
('حسن آباد ياسوكند', 20, 402),
('ديواندره', 20, 403),
('سروآباد', 20, 404),
('كامياران', 20, 405),
('ارزوئيه', 21, 406),
('باغين', 21, 407),
('پاريز', 21, 408),
('رابر', 21, 409),
('راين', 21, 410),
('زنگي آباد', 21, 411),
('عنبرآباد', 21, 412),
('فهرج', 21, 413),
('كشكوييه', 21, 414),
('گلباف', 21, 415),
('منوجان', 21, 416),
('جوانرود', 22, 417),
('تازه آباد', 22, 418),
('كرند', 22, 419),
('پاوه', 22, 420),
('گيلانغرب', 22, 421),
('دهدشت', 23, 422),
('باشت', 23, 423),
('سي سخت', 23, 424),
('ليكك', 23, 425),
('بندر تركمن', 24, 426),
('آزادشهر', 24, 427),
('آق قلا', 24, 428),
('بندرگز', 24, 429),
('راميان', 24, 430),
('علي آباد كتول', 24, 431),
('كردكوي', 24, 432),
('گالكيش', 24, 433),
('تالش', 25, 434),
('رودسر', 25, 435),
('صومعه سرا', 25, 436),
('آستانه اشرفيه', 25, 437),
('املش', 25, 438),
('رضوانشهر', 25, 439),
('سياهكل', 25, 440),
('شفت', 25, 441),
('فومن', 25, 442),
('لنگرود', 25, 443),
('پلدختر', 26, 444),
('دورود', 26, 445),
('نورآباد دلفان', 26, 446),
('بهشهر', 27, 447),
('تنكابن', 27, 448),
('كله بست', 27, 449),
('بندپي غربي', 27, 450),
('جويبار', 27, 451),
('رينه', 27, 452),
('زيرآب', 27, 453),
('قائمشهر', 27, 454),
('محمودآباد', 27, 455),
('نكا', 27, 456),
('چالوس', 27, 457),
('نور', 27, 458),
('شازند', 28, 459),
('آشتيان', 28, 460),
('غرق آباد', 28, 461),
('فرمهين', 28, 462),
('قورچي باشي', 28, 463),
('محلات', 28, 464),
('ميلاجرد', 28, 465),
('بستك', 29, 466),
('بندر خمير', 29, 467),
('فين', 29, 468),
('دهبارز', 29, 469),
('سيريك', 29, 470),
('تويسر كان', 30, 471),
('اسدآباد', 30, 472),
('بهار', 30, 473),
('رزن', 30, 474),
('كبودرآهنگ', 30, 475),
('قهاوند', 30, 476),
('دمق', 30, 477),
('سامن', 30, 478),
('صالح آباد', 30, 479),
('فامنين', 30, 480),
('قروه درجزين', 30, 481),
('لالجين', 30, 482),
('زارچ', 31, 483),
('رضوانشهر صدوق', 31, 484),
('اردكان', 31, 485),
('تفت', 31, 486),
('گجساران', 17, 487),
('گلوگاه', 27, 488),
('فريدونكنار', 27, 489),
('آئينه ورزان', 7, 490),
('آب باريك', 7, 491),
('آتشگاه', 7, 492),
('آجين دوجين', 7, 493),
('آدران اسلامشهر', 7, 494),
('آدران كرج', 7, 495),
('آران', 7, 496),
('آردهه', 7, 497),
('آرموت', 7, 498),
('آرو', 7, 499),
('آسارا', 7, 500),
('آسور', 7, 501),
('آغشت', 7, 502),
('آلارد', 7, 503),
('آلوئك', 7, 504),
('آيگان', 7, 505),
('ابراهيم آباد ورامين', 7, 506),
('اختر آباد', 7, 507),
('ارجمند', 7, 508),
('ارغش آباد', 7, 509),
('ارنگه', 7, 510),
('اسدآباد', 7, 511),
('اسمكان', 7, 512),
('اسلام آباد', 7, 513),
('شهرك واوان', 7, 514),
('اصيل آباد', 7, 515),
('اقلان تپه', 7, 516),
('اكبر آباد', 7, 517),
('اميرآباد قشلاق', 7, 518),
('اميرنان', 7, 519),
('امين آباد', 7, 520),
('انجم آباد', 7, 521),
('اوچونك', 7, 522),
('اورزان', 7, 523),
('اورين', 7, 524),
('ايپك آباد', 7, 525),
('ايرا', 7, 526),
('ايرين', 7, 527),
('باباسلمان', 7, 528),
('باغ خواص', 7, 529),
('باقر آباد', 7, 530),
('بردآباد', 7, 531),
('برغان', 7, 532),
('بزج', 7, 533),
('بكه', 7, 534),
('بيدگنه', 7, 535),
('پادگان پرندك', 7, 536),
('پارچين', 7, 537),
('پوركان', 7, 538),
('پيرده', 7, 539),
('پيست آبعلي', 7, 540),
('پيشوا', 7, 541),
('تاليان علاقبند', 7, 542),
('تكيه ناوه', 7, 543),
('تنكمان', 7, 544),
('توچال', 7, 545),
('جابان', 7, 546),
('جارو', 7, 547),
('جعفر آباد رحمانيه', 7, 548),
('جليزجند', 7, 549),
('جليل آباد', 7, 550),
('جمال آباد', 7, 551),
('جواد آباد', 7, 552),
('جورد آرينه', 7, 553),
('جوستان', 7, 554),
('جوقين', 7, 555),
('جي', 7, 556),
('چاران', 7, 557),
('چرمشهر', 7, 558),
('چنارشرق', 7, 559),
('چنارغرب', 7, 560),
('چندار', 7, 561),
('چنگي كبود گنبد', 7, 562),
('چيچكو', 7, 563),
('حاجي آباد كرج', 7, 564),
('حاجي آباد ورامين', 7, 565),
('حاجي بيگ', 7, 566),
('حسن آباد خالصه', 7, 567),
('حسين خانلو', 7, 568),
('خادم آباد', 7, 569),
('خسبان', 7, 570),
('خور', 7, 571),
('خير آباد اسلامشهر', 7, 572),
('دماوند گيلاوند', 7, 573),
('رزكان', 7, 574),
('رستم آباد هفت جوبه', 7, 575),
('رودهن', 7, 576),
('ريحان آباد', 7, 577),
('زرين دشت', 7, 578),
('زعفرانيه', 7, 579),
('زكي آباد', 7, 580),
('سربندان', 7, 581),
('سرخاب', 7, 582),
('سعيد آباد شهريار', 7, 583),
('سعيد آباد ورامين', 7, 584),
('سعيد آباد هشتگرد', 7, 585),
('سلمان آباد ورامين', 7, 586),
('شهر آباد صفادشت', 7, 587),
('شهر آباد فيروزكوه', 7, 588),
('شهر جديد پرند', 7, 589),
('شهر جديد هشتگرد', 7, 590);

-- --------------------------------------------------------

--
-- Table structure for table `shajarename`
--

CREATE TABLE `shajarename` (
  `id` bigint(20) NOT NULL,
  `title` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `description` text CHARACTER SET utf8,
  `cover_picture_id` bigint(20) DEFAULT '0',
  `icon_picture_id` bigint(20) DEFAULT '0',
  `insert_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `create_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_id` bigint(20) DEFAULT '0',
  `is_public` tinyint(4) DEFAULT '0',
  `view_count` int(11) DEFAULT '0',
  `like_count` int(11) DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT '0',
  `tag` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `calc_rate` int(11) DEFAULT '0',
  `is_accepted` tinyint(4) DEFAULT '0',
  `member_count` int(11) DEFAULT '0',
  `is_vip` tinyint(4) DEFAULT '0',
  `comment_count` int(11) DEFAULT '0',
  `shahr_id` bigint(20) DEFAULT '0',
  `ostan_id` bigint(20) DEFAULT '0',
  `softversion` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `owner_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `ownerId` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `parent_shajarename_id` bigint(20) DEFAULT '0',
  `parent_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `child_count` int(10) UNSIGNED DEFAULT '0',
  `root_node_index` varchar(30) COLLATE utf8_persian_ci DEFAULT '0',
  `root_node_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `store_count` int(11) DEFAULT '0',
  `pic_count` int(11) DEFAULT '0',
  `ownerName` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL,
  `root_node_id` double DEFAULT NULL,
  `members` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `shajarename`
--

-- --------------------------------------------------------

--
-- Table structure for table `sqlbug`
--

CREATE TABLE `sqlbug` (
  `sqlbug_id` bigint(20) NOT NULL,
  `error_code` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد خطا',
  `describe` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `time` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `file` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'داخل کدام فایل خطا رخ داده است',
  `sql` text COLLATE utf8_persian_ci COMMENT 'کد اس کیو ال که خطا داده است',
  `user_id` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `message` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحی در مورد عملیاتی که باعث خطا شده',
  `read` enum('yes','no') COLLATE utf8_persian_ci DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'چون ممکن است هنگام ورود بوزر آی دی در دسارس نباشد امکان ذخیره ی یوزر آی دی نیز باید در این جدول یاشد',
  `userip` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='خطاهای اس کیو ال در این جدول ثیت می شوند';

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `id` bigint(20) NOT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `device` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `screen` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `admin` bigint(20) DEFAULT NULL,
  `os` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
  `browser` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_mobile` bit(1) DEFAULT b'1',
  `part` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `data` text COLLATE utf8_persian_ci,
  `is_ads` int(11) UNSIGNED DEFAULT NULL,
  `plan_registered_id` bigint(1) UNSIGNED DEFAULT NULL,
  `price` int(11) UNSIGNED DEFAULT NULL,
  `referrer` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `visit`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `adslog`
--
ALTER TABLE `adslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adsvisit`
--
ALTER TABLE `adsvisit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_type` (`item_type`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `geraph`
--
ALTER TABLE `geraph`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`shajarename_id`);

--
-- Indexes for table `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `ostan`
--
ALTER TABLE `ostan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shahr`
--
ALTER TABLE `shahr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shajarename`
--
ALTER TABLE `shajarename`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_accepted` (`is_accepted`);

--
-- Indexes for table `sqlbug`
--
ALTER TABLE `sqlbug`
  ADD PRIMARY KEY (`sqlbug_id`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382326;
--
-- AUTO_INCREMENT for table `adslog`
--
ALTER TABLE `adslog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `adsvisit`
--
ALTER TABLE `adsvisit`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `geraph`
--
ALTER TABLE `geraph`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6456;
--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `shajarename`
--
ALTER TABLE `shajarename`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT for table `sqlbug`
--
ALTER TABLE `sqlbug`
  MODIFY `sqlbug_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1575;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
