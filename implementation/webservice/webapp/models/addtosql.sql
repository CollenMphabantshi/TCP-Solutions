--INSERT INTO scenetype (sceneTypeDescription)   VALUES ('section 48');

--INSERT INTO weatherconditions (weatherConditionDescription)   VALUES ('it was very hot, cold and partly cloudy');

--INSERT INTO scene (sceneTypeID, sceneTime, sceneDate, sceneLocation, sceneTemparature, sceneInvestigatingOfficerName, sceneInvestigatingOfficerRank, sceneInvestigatingOfficerCellNumber, firstOfficerOnSceneName, firstOfficerOnSceneRank)   VALUES (1, '10:00:00','2014-06-10', 'Steve Biko Hospital', '18 C', 'Pulle Legodi','Constable', '078886895', 'Collen Mphabantshi','Traineer');

--INSERT INTO victims (victimGender, victimRace, victimName, victimSurname, IDnumber, bodyDecompose, medicalIntervention, bodyBurned, bodyIntact, victimInside, victimOutside, victimFoundCloseToWater, victimSuicideNoteFound, victimGeneralHistory, rapeHomicideSuspected, suicideSuspected, previousAttempts, numberOfPreviousAttempts)  VALUES ('male', 'Asian', 'Ashim', 'Khali', '89658971524552', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 0);
 
--INSERT INTO victimscenephotos (victimID, photoFilename)  VALUES (1,'photo/pic.jpg');
 
--INSERT INTO victimtype (victimTypeDiscription)   VALUES ('young india boy');

--INSERT INTO sec48 (sceneID, victimHospitalized, medicalEquipmentInSitu, gw714file, DrNames, DrCellNumber, NurseNames, NurseCellNumber)     VALUES (1, 'victim hospitalized for 20 years','yes', 'yes','Dr Sekoaere Malatji', '0468889999', 'Aluwani Bege', '0124457887');

insert into ligaturetype values(0, 'Rope');
insert into ligaturetype values(0, 'Tie');
insert into ligaturetype values(0, 'Wire');
insert into ligaturetype values( 0,'Hosepipe');
insert into ligaturetype values( 0,'Material/fabric/towel/bedding');
insert into ligaturetype values( 0,'other');


insert into partialhanging values( 0,'Sitting');
insert into partialhanging values( 0,'Kneeling');
insert into partialhanging values( 0,'Half-lying');
insert into partialhanging values( 0,'Feet still touching the floor');
insert into partialhanging values(0,'other');

insert into weatherconditions values(0,'Sunny');
insert into weatherconditions values(0,'Misty');
insert into weatherconditions values(0,'Rainy');
insert into weatherconditions values(0,'Cloudy');
insert into weatherconditions values(0,'Snowy');
insert into weatherconditions values(0,'Thunderstorm');
insert into weatherconditions values(0,'Hail');

insert into bicycletype values(0,'Bicycle only accident');
insert into bicycletype values(0,'Bicycle- motorcycle accident');
insert into bicycletype values(0,'Bicycle- car accident');
insert into bicycletype values(0,'Bicycle- truck accident');
insert into bicycletype values(0,'Bicycle- still standing object accident');
insert into bicycletype values(0,'Bicycle- train accident');