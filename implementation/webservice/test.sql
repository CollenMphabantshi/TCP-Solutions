-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2014 at 02:37 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mobileforensics`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `personelNumber` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`personelNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--


-- --------------------------------------------------------

--
-- Table structure for table `aviation`
--

CREATE TABLE IF NOT EXISTS `aviation` (
  `Photo` text NOT NULL,
  `BodyDecompose` text NOT NULL,
  `MedicalIntervention` text NOT NULL,
  `BodyBurned` text NOT NULL,
  `BodyIntact` text NOT NULL,
  `CloseToWater` text NOT NULL,
  `AviationOutside` text NOT NULL,
  `AircraftType` text NOT NULL,
  `AircraftNumPeople` text NOT NULL,
  `Victim` text NOT NULL,
  `VictiomIO` text NOT NULL,
  `WeatherCondition` text NOT NULL,
  `WeatherType` text NOT NULL,
  `SuicideNote` text NOT NULL,
  `GeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aviation`
--


-- --------------------------------------------------------

--
-- Table structure for table `bicycle`
--

CREATE TABLE IF NOT EXISTS `bicycle` (
  `BicyclePhoto` text NOT NULL,
  `BicycleBodyDecompose` varchar(5) NOT NULL,
  `BicycleMedicalIntervention` varchar(5) NOT NULL,
  `BicycleFoundBoby` text NOT NULL,
  `BicycleBodyIntact` varchar(5) NOT NULL,
  `BicycleOutside` text NOT NULL,
  `BicycleNumPeople` text NOT NULL,
  `BicycleHit` text NOT NULL,
  `BicycleType` text NOT NULL,
  `BicycleWeatherCondition` text NOT NULL,
  `BicycleSuicideNote` varchar(5) NOT NULL,
  `BicycleGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bicycle`
--


-- --------------------------------------------------------

--
-- Table structure for table `blunt`
--

CREATE TABLE IF NOT EXISTS `blunt` (
  `BluntPhoto` text NOT NULL,
  `BluntBodyDecompose` varchar(5) NOT NULL,
  `BluntMedicalIntervention` varchar(5) NOT NULL,
  `BluntFoundBody` text NOT NULL,
  `BluntCloseWater` varchar(5) NOT NULL,
  `BluntRapeHomicide` varchar(5) NOT NULL,
  `BluntSuspicionSuicide` varchar(5) NOT NULL,
  `BluntPreviousTempts` varchar(5) NOT NULL,
  `BluntIO` text NOT NULL,
  `BluntForceObjectSuspected` text NOT NULL,
  `BluntForceObject` varchar(5) NOT NULL,
  `BluntSuspicionStangulation` varchar(5) NOT NULL,
  `BluntSuspicionSmothering` varchar(5) NOT NULL,
  `BluntSuspicionChocking` varchar(5) NOT NULL,
  `BluntSuicideNote` varchar(5) NOT NULL,
  `BluntGeneralHistory` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blunt`
--


-- --------------------------------------------------------

--
-- Table structure for table `bluntinput`
--

CREATE TABLE IF NOT EXISTS `bluntinput` (
  `BluntType` text NOT NULL,
  `BluntDoor` varchar(5) NOT NULL,
  `BluntWindowsClosed` varchar(5) NOT NULL,
  `BluntWindowsBroken` varchar(5) NOT NULL,
  `BluntVictionAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bluntinput`
--


-- --------------------------------------------------------

--
-- Table structure for table `bluntoutput`
--

CREATE TABLE IF NOT EXISTS `bluntoutput` (
  `BluntOutside` text NOT NULL,
  `BluntStuggle` varchar(5) NOT NULL,
  `BluntAlcohol` varchar(5) NOT NULL,
  `BluntDrug` varchar(5) NOT NULL,
  `BluntComAssult` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bluntoutput`
--


-- --------------------------------------------------------

--
-- Table structure for table `burn`
--

CREATE TABLE IF NOT EXISTS `burn` (
  `BurnBody` text NOT NULL,
  `BurnBodyDecompose` varchar(5) NOT NULL,
  `BurnMedicalIntervention` varchar(5) NOT NULL,
  `BurnFoundBody` text NOT NULL,
  `BurnCloseWater` varchar(5) NOT NULL,
  `BurnRapeHomicide` varchar(5) NOT NULL,
  `BurnSuspicionSuicide` varchar(5) NOT NULL,
  `BurnPreviousTempts` varchar(5) NOT NULL,
  `BurnIO` text NOT NULL,
  `BurnSuspicion` varchar(5) NOT NULL,
  `BurnSuicideNote` varchar(5) NOT NULL,
  `BurnGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `burn`
--


-- --------------------------------------------------------

--
-- Table structure for table `burninside`
--

CREATE TABLE IF NOT EXISTS `burninside` (
  `BurnType` text NOT NULL,
  `BurnFoundBody` varchar(5) NOT NULL,
  `BurnWindowsClosed` varchar(5) NOT NULL,
  `BurnWindowsBroken` varchar(5) NOT NULL,
  `BurnVictimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `burninside`
--


-- --------------------------------------------------------

--
-- Table structure for table `burnoutside`
--

CREATE TABLE IF NOT EXISTS `burnoutside` (
  `BurnType` text NOT NULL,
  `BurnStruggle` varchar(5) NOT NULL,
  `BurnAlcohol` varchar(5) NOT NULL,
  `BurnDrug` varchar(5) NOT NULL,
  `BurnAccelerants` varchar(5) NOT NULL,
  `BurnIgniter` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `burnoutside`
--


-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE IF NOT EXISTS `cases` (
  `caseNumber` int(11) NOT NULL AUTO_INCREMENT,
  `sceneID` int(11) NOT NULL,
  `FOPersonelNumber` int(11) NOT NULL,
  PRIMARY KEY (`caseNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `cases`
--


-- --------------------------------------------------------

--
-- Table structure for table `deathregister`
--

CREATE TABLE IF NOT EXISTS `deathregister` (
  `deathRegisterNumber` int(11) NOT NULL AUTO_INCREMENT,
  `caseNumber` int(11) NOT NULL,
  PRIMARY KEY (`deathRegisterNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `deathregister`
--


-- --------------------------------------------------------

--
-- Table structure for table `forensicofficer`
--

CREATE TABLE IF NOT EXISTS `forensicofficer` (
  `personelNumber` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `cellphoneNumber` int(11) NOT NULL,
  PRIMARY KEY (`personelNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forensicofficer`
--


-- --------------------------------------------------------

--
-- Table structure for table `forensicpractitioner`
--

CREATE TABLE IF NOT EXISTS `forensicpractitioner` (
  `personelNumber` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `cellphoneNumber` int(11) NOT NULL,
  PRIMARY KEY (`personelNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forensicpractitioner`
--


-- --------------------------------------------------------

--
-- Table structure for table `hanging`
--

CREATE TABLE IF NOT EXISTS `hanging` (
  `hangingID` int(11) NOT NULL AUTO_INCREMENT,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `closeWater` varchar(5) NOT NULL,
  `suspicionSuicide` varchar(5) NOT NULL,
  `previousAttepts` varchar(5) NOT NULL,
  `hangingIO` text NOT NULL,
  `autoeroticAsphyxia` varchar(5) NOT NULL,
  `partialHanging` int(11) NOT NULL,
  `completeHanging` text NOT NULL,
  `ligatureAroundNeck` varchar(5) NOT NULL,
  `ligatureType` int(11) NOT NULL,
  `suspicionOfStrangulation` varchar(5) NOT NULL,
  `suspicionOfSmothering` varchar(5) NOT NULL,
  `suspicionOfChocking` varchar(5) NOT NULL,
  `suicedNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL,
  PRIMARY KEY (`hangingID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `hanging`
--


-- --------------------------------------------------------

--
-- Table structure for table `hanginginside`
--

CREATE TABLE IF NOT EXISTS `hanginginside` (
  `location` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hanginginside`
--


-- --------------------------------------------------------

--
-- Table structure for table `hangingoutside`
--

CREATE TABLE IF NOT EXISTS `hangingoutside` (
  `location` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hangingoutside`
--


-- --------------------------------------------------------

--
-- Table structure for table `partialhanging`
--

CREATE TABLE IF NOT EXISTS `partialhanging` (
  `partialHangingID` int(11) NOT NULL AUTO_INCREMENT,
  `sitting` text NOT NULL,
  `kneeling` text NOT NULL,
  `halfLying` text NOT NULL,
  `FeetOnFloor` text NOT NULL,
  `other` text NOT NULL,
  PRIMARY KEY (`partialHangingID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `partialhanging`
--


-- --------------------------------------------------------

--
-- Table structure for table `scene`
--

CREATE TABLE IF NOT EXISTS `scene` (
  `sceneID` int(11) NOT NULL AUTO_INCREMENT,
  `sceneTypeID` int(11) NOT NULL,
  `sceneTime` time NOT NULL,
  `sceneDate` date NOT NULL,
  `sceneLocation` text NOT NULL,
  `sceneTemparature` text NOT NULL,
  `sceneInvestigatingOfficerName` varchar(200) NOT NULL,
  `sceneInvestigatingOfficerRank` varchar(200) NOT NULL,
  `sceneInvestigatingOfficerCellNumber` int(11) NOT NULL,
  `firstOfficerOnSceneName` varchar(200) NOT NULL,
  `firstOfficerOnSceneRank` varchar(200) NOT NULL,
  `sceneVictimGender` text NOT NULL,
  `sceneVictimRace` text NOT NULL,
  `sceneVictimID` text NOT NULL,
  `sceneVictimName` text NOT NULL,
  `sceneVictimSurname` text NOT NULL,
  PRIMARY KEY (`sceneID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scene`
--


-- --------------------------------------------------------

--
-- Table structure for table `scenetype`
--

CREATE TABLE IF NOT EXISTS `scenetype` (
  `sceneTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `sceneTypeDescription` text NOT NULL,
  PRIMARY KEY (`sceneTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scenetype`
--


-- --------------------------------------------------------

--
-- Table structure for table `scenevvictims`
--

CREATE TABLE IF NOT EXISTS `scenevvictims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sceneID` int(11) NOT NULL,
  `victimID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scenevvictims`
--


-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `studentNumber` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `cellphoneNumber` int(11) NOT NULL,
  PRIMARY KEY (`studentNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `userTypeID` int(11) NOT NULL,
  `userActive` tinyint(4) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--


-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `userTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `userTypeDescription` varchar(100) NOT NULL,
  PRIMARY KEY (`userTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `usertype`
--


-- --------------------------------------------------------

--
-- Table structure for table `victims`
--

CREATE TABLE IF NOT EXISTS `victims` (
  `victimID` int(11) NOT NULL AUTO_INCREMENT,
  `victimGender` varchar(10) NOT NULL,
  `victimRace` int(11) NOT NULL,
  `victimName` varchar(200) NOT NULL,
  `victimSurname` varchar(200) NOT NULL,
  PRIMARY KEY (`victimID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `victims`
--
-- --------------------------------------------------------

--
-- Table structure for table `electrocutionlightning`
--

CREATE TABLE IF NOT EXISTS `electrocutionlightning` (
  `electrocutionlightningPhoto` text NOT NULL,
  `electrocutionlightningBodyDecompose` varchar(5) NOT NULL,
  `electrocutionlightningMedicalInverntion` varchar(5) NOT NULL,
  `electrocutionlightningFoundBody` text NOT NULL,
  `electrocutionlightningCloseWater` varchar(5) NOT NULL,
  `electrocutionlightningBodyBurnt` varchar(5) NOT NULL,
  `electrocutionlightningIO` text NOT NULL,
  `electrocutionlightningOpenWire` varchar(5) NOT NULL,
  `electrocutionlightningSceneWet` varchar(5) NOT NULL,
  `electrocutionlightningSuicideNote` varchar(5) NOT NULL,
  `electrocutionlightningGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `electrocutionlightning`
--


-- --------------------------------------------------------

--
-- Table structure for table `electrocutionlightninginside`
--

CREATE TABLE IF NOT EXISTS `electrocutionlightninginside` (
  `electrocutionlightningInsideType` text NOT NULL,
  `electrocutionlightningDoor` varchar(5) NOT NULL,
  `electrocutionlightningWindowsClosed` varchar(5) NOT NULL,
  `electrocutionlightningWindowsBroken` varchar(5) NOT NULL,
  `electrocutionlightningVictimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `electrocutionlightninginside`
--


-- --------------------------------------------------------

--
-- Table structure for table `electrocutionlightningoutside`
--

CREATE TABLE IF NOT EXISTS `electrocutionlightningoutside` (
  `electrocutionlightningOutsideType` text NOT NULL,
  `electrocutionlightningStruggle` varchar(5) NOT NULL,
  `electrocutionlightningAlcohol` varchar(5) NOT NULL,
  `electrocutionlightningDrug` varchar(5) NOT NULL,
  `electrocutionlightningTrees` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `firearm`
--

CREATE TABLE IF NOT EXISTS `firearm` (
  `firearmPhoto` text NOT NULL,
  `firearmBodyDecompose` varchar(5) NOT NULL,
  `firearmMedicalIntervention` varchar(5) NOT NULL,
  `firearmFoundBody` text NOT NULL,
  `firearmCloseWater` varchar(5) NOT NULL,
  `firearmRapeHomicide` varchar(5) NOT NULL,
  `firearmSuspicionSuicide` varchar(5) NOT NULL,
  `firearmPreviousTempts` varchar(5) NOT NULL,
  `firearmGunshot` text NOT NULL,
  `firearmWonds` text NOT NULL,
  `firearmWondsArea` text NOT NULL,
  `firearmInScene` varchar(5) NOT NULL,
  `firearmCalibre` text NOT NULL,
  `firearmSuicideNote` varchar(5) NOT NULL,
  `firearmGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `firearm`
--


-- --------------------------------------------------------

--
-- Table structure for table `firearminside`
--

CREATE TABLE IF NOT EXISTS `firearminside` (
  `fireInsideType` text NOT NULL,
  `fireDoor` varchar(5) NOT NULL,
  `fireWindowsClosed` varchar(5) NOT NULL,
  `fireWindowsBroken` varchar(5) NOT NULL,
  `fireVictimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `firearminside`
--


-- --------------------------------------------------------

--
-- Table structure for table `firearmoutside`
--

CREATE TABLE IF NOT EXISTS `firearmoutside` (
  `firearmOutsideType` text NOT NULL,
  `firearmStruggle` varchar(5) NOT NULL,
  `firearmAlcohol` varchar(5) NOT NULL,
  `firearmDrug` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
