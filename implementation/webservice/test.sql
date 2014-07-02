
drop database if exists mobileForensics;
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
 userName varchar(200) not null,
 userPassword varchar(200) not null,
`userFirstname` varchar(200) NOT NULL,
`userSurname` varchar(200) NOT NULL,
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
    victimGender varchar(5) not null,
    victimRace int not null,
    victimName varchar(200) not null,
    victimSurname varchar(200) not null,
    bodyDecompose varchar(5) NOT NULL,
    medicalIntervention varchar(5) NOT NULL,
    bodyBurned varchar(5) NOT NULL,
    bodyIntact varchar(5) NOT NULL,
    `victimInside` varchar(5) NOT NULL,
    `victimOutside` varchar(5) NOT NULL,
    `victimFoundCloseToWater` varchar(5) NOT NULL,
    `victimSuicideNoteFound` varchar(5) NOT NULL,
    `victimGeneralHistory` text NOT NULL,
    `rapeHomicideSuspected` varchar(5) NOT NULL,
    `suicideSuspected` varchar(5) NOT NULL,
    previousAttempts varchar(5) NOT NULL,
    numberOfPreviousAttempts int not null,
    primary key(victimID)
);

create table if not exists photos
(
    photoID int not null auto_increment,
    victimID int not null,
    photoFilename text not null,
    primary key(photoID)
);

create TABLE IF NOT EXISTS aviationOutsideType (
   aviationOutsideTypeID int not null auto_increment primary key,
   aviationOutsideTypeDescription text not null
);



CREATE TABLE IF NOT EXISTS aviation (
   aviationID int not null auto_increment primary key,
  `aviationOutsideType` int NOT NULL,
  `aircraftType` text NOT NULL,
  `aircraftNumPeople` text NOT NULL,
  `weatherCondition` text NOT NULL,
  `weatherType` text NOT NULL
) ;


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
) ;


CREATE TABLE IF NOT EXISTS `blunt` (
  `bluntID` int NOT NULL auto_increment primary key,
  `bluntInsideID` int NOT NULL,
  `bluntOutsideID` int NOT NULL,
  `bluntForceObjectSuspected` text NOT NULL,
  `bluntForceObjectStillOnScene` varchar(5) NOT NULL
) ;

CREATE TABLE IF NOT EXISTS `outsideScenes` (
  `outsideSceneID` int NOT NULL auto_increment primary key,
   outsideSceneDescription text not null
);
CREATE TABLE IF NOT EXISTS `outsideScenes` (
  `outsideSceneID` int NOT NULL auto_increment primary key,
   outsideSceneDescription text not null
);

CREATE TABLE IF NOT EXISTS `bluntInside` (
  `bluntInsideID` int NOT NULL auto_increment primary key,
  `insideSceneID` int NOT NULL,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
);


