

insert into userType values(100,"Administrator");
insert into userType values(0,"Forensic Practitioner");
insert into userType values(0,"Forensic Officer");
insert into userType values(0,"Student");

insert into users values(0,"p11111111","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",100,1);
insert into administrator values("p11111111",1);

insert into users values(0,"p22222222","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",101,1);
insert into forensicPractitioner values("p22222222",2,"12345");

insert into users values(0,"p33333333","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",102,1);
insert into forensicOfficer values("p33333333",3,"12345");

insert into users values(0,"p44444444","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",103,1);
insert into student values("p44444444",4,"12345");

insert into sceneType values(0,"Sudden unexpected death of an infant (SUDI)");
insert into sceneType values(0,"Sudden unexpected death of a child  (1 – 18 years)");
insert into sceneType values(0,"Sudden unexpected death of an adult/ found dead");
insert into sceneType values(0,"Foetus / Abandoned baby");
insert into sceneType values(0,"Section 48  death –surgical case");
insert into sceneType values(0,"Pedestrian vehicle accident");
insert into sceneType values(0,"Bicycle accident");
insert into sceneType values(0,"Motorbike accident");
insert into sceneType values(0,"Motor vehicle accident");
insert into sceneType values(0,"Railway accident");
insert into sceneType values(0,"Aviation accident");
insert into sceneType values(0,"Fall/push/jump from height");
insert into sceneType values(0,"Crush injury");
insert into sceneType values(0,"Firearm discharge/  gunshot wound");
insert into sceneType values(0,"Sharp force injury/ stab injury");
insert into sceneType values(0,"Blunt force injury/ assault");
insert into sceneType values(0,"Drowning");
insert into sceneType values(0,"Gassing");
insert into sceneType values(0,"Hanging");
insert into sceneType values(0,"Ingestion/overdose /poisoning");
insert into sceneType values(0,"Burns");
insert into sceneType values(0,"Lightning/ electrocution");

insert into scene values(0,19,"00:00:12","2014-01-01","Hatfield plaza","30 C","Cobi Timoty","Surgent","0223333","Ramzi Cooper","Detective");
insert into scene values(0,19,"12:10:10","2014-04-03","Lacansda","40 C","Folo Gola","Luetanent","01244355","Dony Lamda","Detective");
insert into scene values(0,11,"12:10:10","2014-04-03","Pretoria","24 C","Sikhitha Talifhani","Luetanent","01244355","Dony Lamda","Detective");
insert into scene values(0,21,"12:10:10","2014-04-03","Jhb","30 C","zeee Dister","John","01244367","Joseph Stiip","Detective");



insert into cases values(0,1,"p33333333");
insert into cases values(0,2,"p33333333");
insert into cases values(0,3,"p33333333");
insert into cases values(0,4,"p33333333");


 
insert into victimType values(0,"Pilot");
insert into victimType values(0,"Co-Pilot");
insert into victimType values(0,"Crew");
insert into victimType values(0,"Passenger");
insert into victimType values(0,"Driver of the train");
insert into victimType values(0,"Passenger of the train");
insert into victimType values(0,"Train surfer");
insert into victimType values(0,"Pedestrian");



insert into insideScenes values(0,"Private house");
insert into insideScenes values(0,"Residential institution");
insert into insideScenes values(0,"Informal settlement/squatter camp");
insert into insideScenes values(0,"Bar, shebeen, night club, disco");
insert into insideScenes values(0,"Amusement park, sports area");
insert into insideScenes values(0,"Railway station");
insert into insideScenes values(0,"Shop, bank, retail area");
insert into insideScenes values(0,"School, educational area");
insert into insideScenes values(0,"Medical service area");
insert into insideScenes values(0,"Industrial & constructional area , mine");
insert into insideScenes values(0,"Farm & primary production area");
insert into insideScenes values(0,"In custody, prison");
insert into insideScenes values(0,"Place unknown");
insert into insideScenes values(0,"Other(Specify)");

insert into outsideScenes values(0,"Yard");
insert into outsideScenes values(0,"Residential institution");
insert into outsideScenes values(0,"Informal settlement/ squatter camp");
insert into outsideScenes values(0,"Bar, shebeen, nightclub, disco");
insert into outsideScenes values(0,"Amusement park, sports area");
insert into outsideScenes values(0,"Road/street/highway");
insert into outsideScenes values(0,"Railway track, station");
insert into outsideScenes values(0,"Shop, bank, retail area");
insert into outsideScenes values(0,"School, educational area");
insert into outsideScenes values(0,"Medical service area");
insert into outsideScenes values(0,"Industrial & construction area, mine");
insert into outsideScenes values(0,"Farm, primary production area");
insert into outsideScenes values(0,"Sea, lake, river, dam");
insert into outsideScenes values(0,"Open land, beach");
insert into outsideScenes values(0,"Countryside");
insert into outsideScenes values(0,"Prison");
insert into outsideScenes values(0,"Place unknown");




