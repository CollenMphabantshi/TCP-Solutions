create database if not exists mobileForensics;
use mobileForensics;


create table if not exists userType
(
    userTypeID int not null auto_increment,
    userTypeDescription varchar(100) not null
);

CREATE TABLE IF NOT EXISTS `users`
(
`userId` int NOT NULL AUTO_INCREMENT,
`firstname` varchar(200) NOT NULL,
`surname` varchar(200) NOT NULL,
`userTypeID` int NOT NULL,
userActive tinyint not null,
PRIMARY KEY (`user_id`)
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
    sceneVictimsID int not null auto_increment,
    sceneID int not null,
    victimID int not null
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

