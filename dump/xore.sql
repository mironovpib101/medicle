-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Янв 27 2019 г., 14:38
-- Версия сервера: 5.7.24-0ubuntu0.18.04.1
-- Версия PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `xore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `emails`
--

INSERT INTO `emails` (`id`, `email`) VALUES
(1, 'mironovpib101@gmail.com'),
(2, 'olegalego@gmail.com'),
(3, 'mironovpib101@mail.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scan` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `licenses`
--

INSERT INTO `licenses` (`id`, `date`, `scan`, `title`) VALUES
(1, '2019-01-26 03:50:01', 'http://xore/data/public/licenses/lic1.jpg', 'лицензия №242543543'),
(17, '2019-01-26 08:09:59', 'http://xore/data/public/licenses/lic2.jpg', 'gjhgkgk');

-- --------------------------------------------------------

--
-- Структура таблицы `methods`
--

CREATE TABLE `methods` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `methods`
--

INSERT INTO `methods` (`id`, `title`, `text`) VALUES
(1, 'Новый метод 2', '<p>пыва пывап ывап ыап ав пвыапывапывапва</p><p>пыыв</p><p>апыва</p><p>п</p><p>ыва</p><p>пыв</p><p>апывакуц цук уцкц ук ку к423423 42342 34234</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `pain`
--

CREATE TABLE `pain` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `top` int(11) NOT NULL,
  `left` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pain`
--

INSERT INTO `pain` (`id`, `title`, `text`, `top`, `left`) VALUES
(1, 'Страдалец', '<p>Вот она - боль</p>', 200, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Автор',
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - черновик, 1 - опубликовано',
  `preview_text` text,
  `preview_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `date`, `text`, `status`, `preview_text`, `preview_image`) VALUES
