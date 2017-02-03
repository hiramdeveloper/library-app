-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-02-2017 a las 06:00:41
-- Versión del servidor: 5.6.33
-- Versión de PHP: 5.5.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `library`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatBooks`
--

CREATE TABLE `CatBooks` (
  `CatBooksId` int(11) NOT NULL,
  `CatCategoryId` int(11) NOT NULL,
  `SysStatusId` int(11) NOT NULL DEFAULT '1',
  `SysStatusLendBookId` int(11) NOT NULL DEFAULT '2',
  `Name` char(150) COLLATE utf8_spanish_ci NOT NULL,
  `Author` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `PublishDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CatBooks`
--

INSERT INTO `CatBooks` (`CatBooksId`, `CatCategoryId`, `SysStatusId`, `SysStatusLendBookId`, `Name`, `Author`, `PublishDate`) VALUES
(1, 7, 1, 2, 'The love in my life', 'Richard Wallas', '2017-02-02'),
(2, 8, 1, 2, 'The escape hitler', 'Alice Brennan', '2002-07-21'),
(3, 4, 1, 2, 'The programming science', 'Linus Torvalds', '2007-10-01'),
(4, 4, 1, 2, 'PHP with MySQL', 'Karl Helton', '2008-11-25'),
(5, 4, 1, 2, 'The best practices in javascript', 'Douglas Crockford', '2008-04-12'),
(6, 6, 1, 2, 'The Space Book', 'Jim Bell', '2007-06-03'),
(7, 6, 1, 2, 'Earth from Space', 'Andrew K. Johnston', '2009-07-08'),
(8, 6, 1, 2, 'Ancestral Machines', 'Michael Cobley', '2010-11-23'),
(9, 5, 1, 2, 'The Love Lemons', 'Jack Mathews', '2011-03-05'),
(10, 5, 1, 2, 'The Feed Zone Fast and Flavorful food for Athletes CookBook', 'Allen Lim', '2010-01-02'),
(11, 5, 1, 2, 'The healthy College cookbook', 'Alexander Niwets', '2011-02-01'),
(12, 8, 1, 2, 'The Iran-Iraq War', 'Nicholas Elliot', '2010-09-28'),
(13, 8, 1, 2, 'Ghost of war', 'Ryan Smithson', '2013-12-15'),
(14, 8, 1, 2, 'The art of war', 'Stephen E. Kaufman', '2008-05-06'),
(15, 8, 1, 2, 'Forgotten War', 'Henry Reynolds', '2006-01-09'),
(16, 2, 1, 2, 'The walking dead', 'Robert Kirkman', '2011-10-11'),
(17, 2, 1, 2, 'Friday the 13TH', 'Scott Philips', '2001-03-16'),
(18, 2, 1, 2, 'Echoes of Darkness', 'Rob Smales', '2000-06-08'),
(19, 2, 1, 2, 'Naomis Room', 'Jonathan Aycliffe', '1997-01-09'),
(20, 7, 1, 2, 'For the love', 'Jen Hatmaker', '2001-08-01'),
(21, 7, 1, 2, 'The mathematics of Love', 'Hannah Fry', '2009-12-01'),
(22, 7, 1, 2, 'Who do you love', 'Jennifer Weiner', '2010-05-24'),
(23, 1, 1, 2, 'The family book', 'Todd Parr', '2008-02-04'),
(24, 1, 1, 2, 'Family and Friends', 'Naomi Simmons', '2012-03-25'),
(25, 1, 1, 2, 'All in the Family', 'Sharon Graham', '2010-01-03'),
(26, 3, 1, 2, 'Comedy Techniques', 'Brian McKim', '2007-08-21'),
(27, 3, 1, 2, 'The Comedians', 'Klip Nesteroff', '2002-12-01'),
(28, 3, 1, 2, 'The hidden tools of comedy', 'Steve Kaplan', '2011-01-15'),
(29, 4, 1, 2, 'Slim Framework', 'Hiram Ramirez', '2017-02-09'),
(30, 4, 1, 2, 'Angular Best Practices', 'Julian Witbell', '2017-02-16'),
(31, 6, 1, 2, 'Alines in the moon', 'Jaime Mausan', '2017-02-07'),
(32, 7, 1, 2, 'The Love in my self', 'Brian Telles', '1965-07-14'),
(33, 1, 1, 2, 'New book 1', 'Hiram Ramirez Ruelas', '2017-02-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatCategory`
--