CREATE TABLE IF NOT EXISTS `bluntOutside` (
  `bluntOutsideID` int NOT NULL auto_increment primary key,
  `outsideSceneID` int NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `wasCommunityAssult` varchar(5) NOT NULL,
  `strangulationSuspected` varchar(5) NOT NULL,
  `smotheringSuspected` varchar(5) NOT NULL,
  `chockingSuspected` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `burn` (
  `burnID` int NOT NULL auto_increment primary key,
  `whoFoundVictimBody` text NOT NULL,
  `burnInsideID` int NOT NULL,
  `burnOutsideID` int NOT NULL
) ;


CREATE TABLE IF NOT EXISTS `burninside` (
  burnInsideID int NOT NULL auto_increment primary key,
  `insideSceneID` int NOT NULL,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
) ;


CREATE TABLE IF NOT EXISTS `burnoutside` (
  `burnOutsideID` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `accelerantsAtScene` varchar(5) NOT NULL,
   accelerantsUsed text null,
  `igniterAtScene` varchar(5) NOT NULL,
   igniterUsed text null,
   foulPlaySuspected varchar(5) not null
) ;


CREATE TABLE IF NOT EXISTS `hanging` (
  `hangingID` int NOT NULL AUTO_INCREMENT,
  `whoFoundVictim` text NOT NULL,
  `hangingInsideID` int NOT NULL,
  `hangingOutsideID` int NOT NULL,
  PRIMARY KEY (`hangingID`)
)  AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `hanginginside` (
  hangingInsideID int NOT NULL AUTO_INCREMENT primary key,
  `insideSceneID` int NOT NULL,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
) ;

CREATE TABLE IF NOT EXISTS partialHanging (
  partialHangingID int NOT NULL AUTO_INCREMENT primary key,
  partialHangingDescription text not null
);

CREATE TABLE IF NOT EXISTS ligatureType (
  ligatureTypeID int NOT NULL AUTO_INCREMENT primary key,
  ligatureTypeDescription text not null
);

CREATE TABLE IF NOT EXISTS `hangingoutside` (
  `hangingOutsideID` int NOT NULL AUTO_INCREMENT primary key,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `autoeroticAsphyxia` varchar(5) NOT NULL,
  `partialHangingID` int NOT NULL,
  `completeHanging` text NOT NULL,
  `ligatureAroundNeck` varchar(5) NOT NULL,
  whoRemovedLigature text null,
  `ligatureType` int NOT NULL,
  `strangulationSuspected` varchar(5) NOT NULL,
  `smotheringSuspected` varchar(5) NOT NULL,
  `chockingSuspected` varchar(5) NOT NULL
) ;


CREATE TABLE IF NOT EXISTS `electrocutionLightning` (
  `electrocutionLightningID` int NOT NULL AUTO_INCREMENT primary key,
  `whoFoundVictimBody` text NOT NULL,
  `electrocutionLightningInsideID` int NOT NULL,
  `electrocutionLightningOutsideID` int NOT NULL
) ;


CREATE TABLE IF NOT EXISTS `electrocutionlightninginside` (
  `electrocutionLightningInsideID` int NOT NULL AUTO_INCREMENT primary key,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
) ;


CREATE TABLE IF NOT EXISTS `electrocutionlightningoutside` (
  `electrocutionLightningOutsideID` int NOT NULL AUTO_INCREMENT primary key,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `anyOpenWire` varchar(5) NOT NULL,
  `sceneWet` varchar(5) NOT NULL,
  `deBarkingOfTrees` varchar(5) NOT NULL
) ;


CREATE TABLE IF NOT EXISTS `firearm` (
  `firearmID` int NOT NULL AUTO_INCREMENT primary key,
  `whoFoundVictimBody` text NOT NULL,
  `firearmInsideID` int NOT NULL,
  `firearmOutsideID` int NOT NULL
) ;


CREATE TABLE IF NOT EXISTS `firearmInside` (
  `firearmInsideID` int NOT NULL AUTO_INCREMENT primary key,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
) ;


CREATE TABLE IF NOT EXISTS `firearmOutside` (
  `firearmOutsideID` int NOT NULL AUTO_INCREMENT primary key,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `gunshotWounds` text NOT NULL,
  `gunshotWoundsLocation` text NOT NULL,
  `gunshotWoundsArea` text NOT NULL,
  `firearmOnScene` varchar(5) NOT NULL,
  `firearmCalibre` text NOT NULL
) ;


CREATE TABLE IF NOT EXISTS `foetusabandonedbaby` (
  `foetusabandonedbabyID` int NOT NULL AUTO_INCREMENT primary key,    
  `whoFoundVictimBody` text NOT NULL,
  `babyInside` text NOT NULL,
  `babyOutside` text NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `height`
--

CREATE TABLE IF NOT EXISTS `height` (
  `heightBodyDecompose` varchar(5) NOT NULL,
  `heightMedicalIntervention` varchar(5) NOT NULL,
  `heightFoundBody` text NOT NULL,
  `heightCloseWater` varchar(5) NOT NULL,
  `heightRapeHomicide` varchar(5) NOT NULL,
  `heightSuspicion` varchar(5) NOT NULL,
  `heightPreviousTempts` varchar(5) NOT NULL,
  `fromWhat` text NOT NULL,
  `heightHigh` text NOT NULL,
  `heightLand` int(11) NOT NULL,
  `heightSuicideNote` int(11) NOT NULL,
  `heightGeneralHistory` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `height`
--


-- --------------------------------------------------------

--
-- Table structure for table `heightinside`
--

CREATE TABLE IF NOT EXISTS `heightinside` (
  `heightInsideType` text NOT NULL,
  `heightDoor` varchar(5) NOT NULL,
  `heightWindowsClosed` varchar(5) NOT NULL,
  `heightWindowsBroken` varchar(5) NOT NULL,
  `heightVictimAlone` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `heightinside`
--


-- --------------------------------------------------------

--
-- Table structure for table `heightoutside`
--

CREATE TABLE IF NOT EXISTS `heightoutside` (
  `heightOutsideType` text NOT NULL,
  `heightStuggle` varchar(5) NOT NULL,
  `heightAlcohol` varchar(5) NOT NULL,
  `heightDrug` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gassing`
--

CREATE TABLE IF NOT EXISTS `gassing` (
  `gaasingBodyDecomposed` varchar(5) NOT NULL,
  `gassingMedicalIntervention` varchar(5) NOT NULL,
  `gassingFoundBody` text NOT NULL,
  `gassingSuspicionSuicide` varchar(5) NOT NULL,
  `gassingPreviousTempts` varchar(5) NOT NULL,
  `gassingIO` text NOT NULL,
  `gassingSuicideNote` varchar(5) NOT NULL,
  `gassingGeneralHistory` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gassing`
--


-- --------------------------------------------------------

--
-- Table structure for table `gassinginside`
--

CREATE TABLE IF NOT EXISTS `gassinginside` (
  `gassingInsideType` text NOT NULL,
  `gassingDoor` varchar(5) NOT NULL,
  `gassingWindowsClosed` varchar(5) NOT NULL,
  `gassingWindowsBroken` varchar(5) NOT NULL,
  `gassingVictimAlone` varchar(5) NOT NULL,
  `gassingAppliances` varchar(5) NOT NULL,
  `gassingAppliancesUsed` text,
  `gassingSmell` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gassinginside`
--


-- --------------------------------------------------------

--
-- Table structure for table `gassingoutside`
--

CREATE TABLE IF NOT EXISTS `gassingoutside` (
  `gassingOutsideType` text NOT NULL,
  `gassingVicyimInCar` varchar(5) NOT NULL,
  `gassingStruggle` varchar(5) NOT NULL,
  `gassingAlcohol` varchar(5) NOT NULL,
  `gassingDrug` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


