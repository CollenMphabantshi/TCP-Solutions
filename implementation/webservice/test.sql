
drop database if exists mobileForensics;
create database if not exists mobileForensics;
use mobileForensics;


create table if not exists userType
(
    userTypeID int not null auto_increment,
    userTypeDescription varchar(100) not null,
    primary key(userTypeID)
);

CREATE TABLE IF NOT EXISTS users
(
`userID` int NOT NULL AUTO_INCREMENT,
 userName varchar(200) not null,
 userPassword varchar(200) not null,
`userFirstname` varchar(200) NOT NULL,
`userSurname` varchar(200) NOT NULL,
`userTypeID` int NOT NULL,
userActive tinyint not null,
FOREIGN KEY (userTypeID) REFERENCES userType(userTypeID),
PRIMARY KEY (`userID`)
);

create table if not exists forensicOfficer
(
    personelNumber varchar(100) not null,
    userID int not null,
    cellphoneNumber varchar(15) not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(personelNumber)
);

create table if not exists forensicPractitioner
(
    personelNumber varchar(100) not null,
    userID int not null,
    cellphoneNumber varchar(15) not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(personelNumber)
);

create table if not exists student
(
    studentNumber varchar(100) not null,
    userID int not null,
    cellphoneNumber varchar(15) not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(studentNumber)
);

create table if not exists administrator
(
    personelNumber varchar(100) not null,
    userID int not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(personelNumber)
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
    sceneInvestigatingOfficerCellNumber varchar(15) not null,
    firstOfficerOnSceneName varchar(200) not null,
    firstOfficerOnSceneRank varchar(200) not null,
    FOREIGN KEY (sceneTypeID) REFERENCES sceneType(sceneTypeID),
    primary key(sceneID)
); 


create table if not exists cases
(
    caseNumber int not null auto_increment,
    sceneID int not null,
    FOPersonelNumber varchar(200) not null,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
    FOREIGN KEY (FOPersonelNumber) REFERENCES forensicOfficer(personelNumber),
    primary key(caseNumber)
);


create table if not exists deathRegister
(
    deathRegisterNumber int not null auto_increment,
    caseNumber int not null,
    FOREIGN KEY (caseNumber) REFERENCES cases(caseNumber),
    primary key(deathRegisterNumber)
);


create table if not exists victimType(
	victimTypeID int not null auto_increment,
	victimTypeDiscription text not null,
	primary key(victimTypeID)
);

create table if not exists victims
(
    victimID int not null auto_increment,
    victimIdentityNumber varchar(200) not null,
    victimGender varchar(10) not null,
    victimRace varchar(200) not null,
    victimName varchar(200) not null,
    victimSurname varchar(200) not null,
    `whoFoundVictimBody` text NOT NULL,
    bodyDecompose varchar(5) NOT NULL,
    medicalIntervention varchar(5) NOT NULL,
    bodyBurned varchar(5) NULL,
    bodyIntact varchar(5) NULL,
    `victimInside` varchar(5) NOT NULL,
    `victimOutside` varchar(5) NOT NULL,
    `victimFoundCloseToWater` varchar(5) NOT NULL,
    `victimSuicideNoteFound` varchar(5) NOT NULL,
    `victimGeneralHistory` text NOT NULL,
    `rapeHomicideSuspected` varchar(5) NOT NULL,
    `suicideSuspected` varchar(5) NOT NULL,
    previousAttempts varchar(5) NOT NULL,
    numberOfPreviousAttempts int not null,
    primary key(victimID,victimIdentityNumber)
);

create table if not exists sceneVictims
(
    id int not null auto_increment,
    sceneID int not null,
    victimID int not null,
    `victimType` text NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
    FOREIGN KEY (victimID) REFERENCES victims(victimID),
    primary key(id)
); 



create table if not exists victimScenePhotos
(
    photoID int not null auto_increment,
    victimID int not null,
    photoFilename text not null,
    FOREIGN KEY (victimID) REFERENCES victims(victimID),
    primary key(photoID)
);

create table if not exists scenePhotos
(
    photoID int not null auto_increment,
    sceneID int not null,
    photoFilename text not null,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
    primary key(photoID)
);

CREATE TABLE IF NOT EXISTS `insideScenes` (
  `insideSceneID` int NOT NULL auto_increment primary key,
   insideSceneDescription text not null
);