CREATE TABLE `CatCategory` (
  `CatCategoryId` int(11) NOT NULL,
  `Name` char(80) COLLATE utf8_spanish_ci NOT NULL,
  `Description` varchar(350) COLLATE utf8_spanish_ci NOT NULL,
  `QuantityBooks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CatCategory`
--

INSERT INTO `CatCategory` (`CatCategoryId`, `Name`, `Description`, `QuantityBooks`) VALUES
(1, 'FAMILY', 'This books are perfect for learning about the family relationship', 3),
(2, 'HORROR', 'Amaizing historys about Ghosts around the world', 4),
(3, 'COMEDY', 'This books are perfect for smile all day', 3),
(4, 'SCIENCE', 'Books for learning about the new technologies in software', 3),
(5, 'COOKBOOK', 'All recipes for cocking all year', 3),
(6, 'SPACE', 'Discover life in other planets', 3),
(7, 'LOVE', 'The best collection the love books', 4),
(8, 'WAR', 'All histories about to the first and second world war', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatCustomer`
--

CREATE TABLE `CatCustomer` (
  `CatCustomerId` int(11) NOT NULL,
  `SysStatusId` int(11) NOT NULL DEFAULT '1',
  `Name` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `Email` char(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Address` char(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Neibordhood` char(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telephone` char(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cellphone` char(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `City` char(70) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CatCustomer`
--

INSERT INTO `CatCustomer` (`CatCustomerId`, `SysStatusId`, `Name`, `Email`, `Address`, `Neibordhood`, `Telephone`, `Cellphone`, `City`) VALUES
(1, 1, 'Roger Redford', 'rog@gmail.com', 'Av. 5TH', 'Downtown', '318456365', '31835686', 'L.A.'),
(2, 1, 'Angy Wallas', 'angy@gmail.com', 'Av. Paz', 'Bronce', '687645688', '35468786', 'L.A.'),
(3, 1, 'Richard Philips', 'rich@gmail.com', 'Av. Stars', 'Lake Hill', '643848646', '65467686', 'L.A.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RelBorrowCustomerBook`
--

CREATE TABLE `RelBorrowCustomerBook` (
  `RelBorrowCustomerBookId` int(11) NOT NULL,
  `CatCustomerId` int(11) NOT NULL,
  `CatBooksId` int(11) DEFAULT NULL,
  `SysStatusId` int(11) DEFAULT NULL,
  `BeginDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SecUser`
--

CREATE TABLE `SecUser` (
  `SecUserId` int(11) NOT NULL,
  `Name` char(80) COLLATE utf8_spanish_ci NOT NULL,
  `Email` char(100) COLLATE utf8_spanish_ci NOT NULL,
  `UserName` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `Password` char(50) COLLATE utf8_spanish_ci NOT NULL,
  `Token` char(39) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SysStatusId` int(11) NOT NULL DEFAULT '1',
  `LastLogin` datetime DEFAULT NULL,
  `CreatedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `SecUser`
--

INSERT INTO `SecUser` (`SecUserId`, `Name`, `Email`, `UserName`, `Password`, `Token`, `SysStatusId`, `LastLogin`, `CreatedDate`) VALUES
(1, 'Hiram Ramirez Ruelas', 'hiram.ramirez8@gmail.com', 'hiramweb', 'developer', NULL, 1, '2017-02-02 23:05:03', '2017-02-01 19:18:04'),
(2, 'Guest User Admin', '', 'guest', 'guest', '86X5KDW0S9-LQ5VD-JAJA7-215QR3G8EN', 1, '2017-02-02 23:05:12', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SysStatus`
--

CREATE TABLE `SysStatus` (
  `SysStatusId` int(11) NOT NULL,
  `Name` char(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `SysStatus`
--

INSERT INTO `SysStatus` (`SysStatusId`, `Name`) VALUES
(1, 'ACTIVE'),
(2, 'AVAILABLE'),
(3, 'BORROWED'),
(4, 'NOT AVAILABLE'),
(5, 'DELETED'),
(6, 'INACTIVE'),
(7, 'CANCELED');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `CatBooks`
--
ALTER TABLE `CatBooks`
  ADD PRIMARY KEY (`CatBooksId`);

--
-- Indices de la tabla `CatCategory`
--
ALTER TABLE `CatCategory`
  ADD PRIMARY KEY (`CatCategoryId`);

--
-- Indices de la tabla `CatCustomer`
--
ALTER TABLE `CatCustomer`
  ADD PRIMARY KEY (`CatCustomerId`);

--
-- Indices de la tabla `RelBorrowCustomerBook`
--
ALTER TABLE `RelBorrowCustomerBook`
  ADD PRIMARY KEY (`RelBorrowCustomerBookId`);

--
-- Indices de la tabla `SecUser`
--
ALTER TABLE `SecUser`
  ADD PRIMARY KEY (`SecUserId`);

--
-- Indices de la tabla `SysStatus`
--
ALTER TABLE `SysStatus`
  ADD PRIMARY KEY (`SysStatusId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `CatBooks`
--
ALTER TABLE `CatBooks`
  MODIFY `CatBooksId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `CatCategory`
--
ALTER TABLE `CatCategory`
  MODIFY `CatCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `CatCustomer`
--
ALTER TABLE `CatCustomer`
  MODIFY `CatCustomerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `RelBorrowCustomerBook`
--
ALTER TABLE `RelBorrowCustomerBook`
  MODIFY `RelBorrowCustomerBookId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `SecUser`
--
ALTER TABLE `SecUser`
  MODIFY `SecUserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `SysStatus`
--
ALTER TABLE `SysStatus`
  MODIFY `SysStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
