
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
    audit_date date not null,
    audit_time text not null,
    audit_action text not null,
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
    assignedDRNumber varchar(200),
    FOREIGN KEY (caseNumber) REFERENCES cases(caseNumber),
    primary key(deathRegisterNumber,assignedDRNumber)
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
    bodyDecompose text NULL,
    medicalIntervention text NULL,
    bodyBurned text NULL,
    bodyIntact text NULL,
    `victimInside` text NULL,
    `victimOutside` text NULL,
    `victimFoundCloseToWater` text NOT NULL,
    `victimSuicideNoteFound` text NOT NULL,
    `victimGeneralHistory` text NOT NULL,
    `rapeHomicideSuspected` text NOT NULL,
    `suicideSuspected` text NULL,
    previousAttempts text NULL,
    numberOfPreviousAttempts int not null,
    victimAge text not null,
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
  `aviationOType` text NOT NULL,
  `aircraftType` text NOT NULL,
  `aircraftNumPeople` text NOT NULL,
  `weatherCondition` text NOT NULL,
  `weatherType` text NOT NULL,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `bicycleType` (
    bicycleTypeID int not null auto_increment primary key,
    bicycleTypeDescription text not null
);

CREATE TABLE IF NOT EXISTS `bicycle`(
   bicycleID int not null, 
   sceneID int not null,
   bicycleOType text not null,
  `bicycleNumPeople` text NOT NULL,
  `bicycleHit` text NOT NULL,
  `bicycleType` text NOT NULL,
  `weatherCondition` text NOT NULL,
   `weatherType` text NOT NULL,
   `eyewitnesses` text NOT NULL,
    `wasBodyMoved` text NOT NULL,
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
    injuriesConcentratedOn text not null,
    injuriesMainlyOn text not null,
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
   wasBodyHospitilized text not null,
   howBurnWoundsSustained text not null,
   bodyCharred text not null,
   wierdSmell text not null,
   anyPotentialWeapons text not null,
   wasItCommunityAssault text not null,
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
    buildingDamaged text not null,
   FOREIGN KEY (burnID) REFERENCES burn(burnID)
);

CREATE TABLE IF NOT EXISTS `crushinjury` (
  `crushinjuryID` int NOT NULL auto_increment primary key,
   sceneID int not null,
  `crushIOType` text NOT NULL,
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
   wasBodyMoved text not null,
   betweenWhichObjects text not null,
    anyWitness text not null,
    whatWasVictimDoing text not null,
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
   wasBodyInsideWater text not null,
   whoRemovedBody text null,
   fencedOff text not null,
   wasGateClosed text null,
   waterType text not null,
   `strangulationSuspected` text NOT NULL,
  `smotheringSuspected` text NOT NULL,
  `chockingSuspected` text NOT NULL,
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
   `anyWitnesses` text NOT NULL,
   `whenDidVictimDie` text NULL,
    `whatWasVictimDoing` text NOT NULL,
    `victimFallFromHeight` text NOT NULL,
    `voltage` text NOT NULL,
    `anyOtherEvidence` text NOT NULL,
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
    `firedThroughObject` text NOT NULL,
    `firearmUsed` text NOT NULL,
    `cartridgesFound` text NOT NULL,
    `howManyCartridgesFound` text NULL,
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
  `foetusabandonedbabyIOType` text NOT NULL,
    howWasBodyDiscovered text not null,
    wasBodyCovered text not null,
    coveredWith text null,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
) ;


CREATE TABLE IF NOT EXISTS `gassing` (
  `gassingID` int NOT NULL AUTO_INCREMENT primary key,
   sceneID int not null,
  `gassingIOType` text NOT NULL, 
  `signsOfStruggle` text NOT NULL,
  `alcoholBottleAround` text NOT NULL,
  `drugParaphernalia` text NOT NULL,
   foundInCar text not null,
    wasCarRunning text null,
    carWindowClosed text null,
    pipeConnected text null,
    medicationPoisonOnScene text null,
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
  /*`gassingAppliancesUsed` text null,*/
  `gassingSmell` text NOT NULL,
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
  `pornographicMaterial` text NOT NULL,
  `partialHangingType` text NULL,
  `completeHanging` text NOT NULL,
  `ligatureAroundNeck` text NOT NULL,
  whoRemovedLigature text null,
  `ligatureType` text NOT NULL,
  `strangulationSuspected` text NOT NULL,
  `smotheringSuspected` text NOT NULL,
  `chockingSuspected` text NOT NULL,
   bodyCutDown text not null,
   whoCutDownBody text null,
   suspensionPointUsed text not null,
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
  `onWhatSurface` text NOT NULL,
   anyWitnesses text null,
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
    suspectedDrug text not null,
    suspectedDrugOnScene text not null,
    whyIngestionOverdoseSuspected text null,
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
    victimFlungRoad text null,
    victimFlungBanister text null,
    victimFlungCar text null,
    motorBikeFellOnVictim text null,
    anyWitnesses text null,
    bodyMoved text null,
    victimWearingHelmet text null,
    weatherType text null,
    weatherCondition text null,
    helmetStillOn text null,
    helmetRemovedBy text null,
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
   weatherType text null,
    weatherCondition text null,
    anyWitnesses text not null,
    seatBeltOn text null,
    airbagDiploid text null,
    trappedInCar text null,
    bodyHit text null,
    numberOfHit text null,
    FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);

