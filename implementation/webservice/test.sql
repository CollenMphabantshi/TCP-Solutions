
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
create table if not exists victimType`(
	victimTypeID int not null auto_increment,
	victimTypeDiscription text not null,
	primary key(victimTypeID)
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
    `victimType` text NULL,
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


CREATE TABLE IF NOT EXISTS `ingestionoverdosepoisoning` (
  `ingestionoverdosepoisoningID` int(11) NOT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `hingestionoverdosepoisoningInsideID` int NOT NULL,
  `hingestionoverdosepoisoningOutsideID` int NOT NULL
);



CREATE TABLE IF NOT EXISTS `ingestionoverdosepoisoninginside` (
  `ingestionoverdosepoisoninginsideID` int NOT NULL AUTO_INCREMENT primary key,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null
);

CREATE TABLE IF NOT EXISTS `ingestionoverdosepoisoningoutside` (
  `ingestionOverdosePoisoningOutsideID` int NOT NULL AUTO_INCREMENT primary key,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
);

----------------------------------------------
CREATE TABLE IF NOT EXISTS `mba` (
  `mbaID` int(11) NOT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `victimWearingProtectiveClothing` varchar(5) NOT NULL,
  `mbaOutsideID` text NOT NULL,
  `victimsOnMotorcycle` text NOT NULL,
  `motorbikeHitFrom` text NOT NULL,
  `typeOfAccident` text NOT NULL
);

CREATE TABLE IF NOT EXISTS `mva` (
  `mvaID` int(11) NOT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `victimFoundInCar` varchar(5) NOT NULL,
  `mvaOutsideID` text NOT NULL,
  `occupants` text NOT NULL,
  `numberOfOccupants` int(11) NOT NULL,
  `victimWas` text NOT NULL,
  `carWasHitFrom` text NOT NULL,
  `victimType` text NOT NULL,
  `carBurnt` varchar(5) NOT NULL
);

CREATE TABLE IF NOT EXISTS `pedestrian` (
  `perdestrianID` int(11) NOT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `perdestrianOutsideID` text NOT NULL,
  `hitAndRun` varchar(5) NOT NULL,
  `numberOfCarsDroveOverBody` int(11) NOT NULL

);


CREATE TABLE IF NOT EXISTS `railway` (
  `railwayID` int(11) NOT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `sceneOfInjury` text NOT NULL,
  `victimTpye` text NOT NULL,
  `railwayType` text NOT NULL
 
);


CREATE TABLE IF NOT EXISTS `gassing` (
  `gassingID` int NOT NULL AUTO_INCREMENT primary key,
  `whoFoundVictimBody` text NOT NULL,
  `gassingInsideID` int NOT NULL,
  `gassingOutsideID` int NOT NULL,
);


CREATE TABLE IF NOT EXISTS `gassinginside` (
  `gassingInsideType` text NOT NULL,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
  `gassingAppliances` varchar(5) NOT NULL,
  `gassingAppliancesUsed` text null,
  `gassingSmell` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `gassingoutside` (
  `gassingOutsideID` int NOT NULL,
  `gassingVictimInCar` varchar(5) NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `sec48` (
  `sec48ID` int(11) NOT NULL AUTO_INCREMENT,
  `victimHospitalized` text NOT NULL,
  `medicalEquipmentInSitu` varchar(5) NOT NULL,
  `gw714file` varchar(5) NOT NULL,
  PRIMARY KEY (`sec48ID`)
);

CREATE TABLE IF NOT EXISTS `sharp` (
  `sharpID` int(11) NOT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `sharpIO` text NOT NULL,
  `sharpObjectAtScene` varchar(5) NOT NULL,
  `sharpForceInjuries` text NOT NULL,
  `theInjury` text NOT NULL
  
);

CREATE TABLE IF NOT EXISTS `sharpinside` (
  `sharpinsidelocation` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL
);

CREATE TABLE IF NOT EXISTS `sharpoutside` (
  `sharpoutsidelocation` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `sid` (
  `sidID` int(11) NOT NULL AUTO_INCREMENT,
  `resuscitationAttemped` varchar(5) NOT NULL,
  `infantSickLately` varchar(5) NOT NULL,
  `infantSickLatelyDescription` text NOT NULL,
  `infantOnMedication` varchar(5) NOT NULL,
  `fallsOrInjuryExperience` varchar(5) NOT NULL,
  `infantWearing` varchar(5) NOT NULL,
  `infantTightlyWrapped` varchar(5) NOT NULL,
  `beddingOverInfant` text NOT NULL,
  `sidIO` text NOT NULL,
  `whoFoundVictimBody`varchar(5) NOT NULL,
  `dateAndTimeLastPlaced` varchar(5) NOT NULL,
  `dateAndTimeDeathDiscovered` varchar(5) NOT NULL,
  `dateAndTimeLastSeenAlive` varchar(5) NOT NULL,
  `anySIDSdeeaths` varchar(5) NOT NULL,
  `photoAfterBodyRemoved` text NOT NULL,
  PRIMARY KEY (`sidID`)
);


CREATE TABLE IF NOT EXISTS `sidinside` (
  `sidinsidelocation` text NOT NULL,
  `infantLastPlaced` text NOT NULL,
  `infantLastSeenAlive` text NOT NULL,
  `whereInfantFoundDead` varchar(5) NOT NULL,
  `sidAppliances` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `student` (
  `studentNumber` varchar(100) NOT NULL,
  `userID` int(11) NOT NULL,
  `cellphoneNumber` int(11) NOT NULL,
  PRIMARY KEY (`studentNumber`)
);


CREATE TABLE IF NOT EXISTS `suda` (
  `sudaID` int(11) NOT NULL AUTO_INCREMENT,
  `whoFoundVictimBody` text NOT NULL,
  `sudaIO` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `suspicionSmothering` varchar(5) NOT NULL,
  `suspicionChocking` varchar(5) NOT NULL,
  PRIMARY KEY (`sudaID`)
);

CREATE TABLE IF NOT EXISTS `sudainside` (
  `sudainsidelocation` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
  `sudaAppliances` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `sudaoutside` (
  `sudaoutsidelocation` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
);


CREATE TABLE IF NOT EXISTS `sudc` (
  `sudcID` int(11) DEFAULT NULL,
  `whoFoundVictimBody` text NOT NULL,
  `closeWater` varchar(5) NOT NULL,
  `sudcIO` text NOT NULL,
  `suspicionStrangulation` varchar(5) NOT NULL,
  `suspicionSmothering` varchar(5) NOT NULL,
  `suspicionChocking` varchar(5) NOT NULL
  
);


CREATE TABLE IF NOT EXISTS `sudcinside` (
  `sudcinsidelocation` text NOT NULL,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
  `sudcAppliances` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL
);

CREATE TABLE IF NOT EXISTS `sudcoutside` (
  `sudcoutsidelocation` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL
);

