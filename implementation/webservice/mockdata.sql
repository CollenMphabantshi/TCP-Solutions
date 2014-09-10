
use forenlnm_mobileforensics;


insert into userType values(0,"Administrator");
insert into userType values(0,"Forensic Practitioner");
insert into userType values(0,"Forensic Officer");
insert into userType values(0,"Student");
insert into userType values(0,"Guest");
insert into userType values(0,"Forensic Practitioner/Administrator");


insert into users values(0,"p11111111","b19b5bbc5f086219ad8b22cd3faf12e2","myname","mysurname",1,1);
insert into administrator values("p11111111",1);

insert into users values(0,"p22222222","b19b5bbc5f086219ad8b22cd3faf12e2","myname","mysurname",2,1);
insert into forensicPractitioner values("p22222222",2,"12345");

insert into users values(0,"p33333333","b19b5bbc5f086219ad8b22cd3faf12e2","myname","mysurname",3,1);
insert into forensicOfficer values("p33333333",3,"12345");

insert into users values(0,"p44444444","b19b5bbc5f086219ad8b22cd3faf12e2","myname","mysurname",4,1);
insert into student values("p44444444",4,"12345");

insert into users values(0,"talie","b19b5bbc5f086219ad8b22cd3faf12e2","myname","mysurname",6,1);
insert into forensicPractitioner values("talie",5,"1234");
insert into administrator values("talie",5);

insert into sceneType values(0,"Aviation accident");
insert into sceneType values(0,"Bicycle accident");
insert into sceneType values(0,"Blunt force injury/ assault");
insert into sceneType values(0,"Burns");
insert into sceneType values(0,"Crush injury");
insert into sceneType values(0,"Drowning");
insert into sceneType values(0,"Fall/push/jump from height");
insert into sceneType values(0,"Firearm discharge/  gunshot wound");
insert into sceneType values(0,"Foetus / Abandoned baby");
insert into sceneType values(0,"Gassing");
insert into sceneType values(0,"Hanging");
insert into sceneType values(0,"Ingestion/overdose /poisoning");
insert into sceneType values(0,"Lightning/ electrocution");
insert into sceneType values(0,"Motorbike accident");
insert into sceneType values(0,"Motor vehicle accident");
insert into sceneType values(0,"Pedestrian vehicle accident");
insert into sceneType values(0,"Railway accident");
insert into sceneType values(0,"Section 48  death –surgical case");
insert into sceneType values(0,"Sharp force injury/ stab injury");
insert into sceneType values(0,"Sudden unexpected death of an infant (SUDI)");
insert into sceneType values(0,"Sudden unexpected death of a child  (1 – 18 years)");
insert into sceneType values(0,"Sudden unexpected death of an adult/ found dead");

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

insert into ligatureType values(0, 'Rope');
insert into ligatureType values(0, 'Tie');
insert into ligatureType values(0, 'Wire');
insert into ligatureType values( 0,'Hosepipe');
insert into ligatureType values( 0,'Material/fabric/towel/bedding');
insert into ligatureType values( 0,'other');

insert into partialHanging values( 0,'Sitting');
insert into partialHanging values( 0,'Kneeling');
insert into partialHanging values( 0,'Half-lying');
insert into partialHanging values( 0,'Feet still touching the floor');
insert into partialHanging values(0,'other');


insert into weatherConditions values(0,'Sunny');
insert into weatherConditions values(0,'Misty');
insert into weatherConditions values(0,'Rainy');
insert into weatherConditions values(0,'Cloudy');
insert into weatherConditions values(0,'Snowy');
insert into weatherConditions values(0,'Thunderstorm');
insert into weatherConditions values(0,'Hail');

insert into bicycleType values(0,'Bicycle only accident');
insert into bicycleType values(0,'Bicycle- motorcycle accident');
insert into bicycleType values(0,'Bicycle- car accident');
insert into bicycleType values(0,'Bicycle- truck accident');
insert into bicycleType values(0,'Bicycle- still standing object accident');
insert into bicycleType values(0,'Bicycle- train accident');


select * from cases;
select * from scene;
select * from users;
select * from victims;
select * from sceneVictims;
select * from hanging;
select * from hanginginside;
select * from blunt;
select * from bluntInside;
