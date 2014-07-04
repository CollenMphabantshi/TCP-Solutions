INSERT INTO scenetype (sceneTypeDescription)   VALUES ('section 48');

--INSERT INTO weatherconditions (weatherConditionDescription)   VALUES ('it was very hot, cold and partly cloudy');

INSERT INTO scene (sceneTypeID, sceneTime, sceneDate, sceneLocation, sceneTemparature, sceneInvestigatingOfficerName, sceneInvestigatingOfficerRank, sceneInvestigatingOfficerCellNumber, firstOfficerOnSceneName, firstOfficerOnSceneRank)   VALUES (1, '10:00:00','2014-06-10', 'Steve Biko Hospital', '18 C', 'Pulle Legodi','Constable', '078886895', 'Collen Mphabantshi','Traineer');

INSERT INTO victims (victimGender, victimRace, victimName, victimSurname, IDnumber, bodyDecompose, medicalIntervention, bodyBurned, bodyIntact, victimInside, victimOutside, victimFoundCloseToWater, victimSuicideNoteFound, victimGeneralHistory, rapeHomicideSuspected, suicideSuspected, previousAttempts, numberOfPreviousAttempts)  VALUES ('male', 'Asian', 'Ashim', 'Khali', '89658971524552', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 0);
 
INSERT INTO victimscenephotos (victimID, photoFilename)  VALUES (1,'photo/pic.jpg');
 
--INSERT INTO victimtype (victimTypeDiscription)   VALUES ('young india boy');

INSERT INTO sec48 (sceneID, victimHospitalized, medicalEquipmentInSitu, gw714file, DrNames, DrCellNumber, NurseNames, NurseCellNumber)     VALUES (1, 'victim hospitalized for 20 years','yes', 'yes','Dr Sekoaere Malatji', '0468889999', 'Aluwani Bege', '0124457887');


