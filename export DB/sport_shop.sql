-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Січ 06 2026 р., 17:11
-- Версія сервера: 8.3.0
-- Версія PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `sport_shop`
--

DELIMITER $$
--
-- Процедури
--
DROP PROCEDURE IF EXISTS `Stats_AvgRatingPerProduct`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Stats_AvgRatingPerProduct` ()   BEGIN
    SELECT 
        p.ProductName,
        AVG(r.Rating) AS AvgRating,
        COUNT(r.ReviewID) AS NumReviews
    FROM products p
    LEFT JOIN reviews r ON p.ProductID = r.ProductID AND r.Status = 'approved'
    GROUP BY p.ProductID
    ORDER BY AvgRating DESC;
END$$

DROP PROCEDURE IF EXISTS `Stats_TopSellingProducts`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Stats_TopSellingProducts` ()   BEGIN
    SELECT 
        p.ProductName,
        SUM(od.Quantity) AS TotalSold,
        SUM(od.Quantity * od.Price) AS Revenue
    FROM orderdetails od
    JOIN products p ON od.ProductID = p.ProductID
    GROUP BY p.ProductID
    ORDER BY TotalSold DESC
    LIMIT 5;
END$$

DROP PROCEDURE IF EXISTS `Stats_TopUsersByReviews`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Stats_TopUsersByReviews` ()   BEGIN
    SELECT 
        u.Username,
        COUNT(r.ReviewID) AS NumReviews
    FROM users u
    LEFT JOIN reviews r ON u.UserID = r.UserID AND r.Status = 'approved'
    GROUP BY u.UserID
    ORDER BY NumReviews DESC
    LIMIT 5;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблиці `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `CartID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `ProductID` int NOT NULL,
  `Quantity` int NOT NULL DEFAULT '1',
  `AddedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`CartID`),
  KEY `UserID` (`UserID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(100) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`, `Description`) VALUES
(1, 'Кросівки', 'Спортивні кросівки для бігу і не тільки.'),
(3, 'Спортивне харчування', 'Їж і пий і будеш сильний як бик.'),
(4, 'Спортивне приладдя', 'Для тренувань різних типів м\'язів.'),
(5, 'Тренажери', 'Тренажери як у залі, але у вас дома.');

-- --------------------------------------------------------

--
-- Структура таблиці `orderdetails`
--

DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE IF NOT EXISTS `orderdetails` (
  `OrderDetailID` int NOT NULL AUTO_INCREMENT,
  `OrderID` int NOT NULL,
  `ProductID` int NOT NULL,
  `Quantity` int NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`OrderDetailID`),
  KEY `OrderID` (`OrderID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetailID`, `OrderID`, `ProductID`, `Quantity`, `Price`) VALUES
(1, 1, 2, 2, 2500.00),
(2, 1, 4, 1, 860.00),
(3, 2, 1, 1, 1989.00),
(4, 3, 1, 1, 1989.00),
(5, 4, 1, 1, 1989.00);

--
-- Тригери `orderdetails`
--
DROP TRIGGER IF EXISTS `trg_decrease_stock_after_order`;
DELIMITER $$
CREATE TRIGGER `trg_decrease_stock_after_order` AFTER INSERT ON `orderdetails` FOR EACH ROW BEGIN
    UPDATE products
    SET Stock = Stock - NEW.Quantity
    WHERE ProductID = NEW.ProductID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL,
  `OrderDate` date NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `Status` enum('Pending','Processing','Shipped','Completed','Cancelled') DEFAULT 'Pending',
  PRIMARY KEY (`OrderID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `OrderDate`, `TotalAmount`, `Status`) VALUES
(1, 2, '2025-06-11', 5860.00, 'Pending'),
(2, 3, '2026-01-05', 1989.00, 'Completed'),
(3, 3, '2026-01-05', 1989.00, 'Completed'),
(4, 3, '2026-01-05', 1989.00, 'Pending');

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `ProductID` int NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(255) NOT NULL,
  `Description` text,
  `Price` decimal(10,2) NOT NULL,
  `Stock` int DEFAULT '0',
  `CategoryID` int DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ProductID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Description`, `Price`, `Stock`, `CategoryID`, `ImageURL`) VALUES
