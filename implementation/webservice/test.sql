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
    primary key(sceneID)
); 

create table if not exists scenevVictims
(
    id int not null auto_increment,
    sceneID int not null,
    victimID int not null,
    `aviationVictimType` varchar(200) NULL,
    primary key(id)
); 

create table if not exists victims
(
    victimID int not null,
    victimGender varchar(10) not null,
    victimRace int not null,
    victimName varchar(200) not null,
    victimSurname varchar(200) not null,
    bodyDecompose varchar(10) NOT NULL,
    medicalIntervention varchar(10) NOT NULL,
    bodyBurned varchar(10) NOT NULL,
    bodyIntact varchar(10) NOT NULL,
    `victimInside` varchar(10) NOT NULL,
    `victimOutside` varchar(10) NOT NULL,
    `victimFoundCloseToWater` varchar(10) NOT NULL,
    `victimSuicideNote` varchar(10) NOT NULL,
    `victimGeneralHistory` text NOT NULL,
    `isRapeHomicide` varchar(10) NOT NULL,
    `suspicionSuicide` varchar(5) NOT NULL,
    primary key(victimID)
);

create table if not exists photos
(
    photoID int not null auto_increment,
    victimID int not null,
    photoFilename text not null,
    primary key(photoID)
);

create TABLE IF NOT EXISTS `aviationOutsideType` (
   aviationOutsideTypeID int not null auto_increnment primary key,
   aviationOutsideType varchar(200) not null
);

CREATE TABLE IF NOT EXISTS `aviation` (
   aviationID int not null auto_increnment primary key,
  `aviationOutsideType` int NOT NULL,
  `aircraftType` text NOT NULL,
  `aircraftNumPeople` text NOT NULL,
  `weatherCondition` text NOT NULL,
  `weatherType` text NOT NULL,
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aviation`
--


-- --------------------------------------------------------

--
-- Table structure for table `bicycle`
--

CREATE TABLE IF NOT EXISTS `weatherConditions` (
    weatherConditionID int not null auto_increment primary key,
    weatherConditionDescription text not null
);

CREATE TABLE IF NOT EXISTS `bicycleType` (
    bicycleTypeID int not null auto_increment primary key,
    bicycleTypeDescription text not null
);


CREATE TABLE IF NOT EXISTS `bicycle` (
   bicycleID int not null auto_increment primary key, 
  `whoFoundVictimBody` text NOT NULL,
  `bicycleNumPeople` text NOT NULL,
  `bicycleHit` text NOT NULL,
  `bicycleTypeID` int NOT NULL,
  `bicycleWeatherConditionID` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Dumping data for table `bicycle`
--


-- --------------------------------------------------------

--
-- Table structure for table `blunt`
--

CREATE TABLE IF NOT EXISTS `blunt` (
  `bluntID` int NOT NULL auto_increment primary key,
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


