
drop database if exists forenlnm_mobileforensics;
create database if not exists forenlnm_mobileforensics;
use forenlnm_mobileforensics;




create table if not exists userType
(
    userTypeID int not null auto_increment,
    userTypeDescription text not null,
    primary key(userTypeID)
);


create table if not exists accessMode(
    uid int not null,
    mode text,
    primary key(uid)
);


create table if not exists audit_log(
    audit_id int not null auto_increment,
    audit_uid int not null,
    audit_date date,
    audit_time time,
    audit_action text,
    primary key(audit_id)
);


CREATE TABLE IF NOT EXISTS users
(
`userID` int NOT NULL AUTO_INCREMENT,
 userName text not null,
 userPassword text not null,
`userFirstname` text NOT NULL,
`userSurname` text NOT NULL,
`userTypeID` int NOT NULL,
userActive tinyint not null,
FOREIGN KEY (userTypeID) REFERENCES userType(userTypeID),
PRIMARY KEY (`userID`)
);


create table if not exists forensicOfficer
(
    personelNumber varchar(500) not null,
    userID int not null,
    cellphoneNumber text not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(personelNumber)
);


create table if not exists forensicPractitioner
(
    personelNumber varchar(500) not null,
    userID int not null,
    cellphoneNumber text not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(personelNumber)
);


create table if not exists student
(
    studentNumber varchar(500) not null,
    userID int not null,
    cellphoneNumber text not null,
    FOREIGN KEY (userID) REFERENCES users(userID),
    primary key(studentNumber)
);


create table if not exists administrator
(
    personelNumber varchar(500) not null,
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
    sceneTime text not null,
    sceneDate text not null,
    sceneLocation text not null,
    sceneTemparature text not null,
    sceneInvestigatingOfficerName text not null,
    sceneInvestigatingOfficerRank text not null,
    sceneInvestigatingOfficerCellNumber text not null,
    firstOfficerOnSceneName text not null,
    firstOfficerOnSceneRank text not null,
    FOREIGN KEY (sceneTypeID) REFERENCES sceneType(sceneTypeID),
    primary key(sceneID)
); 