CREATE TABLE IF NOT EXISTS `pedestrian` (
  `perdestrianID` int NOT NULL,
   sceneID int not null,  
  `perdestrianOutsideType` text NOT NULL,
  `hitAndRun` text NOT NULL,
  `pedestrianType` text NOT NULL,
  `numberOfCarsDroveOverBody` int NOT NULL,
  `weatherType` text NOT NULL,
  `weatherCondition` text NOT NULL,
   typeOfCar text null,
   anyWitnesses text null,
   bodyMoved text null,
   victimJumped text null,
   anyStrangeCircumstances text null,
   FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
);


CREATE TABLE IF NOT EXISTS `railway` (
  `railwayID` int NOT NULL,
   sceneID int not null,
  `railwayIOType` text NOT NULL,
  `victimType` text NOT NULL,
  `railwayType` text NOT NULL,
   anyWitnesses text not null,
    driverSeeWhatHappened text null,
    `weatherType` text NOT NULL,
  `weatherCondition` text NOT NULL,
      FOREIGN KEY (sceneID) REFERENCES scene(sceneID)
 
);


CREATE TABLE IF NOT EXISTS `sec48` (
  `sec48ID` int NOT NULL AUTO_INCREMENT,
  `sceneID` int NOT NULL,
  `victimHospitalized` text NOT NULL,
  `medicalEquipmentInSitu` text NOT NULL,
  `gw7_24file` text NOT NULL,
  `DrNames` text NOT NULL,
  `DrCellNumber` text NOT NULL,
  `NurseNames` text NOT NULL,
  `NurseCellNumber` text NOT NULL,
   hospitalName text null,
   whoRemovedEquipment text null,
   gw7_24fileFullyComplete text null,
   medicalRecords text null,
   importantInfoFromMedicalStuff text null,
  FOREIGN KEY (sceneID) REFERENCES scene(sceneID),
  PRIMARY KEY (`sec48ID`)
) ;


CREATE TABLE IF NOT EXISTS `sharp`(
 `sharpID` int NOT NULL auto_increment primary key,
  sceneID int not null,
  `sharpIOType` text NOT NULL,
  sharpObjectSuspected text not null,
  `sharpObjectAtScene` text NOT NULL,
  `sharpForceInjuries` text NOT NULL,
  `theInjuryConcentrated` text NOT NULL,
  `theInjuryMainlyOn` text NOT NULL,
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
   dieDuringSleep text null,
   whatWasInfantDoing text null,
   whatHappenedToInfant text null,
   relationshiptoInfant text null,
   whoAttempedResuscitation text null,
   anyHeatingDevices text null,
   anyWeirdSmell text null,
    anySmokeSmell text null,
    infantOneOfTwins text null,
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
   anyHeatingDevices text null,
  `wierdSmellInAir` text NOT NULL,
    victimHistory text NOT NULL,
    victimTakeMedication text NOT NULL,
    victimHadAnySymptoms text NOT NULL,
    familyMedicalHistory text NOT NULL,
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
   `anyHeatingDevices` text NOT NULL,
    `specifiedAppliences` text NOT NULL,
   `wierdSmellInAir` text NOT NULL,
    `specifiedSmell` text NOT NULL,
    `victimBusy` text NOT NULL,
    `victimBusySpecified` text NOT NULL,
    physicalExercise text NOT NULL,
    familyMedicalHistory text NOT NULL,
    familyMembersSufferingFrom text not null,
    familyMembersSuffering text not null,
    victimFell text not null,
    victimComplain text not null,
    victimComplainSpecified text not null,
    victimTakeMedication text not null,
    victimTakeMedicationSpecified text not null,
    suspisionOfAssault text not null,
    suspisionOfOverdose text not null,
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