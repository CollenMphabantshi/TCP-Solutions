create database if not exists mobileForensics;
use mobileForensics;


create table if not exists userType
(
    userTypeID int not null auto_increment,
    userTypeDescription varchar(100) not null,
    primary key(userTypeID)
);

CREATE TABLE IF NOT EXISTS `users`
(
`userID` int NOT NULL AUTO_INCREMENT,
`firstname` varchar(200) NOT NULL,
`surname` varchar(200) NOT NULL,
`userTypeID` int NOT NULL,
userActive tinyint not null,
PRIMARY KEY (`userID`)
);

create table if not exists forensicOfficer
(
    personelNumber varchar(100) not null,
    userID int not null,
    cellphoneNumber int not null,
    primary key(personelNumber)
);

create table if not exists forensicPractitioner
(
    personelNumber varchar(100) not null,
    userID int not null,
    cellphoneNumber int not null,
    primary key(personelNumber)
);

create table if not exists student
(
    studentNumber varchar(100) not null,
    userID int not null,
    cellphoneNumber int not null,
    primary key(studentNumber)
);

create table if not exists administrator
(
    personelNumber varchar(100) not null,
    userID int not null,
    primary key(personelNumber)
);

create table if not exists cases
(
    caseNumber int not null auto_increment,
    sceneID int not null,
    FOPersonelNumber int not null,
    primary key(caseNumber)
);

create table if not exists deathRegister
(
    deathRegisterNumber int not null auto_increment,
    caseNumber int not null,
    primary key(deathRegisterNumber)
);

create table if not exists sceneType
(
    sceneTypeID int not null auto_increment,
    sceneTypeDescription text not null,
    primary key(sceneTypeID)
);
create table if not exists scene
(
    sceneID int not null auto_increment,
    sceneTypeID int not null,
    sceneTime time not null,
    sceneDate date not null,
    sceneLocation text not null,
    sceneTemparature text not null,
    sceneInvestigatingOfficerName varchar(200) not null,
    sceneInvestigatingOfficerRank varchar(200) not null,
    sceneInvestigatingOfficerCellNumber int not null,
    firstOfficerOnSceneName varchar(200) not null,
    firstOfficerOnSceneRank varchar(200) not null,
    sceneVictimGender text not null,
    sceneVictimRace text not null,
    sceneVictimID text not null,
    sceneVictimName text not null,
    sceneVictimSurname text not null,
    primary key(sceneID)
); 

create table if not exists scenevVictims
(
    id int not null auto_increment,
    sceneID int not null,
    victimID int not null,
    primary key(id)
); 

create table if not exists victims
(
    victimID int not null auto_increment,
    victimGender varchar(10) not null,
    victimRace int not null,
    victimName varchar(200) not null,
    victimSurname varchar(200) not null,
    primary key(victimID)
);

/*insert into users values(0,'aaa','aa@aa.com','open',0);*/


select * from users;

-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2014 at 01:12 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `Scenes`
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
-- Table structure for table `crushinjury`
--

CREATE TABLE IF NOT EXISTS `crushinjury` (
  `crushPhoto` text NOT NULL,
  `crushBodyDecompose` varchar(5) NOT NULL,
  `crushMedicalIntervention` varchar(5) NOT NULL,
  `crushBodyFound` text NOT NULL,
  `crushCloseWater` varchar(5) NOT NULL,
  `crushRapeHomicide` varchar(5) NOT NULL,
  `crushIO` varchar(5) NOT NULL,
  `crushGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crushinjury`
--


-- --------------------------------------------------------

--
-- Table structure for table `crushinjuryinside`
--

CREATE TABLE IF NOT EXISTS `crushinjuryinside` (
  `crushInsideType` text NOT NULL,
  `crushDoor` varchar(5) NOT NULL,
  `crushWindowsClosed` varchar(5) NOT NULL,
  `crushWindowsBroken` varchar(5) NOT NULL,
  `crushVictimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crushinjuryinside`
--


-- --------------------------------------------------------

--
-- Table structure for table `crushinjuryoutside`
--

CREATE TABLE IF NOT EXISTS `crushinjuryoutside` (
  `crushOutsideType` text NOT NULL,
  `crushStruggle` varchar(5) NOT NULL,
  `crushAlcohol` varchar(5) NOT NULL,
  `crushDrug` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crushinjuryoutside`
--


-- --------------------------------------------------------

--
-- Table structure for table `drowning`
--

CREATE TABLE IF NOT EXISTS `drowning` (
  `drowningBody` text NOT NULL,
  `drowningBodyDecompose` varchar(5) NOT NULL,
  `drowningMedicalIntervention` varchar(5) NOT NULL,
  `drowningFoundBody` text NOT NULL,
  `drowningIO` text NOT NULL,
  `drowningType` text NOT NULL,
  `drowningWaterType` text NOT NULL,
  `drowningSuspicionStrangulation` varchar(5) NOT NULL,
  `drowningSuspicionSmothering` varchar(5) NOT NULL,
  `drowningSuspicionChocking` varchar(5) NOT NULL,
  `drowningSuicideNote` varchar(5) NOT NULL,
  `drowningGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drowning`
--


-- --------------------------------------------------------

--
-- Table structure for table `drowninginside`
--

CREATE TABLE IF NOT EXISTS `drowninginside` (
  `drowningInsideType` text NOT NULL,
  `drowningDoor` varchar(5) NOT NULL,
  `drowningWindowsClosed` varchar(5) NOT NULL,
  `drowningWindowsBroken` varchar(5) NOT NULL,
  `drowningVictimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drowninginside`
--


-- --------------------------------------------------------

--
-- Table structure for table `drowningoutside`
--

CREATE TABLE IF NOT EXISTS `drowningoutside` (
  `drowningOutsideType` text NOT NULL,
  `drowningStruggle` varchar(5) NOT NULL,
  `drowningAlcohol` varchar(5) NOT NULL,
  `drowningDrug` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drowningoutside`
--



