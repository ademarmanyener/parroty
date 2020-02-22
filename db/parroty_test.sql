-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 22 Şub 2020, 13:16:03
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `parroty_test`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL DEFAULT 0,
  `text` varchar(255) NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `added_time` varchar(255) NOT NULL,
  `visibility` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `announcements`
--

INSERT INTO `announcements` (`id`, `text`, `added_by`, `added_time`, `visibility`) VALUES
(1, 'test announcement', 'adem', '22-02-2020 13:14:10', 'users');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `links`
--

CREATE TABLE `links` (
  `site` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `links`
--

INSERT INTO `links` (`site`, `link`) VALUES
('facebook', 'https://facebook.com'),
('twitter', 'https://twitter.com'),
('youtube', 'https://youtube.com'),
('instagram', 'https://instagram.com'),
('git', 'https://github.com/anilademyener/parroty/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_number` int(11) NOT NULL,
  `product_added_time` varchar(255) NOT NULL,
  `product_added_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_price`, `product_description`, `product_image`, `product_number`, `product_added_time`, `product_added_by`) VALUES
(2, 'TEST ÜRÜN EKLİYORUM', 25, 'MERHANBA ARKAŞADLAR BU BİR \r\n\r\n\r\nTEST ĞRÜN', 'https://previews.123rf.com/images/victoroancea/victoroancea1201/victoroancea120100059/12055848-tv-color-test-pattern-test-card-for-pal-and-ntsc.jpg', 5, '22-02-2020 13:03:34', 'adem');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `username` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `added_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_values`
--

CREATE TABLE `site_values` (
  `header_logo` varchar(255) NOT NULL,
  `header_text` varchar(255) NOT NULL,
  `header_motto` varchar(255) NOT NULL,
  `footer_logo` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `footer_motto` varchar(255) NOT NULL,
  `tab_logo` varchar(255) NOT NULL,
  `tab_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `site_values`
--

INSERT INTO `site_values` (`header_logo`, `header_text`, `header_motto`, `footer_logo`, `footer_text`, `footer_motto`, `tab_logo`, `tab_text`) VALUES
('src/img/logo-white.png', 'parroty', 'welcome', 'src/img/logo-black.png', 'parroty', 'goodbyee', 'src/img/logo-black.png', 'parroty - tab');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `added_time` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`username`, `password`, `avatar`, `added_time`, `permission`) VALUES
('', '', 'src/img/logo.png', '22-02-2020 12:56:58', 'normal'),
('adem', '1234', 'https://img.freepik.com/free-vector/abstract-technology-particle-background_52683-25766.jpg?size=626&ext=jpg', '22-02-2020 12:57:10', 'admin');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