create table if not exists cases
(
    caseNumber int not null auto_increment,
    sceneID int not null,
    FOPersonelNumber varchar(500) not null,
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
    victimIdentityNumber text not null,
    victimGender text not null,
    victimRace text not null,
    victimName text not null,
    victimSurname text not null,
    `whoFoundVictimBody` text NOT NULL,
    bodyDecompose text NOT NULL,
    medicalIntervention text NOT NULL,
    bodyBurned text NULL,
    bodyIntact text NULL,
    `victimInside` text NOT NULL,
    `victimOutside` text NOT NULL,
    `victimFoundCloseToWater` text NOT NULL,
    `victimSuicideNoteFound` text NOT NULL,
    `victimGeneralHistory` text NOT NULL,
    `rapeHomicideSuspected` text NOT NULL,
    `suicideSuspected` text NOT NULL,
    previousAttempts text NOT NULL,
    numberOfPreviousAttempts int not null,
    primary key(victimID)
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
   `bicycleOutputType` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `blunt` (
  `bluntID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `bluntIOType` text NOT NULL,
  `bluntForceObjectSuspected` text NOT NULL,
  `bluntForceObjectStillOnScene` text NOT NULL,
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `wasCommunityAssult` text NOT NULL,
  `strangulationSuspected` text NOT NULL,
  `smotheringSuspected` text NOT NULL,
  `chockingSuspected` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `bluntInside` (
  insideID int not null auto_increment primary key,
  `bluntID` int NOT NULL,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (bluntID) REFERENCES blunt(bluntID)
);


CREATE TABLE IF NOT EXISTS `burn` (
  `burnID` int NOT NULL auto_increment primary key,
   sceneID int not null,
   burnIOType text NOT NULL,
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `accelerantsAtScene` text NOT NULL,
   accelerantsUsed text null,
  `igniterAtScene` text NOT NULL,
   igniterUsed text null,
   foulPlaySuspected text not null,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `burninside` (
  insideID int not null auto_increment primary key,
  burnID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (burnID) REFERENCES burn(burnID)
);

CREATE TABLE IF NOT EXISTS `crushinjury` (
  `crushinjuryID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `crushIOType` text NOT NULL,
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `crushinjuryinside` (
  insideID int not null auto_increment primary key,
  crushinjuryID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (crushinjuryID) REFERENCES crushinjury(crushinjuryID)
);

CREATE TABLE IF NOT EXISTS `drowning` (
  `drowningID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `drowningIOType` text NOT NULL,
  `drowningType` text NOT NULL,
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `drowninginside` (
  insideID int not null auto_increment primary key,
  drowningID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (drowningID) REFERENCES drowning(drowningID)
);

CREATE TABLE IF NOT EXISTS `electrocutionLightning` (
  `electrocutionLightningID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
  `electrocutionLightningIOType` text NOT NULL,
  
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `anyOpenWire` text NOT NULL,
  `sceneWet` text NOT NULL,
  `deBarkingOfTrees` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `electrocutionlightninginside` (
   insideID int not null auto_increment primary key,
   electrocutionLightningID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
    FOREIGN KEY (electrocutionLightningID) REFERENCES electrocutionLightning(electrocutionLightningID)
);



CREATE TABLE IF NOT EXISTS `firearm` (
  `firearmID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
   `firearmIOType` text NOT NULL,
  
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `gunshotWounds` text NOT NULL,
  `gunshotWoundsLocation` text NOT NULL,
  `gunshotWoundsArea` text NOT NULL,
  `firearmOnScene` text NOT NULL,
  `firearmCalibre` text NOT NULL,
  FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
) ;


CREATE TABLE IF NOT EXISTS `firearmInside` (
  insideID int not null auto_increment primary key,
   firearmID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (firearmID) REFERENCES firearm(firearmID)
) ;



CREATE TABLE IF NOT EXISTS `foetusabandonedbaby` (
  `foetusabandonedbabyID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
  `babyIOType` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
) ;


CREATE TABLE IF NOT EXISTS `gassing` (
  `gassingID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
  `gassingIOType` text NOT NULL, 
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `gassinginside` (
   insideID int not null auto_increment primary key,
   gassingID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
  `gassingAppliances` text NOT NULL,
  `gassingAppliancesUsed` text null,
  `gassingSmell` text NOT NULL,
      FOREIGN KEY (gassingID) REFERENCES gassing(gassingID)
);


CREATE TABLE IF NOT EXISTS `gassingoutside` (
  outsideID int not null auto_increment primary key,
   gassingID int not null,
  `gassingVictimInCar` text NOT NULL,
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
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `autoeroticAsphyxia` text NOT NULL,
  `partialHangingType` text NOT NULL,
  `completeHanging` text NOT NULL,
  `ligatureAroundNeck` text NOT NULL,
  whoRemovedLigature text null,
  `ligatureType` text NOT NULL,
  `strangulationSuspected` text NOT NULL,
  `smotheringSuspected` text NOT NULL,
  `chockingSuspected` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`hangingID`)
);



CREATE TABLE IF NOT EXISTS `hanginginside` (
  insideID int not null auto_increment primary key,
   hangingID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (hangingID) REFERENCES hanging(hangingID)
) ;

CREATE TABLE IF NOT EXISTS `height` (
  `heightID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
   `heightIOType` text NOT NULL,
  
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `fromWhat` text NOT NULL,
  `howHigh` text NOT NULL,
  `onWhatVictimLanded` text NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `heightinside` (
  insideID int not null auto_increment primary key,
   heightID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
      FOREIGN KEY (heightID) REFERENCES height(heightID)
);

CREATE TABLE IF NOT EXISTS `ingestionOverdosePoisoning` (
  `ingestionOverdosePoisoningID` int NOT NULL auto_increment primary key,
   sceneID int not null,
   `ingestionOverdosePoisoningIOType` text NOT NULL,
  
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `ingestionOverdosePoisoningInside` (
  insideID int not null auto_increment primary key,
   ingestionOverdosePoisoningID int not null,
  `doorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
    FOREIGN KEY (ingestionOverdosePoisoningID) REFERENCES ingestionOverdosePoisoning(ingestionOverdosePoisoningID)
);

CREATE TABLE IF NOT EXISTS `mba` (
  `mbaID` int NOT NULL,
   sceneID int not null,
  
  `victimWearingProtectiveClothing` text NOT NULL,
  `mbaOutsideType` text NOT NULL,
  `victimsOnMotorcycle` text NOT NULL,
  `motorbikeHitFrom` text NOT NULL,
  `typeOfAccident` text NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `mva` (
  `mvaID` int NOT NULL,
   sceneID int not null,
  `victimFoundInCar` text NOT NULL,
  `mvaOutsideType` text NOT NULL,
  `occupants` text NOT NULL,
  `numberOfOccupants` int NOT NULL,
  `victimWas` text NOT NULL,
  `carWasHitFrom` text NOT NULL,
  `victimType` text NOT NULL,
  `carBurnt` text NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `pedestrian` (
  `perdestrianID` int NOT NULL,
   sceneID int not null,  
  `perdestrianOutsideType` text NOT NULL,
  `hitAndRun` text NOT NULL,
  `pedestrianType` int NOT NULL,
  `numberOfCarsDroveOverBody` int NOT NULL,
  `weatherConditionType` text NOT NULL,
  `weatherCondition` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `railway` (
  `railwayID` int NOT NULL,
   sceneID int not null,
  `railwayIOType` text NOT NULL,
  `victimType` text NOT NULL,
  `railwayType` text NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
 
);


CREATE TABLE IF NOT EXISTS `sec48` (
  `sec48ID` int NOT NULL AUTO_INCREMENT,
  `sceneID` int NOT NULL,
  `victimHospitalized` text NOT NULL,
  `medicalEquipmentInSitu` text NOT NULL,
  `gw714file` text NOT NULL,
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
  `sharpObjectAtScene` text NOT NULL,
  `sharpForceInjuries` text NOT NULL,
  `theInjury` text NOT NULL,
    `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
     FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `sharpinside` (
  insideID int not null auto_increment primary key,
  sharpID int not null,
  `wasDoorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null, 
      FOREIGN KEY (sharpID) REFERENCES sharp(sharpID)
);

CREATE TABLE IF NOT EXISTS `sid` (
  `sidID` int NOT NULL AUTO_INCREMENT,
   sceneID int not null,
   `sidIOType` text NOT NULL,
  `resuscitationAttemped` text NOT NULL,
  `infantSickLately` text NOT NULL,
  `infantSickLatelyDescription` text NOT NULL,
  `infantOnMedication` text NOT NULL,
  `fallsOrInjuryExperience` text NOT NULL,
  `infantWearing` text NOT NULL,
  `infantTightlyWrapped` text NOT NULL,
  `beddingOverInfant` text NOT NULL,
  `dateAndTimeLastPlaced` text NOT NULL,
  `dateAndTimeDeathDiscovered` text NOT NULL,
  `dateAndTimeLastSeenAlive` text NOT NULL,
  `anySIDSdeaths` text NOT NULL,
  `photoAfterBodyRemoved` text NOT NULL,
   `infantLastPlaced` text NOT NULL,
  `infantLastSeenAlive` text NOT NULL,
  `whereInfantFoundDead` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`sidID`)
);

CREATE TABLE IF NOT EXISTS `suda` (
  `sudaID` int NOT NULL AUTO_INCREMENT,
   sceneID int not null,
   `sudaIOType` text NOT NULL,
  
   `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
  `strangulationSuspected` text NOT NULL,
  `smotheringSuspected` text NOT NULL,
  `chockingSuspected` text NOT NULL,
   `sudaAppliances` text NOT NULL,
  `wierdSmellInAir` text NOT NULL,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`sudaID`)
);

CREATE TABLE IF NOT EXISTS `sudainside` (
  insideID int not null auto_increment primary key,
   sudaID int not null,
  `wasDoorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,   
    FOREIGN KEY (sudaID) REFERENCES suda(sudaID)
);

CREATE TABLE IF NOT EXISTS `sudc` (
  `sudcID` int NULL auto_increment primary key,
   sceneID int not null,
   `sudcIOType` text NOT NULL,
  
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
   `strangulationSuspected` text NOT NULL,
  `smotheringSuspected` text NOT NULL,
  `chockingSuspected` text NOT NULL,
   `sudcAppliances` text NOT NULL,
   `wierdSmellInAir` text NOT NULL,
     FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `sudcinside` (
  insideID int not null auto_increment primary key,
   sudcID int not null,
  `wasDoorLocked` text NOT NULL,
  `windowsClosed` text NOT NULL,
  `windowsBroken` text NOT NULL,
  `victimAlone` text NOT NULL,
   peopleWithVictim text null,
   FOREIGN KEY (sudcID) REFERENCES sudc(sudcID)
);