-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 10:33 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `isParentCategory` tinyint(1) NOT NULL,
  `parentCategoryId` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `description`, `isParentCategory`, `parentCategoryId`, `dateAdded`) VALUES
(1, 'Web Development', 'Existing technologies and methods involved in web development', 1, 0, '2018-06-10 10:33:11'),
(2, 'Mobile App Design', 'Existing technologies and methods involved in app design', 1, 0, '2018-06-10 10:33:11'),
(3, 'IOS', 'Existing technologies and methods involved in app design', 0, 2, '2018-06-10 10:33:11'),
(4, 'Android', 'Existing technologies and methods involved in app design', 0, 2, '2018-06-10 10:33:11'),
(5, 'Misc', 'Existing technologies and methods involved in app design', 0, 2, '2018-06-10 10:33:11'),
(6, 'Graphics Design', 'The latest techniques, and tools employed in graphics design', 1, 0, '2018-06-10 10:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `pageId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `replyTo` varchar(20) NOT NULL,
  `isSpam` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `isTrashed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `pageId`, `name`, `email`, `website`, `comment`, `replyTo`, `isSpam`, `isApproved`, `dateAdded`, `dateUpdated`, `isTrashed`) VALUES
(2, 10, 'Ogaba Samuel', 'elmagesly@gmail.com', '', 'This is a comment', '0', 0, 1, '2018-06-11 21:45:51', '2018-06-13 09:27:48', 0),
(3, 10, 'Ogaba Emmanuel', 'elmageace@gmail.com', '', 'This is another comment', '0', 0, 1, '2018-06-12 10:22:04', '2018-06-13 09:27:34', 0),
(4, 10, 'Ogaba Emmanuel', 'elmageace@gmail.com', '', 'A different comment', '0', 0, 1, '2018-06-12 10:36:04', '2018-06-14 14:46:49', 1),
(5, 10, 'Ogaba Emmanuel', 'elmageace@gmail.com', '', 'Show me the comment', '0', 0, 1, '2018-06-12 10:37:25', '2018-06-14 12:38:19', 1),
(6, 10, 'Ogaba Emmanuel', 'elmageace@gmail.com', '', 'Please comment', '0', 0, 1, '2018-06-12 10:40:10', '2018-06-13 09:27:34', 0),
(8, 11, 'Ogaba Emmanuel', 'elmageace@gmail.com', '', 'Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before', '0', 0, 1, '2018-06-12 19:46:31', '2018-06-13 09:27:08', 0),
(9, 11, 'Sam', 'elmagegace@hotmail.com', '', 'My first comment! yay!', '', 0, 1, '2018-06-13 20:19:31', '2018-06-14 14:46:49', 0),
(10, 11, 'A visitor', 'elmagesly@gmail.com', '', 'A visitor&#039;s comment', '', 0, 1, '2018-06-14 14:54:00', '2018-06-14 14:54:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `creatorId` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `dateUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateAdded` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `creatorId` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(150) NOT NULL,
  `post_category` int(11) NOT NULL,
  `sub_category` int(11) NOT NULL,
  `content` text NOT NULL,
  `isPublished` tinyint(1) NOT NULL,
  `isReviewed` tinyint(1) NOT NULL,
  `rating` int(11) NOT NULL,
  `dateUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `creatorId`, `title`, `subtitle`, `post_category`, `sub_category`, `content`, `isPublished`, `isReviewed`, `rating`, `dateUpdated`, `dateAdded`) VALUES