(1, 'Чоловічі кросівки Puma Milenio Tech', 'Круті кросівки для бігу і взагалі для спорту!', 1989.00, 21, 1, 'https://content.rozetka.com.ua/goods/images/big/346907289.jpg'),
(2, 'Adidas Ultraboost 24', 'преміум-клас для щоденних пробіжок та фітнесу.', 2500.00, 12, 1, 'https://runinn.com/cdn/shop/files/Ultraboost_Light_Shoes_Black_GY9351_HM1.jpg?v=1706982487'),
(3, 'Asics Gel-Kayano 31', 'підтримка для пронації, ідеальні для тривалих дистанцій.', 2800.00, 2, 1, 'https://img.modivo.cloud/product(b/a/d/6/bad630910d2176999b3a247c47b4e7845b1926f6_22_4570158286534.jpg,webp)/asics-vzuttia-dlia-bigu-jolt-5-1011b963-chornii-0000304560033.webp'),
(4, 'Optimum Nutrition Gold Standard Whey', 'сироватковий протеїн з високою біодоступністю.', 860.00, 12, 3, 'https://allnutrition.ua/produkt_img/Whey_Gold_Standard_100_i2268_d1200x1200.png'),
(5, 'Kevin Levrone LevroPump', 'помпа та енергія без цукру, з цитрулін малатом.', 450.00, 6, 3, 'https://www.proteinplus.com.ua/components/com_virtuemart/shop_image/product/06530.jpg?1573159575'),
(6, 'Гантелі з регульованою вагою 2–24 кг', 'зручні для домашніх тренувань.', 1699.00, 6, 4, 'https://content.rozetka.com.ua/goods/images/big/425630794.jpg'),
(7, 'Килимок для йоги Reebok 6mm', 'нековзкий і м’який для всіх видів вправ.', 599.00, 12, 4, 'https://www.orto-line.com.ua/images/detailed/151/RAYG-11042PL.jpg'),
(8, 'Велотренажер Schwinn IC8', 'Велотренажер Schwinn IC8 – з Bluetooth-підключенням до Zwift/Peloton.', 7600.00, 5, 5, 'https://content2.rozetka.com.ua/goods/images/big_tile/536126716.jpg'),
(9, 'Мультистанція Bowflex PR1000', 'для силових вправ вдома.', 12300.00, 16, 5, 'https://artofsport.com.ua/wp-content/uploads/2024/04/BowFlex_PR1000_Home_Gym_Angled_V.png');

-- --------------------------------------------------------

--
-- Структура таблиці `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `ReviewID` int NOT NULL AUTO_INCREMENT,
  `ProductID` int NOT NULL,
  `UserID` int NOT NULL,
  `Rating` int DEFAULT NULL,
  `ReviewText` text,
  `ReviewDate` date NOT NULL,
  `Status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`ReviewID`),
  KEY `ProductID` (`ProductID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `ProductID`, `UserID`, `Rating`, `ReviewText`, `ReviewDate`, `Status`) VALUES
(1, 2, 2, 4, 'Дуже хороші кроси, але дорогі', '2025-06-11', 'approved'),
(2, 3, 3, 5, 'вау ', '2026-01-05', 'approved');

--
-- Тригери `reviews`
--
DROP TRIGGER IF EXISTS `trg_set_review_date`;
DELIMITER $$
CREATE TRIGGER `trg_set_review_date` BEFORE INSERT ON `reviews` FOR EACH ROW BEGIN
    IF NEW.ReviewDate IS NULL THEN
        SET NEW.ReviewDate = CURDATE();
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_validate_review_rating`;
DELIMITER $$
CREATE TRIGGER `trg_validate_review_rating` BEFORE INSERT ON `reviews` FOR EACH ROW BEGIN
    IF NEW.Rating < 1 OR NEW.Rating > 5 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Rating must be between 1 and 5';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Role` enum('user','admin') DEFAULT 'user',
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `PostalCode` varchar(20) DEFAULT NULL,
  `RegistrationDate` date NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `PasswordHash`, `Role`, `FirstName`, `LastName`, `Phone`, `Address`, `City`, `Country`, `PostalCode`, `RegistrationDate`) VALUES
(3, 'Admin', 'admin@gmail.com', '$2y$10$5JKBvnPEFG0SJ81q4ItuK.VWHyWMOJdI.HZzc8v16v8oTce/l6JpC', 'admin', 'admin', 'admin', '+380638962592', 'admin', 'admin', 'admin', '12345', '2026-01-05'),
(2, 'User', 'user@gmail.com', '$2y$10$0VtnLhOsTOf21gmoKBCQA.9iRhniIxMPUA9XwrebVecArdL/kHh7C', 'user', 'Roma', 'Grebko', '0635351351', 'Bayker str', 'Zhytomyr', 'Ukraine', '241242', '2025-06-11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
