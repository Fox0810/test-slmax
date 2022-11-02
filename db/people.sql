-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 02 2022 г., 22:59
-- Версия сервера: 10.8.4-MariaDB-log
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `people`
--

-- --------------------------------------------------------

--
-- Структура таблицы `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `surname` mediumtext NOT NULL,
  `birthday` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `people`
--

INSERT INTO `people` (`id`, `name`, `surname`, `birthday`, `gender`, `city`) VALUES
(2, 'Людмила', 'Иванова', '1984-06-15', 0, 'Минск'),
(3, 'Ольга', 'Асташко', '2005-09-18', 0, 'Брест'),
(5, 'Александр', 'Новиков', '1989-11-12', 1, 'Мозырь'),
(6, 'Константин', 'Романов', '1993-07-09', 1, 'Хабаровск'),
(9, 'Екатерина', 'Морозова', '2005-12-25', 0, 'Гомель'),
(12, 'Максим', 'Саломатин', '1992-05-09', 1, 'Барановичи'),
(18, 'Марина', 'Семенова', '1959-01-08', 0, 'Могилев'),
(23, 'Кристина', 'Сагидулина', '2004-02-07', 0, 'Гродно'),
(27, 'Матвей', 'Ивлев', '1998-05-18', 1, 'Санкт-Петербург');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
