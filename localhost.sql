-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 15 2022 г., 14:55
-- Версия сервера: 10.6.5-MariaDB-1:10.6.5+maria~focal
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `1110-20_clothing_store`
--
CREATE DATABASE IF NOT EXISTS `1110-20_clothing_store` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `1110-20_clothing_store`;

-- --------------------------------------------------------

--
-- Структура таблицы `cloth`
--

CREATE TABLE `cloth` (
  `product_number` int(11) NOT NULL COMMENT 'ид товара',
  `product_name` varchar(100) NOT NULL COMMENT 'название товара',
  `product_pic` varchar(200) DEFAULT NULL COMMENT 'изображение товара',
  `characteristic` varchar(100) NOT NULL COMMENT 'характеристика товара',
  `category` varchar(100) NOT NULL COMMENT 'категория',
  `prod_amount` int(100) NOT NULL COMMENT 'кол-во товара на складе'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='товары';

--
-- Дамп данных таблицы `cloth`
--

INSERT INTO `cloth` (`product_number`, `product_name`, `product_pic`, `characteristic`, `category`, `prod_amount`) VALUES
(4, 'майка', '/img/black_T-shirt', 'черная S', 'жен.одежда верх', 30),
(6, 'майка', '/img/red_T-shirtM', 'красная M', 'муж.одежда верх', 30),
(7, 'майка', '/img/black_T-shirtM', 'черная M', 'муж.одежда верх', 30),
(8, 'майка', '/img/white_T-shirtM', 'белая M', 'муж.одежда верх', 30),
(9, 'толстовка', '/img/white_hoodyM', 'белая L', 'муж.одежда верх', 35),
(10, 'толстовка', '/img/black_hoodyM', 'черная L', 'муж.одежда верх', 35),
(11, 'толстовка', '/img/white_hoody', 'белая M', 'жен.одежда верх', 40),
(12, 'толстовка', '/img/black_hoody', 'черная M', 'жен.одежда верх', 40),
(13, 'джинсы', '/img/jeans', 'синие M', 'жен.одежда низ', 25),
(14, 'джинсы', '/img/jeansM', 'синие M', 'муж.одежда низ', 30),
(15, 'свитер', NULL, 'черный L', 'жен.одежда верх', 40);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `order_number` int(11) NOT NULL COMMENT 'ид заказа',
  `product_number` int(11) NOT NULL COMMENT 'ид заказываемого продукта',
  `amount` int(100) NOT NULL COMMENT 'кол-во заказанного продукта',
  `store_id` int(11) NOT NULL COMMENT 'ид магазина',
  `user_id` int(11) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'принят в обработку'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='таблица оформленных заказов';

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`order_number`, `product_number`, `amount`, `store_id`, `user_id`, `order_status`) VALUES
(2, 13, 1, 3, 3, 'в сборке'),
(12, 13, 2, 3, 22, 'Принят в обработку');

-- --------------------------------------------------------

--
-- Структура таблицы `store`
--

CREATE TABLE `store` (
  `store_id` int(11) NOT NULL COMMENT 'ид магазина',
  `store_address` varchar(100) NOT NULL COMMENT 'адрес магазина'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `store`
--

INSERT INTO `store` (`store_id`, `store_address`) VALUES
(1, 'ул. Улица 1'),
(2, 'ул. Древесная стр.15 лит.А'),
(3, 'ТЦ \"Открытие\" ул. Железнякова 12 '),
(5, 'ул.Архипова 6 лит.В');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL COMMENT 'ид пользователя',
  `first_name` varchar(100) NOT NULL COMMENT 'имя пользователя',
  `last_name` varchar(100) NOT NULL COMMENT 'фамилия пользователя',
  `patronymic` varchar(100) NOT NULL COMMENT 'отчество пользователя',
  `email` varchar(100) NOT NULL COMMENT 'почта пользователя',
  `phone` varchar(15) NOT NULL COMMENT 'телефон пользователя',
  `store_id` int(11) NOT NULL COMMENT 'ид адреса магазина',
  `password` varchar(100) NOT NULL COMMENT 'пароль пользователя',
  `is_admin` int(1) NOT NULL DEFAULT 0 COMMENT 'админ - 1\r\nпользователь - 0',
  `token` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='таблица пользователей';

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `patronymic`, `email`, `phone`, `store_id`, `password`, `is_admin`, `token`) VALUES
(3, 'Борис', 'Размахаенко', 'Федорович', 'zerki@gmail.com', '+78998265421', 2, 'pass1235sas', 1, NULL),
(4, 'Тая', 'Михао', 'Сергеевна', '436523@mail.com', '+78958963542', 3, '345345dfg', 1, NULL),
(5, 'Лаврентий', 'Сергеевко', 'Михайлович', '72364@gmail.com', '+78998265621', 1, '342r2r34', 1, NULL),
(6, 'Иван', 'Петров', 'Петрович', '123@gmail.com', '+79001234568', 1, 'password', 0, NULL),
(7, 'Иван', 'Петров', 'Петрович', '123@gmail.com', '+79001234568', 3, '$2y$13$Xm.67TV2AtUPNphgy5On/eMN7OzaWUA7V2QHLa.c5KB2pUSfMUX8u', 0, NULL),
(8, 'Иван', 'Петров', 'Петрович', '123@gmail.com', '+79045234568', 3, '$2y$13$D/cV1LPEec9uj.k4Zi8gvuxnIdbEyboJ2Eww/6D3BCcThk//EqWN6', 0, NULL),
(9, 'Иван', 'Петров', 'Петрович', '123@gmail.com', '+7948756', 3, '$2y$13$ucwNmzQ49w32GAeHp4.7wOH0f0H1iRYd5sX/yZ8SJZ.pNlrzDMylC', 0, NULL),
(21, 'Вася', 'Васин', 'Сергеевич', '12345@gmail.com', '+79465858', 3, '$2y$13$OUfrcGm0c5mzv7MrESIfD.5f6rFBGo4JqfepzCQ766NxoWTNN.Hju', 0, 'UYPXCaRY5Qwhy5qUOltH34_LSQJ0-7U0'),
(22, 'Вася', 'Васин', 'Сергеевич', '123@gmail.com', '+79495858698', 3, '$2y$13$Y8Cxoq0okwoC4pu5Vl3SlOplfYw0gnzqEABNzEnV43p5ye6cKGnya', 1, 'Uf1sJ51RWccl2XBT_lxK2g8gtOHKcBjQ');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cloth`
--
ALTER TABLE `cloth`
  ADD PRIMARY KEY (`product_number`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_number`),
  ADD KEY `address_ibfk_2` (`store_id`),
  ADD KEY `product_ibfk_1` (`product_number`),
  ADD KEY `user_ibfk_1` (`user_id`);

--
-- Индексы таблицы `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `address_ibfk_1` (`store_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cloth`
--
ALTER TABLE `cloth`
  MODIFY `product_number` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид товара', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `order_number` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид заказа', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид магазина', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид пользователя', AUTO_INCREMENT=23;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `address_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`product_number`) REFERENCES `cloth` (`product_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