insert into aviationOutsideType values(0,"Commercial aircraft");
insert into aviationOutsideType values(0,"Light aircraft");
insert into aviationOutsideType values(0,"Helicopter");


insert into victims values(0,"29300201201","Male","White","Tony","Coola","Roomi Jane","no","no","no","no","no","no","no","no","Violance and weird","no","no","no",0);
insert into victims values(0,"12300201201","Male","Indian","Ramzy","Palar","Soliu Jin","yes","yes","no","no","yes","yes","no","no","Violance and weird","yes","no","no",0);
insert into victims values(0,"45300201201","Female","White","Sally","Joomla","Lee Poo","no","yes","no","no","yes","yes","no","no","Violance and weird","no","yes","no",0);
insert into victims values(0,"23432561524","Female","Black","Talie","Fiona","Azee Poo","no","yes","no","no","yes","yes","no","no","Violance and weird","no","yes","no",0);
insert into victims values(0,"23432561524","Female","Black","Talie","Fiona","Azee Poo","no","yes","no","no","yes","yes","no","no","Violance and weird","no","yes","no",0);


insert into sceneVictims values(0,1,1,null);
insert into sceneVictims values(0,1,3,null);
insert into sceneVictims values(0,2,2,null);
insert into sceneVictims values(0,3,4,"Crew");
insert into sceneVictims values(0,4,5,null);

insert into hanging values(0,1,'Private house','yes','no','no','no','Feet still touching the floor','feet of ground','yes','Toso cookoo','Rope','yes','yes','yes');
insert into hanging values(0,2,'Industrial & construction area, mine','yes','no','no','no','Feet still touching the floor','feet of ground','yes','Toso cookoo','Rope','yes','yes','yes');

insert into hanginginside values(0,1,'yes','yes','yes','no','Tony Lee, The Neighbour');

insert into foetusabandonedbaby values(0,2,'Near River');
insert into aviation values(0,3,'Commercial aircraft','Plane','6','Rainy','Hail');
insert into burn values(0,4,'inside','No','No','No','Yes','No','no','no','no');

select * from aviation;
select * from victims;
select * from foetusabandonedbaby;

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




INSERT INTO `scene` (`sceneID`, `sceneTypeID`, `sceneTime`, `sceneDate`, `sceneLocation`, `sceneTemparature`, `sceneInvestigatingOfficerName`, `sceneInvestigatingOfficerRank`, `sceneInvestigatingOfficerCellNumber`, `firstOfficerOnSceneName`, `firstOfficerOnSceneRank`) VALUES
(0, 1, '10:00:00', '2014-06-10', 'Steve Biko Hospital', '18 C', 'Pulle Legodi', 'Constable', '078886895', 'Collen Mphabantshi', 'Traineer');

INSERT INTO `sec48` (`sec48ID`, `sceneID`, `victimHospitalized`, `medicalEquipmentInSitu`, `gw714file`, `DrNames`, `DrCellNumber`, `NurseNames`, `NurseCellNumber`) VALUES
(2, 1, 'victim hospitalized for 20 years', 'yes', 'yes', 'Dr Sekoaere Malatji', '0468889999', 'Aluwani Bege', '0124457887');

INSERT INTO `victims` (`victimID`,victimIdentityNumber, `victimGender`, `victimRace`, `victimName`, `victimSurname`,whoFoundVictimBody ,`bodyDecompose`, `medicalIntervention`, `bodyBurned`, `bodyIntact`, `victimInside`, `victimOutside`, `victimFoundCloseToWater`, `victimSuicideNoteFound`, `victimGeneralHistory`, `rapeHomicideSuspected`, `suicideSuspected`, `previousAttempts`, `numberOfPreviousAttempts`) VALUES
(0, '89658971524552','male', 'Asian', 'Ashim', 'Khali','me', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 'null', 0);

INSERT INTO `victimScenePhotos` (`photoID`, `victimID`, `photoFilename`) VALUES
(0, 1, 'photo/pic.jpg');

select * from cases as c,hanging as h where c.sceneID=h.sceneID;

select * from victims;

select * from scene;

select * from cases;

select * from userType;
select * from users;

select * from administrator;
select * from forensicOfficer;
select * from forensicpractitioner;
select * from student;
select * from blunt;