(42, 1, 'Терапия (лечение)', '2019-01-25 20:00:00', '<h2>Терапевтические подходы</h2><ul><li><a href=\"https://ru.wikipedia.org/wiki/%D0%AD%D1%82%D0%B8%D0%BE%D1%82%D1%80%D0%BE%D0%BF%D0%BD%D0%B0%D1%8F_%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\"><strong>Этиотропная</strong> терапия</a> направлена на устранение <strong>причины</strong> заболевания (например, <a href=\"https://ru.wikipedia.org/wiki/%D0%90%D0%BD%D1%82%D0%B8%D0%B1%D0%B8%D0%BE%D1%82%D0%B8%D0%BA%D0%B8\">антибактериальная</a> терапия при <a href=\"https://ru.wikipedia.org/wiki/%D0%98%D0%BD%D1%84%D0%B5%D0%BA%D1%86%D0%B8%D0%BE%D0%BD%D0%BD%D1%8B%D0%B5_%D0%B7%D0%B0%D0%B1%D0%BE%D0%BB%D0%B5%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F\">инфекционных болезнях</a>).</li></ul><p>&nbsp;</p><ul><li><a href=\"https://ru.wikipedia.org/wiki/%D0%9F%D0%B0%D1%82%D0%BE%D0%B3%D0%B5%D0%BD%D0%B5%D0%B7\"><strong>Патогенетическая</strong></a> терапия направлена на <strong>механизмы</strong> развития заболевания. Она применяется при невозможности <i>этиотропной</i> терапии (например, заместительная терапия <a href=\"https://ru.wikipedia.org/wiki/%D0%98%D0%BD%D1%81%D1%83%D0%BB%D0%B8%D0%BD\">инсулином</a> при <a href=\"https://ru.wikipedia.org/wiki/%D0%A1%D0%B0%D1%85%D0%B0%D1%80%D0%BD%D1%8B%D0%B9_%D0%B4%D0%B8%D0%B0%D0%B1%D0%B5%D1%82\">сахарном диабете</a> в связи с недостаточной продукцией этого <a href=\"https://ru.wikipedia.org/wiki/%D0%93%D0%BE%D1%80%D0%BC%D0%BE%D0%BD\">гормона</a> <a href=\"https://ru.wikipedia.org/wiki/%D0%9F%D0%BE%D0%B4%D0%B6%D0%B5%D0%BB%D1%83%D0%B4%D0%BE%D1%87%D0%BD%D0%B0%D1%8F_%D0%B6%D0%B5%D0%BB%D0%B5%D0%B7%D0%B0\">поджелудочной железой</a> и невозможностью, на современном уровне развития медицины, восстановить эту функцию).</li></ul><p>&nbsp;</p><ul><li><a href=\"https://ru.wikipedia.org/wiki/%D0%A1%D0%B8%D0%BC%D0%BF%D1%82%D0%BE%D0%BC\"><strong>Симптоматическая</strong></a> (<a href=\"https://ru.wikipedia.org/wiki/%D0%9F%D0%B0%D0%BB%D0%BB%D0%B8%D0%B0%D1%82%D0%B8%D0%B2\">паллиативная</a>) терапия применяется для устранения отдельных <a href=\"https://ru.wikipedia.org/wiki/%D0%A1%D0%B8%D0%BC%D0%BF%D1%82%D0%BE%D0%BC\">симптомов</a> заболевания (например, применение <a href=\"https://ru.wikipedia.org/wiki/%D0%90%D0%BD%D0%B0%D0%BB%D1%8C%D0%B3%D0%B5%D1%82%D0%B8%D0%BA\">анальгетиков</a> при боли, жаропонижающих препаратов при «<a href=\"https://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%85%D0%BE%D1%80%D0%B0%D0%B4%D0%BA%D0%B0\">высокой температуре</a>» и др.) Она может применяться в дополнение к <i>этиотропной</i> и <i>патогенетической</i> терапии.</li></ul><p>Симптоматическая терапия при невозможности радикального излечения (терминальная стадия онкологического заболевания и др.) осуществляется в рамках спектра лечебно-социальных мероприятий, называемого <a href=\"https://ru.wikipedia.org/wiki/%D0%9F%D0%B0%D0%BB%D0%BB%D0%B8%D0%B0%D1%82%D0%B8%D0%B2%D0%BD%D0%B0%D1%8F_%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D1%8C\">паллиативной помощью</a>.</p><h2>Консервативное лечение</h2><p>Консервативное (нехирургическое) лечение (собственно, терапия) осуществляется химическими, физическими и биологическими методами.</p><p><strong>Химические и биологические методы[</strong><a href=\"https://ru.wikipedia.org/w/index.php?title=%D0%A2%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F_(%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5)&amp;veaction=edit&amp;section=3\"><strong>править</strong></a><strong> | </strong><a href=\"https://ru.wikipedia.org/w/index.php?title=%D0%A2%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F_(%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5)&amp;action=edit&amp;section=3\"><strong>править код</strong></a><strong>]</strong></p><h3>&nbsp;</h3><p>Химические и биологические методы являются основными консервативными способами воздействия на больной организм. К их числу относятся:</p><ul><li><a href=\"https://ru.wikipedia.org/wiki/%D0%A4%D0%B0%D1%80%D0%BC%D0%B0%D0%BA%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">фармакотерапия</a> (включая <a href=\"https://ru.wikipedia.org/wiki/%D0%A5%D0%B8%D0%BC%D0%B8%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">химиотерапию</a>)</li><li><a href=\"https://ru.wikipedia.org/wiki/%D0%A4%D0%B8%D1%82%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">фитотерапия</a></li><li><a href=\"https://ru.wikipedia.org/wiki/%D0%98%D0%BC%D0%BC%D1%83%D0%BD%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">иммунотерапия</a></li></ul><p>и другие, более редкие, методы.</p><p><strong>Физические методы[</strong><a href=\"https://ru.wikipedia.org/w/index.php?title=%D0%A2%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F_(%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5)&amp;veaction=edit&amp;section=4\"><strong>править</strong></a><strong> | </strong><a href=\"https://ru.wikipedia.org/w/index.php?title=%D0%A2%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F_(%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5)&amp;action=edit&amp;section=4\"><strong>править код</strong></a><strong>]</strong></p><h3>&nbsp;</h3><p>К физическим консервативным методам лечения относятся <a href=\"https://ru.wikipedia.org/wiki/%D0%A4%D0%B8%D0%B7%D0%B8%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">физиотерапия</a>, <a href=\"https://ru.wikipedia.org/wiki/%D0%9C%D0%B0%D1%81%D1%81%D0%B0%D0%B6\">массаж</a> и <a href=\"https://ru.wikipedia.org/wiki/%D0%9B%D0%B5%D1%87%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F_%D1%84%D0%B8%D0%B7%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B0%D1%8F_%D0%BA%D1%83%D0%BB%D1%8C%D1%82%D1%83%D1%80%D0%B0\">лечебная физкультура</a>, <a href=\"https://ru.wikipedia.org/wiki/%D0%93%D0%B8%D0%B4%D1%80%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">гидротерапия</a>. В большинстве случаев эти методы являются вспомогательными. Физические методы также включают в себя воздействия на организм с помощью электромагнитных и звуковых излучений:</p><ul><li><a href=\"https://ru.wikipedia.org/wiki/%D0%A0%D0%B0%D0%B4%D0%B8%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">радиотерапия</a></li><li><a href=\"https://ru.wikipedia.org/wiki/%D0%A3%D0%92%D0%A7-%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">УВЧ-терапия</a></li><li><a href=\"https://ru.wikipedia.org/wiki/%D0%9C%D0%B0%D0%B3%D0%BD%D0%B8%D1%82%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">магнитотерапия</a></li><li>лекарственный <a href=\"https://ru.wikipedia.org/wiki/%D0%AD%D0%BB%D0%B5%D0%BA%D1%82%D1%80%D0%BE%D1%84%D0%BE%D1%80%D0%B5%D0%B7\">электрофорез</a></li><li><a href=\"https://ru.wikipedia.org/wiki/%D0%9B%D0%B0%D0%B7%D0%B5%D1%80%D0%BE%D1%82%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F\">лазеротерапия</a></li></ul><h2>Хирургическое лечение</h2><p><i>Основная статья: </i><a href=\"https://ru.wikipedia.org/wiki/%D0%A5%D0%B8%D1%80%D1%83%D1%80%D0%B3%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%BE%D0%B5_%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5\"><i><strong>Хирургическое лечение</strong></i></a></p><p>Хирургическое лечение формально выходит за рамки <a href=\"https://ru.wikipedia.org/wiki/%D0%92%D0%BD%D1%83%D1%82%D1%80%D0%B5%D0%BD%D0%BD%D0%B8%D0%B5_%D0%B1%D0%BE%D0%BB%D0%B5%D0%B7%D0%BD%D0%B8\">внутренней медицины (терапии)</a>. Применяется в случае невозможности или низкой эффективности консервативного лечения.</p><p>Тем не менее, терапию нельзя логически противопоставлять хирургии, поскольку хирургическое вмешательство это частный случай лечения (терапии), который должен применяться тогда, когда это необходимо с точки зрения терапевтической программы.</p>', 1, '<p><strong>Терапи́я</strong> (<a href=\"https://ru.wikipedia.org/wiki/%D0%94%D1%80%D0%B5%D0%B2%D0%BD%D0%B5%D0%B3%D1%80%D0%B5%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B9_%D1%8F%D0%B7%D1%8B%D0%BA\">др.-греч.</a> θερᾰπεία&nbsp;«врачебный уход, лечение»<a href=\"https://ru.wikipedia.org/wiki/%D0%A2%D0%B5%D1%80%D0%B0%D0%BF%D0%B8%D1%8F_(%D0%BB%D0%B5%D1%87%D0%B5%D0%BD%D0%B8%D0%B5)#cite_note-1\">[1]</a>)&nbsp;— процесс, целью которого является облегчение, снятие или устранение <a href=\"https://ru.wikipedia.org/wiki/%D0%A1%D0%B8%D0%BC%D0%BF%D1%82%D0%BE%D0%BC\">симптомов</a> и проявлений того или иного <a href=\"https://ru.wikipedia.org/wiki/%D0%97%D0%B0%D0%B1%D0%BE%D0%BB%D0%B5%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5\">заболевания</a> или <a href=\"https://ru.wikipedia.org/wiki/%D0%A2%D1%80%D0%B0%D0%B2%D0%BC%D1%8B\">травмы</a>, патологического состояния или иного нарушения <a href=\"https://ru.wikipedia.org/wiki/%D0%96%D0%B8%D0%B7%D0%BD%D0%B5%D0%B4%D0%B5%D1%8F%D1%82%D0%B5%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D1%8C\">жизнедеятельности</a>, нормализация нарушенных процессов жизнедеятельности и выздоровление, восстановление <a href=\"https://ru.wikipedia.org/wiki/%D0%97%D0%B4%D0%BE%D1%80%D0%BE%D0%B2%D1%8C%D0%B5\">здоровья</a>.</p>', 'http://xore/data/public/posts/heal.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `prices`
--

INSERT INTO `prices` (`id`, `name`, `price`) VALUES
(2, 'Лечение №1', '100 руб.'),
(4, 'Лечение №2', '1000 руб.'),
(5, 'Лечение №3', '10000 руб.');

-- --------------------------------------------------------

--
-- Структура таблицы `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `href` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - черновик, 1 - опубликовано'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `slides`
--

INSERT INTO `slides` (`id`, `image`, `href`, `text`, `title`, `status`) VALUES
(1, 'http://xore/data/public/slider/slide1.png', 'http://xore/prices/', 'В связи с расширением, мы предоставляем вам новый список наших услуг', 'Мы открылись!', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `staff`
--

INSERT INTO `staff` (`id`, `fullname`, `photo`, `about`) VALUES
(4, 'Иван Иванович Иванов', 'http://xore/data/public/staff/3196.jpg', 'Квалифицированный специалист, ... хороший специалист, отличный специалист, лучший специалист.'),
(5, 'Иван Иванович Иванов', 'http://xore/data/public/staff/Peganov.jpg', ' квалифицированный специалист, ... хороший специалист, отличный специалист, лучший специалист.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `links` json DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login`, `password`, `links`, `token`, `status`) VALUES
(1, 'Oleg', 'mironovpib101@gmail.com', 'admin', '202cb962ac59075b964b07152d234b70', NULL, 'Y3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsI', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `licenses`
--
ALTER TABLE `licenses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `methods`
--
ALTER TABLE `methods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pain`
--
ALTER TABLE `pain`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `licenses`
--
ALTER TABLE `licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `methods`
--
ALTER TABLE `methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pain`
--
ALTER TABLE `pain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
