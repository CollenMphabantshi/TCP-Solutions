CREATE TABLE IF NOT EXISTS `height` (
  `heightID` int NOT NULL AUTO_INCREMENT primary key,
  `whoFoundVictimBody` text NOT NULL,
  `heightInsideID` int NOT NULL,
  `heightOutsideID` int NOT NULL
);


CREATE TABLE IF NOT EXISTS `heightinside` (
  `heightInsideID` int NOT NULL AUTO_INCREMENT primary key,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
);


CREATE TABLE IF NOT EXISTS `heightoutside` (
  `heightOutsideID` int NOT NULL AUTO_INCREMENT primary key,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `fromWhat` text NOT NULL,
  `howHigh` text NOT NULL,
  `onWhatVictimLanded` int NOT NULL 
);