(2, 3, 'Man must explore, and this is exploration at its greatest', 'Problems look mighty small from 150 miles up', 0, 0, '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n\r\n                    <p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n\r\n                    <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n\r\n                    <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>\r\n\r\n                    <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n\r\n                    <h2 class=\"section-heading\">The Final Frontier</h2>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n\r\n                    <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n\r\n                    <h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n\r\n                    <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n\r\n                    <a href=\"#\">\r\n                        <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\">\r\n                    </a>\r\n                    <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span>\r\n\r\n                    <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n\r\n                    <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n\r\n                    <p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', 1, 1, 5, '2018-06-14 14:44:10', '2018-05-25 19:18:00'),
(7, 3, 'Man must explore, and this is exploration at its greatest', 'Problems look mighty small from 150 miles up', 0, 0, '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n\r\n                    <p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n\r\n                    <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n\r\n                    <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>\r\n\r\n                    <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n\r\n                    <h2 class=\"section-heading\">The Final Frontier</h2>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n\r\n                    <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n\r\n                    <h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n\r\n                    <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n\r\n                    <a href=\"#\">\r\n                        <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\">\r\n                    </a>\r\n                    <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span>\r\n\r\n                    <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n\r\n                    <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n\r\n                    <p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', 0, 1, 0, '2018-06-14 12:42:24', '2018-05-25 18:27:00'),
(8, 3, 'Man must explore, and this is exploration at its greatest', 'Problems look mighty small from 150 miles up', 0, 0, '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n\r\n                    <p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n\r\n                    <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n\r\n                    <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>\r\n\r\n                    <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n\r\n                    <h2 class=\"section-heading\">The Final Frontier</h2>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n\r\n                    <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n\r\n                    <h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n\r\n                    <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n\r\n                    <a href=\"#\">\r\n                        <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\">\r\n                    </a>\r\n                    <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span>\r\n\r\n                    <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n\r\n                    <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n\r\n                    <p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', 1, 1, 0, '2018-06-14 12:42:18', '2018-05-25 18:27:00'),
(9, 3, 'Man must explore, and this is exploration at its greatest', 'Problems look mighty small from 150 miles up', 0, 0, '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n\r\n                    <p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n\r\n                    <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n\r\n                    <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>\r\n\r\n                    <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n\r\n                    <h2 class=\"section-heading\">The Final Frontier</h2>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n\r\n                    <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n\r\n                    <h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n\r\n                    <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n\r\n                    <a href=\"#\">\r\n                        <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\">\r\n                    </a>\r\n                    <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span>\r\n\r\n                    <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n\r\n                    <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n\r\n                    <p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', 1, 1, 2, '2018-06-14 14:40:47', '2018-05-25 18:27:00'),
(10, 4, 'Man must explore, and this is exploration at its greatest', 'Problems look mighty small from 250 miles up', 0, 0, '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n<p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n<p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n<p><span style=\"color: #ff0000;\"><em>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</em></span></p>\r\n<p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n<h2 class=\"section-heading\">The Final Frontier</h2>\r\n<p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n<p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n<blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n<p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n<h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n<p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n<p><a href=\"#\"> <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\" /> </a> <span class=\"caption text-muted\" style=\"color: #008000;\">To go places and do things that have never been done before - that\'s what living is all about.</span></p>\r\n<p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n<p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n<p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', 1, 1, 4, '2018-06-14 14:33:40', '2018-05-25 18:27:00'),
(11, 4, 'Man must explore, and this is exploration at its greatest', 'Problems look mighty small from 350 miles up', 2, 0, '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n<p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n<p><strong>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</strong></p>\r\n<p><span style=\"color: #ff6600;\">A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</span></p>\r\n<p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n<h2 class=\"section-heading\">The Final Frontier</h2>\r\n<p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n<p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n<blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n<p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n<h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n<p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n<p><a href=\"#\"> <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\" /> </a> <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span></p>\r\n<p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n<p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n<p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', 1, 1, 2, '2018-06-14 14:31:01', '2018-05-25 18:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `trash`
--

CREATE TABLE `trash` (
  `id` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `post_category` varchar(255) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trash`
--

INSERT INTO `trash` (`id`, `creatorId`, `title`, `subtitle`, `content`, `post_category`, `dateAdded`, `dateUpdated`) VALUES
(1, 4, 'NEW LIFE CIVILIZATIONS TO BOLDLY', '', '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n\r\n                    <p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n\r\n                    <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n\r\n                    <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>\r\n\r\n                    <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n\r\n                    <h2 class=\"section-heading\">The Final Frontier</h2>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n\r\n                    <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n\r\n                    <h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n\r\n                    <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n\r\n                    <a href=\"#\">\r\n                        <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\">\r\n                    </a>\r\n                    <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span>\r\n\r\n                    <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n\r\n                    <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n\r\n                    <p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', '', '2018-05-25 18:06:00', '2018-05-29 11:05:46'),
(2, 4, 'NEW LIFE CIVILIZATIONS TO BOLDLY', '', '<p>Never in all their history have men been able truly to conceive of the world as one: a single sphere, a globe, having the qualities of a globe, a round earth in which all the directions eventually meet, in which there is no center because every point, or none, is center - an equal earth which all men occupy as equals. The airman\'s earth, if free men make it, will be truly round: a globe in practice, not in theory.</p>\r\n\r\n                    <p>Science cuts two ways, of course; its products can be used for both good and evil. But there is no turning back from science. The early warnings about technological dangers also come from science.</p>\r\n\r\n                    <p>What was most significant about the lunar voyage was not that man set foot on the Moon but that they set eye on the earth.</p>\r\n\r\n                    <p>A Chinese tale tells of some men sent to harm a young girl who, upon seeing her beauty, become her protectors rather than her violators. That\'s how I felt seeing the Earth for the first time. I could not help but love and cherish her.</p>\r\n\r\n                    <p>For those who have seen the Earth from space, and for the hundreds and perhaps thousands more who will, the experience most certainly changes your perspective. The things that we share in our world are far more valuable than those which divide us.</p>\r\n\r\n                    <h2 class=\"section-heading\">The Final Frontier</h2>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <p>There can be no thought of finishing for \'aiming for the stars.\' Both figuratively and literally, it is a task to occupy the generations. And no matter how much progress one makes, there is always the thrill of just beginning.</p>\r\n\r\n                    <blockquote>The dreams of yesterday are the hopes of today and the reality of tomorrow. Science has not yet mastered prophecy. We predict too much for the next year and yet far too little for the next ten.</blockquote>\r\n\r\n                    <p>Spaceflights cannot be stopped. This is not the work of any one man or even a group of men. It is a historical process which mankind is carrying out in accordance with the natural laws of human development.</p>\r\n\r\n                    <h2 class=\"section-heading\">Reaching for the Stars</h2>\r\n\r\n                    <p>As we got further and further away, it [the Earth] diminished in size. Finally it shrank to the size of a marble, the most beautiful you can imagine. That beautiful, warm, living object looked so fragile, so delicate, that if you touched it with a finger it would crumble and fall apart. Seeing this has to change a man.</p>\r\n\r\n                    <a href=\"#\">\r\n                        <img class=\"img-responsive\" src=\"img/post-sample-image.jpg\" alt=\"\">\r\n                    </a>\r\n                    <span class=\"caption text-muted\">To go places and do things that have never been done before - that\'s what living is all about.</span>\r\n\r\n                    <p>Space, the final frontier. These are the voyages of the Starship Enterprise. Its five-year mission: to explore strange new worlds, to seek out new life and new civilizations, to boldly go where no man has gone before.</p>\r\n\r\n                    <p>As I stand out here in the wonders of the unknown at Hadley, I sort of realize there\'s a fundamental truth to our nature, Man must explore, and this is exploration at its greatest.</p>\r\n\r\n                    <p>Placeholder text by <a href=\"http://spaceipsum.com/\">Space Ipsum</a>. Photographs by <a href=\"https://www.flickr.com/photos/nasacommons/\">NASA on The Commons</a>.</p>', '', '2018-06-02 18:06:00', '2018-05-29 11:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `userType` enum('public','author','editor','admin','superAdmin') DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `publish_name` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `bio` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `password` char(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userType`, `username`, `first_name`, `last_name`, `publish_name`, `email`, `bio`, `avatar`, `password`, `salt`, `dateAdded`) VALUES
(2, 'editor', 'authorUser', '', '', '', 'author@example.com', '', '', 'f3c88fdd93fcd019fd6b4b490c69c851', '', '2018-05-24 00:07:23'),
(3, 'admin', 'adminUser', 'Ogaba', 'Grace', 'Ogaba Grace', 'admin@example.com', 'I\'m a girl', '', 'ba73637a27dfcb35a5d4310a1ef995f3', '', '2018-05-24 00:07:23'),
(4, 'superAdmin', 'Elmage', 'Emmanuel', 'Ogaba', 'Ogaba Emmanuel', 'elmageace@gmail.com', 'I\'m the boss!', '', '5e187e88161df65cab0d7e3e222d4d22a125507e24e6386eb8562a64a62a4c3e', '_¢²™Eù9ÒC}[*†V.Jñ¼[\rP°×„1ŒÙt', '2018-05-26 23:07:23'),
(5, 'author', 'Sam', 'Samuel', 'Ogaba', 'Sam', 'elmagegace@hotmail.com', 'An editor', '', '26f9bbe0397ebcb7f1cf39d496b874ba67d95bb6216a74d4b0f79084b56a0c01', '#(k\'\0s´îŠKÌÀizÉ:HþUÈ­BØˆ{Üú', '2018-06-13 20:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_session`
--

INSERT INTO `users_session` (`id`, `user_id`, `hash`) VALUES
(1, 4, 'a9be0a538477ea77fdde63b53ed0ea0500b0db497e6b5974c82dbfbd08e0da06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creatorId` (`creatorId`),
  ADD KEY `dateUpdated` (`dateUpdated`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creatorId` (`creatorId`),
  ADD KEY `dateUpdated` (`dateUpdated`);

--
-- Indexes for table `trash`
--
ALTER TABLE `trash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `login` (`email`,`password`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `trash`
--
ALTER TABLE `trash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