CREATE TABLE IF NOT EXISTS `outsideScenes` (
  `outsideSceneID` int NOT NULL auto_increment primary key,
   outsideSceneDescription text not null
);

create TABLE IF NOT EXISTS aviationOutsideType (
   aviationOutsideTypeID int not null auto_increment primary key,
   aviationOutsideTypeDescription text not null
);


CREATE TABLE IF NOT EXISTS `weatherConditions` (
    weatherConditionID int not null auto_increment primary key,
    weatherConditionDescription text not null
);

CREATE TABLE IF NOT EXISTS aviation (
   aviationID int not null auto_increment primary key,
   sceneID int not null,
  `aviationOutsideType` text NOT NULL,
  `aircraftType` text NOT NULL,
  `aircraftNumPeople` text NOT NULL,
  `weatherCondition` text NOT NULL,
  `weatherType` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
) ;


CREATE TABLE IF NOT EXISTS `bicycleType` (
    bicycleTypeID int not null auto_increment primary key,
    bicycleTypeDescription text not null
);

CREATE TABLE IF NOT EXISTS `bicycle`(
   bicycleID int not null, 
   sceneID int not null,
  `bicycleNumPeople` text NOT NULL,
  `bicycleHit` text NOT NULL,
  `bicycleType` text NOT NULL,
  `weatherCondition` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `blunt` (
  `bluntID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `bluntIOType` text NOT NULL,
  `bluntForceObjectSuspected` text NOT NULL,
  `bluntForceObjectStillOnScene` varchar(5) NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `wasCommunityAssult` varchar(5) NOT NULL,
  `strangulationSuspected` varchar(5) NOT NULL,
  `smotheringSuspected` varchar(5) NOT NULL,
  `chockingSuspected` varchar(5) NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `bluntInside` (
  insideID int not null auto_increment primary key,
  `bluntID` int NOT NULL,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (bluntID) REFERENCES blunt(bluntID)
);


CREATE TABLE IF NOT EXISTS `burn` (
  `burnID` int NOT NULL auto_increment primary key,
   sceneID int not null,
   burnIOType text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `accelerantsAtScene` varchar(5) NOT NULL,
   accelerantsUsed text null,
  `igniterAtScene` varchar(5) NOT NULL,
   igniterUsed text null,
   foulPlaySuspected varchar(5) not null,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `burninside` (
  insideID int not null auto_increment primary key,
  burnID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (burnID) REFERENCES burn(burnID)
);

CREATE TABLE IF NOT EXISTS `crushinjury` (
  `crushinjuryID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `crushIO` varchar(5) NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `crushinjuryinside` (
  insideID int not null auto_increment primary key,
  crushinjuryID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (crushinjuryID) REFERENCES crushinjury(crushinjuryID)
);

CREATE TABLE IF NOT EXISTS `drowning` (
  `drowningID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `drowningIO` text NOT NULL,
  `drowningType` text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `drowninginside` (
  insideID int not null auto_increment primary key,
  drowningID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (drowningID) REFERENCES drowning(drowningID)
);

CREATE TABLE IF NOT EXISTS `electrocutionLightning` (
  `electrocutionLightningID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
  `electrocutionLightningIOType` text NOT NULL,
  
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `anyOpenWire` varchar(5) NOT NULL,
  `sceneWet` varchar(5) NOT NULL,
  `deBarkingOfTrees` varchar(5) NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `electrocutionlightninginside` (
   insideID int not null auto_increment primary key,
   electrocutionLightningID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
    FOREIGN KEY (electrocutionLightningID) REFERENCES electrocutionLightning(electrocutionLightningID)
);



CREATE TABLE IF NOT EXISTS `firearm` (
  `firearmID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
   `firearmIOType` int NOT NULL,
  
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `gunshotWounds` text NOT NULL,
  `gunshotWoundsLocation` text NOT NULL,
  `gunshotWoundsArea` text NOT NULL,
  `firearmOnScene` varchar(5) NOT NULL,
  `firearmCalibre` text NOT NULL,
  FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
) ;


CREATE TABLE IF NOT EXISTS `firearmInside` (
  insideID int not null auto_increment primary key,
   firearmID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (firearmID) REFERENCES firearm(firearmID)
) ;



CREATE TABLE IF NOT EXISTS `foetusabandonedbaby` (
  `foetusabandonedbabyID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
  `babyIO` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
) ;


CREATE TABLE IF NOT EXISTS `gassing` (
  `gassingID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
   `gassingIOType` text NOT NULL,
  
   `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `gassinginside` (
   insideID int not null auto_increment primary key,
   gassingID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
  `gassingAppliances` varchar(5) NOT NULL,
  `gassingAppliancesUsed` text null,
  `gassingSmell` varchar(5) NOT NULL,
      FOREIGN KEY (gassingID) REFERENCES gassing(gassingID)
);


CREATE TABLE IF NOT EXISTS `gassingoutside` (
  outsideID int not null auto_increment primary key,
   gassingID int not null,
  `gassingVictimInCar` varchar(5) NOT NULL,
   victimInCarDescription text null,
      FOREIGN KEY (gassingID) REFERENCES gassing(gassingID)
);

CREATE TABLE IF NOT EXISTS partialHanging (
  partialHangingID int NOT NULL AUTO_INCREMENT primary key,
  partialHangingDescription text not null
);

CREATE TABLE IF NOT EXISTS ligatureType (
  ligatureTypeID int NOT NULL AUTO_INCREMENT primary key,
  ligatureTypeDescription text not null
);

CREATE TABLE IF NOT EXISTS `hanging` (
  `hangingID` int NOT NULL AUTO_INCREMENT,
   sceneID int not null,
   hangingIOType text NOT NULL,
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `autoeroticAsphyxia` varchar(5) NOT NULL,
  `partialHangingType` text NOT NULL,
  `completeHanging` text NOT NULL,
  `ligatureAroundNeck` varchar(5) NOT NULL,
  whoRemovedLigature text null,
  `ligatureType` text NOT NULL,
  `strangulationSuspected` varchar(5) NOT NULL,
  `smotheringSuspected` varchar(5) NOT NULL,
  `chockingSuspected` varchar(5) NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`hangingID`)
);



CREATE TABLE IF NOT EXISTS `hanginginside` (
  insideID int not null auto_increment primary key,
   hangingID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (hangingID) REFERENCES hanging(hangingID)
) ;

CREATE TABLE IF NOT EXISTS `height` (
  `heightID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
   `heightIOType` text NOT NULL,
  
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `fromWhat` text NOT NULL,
  `howHigh` text NOT NULL,
  `onWhatVictimLanded` text NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `heightinside` (
  insideID int not null auto_increment primary key,
   heightID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
      FOREIGN KEY (heightID) REFERENCES height(heightID)
);

CREATE TABLE IF NOT EXISTS `ingestionOverdosePoisoning` (
  `ingestionOverdosePoisoningID` int NOT NULL auto_increment primary key,
   sceneID int not null,
   `ingestionOverdosePoisoningIOType` text NOT NULL,
  
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `ingestionOverdosePoisoningInside` (
  insideID int not null auto_increment primary key,
   ingestionOverdosePoisoningID int not null,
  `doorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
    FOREIGN KEY (ingestionOverdosePoisoningID) REFERENCES ingestionOverdosePoisoning(ingestionOverdosePoisoningID)
);

CREATE TABLE IF NOT EXISTS `mba` (
  `mbaID` int NOT NULL,
   sceneID int not null,
  
  `victimWearingProtectiveClothing` varchar(5) NOT NULL,
  `mbaOutsideType` text NOT NULL,
  `victimsOnMotorcycle` text NOT NULL,
  `motorbikeHitFrom` text NOT NULL,
  `typeOfAccident` text NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `mva` (
  `mvaID` int NOT NULL,
   sceneID int not null,
  `victimFoundInCar` varchar(5) NOT NULL,
  `mvaOutsideType` text NOT NULL,
  `occupants` text NOT NULL,
  `numberOfOccupants` int NOT NULL,
  `victimWas` text NOT NULL,
  `carWasHitFrom` text NOT NULL,
  `victimType` text NOT NULL,
  `carBurnt` varchar(5) NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `pedestrian` (
  `perdestrianID` int NOT NULL,
   sceneID int not null,  
  `perdestrianOutside` text NOT NULL,
  `hitAndRun` varchar(5) NOT NULL,
  `pedestrianType` int NOT NULL,
  `numberOfCarsDroveOverBody` int NOT NULL,
  `weatherConditionType` int NOT NULL,
  `weatherCondition` int NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `railway` (
  `railwayID` int NOT NULL,
   sceneID int not null,
  
  `sceneOfInjury` text NOT NULL,
  `victimType` text NOT NULL,
  `railwayType` text NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
 
);


CREATE TABLE IF NOT EXISTS `sec48` (
  `sec48ID` int NOT NULL AUTO_INCREMENT,
  `sceneID` int NOT NULL,
  `victimHospitalized` text NOT NULL,
  `medicalEquipmentInSitu` varchar(5) NOT NULL,
  `gw714file` varchar(5) NOT NULL,
  `DrNames` text NOT NULL,
  `DrCellNumber` text NOT NULL,
  `NurseNames` text NOT NULL,
  `NurseCellNumber` text NOT NULL,
  FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`sec48ID`)
) ;


CREATE TABLE IF NOT EXISTS `sharp`(
  `sharpID` int NOT NULL auto_increment primary key,
   sceneID int not null,
   `sharpIOType` text NOT NULL,
  
  `sharpObjectAtScene` varchar(5) NOT NULL,
  `sharpForceInjuries` text NOT NULL,
  `theInjury` text NOT NULL,
    `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
     FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `sharpinside` (
  insideID int not null auto_increment primary key,
  sharpID int not null,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null, 
      FOREIGN KEY (sharpID) REFERENCES sharp(sharpID)
);

CREATE TABLE IF NOT EXISTS `sid` (
  `sidID` int NOT NULL AUTO_INCREMENT,
   sceneID int not null,
   `sidIOType` text NOT NULL,
  `resuscitationAttemped` varchar(5) NOT NULL,
  `infantSickLately` varchar(5) NOT NULL,
  `infantSickLatelyDescription` text NOT NULL,
  `infantOnMedication` varchar(5) NOT NULL,
  `fallsOrInjuryExperience` varchar(5) NOT NULL,
  `infantWearing` varchar(5) NOT NULL,
  `infantTightlyWrapped` varchar(5) NOT NULL,
  `beddingOverInfant` text NOT NULL,
  `whoFoundVictimBody`varchar(5) NOT NULL,
  `dateAndTimeLastPlaced` varchar(5) NOT NULL,
  `dateAndTimeDeathDiscovered` varchar(5) NOT NULL,
  `dateAndTimeLastSeenAlive` varchar(5) NOT NULL,
  `anySIDSdeeaths` varchar(5) NOT NULL,
  `photoAfterBodyRemoved` text NOT NULL,
   `infantLastPlaced` text NOT NULL,
  `infantLastSeenAlive` text NOT NULL,
  `whereInfantFoundDead` varchar(5) NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`sidID`)
);

CREATE TABLE IF NOT EXISTS `suda` (
  `sudaID` int NOT NULL AUTO_INCREMENT,
   sceneID int not null,
   `sudaIOType` text NOT NULL,
  
   `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
  `strangulationSuspected` varchar(5) NOT NULL,
  `smotheringSuspected` varchar(5) NOT NULL,
  `chockingSuspected` varchar(5) NOT NULL,
   `sudaAppliances` varchar(5) NOT NULL,
  `wierdSmellInAir` varchar(5) NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`sudaID`)
);

CREATE TABLE IF NOT EXISTS `sudainside` (
  insideID int not null auto_increment primary key,
   sudaID int not null,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,   
    FOREIGN KEY (sudaID) REFERENCES suda(sudaID)
);

CREATE TABLE IF NOT EXISTS `sudc` (
  `sudcID` int NULL auto_increment primary key,
   sceneID int not null,
   `sudcIOType` text NOT NULL,
  
  `signsOfStruggle` varchar(5) NOT NULL,
  `alcoholBottleAround` varchar(5) NOT NULL,
  `drugParaphernalia` varchar(5) NOT NULL,
   `strangulationSuspected` varchar(5) NOT NULL,
  `smotheringSuspected` varchar(5) NOT NULL,
  `chockingSuspected` varchar(5) NOT NULL,
   `sudcAppliances` varchar(5) NOT NULL,
   `wierdSmellInAir` varchar(5) NOT NULL,
     FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `sudcinside` (
  insideID int not null auto_increment primary key,
   sudcID int not null,
  `wasDoorLocked` varchar(5) NOT NULL,
  `windowsClosed` varchar(5) NOT NULL,
  `windowsBroken` varchar(5) NOT NULL,
  `victimAlone` varchar(5) NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (sudcID) REFERENCES sudc(sudcID)
);