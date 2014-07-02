-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2014 at 01:03 PM
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
-- Table structure for table `ingestionoverdosepoisoning`
--

CREATE TABLE IF NOT EXISTS `ingestionoverdosepoisoning` (
  `ingestionoverdosepoisoningID` int(11) NOT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `closeWater` varchar(5) NOT NULL,
  `suspicionSuicide` varchar(5) NOT NULL,
  `previousAttepts` varchar(5) NOT NULL,
  `hingestionoverdosepoisoningIO` text NOT NULL,
  `suspectedSubstance` text NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingestionoverdosepoisoning`
--


-- --------------------------------------------------------

--
-- Table structure for table `ingestionoverdosepoisoninginside`
--

CREATE TABLE IF NOT EXISTS `ingestionoverdosepoisoninginside` (
  `location` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingestionoverdosepoisoninginside`
--


-- --------------------------------------------------------

--
-- Table structure for table `ingestionoverdosepoisoningoutside`
--

CREATE TABLE IF NOT EXISTS `ingestionoverdosepoisoningoutside` (
  `location` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ingestionoverdosepoisoningoutside`
--


-- --------------------------------------------------------

--
-- Table structure for table `mba`
--

CREATE TABLE IF NOT EXISTS `mba` (
  `mbaID` int(11) NOT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `bodyBurnt` varchar(5) NOT NULL,
  `bodyIntact` varchar(5) NOT NULL,
  `victimWearingProtectiveClothing` varchar(5) NOT NULL,
  `mbaOutside` text NOT NULL,
  `victimsOnMotorcycle` text NOT NULL,
  `motorbikeHitFrom` text NOT NULL,
  `typeOfAccident` text NOT NULL,
  `weatherCondition` text NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mba`
--


-- --------------------------------------------------------

--
-- Table structure for table `mva`
--

CREATE TABLE IF NOT EXISTS `mva` (
  `mvaID` int(11) NOT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `bodyBurnt` varchar(5) NOT NULL,
  `bodyIntact` varchar(5) NOT NULL,
  `victimFoundInCar` varchar(5) NOT NULL,
  `mvaOutside` text NOT NULL,
  `occupants` text NOT NULL,
  `numberOfOccupants` int(11) NOT NULL,
  `victimWas` text NOT NULL,
  `carWasHitFrom` text NOT NULL,
  `wasIt` text NOT NULL,
  `carBurnt` varchar(5) NOT NULL,
  `alcoholBottlesInCars` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `weatherCondition` text NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mva`
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
-- Table structure for table `pedestrian`
--

CREATE TABLE IF NOT EXISTS `pedestrian` (
  `perdestrianID` int(11) NOT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `perdestrianOutside` text NOT NULL,
  `hitAndRun` varchar(5) NOT NULL,
  `outsideWas` text NOT NULL,
  `wasIt` text NOT NULL,
  `numberOfCarsDroveOverBody` int(11) NOT NULL,
  `weatherCondition` text NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pedestrian`
--


-- --------------------------------------------------------

--
-- Table structure for table `railway`
--

CREATE TABLE IF NOT EXISTS `railway` (
  `railwayID` int(11) NOT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `bodyBurnt` varchar(5) NOT NULL,
  `bodyIntact` varchar(5) NOT NULL,
  `sceneOfInjury` text NOT NULL,
  `victimWas` text NOT NULL,
  `wasIt` text NOT NULL,
  `alocoholBottlesIfPedestrian` varchar(5) NOT NULL,
  `drugParaphernaliaIfPedestian` varchar(5) NOT NULL,
  `weatherCondition` text NOT NULL,
  `suicedNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `railway`
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
-- Table structure for table `sec48`
--

CREATE TABLE IF NOT EXISTS `sec48` (
  `sec48ID` int(11) NOT NULL AUTO_INCREMENT,
  `photo` text NOT NULL,
  `victimHospitalized` text NOT NULL,
  `medicalEquipmentInSitu` varchar(5) NOT NULL,
  `gw7/14file` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL,
  PRIMARY KEY (`sec48ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sec48`
--


-- --------------------------------------------------------

--
-- Table structure for table `sharp`
--

CREATE TABLE IF NOT EXISTS `sharp` (
  `sharpID` int(11) NOT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `closeWater` varchar(5) NOT NULL,
  `rapeHomicideSuspected` varchar(5) NOT NULL,
  `suspicionOfSuicide` varchar(5) NOT NULL,
  `previousTempts` varchar(5) NOT NULL,
  `sharpIO` text NOT NULL,
  `sharpObjectAtScene` varchar(5) NOT NULL,
  `sharpForceInjuries` text NOT NULL,
  `theInjury` text NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sharp`
--


-- --------------------------------------------------------

--
-- Table structure for table `sharpinside`
--

CREATE TABLE IF NOT EXISTS `sharpinside` (
  `location` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sharpinside`
--


-- --------------------------------------------------------

--
-- Table structure for table `sharpoutside`
--

CREATE TABLE IF NOT EXISTS `sharpoutside` (
  `location` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sharpoutside`
--


-- --------------------------------------------------------

--
-- Table structure for table `sid`
--

CREATE TABLE IF NOT EXISTS `sid` (
  `sidID` int(11) NOT NULL AUTO_INCREMENT,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `resuscitationAttemped` varchar(5) NOT NULL,
  `infantSickLately` varchar(5) NOT NULL,
  `wasIt` text NOT NULL,
  `infantOnMedication` varchar(5) NOT NULL,
  `fallsOrInjuryExperience` varchar(5) NOT NULL,
  `infantWearing` varchar(5) NOT NULL,
  `infantTightlyWrapped` varchar(5) NOT NULL,
  `beddingOverInfant` text NOT NULL,
  `sidIO` text NOT NULL,
  `bodyFound` varchar(5) NOT NULL,
  `dateAndTimeLastPlaced` varchar(5) NOT NULL,
  `dateAndTimeDeathDiscovered` varchar(5) NOT NULL,
  `dateAndTimeLastSeenAlive` varchar(5) NOT NULL,
  `anySIDSdeeaths` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL,
  `photoAfterBodyRemoved` text NOT NULL,
  PRIMARY KEY (`sidID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sid`
--


-- --------------------------------------------------------

--
-- Table structure for table `sidinside`
--

CREATE TABLE IF NOT EXISTS `sidinside` (
  `location` text NOT NULL,
  `infantLastPlaced` text NOT NULL,
  `infantLastSeenAlive` text NOT NULL,
  `whereInfantFoundDead` varchar(5) NOT NULL,
  `Heater/OpenFire/gasHeater/galleyBlik` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sidinside`
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
-- Table structure for table `suda`
--

CREATE TABLE IF NOT EXISTS `suda` (
  `sudaID` int(11) NOT NULL AUTO_INCREMENT,
  `photo` int(11) NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `closeWater` varchar(5) NOT NULL,
  `sudaIO` text NOT NULL,
  `suspicionStrangulation` varchar(5) NOT NULL,
  `suspicionSmothering` varchar(5) NOT NULL,
  `suspicionChocking` varchar(5) NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL,
  PRIMARY KEY (`sudaID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `suda`
--


-- --------------------------------------------------------

--
-- Table structure for table `sudainside`
--

CREATE TABLE IF NOT EXISTS `sudainside` (
  `location` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
  `Heater/OpenFire/gasHeater/galleyBlik` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sudainside`
--


-- --------------------------------------------------------

--
-- Table structure for table `sudaoutside`
--

CREATE TABLE IF NOT EXISTS `sudaoutside` (
  `location` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sudaoutside`
--


-- --------------------------------------------------------

--
-- Table structure for table `sudc`
--

CREATE TABLE IF NOT EXISTS `sudc` (
  `sudcID` int(11) DEFAULT NULL,
  `photo` text NOT NULL,
  `bodyDecomposed` varchar(5) NOT NULL,
  `medicalInterverntion` varchar(5) NOT NULL,
  `bodyFound` text NOT NULL,
  `closeWater` varchar(5) NOT NULL,
  `sudcIO` text NOT NULL,
  `suspicionStrangulation` varchar(5) NOT NULL,
  `suspicionSmothering` varchar(5) NOT NULL,
  `suspicionChocking` varchar(5) NOT NULL,
  `suicideNote` varchar(5) NOT NULL,
  `generalHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sudc`
--


-- --------------------------------------------------------

--
-- Table structure for table `sudcinside`
--

CREATE TABLE IF NOT EXISTS `sudcinside` (
  `location` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
  `Heater/OpenFire/gasHeater/galleyBlik` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sudcinside`
--


-- --------------------------------------------------------

--
-- Table structure for table `sudcoutside`
--

CREATE TABLE IF NOT EXISTS `sudcoutside` (
  `location` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sudcoutside`
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


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
