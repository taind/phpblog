-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 30, 2016 at 03:44 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3
use phpblog;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phpblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_cats`
--

CREATE TABLE IF NOT EXISTS `blog_cats` (
  `catID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catTitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `catSlug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `blog_cats`
--

INSERT INTO `blog_cats` (`catID`, `catTitle`, `catSlug`) VALUES
(6, 'dire tire', 'dire-tire'),
(2, '9k mmr', '9k-mmr'),
(3, 'dendi', 'dendi'),
(5, 'navi', 'navi'),
(7, 'play doto', 'play-doto'),
(11, 'work hard', 'work-hard');

-- --------------------------------------------------------

--
-- Table structure for table `blog_members`
--

CREATE TABLE IF NOT EXISTS `blog_members` (
  `memberID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `blog_members`
--

INSERT INTO `blog_members` (`memberID`, `username`, `password`, `email`) VALUES
(1, 'admin', 'admin', 'admin@admin'),
(7, 'ngan', '123', 'ngan@ngan');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `postID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `postDesc` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `postCont` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `postDate` datetime DEFAULT NULL,
  `postSlug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`postID`),
  KEY `postID` (`postID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`postTitle`, `postDesc`, `postCont`, `postDate`, `postSlug`) VALUES
('That Darn Katz!', '<p>Wow! A superpowers drug you can just rub onto your skin? You''d think it would be something you''d have to freebase. Fry, you can''t just sit here in the dark listening to classical music. And yet you haven''t said what I told you to say! How can any of us', '<h2>Xmas Story</h2>\r\n<p>It must be wonderful. Does anybody else feel jealous and aroused and worried? Is today''s hectic lifestyle making you tense and impatient? Soothe us with sweet lies. That''s right, baby. I ain''t your loverboy Flexo, the guy you love so much. You even love anyone pretending to be him!</p>\r\n<ul>\r\n<li>Goodbye, friends. I never thought I''d die like this. But I always really hoped.</li>\r\n<li>They''re like sex, except I''m having them!</li>\r\n<li>Come, Comrade Bender! We must take to the streets!</li>\r\n</ul>\r\n<h3>Anthology of Interest I</h3>\r\n<p>Hey, whatcha watching? They''re like sex, except I''m having them! Well I''da done better, but it''s plum hard pleading a case while awaiting trial for that there incompetence. Yes, except the Dave Matthews Band doesn''t rock. I suppose I could part with ''one'' and still be feared&hellip;</p>\r\n<h4>Teenage Mutant Leela''s Hurdles</h4>\r\n<p>Oh, but you can. But you may have to metaphorically make a deal with the devil. And by "devil", I mean Robot Devil. And by "metaphorically", I mean get your coat. Please, Don-Bot&hellip; look into your hard drive, and open your mercy file! It''s a T. It goes "tuh". I guess if you want children beaten, you have to do it yourself.</p>\r\n<ol>\r\n<li>Spare me your space age technobabble, Attila the Hun!</li>\r\n<li>Well, thanks to the Internet, I''m now bored with sex. Is there a place on the web that panders to my lust for violence?</li>\r\n</ol>\r\n<h5>The Farnsworth Parabox</h5>\r\n<p>Wow! A superpowers drug you can just rub onto your skin? You''d think it would be something you''d have to freebase. We need rest. The spirit is willing, but the flesh is spongy and bruised. It must be wonderful.</p>', '2013-06-05 23:10:35', 'That-Darn-Katz'),
('Love is hurt', '<p>this is fucking true man</p>\r\n<div>&nbsp;</div>\r\n<div>Quả nhi&ecirc;n l&agrave; c&oacute; in dữ liệu trong m&atilde; nguồn, Chrome trả về 5 kết quả. Ch&uacute; &yacute; v&agrave;o nh&oacute;m kết quả thứ nhất, ta c&oacute; thể thấy dữ liệu đ&atilde; đư', '<div>&nbsp;</div>\r\n<div>Quả nhi&ecirc;n l&agrave; c&oacute; in dữ liệu trong m&atilde; nguồn, Chrome trả về 5 kết quả. Ch&uacute; &yacute; v&agrave;o nh&oacute;m kết quả thứ nhất, ta c&oacute; thể thấy dữ liệu đ&atilde; được m&atilde; h&oacute;a c&aacute;c k&yacute; tự HTML. Nhưng ở vị tr&iacute; 2 v&agrave; 3 th&igrave; c&aacute;c k&yacute; tự "/" kh&ocirc;ng bị m&atilde; h&oacute;a th&agrave;nh "%2F" nữa? Tới đ&acirc;y th&igrave; ch&uacute;ng ta c&oacute; thể bắt đầu nghi ngờ về việc lỗ hổng XSS c&oacute; thể xảy ra.</div>', '2016-06-25 00:20:20', 'Love-is-hurt'),
('Fucking bitch you dog', '<div>&nbsp;</div>\r\n<div>Quả nhi&ecirc;n l&agrave; c&oacute; in dữ liệu trong m&atilde; nguồn, Chrome trả về 5 kết quả. Ch&uacute; &yacute; v&agrave;o nh&oacute;m kết quả thứ nhất, ta c&oacute; thể thấy dữ liệu đ&atilde; được m&atilde; h&oacute;a c&aacute;', '<div>&nbsp;</div>\r\n<div>Quả nhi&ecirc;n l&agrave; c&oacute; in dữ liệu trong m&atilde; nguồn, Chrome trả về 5 kết quả. Ch&uacute; &yacute; v&agrave;o nh&oacute;m kết quả thứ nhất, ta c&oacute; thể thấy dữ liệu đ&atilde; được m&atilde; h&oacute;a c&aacute;c k&yacute; tự HTML. Nhưng ở vị tr&iacute; 2 v&agrave; 3 th&igrave; c&aacute;c k&yacute; tự "/" kh&ocirc;ng bị m&atilde; h&oacute;a th&agrave;nh "%2F" nữa? Tới đ&acirc;y th&igrave; ch&uacute;ng ta c&oacute; thể bắt đầu nghi ngờ về việc lỗ hổng XSS c&oacute; thể xảy ra.\r\n<div>&nbsp;</div>\r\n<div>Quả nhi&ecirc;n l&agrave; c&oacute; in dữ liệu trong m&atilde; nguồn, Chrome trả về 5 kết quả. Ch&uacute; &yacute; v&agrave;o nh&oacute;m kết quả thứ nhất, ta c&oacute; thể thấy dữ liệu đ&atilde; được m&atilde; h&oacute;a c&aacute;c k&yacute; tự HTML. Nhưng ở vị tr&iacute; 2 v&agrave; 3 th&igrave; c&aacute;c k&yacute; tự "/" kh&ocirc;ng bị m&atilde; h&oacute;a th&agrave;nh "%2F" nữa? Tới đ&acirc;y th&igrave; ch&uacute;ng ta c&oacute; thể bắt đầu nghi ngờ về việc lỗ hổng XSS c&oacute; thể xảy ra.</div>\r\n</div>', '2016-06-25 00:20:42', 'Fucking-bitch-you-dog'),
('Post mới', '<p>Spain thua Italy</p>', '<p>Kh&ocirc;ng thể tin nổi</p>', '2016-06-28 00:52:47', 'Post-moi'),
('messi giải nghệ', '<p>ăn bơ li vơ bồ</p>', '<p>n&ocirc; kh&ocirc;ng thể tin được</p>', '2016-06-28 14:41:48', 'messi-giai-nghe');

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_cats`
--

CREATE TABLE IF NOT EXISTS `blog_post_cats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postID` int(11) DEFAULT NULL,
  `catID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `postID` (`postID`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `blog_post_cats`
--

INSERT INTO `blog_post_cats` (`id`, `postID`, `catID`) VALUES
(1, 1, 1),
(26, 2, 7),
(24, 50, 2),
(4, 6, 4),
(5, 11, 2),
(6, 1, 4),
(9, 6, 6),
(10, 7, 6),
(11, 15, 6),
(28, 16, 2),
(29, 16, 3),
(27, 2, 11),
(25, 50, 6),
(23, 49, 11),
(22, 49, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
