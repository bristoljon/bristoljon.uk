-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: mysql2.clusterdb.net
-- Generation Time: Aug 05, 2015 at 09:19 PM
-- Server version: 10.0.14-MariaDB
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jon-jey-u-000188`
--

-- --------------------------------------------------------

--
-- Table structure for table `new_update`
--

CREATE TABLE IF NOT EXISTS `new_update` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(32) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `reference_type` varchar(24) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `hide` tinyint(1) NOT NULL DEFAULT '0',
  `privacy` tinyint(1) NOT NULL DEFAULT '0',
  `url` varchar(64) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_update`
--

INSERT INTO `new_update` (`id`, `date`, `type`, `reference_id`, `reference_type`, `title`, `content`, `hide`, `privacy`, `url`) VALUES
(1, '2015-08-03 14:37:09', 'Code Update', 15, 'project', 'Colours', 'Changed colour for dozenal mode so that '';'' key is consistent as well. Still don''t really like the whole colour scheme but it''ll do for now.', 0, 0, '/project/dozenal'),
(5, '2015-08-03 09:53:49', 'New Geek Blog Post', 12, 'blog', '2 Months Later', 'So it''s been about a month since my last post and 2 months since I stopped paramedic(k)ing around and took up coding (or learning to code) full-time. I''ve been pretty busy, mainly working on this site, adding features like the technical detail button', 0, 0, '/blog/update-3'),
(6, '2015-07-22 16:08:49', 'New Mobile App Project', 13, 'project', 'Urban Sports App', 'The idea is to create a platform or portal for organising large-scale, multi-player, location-based games. Users would have a profile and gain experience points and rep points for participating in and winning games. Most games would be best suited to urban environments and high population density areas hence the name. The point is to connect strangers and have fun but it could potentially be tastefully commercialised through geo-targeted ads for local businesses.', 1, 1, '/project/urbansports'),
(7, '2015-07-09 16:15:16', 'New Software Fun Project', 11, 'project', 'One Time Pad Encryption', 'A one-time-pad is a method for encrypting a message using a cipher. First, all the characters in both the cipher and message are converted to numbers. Then each character is subtracted from it''s matching character in the cipher text. The result is converted back into a character. Technically there is no way to crack the code as the same code could decrypt to any message given the right cipher. However the problem is, you need some way to communicate the key to the recipient in the first place hence why it''s not widely used.', 0, 0, '/project/onetimepad'),
(8, '2015-08-05 16:22:00', 'New Website Project', 18, 'project', 'bristoljon.uk', 'The idea is to create a website to keep track of all my project ideas and also to practice my developing developing skills (see what I did there!)', 1, 0, '/project/this'),
(9, '2015-08-05 16:24:10', 'New Feature', 18, 'project', 'bristoljon.uk', 'Added a ''recent updates'' feed for the home page that generates this little panel that you are reading this in. I added a ''updates'' table to my database, any changes I make generate an entry there and this page uses AJAX to collect the most recent ones and display them here.', 0, 0, '/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `new_update`
--
ALTER TABLE `new_update`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `new_update`
--
ALTER TABLE `new_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
