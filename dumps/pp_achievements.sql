--
-- Baza danych: `pp_achievements`
--
CREATE DATABASE IF NOT EXISTS `pp_achievements` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pp_achievements`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `achievements`
--

DROP TABLE IF EXISTS `achievements`;
CREATE TABLE IF NOT EXISTS `achievements` (
  `nick` varchar(64) NOT NULL,
  `level5` int(1) NOT NULL,
  `level10` int(1) NOT NULL,
  `level15` int(1) NOT NULL,
  PRIMARY KEY (`nick`),
  UNIQUE KEY `nick` (`nick`),
  KEY `nick_2` (`nick`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
