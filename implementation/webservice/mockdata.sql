

insert into userType values(100,"Administrator");
insert into userType values(0,"Forensic Practitioner");
insert into userType values(0,"Forensic Officer");
insert into userType values(0,"Student");

insert into users values(0,"p11111111","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",100,1);
insert into administrator values("p11111111",1);

insert into users values(0,"p22222222","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",101,1);
insert into forensicPractitioner values("p22222222",2,12345);

insert into users values(0,"p33333333","7cef8a734855777c2a9d0caf42666e69","myname","mysurname",102,1);
insert into forensicOfficer values("p33333333",3,12345);


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

insert into cases values(0,1,"p33333333");
insert into cases values(0,2,"p33333333");



 
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

insert into victims values(0,"Male","White","Tony","Coola","Roomi Jane","no","no","no","no","no","no","no","no","Violance and weird","no","no","no",0);
insert into victims values(0,"Male","Indian","Ramzy","Palar","Soliu Jin","yes","yes","no","no","yes","yes","no","no","Violance and weird","yes","no","no",0);
insert into victims values(0,"Female","White","Sally","Joomla","Lee Poo","no","yes","no","no","yes","yes","no","no","Violance and weird","no","yes","no",0);


insert into sceneVictims values(0,1,1,null);
insert into sceneVictims values(0,1,3,null);
insert into sceneVictims values(0,2,2,null);

insert into hanging values(0,1,'Private house','yes','no','no','no','Feet still touching the floor','feet of ground','yes','Toso cookoo','Rope','yes','yes','yes');
insert into hanging values(0,2,'Industrial & construction area, mine','yes','no','no','no','Feet still touching the floor','feet of ground','yes','Toso cookoo','Rope','yes','yes','yes');

insert into hanginginside values(0,1,'yes','yes','yes','no','Tony Lee, The Neighbour');

select * from victims;