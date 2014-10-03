
var URL = "models/webapi.php";
var LOGIN_PAGE = "/webapp/";
var caseList = new Object();
var victim_count = 0;
var currentCaseNumber = -1;
var currentCase = null;
var currentSceneType = null;

$(document).ready(function (){
    
    showPage(1);
    $("#login-form-button").click(function(){
        var username = $("#username").val();
        var pass = $("#password").val();
        
        if(username !== "" && pass !== ""){
            login(username,pass);
        }else{
            alertResponse("Please fill in both username and password","error");
        }
    });
    
       $("#addUserButton").click(function(p){
        //p.preventDefault();
        
        var name = document.getElementById("name").value;
        var pass = document.getElementById("pass").value;
        var cpass = document.getElementById("cpass").value;
        var firstname = document.getElementById("firstname").value;
        var surname = document.getElementById("surnname").value;
        var combobox = document.getElementById("userType").options[document.getElementById("userType").selectedIndex].value;

         if(name !== "" && pass !== "" && cpass !== "" && firstname !== "" && surname !== "" && combobox !== ""){
             if(!passwordCheck(pass,cpass)){
                 return;
             }
             if(combobox !== "Administrator")
             {
                 var cell = document.getElementById("cellphone").value;
                 if(cell !== "" )
                 {
                    addUser(name,pass,firstname,surname,combobox,cell);
                 }else{
                     alertResponse("Please fill in all fields.","error")
                 }
             }else{
                 
                 addUser(name,pass,firstname,surname,combobox,null);
             }
         }else{
             
             alertResponse("Please fill in the  missing information","error");
         }
         
    });
    
    // Main Pages
    $(".viewCase").click(function(){
        
        //loadCaseInfo($(this).attr("id"));
    });
    $(".pages").click(function(){
        showPage($(this).attr("id"));
    });
    
    $("#searchButton").click(function(){
        searchCase($("#search").val());
    });
    $("#userSearchButton").click(function(){
        searchUser($("#userSearch").val());
        
    });
    $("#auditSearchButton").click(function(){
        searchAudit($("#auditSearch").val());
        
    });
    
    $(".listUsers").click(function(){
        $(".response").remove();
        loadUsers();
        
    });
    
    $(".listCases").click(function(){
        $(".response").remove();
        loadCases();
        
    });
    
    $(".listAudit").click(function(){
        $(".response").remove();
        loadAuditLog();
        
    });
    
    $("#assignDR").click(function(){ 
        assignDeathRegister($("#deathreg").val());
    });
    $("#activeUsers").click(function(){ 
        
        sortBy($(this).attr("title"));
    });
    $("#deactiveUsers").click(function(){ 
        sortBy($(this).attr("title"));
    });
    $("#logout").click(function(){
        logout();
    });
    $("#printScene").click(function(){
        pdfRender();
    });
    
});

function sortBy(by){
    var query = new FormData();
    query.append("rquest","sortUsers");
    query.append("by",by);
    query.append("platform","webapp");
        
    var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
            
            var obj = JSON.parse(request.responseText);
            var data = "";
            
            for(var i = 0; i < obj.length;i++)
            {
                
                data += "<tr class='appendUser'>";
                data += "<td>"+obj[i].userName+"</td>";
                data += "<td>"+obj[i].userFirstname+"</td>";
                data += "<td>"+obj[i].userSurname+"</td>";
               
                var sid = obj[i].userID;
                //Add the delete.php to delete users by ID
                if(obj[i].userActive === "1")
                {
                    data += "<td>"+"<a href='#' onclick='deactivateUser(this);' title='"+obj[i].userName+"' id='"+sid+"'>Deactivate</a>"+"</td>";
                }else{
                    data += "<td>"+"<a href='#' onclick='activateUser(this);' title='"+obj[i].userName+"' id='"+sid+"'>Activate</a>"+"</td>";
                }
                data += "</tr>";
            }
            if(obj.length > 0){
                $(".appendUser").remove();
            }
            $("#users .table-headers").after(data);
    }};
    request.open("POST",URL);
    request.send(query);
}
function loadafp(){
    loadUsers();
    loadCases();
    loadAuditLog();
}
function hidePages(){
    $(".page").hide();
}
function showPage(page){
    hidePages();
    $("#Page"+page).show();
}

function resetResponse(){
    
    $(".response").remove();
}

function loadSceneInfo(view){
    $(".right-content table").show();
    $(".right-content #pdfRenderer").hide();
    try{
       currentCaseNumber = view.id;
        var query = new FormData();
        query.append("rquest","getSceneData");
        query.append("caseNumber",view.id);
        query.append("sceneType",view.title);
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            var data = "<tr><td colspan='2' class='table-header'>Scene Information</td></tr>";
            
            var obj = JSON.parse(request.responseText);
            currentCase = obj;
            data += "<tr>";
            data += "<td>Time of scene:</td><td>"+obj.sceneTime+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Date of scene:</td><td>"+obj.sceneDate+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Location of scene:</td><td>"+obj.sceneLocation+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Temperature of scene:</td><td>"+obj.sceneTemparature+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Scene Investigating Officer Name:</td><td>"+obj.sceneInvestigatingOfficerName+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Scene Investigating Officer Rank:</td><td>"+obj.sceneInvestigatingOfficerRank+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Scene Investigating Officer Cell Number:</td><td>"+obj.sceneInvestigatingOfficerCellNumber+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>First Officer On Scene Name:</td><td>"+obj.firstOfficerOnSceneName+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>First Officer On Scene Rank:</td><td>"+obj.firstOfficerOnSceneRank+"</td>";
            data += "</tr>";
            
            data += "<tr><td colspan='2' class='table-header'>Victim Information</td></tr>";
            
            data += "<tr>";
            data += "<td>Victim Name:</td><td>"+obj.victim[victim_count].victimName+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Victim Surname:</td><td>"+obj.victim[victim_count].victimSurname+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Victim Gender:</td><td>"+obj.victim[victim_count].victimGender+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Victim Race:</td><td>"+obj.victim[victim_count].victimRace+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Victim ID Number:</td><td>"+obj.victim[victim_count].victimIdentityNumber+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Victim Estimated Age:</td><td>"+obj.victim[victim_count].victimAge+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Who found the victim&apos;s Body?</td><td>"+obj.victim[victim_count].whoFoundVictimBody+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the body decomposed?</td><td>"+obj.victim[victim_count].bodyDecompose+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was there any Medical Intervention?</td><td>"+obj.victim[victim_count].medicalIntervention+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the body burned?</td><td>"+obj.victim[victim_count].bodyBurned+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the body intact?</td><td>"+obj.victim[victim_count].bodyIntact+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the victim inside?</td><td>"+obj.victim[victim_count].victimInside+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the victim outside?</td><td>"+obj.victim[victim_count].victimOutside+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the victim found close to water?</td><td>"+obj.victim[victim_count].victimFoundCloseToWater+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the victim suicide note found?</td><td>"+obj.victim[victim_count].victimSuicideNoteFound+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was rape homicide suspected?</td><td>"+obj.victim[victim_count].rapeHomicideSuspected+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was suicide Suspected?</td><td>"+obj.victim[victim_count].suicideSuspected+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Any previous attempts?</td><td>"+obj.victim[victim_count].previousAttempts+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Number of previous attempts:</td><td>"+obj.victim[victim_count].numberOfPreviousAttempts+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Victim general history:</td><td>"+obj.victim[victim_count].victimGeneralHistory+"</td>";
            data += "</tr>";
            currentSceneType = view.title;
            data += getSceneTypeData(view.title,obj.sceneTypeData);
            /// show images here
            /*data += "<tr class='sceneImages'><td colspan='2'>";
            for(var j = 0; j < obj.photos.length;j++)
            {
                data += "<ul>"+"<li><img class='scene-img' src='"+obj.photos[j].photoFilename+"'/></li>"+"</ul>";
            }
            data += "</td></tr>";*/
            $(".right-content table").html(data);
        }};

        request.open("POST",URL);
        request.send(query);
    }catch(e){
        
    }
}

function pdfRender(){
    $(".right-content table").hide();
    
    var doc = new jsPDF();
    doc.setFontSize(24);
    doc.text(50, 20, 'Case Information');
    doc.setFontSize(20);
    doc.text(40, 40, currentSceneType);
    
    // scene information
    doc.setFontSize(16);
    doc.text(20, 60, 'Time of scene:\t\t'+currentCase.sceneTime);
    doc.text(20, 70, 'Date of scene:\t\t'+currentCase.sceneDate);
    doc.text(20, 80, 'Location of Scene:\t\t'+currentCase.sceneLocation);
    doc.text(20, 90, 'Temperature of scene:\t\t'+currentCase.sceneTemparature);
    doc.text(20, 100, 'Scene Investigating Officer Name:\t\t'+currentCase.sceneInvestigatingOfficerName);
    doc.text(20, 110, 'Scene Investigating Officer Rank:\t\t'+currentCase.sceneInvestigatingOfficerRank);
    doc.text(20, 120, 'Scene Investigating Officer Cell Number:\t\t'+currentCase.sceneInvestigatingOfficerCellNumber);
    doc.text(20, 130, 'First Officer On Scene Name:\t\t'+currentCase.firstOfficerOnSceneName);
    doc.text(20, 140, 'First Officer On Scene Rank:\t\t'+currentCase.firstOfficerOnSceneRank);
    
    // victim information
    doc.setFontSize(20);
    var pos = 20;
    doc.text(30, 160, 'Victim information');
    doc.setFontSize(16);
    doc.text(20, 180, 'Victim Name:\t\t'+currentCase.victim[0].victimName);
    doc.text(20, 190, 'Victim Surname:\t\t'+currentCase.victim[0].victimSurname);
    doc.text(20, 200, 'Victim Gender:\t\t'+currentCase.victim[0].victimGender);
    doc.text(20, 210, 'Victim Race:\t\t'+currentCase.victim[0].victimRace);
    doc.text(20, 220, 'Victim ID Number:\t\t'+currentCase.victim[0].victimIdentityNumber);
    doc.text(20, 240, 'Victim Estimated Age:\t\t'+currentCase.victim[0].victimAge);
    doc.text(20, 250, 'Who found the body:\t\t'+currentCase.whoFoundVictimBody);
    doc.text(20, 260, 'Was the body decomposed:\t\t'+currentCase.victim[0].bodyDecompose);
    doc.text(20, 270, 'Was there any Medical Intervention:\t\t'+currentCase.victim[0].medicalIntervention);
    doc.addPage();
    
    doc.text(20, pos+=10, 'Was the body burned:\t\t'+currentCase.victim[0].bodyBurned);
    doc.text(20, pos+=10, 'Was the body intact:\t\t'+currentCase.victim[0].bodyIntact);
    doc.text(20, pos+=10, 'Was the victim inside:\t\t'+currentCase.victim[0].victimInside);
    doc.text(20, pos+=10, 'Was the victim outside:\t\t'+currentCase.victim[0].victimOutside);
    doc.text(20, pos+=10, 'Was the victim found close to water:\t\t'+currentCase.victim[0].victimFoundCloseToWater);
    doc.text(20, pos+=10, 'Was the victim suicide note found:\t\t'+currentCase.victim[0].victimSuicideNoteFound);
    doc.text(20, pos+=10, 'Was rape homicide suspected:\t\t'+currentCase.victim[0].rapeHomicideSuspected);
    doc.text(20, pos+=10, 'Was suicide Suspected:\t\t'+currentCase.victim[0].suicideSuspected);
    doc.text(20, pos+=10, 'Any previous attempts:\t\t'+currentCase.victim[0].previousAttempts);
    doc.text(20, pos+=10, 'Number of previous attempts:\t\t'+currentCase.victim[0].numberOfPreviousAttempts);
    doc.text(20, pos+=10, 'Victim general history:\t\t'+currentCase.victim[0].victimGeneralHistory);
    
    var sceneData = currentCase.sceneTypeData;
    pos = 20;
    doc.addPage();
    doc.setFontSize(20);
    doc.text(30, pos+=10, 'Scene Type Information');
    doc.setFontSize(16);
    switch(currentSceneType)
    {
        case "Foetus / Abandoned baby":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.babyIOType);
                        
                        break;
                    case "Aviation accident":    
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.aviationOutsideType);
                        
                        
                       doc.text(20, pos+=10, 'Aircraft type:\t\t'+sceneData.aircraftType);
                        
                        
                       doc.text(20, pos+=10, 'Number of people on aircraft:\t\t'+sceneData.aircraftNumPeople);
                        
                        
                       doc.text(20, pos+=10, 'Weather condition:\t\t'+sceneData.weatherCondition);
                        
                       doc.text(20, pos+=10, 'Weather type:\t\t'+sceneData.weatherType);
                        
                        break;
                     case "Hanging":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.hangingIOType);
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                       doc.text(20, pos+=10, 'Autoerotic Asphyxia?\t\t'+sceneData.autoeroticAsphyxia);
                        
                       doc.text(20, pos+=10, 'Partial hanging type:\t\t'+sceneData.partialHangingType);
                        
                       doc.text(20, pos+=10, 'Complete hanging?\t\t'+sceneData.completeHanging);
                        
                       doc.text(20, pos+=10, 'Was ligature around neck?\t\t'+sceneData.ligatureAroundNeck);
                        
                       doc.text(20, pos+=10, 'Who removed ligature:\t\t'+sceneData.whoRemovedLigature);
                        
                       doc.text(20, pos+=10, 'Ligature type:\t\t'+sceneData.ligatureType);
                        
                       doc.text(20, pos+=10, 'Was strangulation suspected?\t\t'+sceneData.strangulationSuspected);
                        
                       doc.text(20, pos+=10, 'Was smothering suspected?\t\t'+sceneData.smotheringSuspected);
                        
                       doc.text(20, pos+=10, 'Was chocking suspected?\t\t'+sceneData.chockingSuspected);
                        pos = 20;
                        doc.addPage();
                        var inside = sceneData.hangingInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }
                        break;
                    case "Bicycle accident":
                         
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.bicycleOutputType);
                        
                       doc.text(20, pos+=10, 'Bicycle type:\t\t'+sceneData.bicycleType);
                        
                        
                       doc.text(20, pos+=10, 'Number of people on bicycle:\t\t'+sceneData.bicycleNumPeople);
                        
                        
                       doc.text(20, pos+=10, 'Weather condition:\t\t'+sceneData.weatherCondition);
                        
                        
                       doc.text(20, pos+=10, 'Bicycle hit:\t\t'+sceneData.bicycleHit);
                        
                        break;
                    case "Blunt force injury/ assault":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.bluntIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Blunt force object suspected:\t\t'+sceneData.bluntForceObjectSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was the blunt force object still on scene?\t\t'+sceneData.bluntForceObjectStillOnScene);
                        
                        
                       doc.text(20, pos+=10, 'Was it a community assult?\t\t'+sceneData.wasCommunityAssult);
                        
                        
                       doc.text(20, pos+=10, 'Was strangulation suspected?\t\t'+sceneData.strangulationSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was smothering suspected?\t\t'+sceneData.smotheringSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was chocking suspected?\t\t'+sceneData.chockingSuspected);
                       doc.addPage();
                        try{
                            var inside = sceneData.bluntInside;
                            if(inside !== null);
                            {

                               doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);


                               doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);


                               doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);


                               doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);


                               doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);

                            }
                        }catch(e){
                            
                        }
                        break;
                    case "Burns":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.burnIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Accelerants at scene?\t\t'+sceneData.accelerantsAtScene);
                        
                        
                       doc.text(20, pos+=10, 'Accelerants used:\t\t'+sceneData.accelerantsUsed);
                        
                        
                       doc.text(20, pos+=10, 'Igniter at scene?\t\t'+sceneData.igniterAtScene);
                        
                        
                       doc.text(20, pos+=10, 'Igniter used:\t\t'+sceneData.igniterUsed);
                        
                        
                       doc.text(20, pos+=10, 'Foul play suspected?\t\t'+sceneData.foulPlaySuspected);
                        
                        try{
                            var inside = sceneData.burnInside;
                            if(inside !== null);
                            {

                               doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);


                               doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);


                               doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);


                               doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);


                               doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);

                            }
                        }catch(e){}
                        break;
                    case "Crush injury":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.crushIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        try{
                        var inside = sceneData.crushinjuryInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "deathregister":     
                        break;
                    case "Drowning":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.drowningIOType);
                        
                        
                       doc.text(20, pos+=10, 'Drowning type:\t\t'+sceneData.drowningType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        try{
                        var inside = sceneData.drowningInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Lightning/ electrocution":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.electrocutionLightningIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Any open wire?\t\t'+sceneData.anyOpenWire);
                        
                        
                       doc.text(20, pos+=10, 'Was the scene wet?\t\t'+sceneData.sceneWet);
                        
                        
                       doc.text(20, pos+=10, 'Debarking of trees?\t\t'+sceneData.deBarkingOfTrees);
                        
                        try{
                        var inside = sceneData.electrocutionlightningInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Firearm discharge/  gunshot wound":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.firearmIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any gunshot wounds?\t\t'+sceneData.gunshotWounds);
                        
                        
                       doc.text(20, pos+=10, 'Where are the gunshot wounds located:\t\t'+sceneData.gunshotWoundsLocation);
                        
                        
                       doc.text(20, pos+=10, 'Where are the gunshot wounds area?\t\t'+sceneData.gunshotWoundsArea);
                        
                        
                       doc.text(20, pos+=10, 'Was the firearm on scene?\t\t'+sceneData.firearmOnScene);
                        
                        
                       doc.text(20, pos+=10, 'Accelerants used:\t\t'+sceneData.accelerantsUsed);
                        
                        
                       doc.text(20, pos+=10, 'Firearm calibre:\t\t'+sceneData.firearmCalibre);
                        try{
                        var inside = sceneData.firearmInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Fall/push/jump from height":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.heightIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Where did the victim fall from?\t\t'+sceneData.fromWhat);
                        
                        
                       doc.text(20, pos+=10, 'How high was the fall?\t\t'+sceneData.howHigh);
                        
                        
                       doc.text(20, pos+=10, 'On what did the victim land?\t\t'+sceneData.onWhatVictimLanded);
                        
                        try{
                        var inside = sceneData.heightInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Gassing":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.gassingIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        try{
                        var inside = sceneData.gassingInside;
                        
                        if(inside !== null)
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                            
                           doc.text(20, pos+=10, 'Any gassing appliances?\t\t'+inside.gassingAppliances);
                            
                            
                           doc.text(20, pos+=10, 'Gassing aplliances used:\t\t'+inside.gassingAppliancesUsed);
                            
                            
                           doc.text(20, pos+=10, 'Was there a gassing smell?\t\t'+inside.gassingSmell);
                            
                        }}catch(e){}
                        break;
                    case "Ingestion/overdose /poisoning":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.ingestionOverdosePoisoningIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        try{
                        var inside = sceneData.ingestionOverdosePoisoningInside;
                        if(inside !== null)
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Motor vehicle accident":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.mvaOutsideType);
                        
                        
                       doc.text(20, pos+=10, 'Was the victim found in car?\t\t'+sceneData.victimFoundInCar);
                        
                        
                       doc.text(20, pos+=10, 'Occupants:\t\t'+sceneData.occupants);
                        
                        
                       doc.text(20, pos+=10, 'Number of occupants:\t\t'+sceneData.numberOfOccupants);
                        
                        
                       doc.text(20, pos+=10, 'Victim was:\t\t'+sceneData.victimWas);
                        
                        
                       doc.text(20, pos+=10, 'Car was hit from:\t\t'+sceneData.carWasHitFrom);
                        
                        
                       doc.text(20, pos+=10, 'Victim Type:\t\t'+sceneData.victimType);
                        
                        
                       doc.text(20, pos+=10, 'Was the car burnt?\t\t'+sceneData.carBurnt);
                       
                        break;
                    case "Motorbike accident":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.mbaOutsideType);
                        
                        
                       doc.text(20, pos+=10, 'Was the victim wearing protective clothing?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Victims on motorcycle?\t\t'+sceneData.victimsOnMotorcycle);
                        
                        
                       doc.text(20, pos+=10, 'Where was the motorbike hit from?\t\t'+sceneData.motorbikeHitFrom);
                        
                        
                       doc.text(20, pos+=10, 'Type of accident:\t\t'+sceneData.typeOfAccident);
                        
                        break;
                    case "Pedestrian vehicle accident":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.perdestrianOutsideType);
                        
                        
                       doc.text(20, pos+=10, 'Was it a hit and run?\t\t'+sceneData.hitAndRun);
                        
                        
                       doc.text(20, pos+=10, 'Pedestrian type:\t\t'+sceneData.pedestrianType);
                        
                        
                       doc.text(20, pos+=10, 'Number of cars drove over the body:\t\t'+sceneData.numberOfCarsDroveOverBody);
                        
                        
                       doc.text(20, pos+=10, 'Victim was:\t\t'+sceneData.victimWas);
                        
                        
                       doc.text(20, pos+=10, 'Weather condition type:\t\t'+sceneData.weatherConditionType);
                        
                        
                       doc.text(20, pos+=10, 'Weather condition:\t\t'+sceneData.weatherCondition);
                        
                        break;
                    case "Railway accident":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.railwayIOType);
                        
                        
                       doc.text(20, pos+=10, 'Victim type:\t\t'+sceneData.victimType);
                        
                        
                       doc.text(20, pos+=10, 'Railway type:\t\t'+sceneData.railwayType);
                        
                        break;
                    case "Sharp force injury/ stab injury":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.sharpIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Was the sharp object at scene?\t\t'+sceneData.sharpObjectAtScene);
                        
                        
                       doc.text(20, pos+=10, 'What are the sharp force injuries of victim?\t\t'+sceneData.sharpForceInjuries);
                        
                        
                       doc.text(20, pos+=10, 'The injury:\t\t'+sceneData.theInjury);
                        
                        try{
                        var inside = sceneData.sharpInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Sudden unexpected death of an infant (SUDI)":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.sidIOType);
                        
                        
                       doc.text(20, pos+=10, 'Resuscitation attemped?\t\t'+sceneData.resuscitationAttemped);
                        
                        
                       doc.text(20, pos+=10, 'Was the infant sick lately?\t\t'+sceneData.infantSickLately);
                        
                        
                       doc.text(20, pos+=10, 'Description of infant sickness:\t\t'+sceneData.infantSickLatelyDescription);
                        
                        
                       doc.text(20, pos+=10, 'Was the infant on medication?\t\t'+sceneData.infantOnMedication);
                        
                        
                       doc.text(20, pos+=10, 'Any falls or inury experience?\t\t'+sceneData.fallsOrInjuryExperience);
                        
                        
                       doc.text(20, pos+=10, 'What was the infant wearing?\t\t'+sceneData.infantWearing);
                        
                        
                       doc.text(20, pos+=10, 'Was the infant tightly wrapped?\t\t'+sceneData.infantTightlyWrapped);
                        
                        
                       doc.text(20, pos+=10, 'Bedding over infant?\t\t'+sceneData.beddingOverInfant);
                        
                        
                       doc.text(20, pos+=10, 'Date and time last placed:\t\t'+sceneData.dateAndTimeLastPlaced);
                        
                        
                       doc.text(20, pos+=10, 'Date and time death discovered:\t\t'+sceneData.dateAndTimeDeathDiscovered);
                        
                        
                       doc.text(20, pos+=10, 'Date and time last seen alive:\t\t'+sceneData.dateAndTimeLastSeenAlive);
                        
                        
                       doc.text(20, pos+=10, 'Any SID deaths?\t\t'+sceneData.anySIDSdeaths);
                        
                        
                       doc.text(20, pos+=10, 'Photo after body removed:\t\t'+sceneData.photoAfterBodyRemoved);
                        
                        
                       doc.text(20, pos+=10, 'Infant last placed:\t\t'+sceneData.infantLastPlaced);
                        
                        
                       doc.text(20, pos+=10, 'Infant last seen alive:\t\t'+sceneData.infantLastSeenAlive);
                        
                        
                       doc.text(20, pos+=10, 'Where was the infant found dead?\t\t'+sceneData.whereInfantFoundDead);
                        
                        break;
                    case "Sudden unexpected death of an adult/ found dead":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.sudaIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Was strangulation suspected?\t\t'+sceneData.strangulationSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was smothering suspected?\t\t'+sceneData.smotheringSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was chocking suspected?\t\t'+sceneData.chockingSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Appliances?\t\t'+sceneData.sudaAppliances);
                        
                        
                       doc.text(20, pos+=10, 'Was there a weird smell in the air?\t\t'+sceneData.wierdSmellInAir);
                        
                        try{
                        var inside = sceneData.sudaInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Sudden unexpected death of a child  (1 – 18 years)":
                        
                       doc.text(20, pos+=10, 'Where did the scene take place?\t\t'+sceneData.sudcIOType);
                        
                        
                       doc.text(20, pos+=10, 'Any signs of struggle?\t\t'+sceneData.signsOfStruggle);
                        
                        
                       doc.text(20, pos+=10, 'Was an alcohol bottle around?\t\t'+sceneData.alcoholBottleAround);
                        
                        
                       doc.text(20, pos+=10, 'Drug Paraphernalia?\t\t'+sceneData.drugParaphernalia);
                        
                        
                       doc.text(20, pos+=10, 'Was strangulation suspected?\t\t'+sceneData.strangulationSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was smothering suspected?\t\t'+sceneData.smotheringSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Was chocking suspected?\t\t'+sceneData.chockingSuspected);
                        
                        
                       doc.text(20, pos+=10, 'Appliances?\t\t'+sceneData.sudaAppliances);
                        
                        
                       doc.text(20, pos+=10, 'Was there a weird smell in the air?\t\t'+sceneData.wierdSmellInAir);
                        
                        try{
                        var inside = sceneData.sudcInside;
                        if(inside !== null);
                        {
                            
                           doc.text(20, pos+=10, 'Was the door locked?\t\t'+inside.doorLocked);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows closed?\t\t'+inside.windowsClosed);
                            
                            
                           doc.text(20, pos+=10, 'Was the windows broken?\t\t'+inside.windowsBroken);
                            
                            
                           doc.text(20, pos+=10, 'Was the victim alone?\t\t'+inside.victimAlone);
                            
                            
                           doc.text(20, pos+=10, 'Who was with the victim?\t\t'+inside.peopleWithVictim);
                            
                        }}catch(e){}
                        break;
                    case "Section 48  death –surgical case":
                        
                       doc.text(20, pos+=10, 'Was the victim hospitalized?\t\t'+sceneData.victimHospitalized);
                        
                        
                       doc.text(20, pos+=10, 'Medical equipment in situ?\t\t'+sceneData.medicalEquipmentInSitu);
                        
                        
                       doc.text(20, pos+=10, 'gw714file:\t\t'+sceneData.gw714file);
                        
                        
                       doc.text(20, pos+=10, 'Names of doctors:\t\t'+sceneData.DrNames);
                        
                        
                       doc.text(20, pos+=10, 'Doctor Cell Number:\t\t'+sceneData.DrCellNumber);
                        
                        
                       doc.text(20, pos+=10, 'Nurses Names:\t\t'+sceneData.NurseNames);
                        
                        
                       doc.text(20, pos+=10, 'Nurse Cell Number:\t\t'+sceneData.NurseCellNumber);
                        
                        break;
                    default:
                        break;
    }
    // Output as Data URI
    doc.output('datauri');

    /*var pdf = new PDFObject({
        url: "Design Doc.pdf",
        id: "pdfRendered",
        pdfOpenParams: {
          view: "FitH"
        }
    }).embed("pdfRenderer");*/
}
function loadCases(){
    try{
        $(".response").remove();
        var query = new FormData();
        query.append("rquest","viewCases");
        query.append("category","all");
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            
            var obj = JSON.parse(request.responseText);
            var data = "";
            
            for(var i = 0; i < obj.length;i++)
            {
                data += "<tr class='appendCase'>";
                data += "<td>"+obj[i].caseNumber+"</td>";
                data += "<td>"+obj[i].sceneType+"</td>";
                data += "<td>"+obj[i].FOPersonelNumber+"</td>";
                var sid = obj[i].sceneID;
                
                data += "<td>"+"<a href='#' onclick='loadSceneInfo(this);' title='"+obj[i].sceneType+"' id='"+sid+"'>view</a>"+"</td>";
                data += "</tr>";
            }
            
            if(obj.length ==0){
                $(".noresult").remove();
                $("#cases").after("<span class='noresult'><br/>There are no cases available.</span>");
                $("#assignDR").attr("disabled","true");
                $("#print").attr("disabled","true");
            }else{
                $(".noresult").remove();
                $("#assignDR").removeAttr("disabled");
                $("#print").removeAttr("disabled");
            }
            $(".appendCase").remove();
            $("#cases .table-headers").after(data);
        }};

        
        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}

function searchUser(search){
    try{
        $(".response").remove();
        var query = new FormData();
        query.append("rquest","getUser");
        query.append("search",search);
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            
            var obj = JSON.parse(request.responseText);
            var data = "";
            
            for(var i = 0; i < obj.length;i++)
            {
                
                data += "<tr class='appendUser'>";
                data += "<td>"+obj[i].userName+"</td>";
                data += "<td>"+obj[i].userFirstname+"</td>";
                data += "<td>"+obj[i].userSurname+"</td>";
               
                var sid = obj[i].userID;
                //Add the delete.php to delete users by ID
                if(obj[i].userActive === "1")
                {
                    data += "<td>"+"<a href='#' onclick='deactivateUser(this);' title='"+obj[i].userName+"' id='"+sid+"'>Deactivate</a>"+"</td>";
                }else{
                    data += "<td>"+"<a href='#' onclick='activateUser(this);' title='"+obj[i].userName+"' id='"+sid+"'>Activate</a>"+"</td>";
                }
                data += "</tr>";
            }
            if(obj.length > 0){
                $(".appendUser").remove();
            }
            $("#users .table-headers").after(data);
        }};
        request.open("POST",URL);
        request.send(query);
    }catch(e){
        
    }
}

function searchCase(search){
    try{
        $(".response").remove();
        var query = new FormData();
        query.append("rquest","viewCases");
        query.append("category","search");
        query.append("m",search);
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            
            var obj = JSON.parse(request.responseText);
            var data = "";
            
            for(var i = 0; i < obj.length;i++)
            {
                data += "<tr class='appendCase'>";
                data += "<td>"+obj[i].caseNumber+"</td>";
                data += "<td>"+obj[i].sceneTypeDescription+"</td>";
                data += "<td>"+obj[i].FOPersonelNumber+"</td>";
                var sid = obj[i].sceneID;
                
                data += "<td>"+"<a href='#' onclick='loadSceneInfo(this);' title='"+obj[i].sceneTypeDescription+"' id='"+sid+"'>view</a>"+"</td>";
                data += "</tr>";
            }
            if(obj.length > 0){
                $(".appendCase").remove();
            }
            $("#cases .table-headers").after(data);
        }};


        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}
function searchAudit(search){
    try{
        $(".response").remove();
        var query = new FormData();
        query.append("rquest","findAudit");
        query.append("search",search);
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            var obj = JSON.parse(request.responseText);
            var data = "";
            
            for(var i = 0; i < obj.length;i++)
            {
                
               data += "<tr class='appendAudit'>";
                data += "<td>"+obj[i].username+"</td>";
                data += "<td>"+obj[i].audit_date+" "+obj[i].audit_time+"</td>";
                data += "<td>"+obj[i].audit_action+"</td>";
               
                var sid = obj[i].audit_id;
                
                data += "</tr>";
            }
            if(obj.length > 0){
                $(".appendAudit").remove();
            }
            $("#audit .table-headers").after(data);
        }};
        request.open("POST",URL);
        request.send(query);
    }catch(e){
        
    }
}

function getSceneTypeData(type,sceneData){
    var data = "<tr><td colspan='2' class='table-header'>"+type+" Information</td></tr>";
    
    switch (type) {
                    case "Foetus / Abandoned baby":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.babyIOType+"</td>";
                        data += "</tr>";
                        break;
                    case "Aviation accident":    
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.aviationOutsideType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Aircraft type:</td><td>"+sceneData.aircraftType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Number of people on aircraft:</td><td>"+sceneData.aircraftNumPeople+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Weather condition:</td><td>"+sceneData.weatherCondition+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Weather type:</td><td>"+sceneData.weatherType+"</td>";
                        data += "</tr>";
                        break;
                     case "Hanging":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.hangingIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Autoerotic Asphyxia?</td><td>"+sceneData.autoeroticAsphyxia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Partial hanging type:</td><td>"+sceneData.partialHangingType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Complete hanging?</td><td>"+sceneData.completeHanging+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was ligature around neck?</td><td>"+sceneData.ligatureAroundNeck+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Who removed ligature:</td><td>"+sceneData.whoRemovedLigature+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Ligature type:</td><td>"+sceneData.ligatureType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was strangulation suspected?</td><td>"+sceneData.strangulationSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was smothering suspected?</td><td>"+sceneData.smotheringSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was chocking suspected?</td><td>"+sceneData.chockingSuspected+"</td>";
                        data += "</tr>";
                        var inside = sceneData.hangingInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Bicycle accident":
                         data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.bicycleOutputType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Bicycle type:</td><td>"+sceneData.bicycleType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Number of people on bicycle:</td><td>"+sceneData.bicycleNumPeople+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Weather condition:</td><td>"+sceneData.weatherCondition+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Bicycle hit:</td><td>"+sceneData.bicycleHit+"</td>";
                        data += "</tr>";
                        break;
                    case "Blunt force injury/ assault":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.bluntIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Blunt force object suspected:</td><td>"+sceneData.bluntForceObjectSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the blunt force object still on scene?</td><td>"+sceneData.bluntForceObjectStillOnScene+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was it a community assult?</td><td>"+sceneData.wasCommunityAssult+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was strangulation suspected?</td><td>"+sceneData.strangulationSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was smothering suspected?</td><td>"+sceneData.smotheringSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was chocking suspected?</td><td>"+sceneData.chockingSuspected+"</td>";
                        data += "</tr>";
                        var inside = sceneData.bluntInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Burns":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.burnIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Accelerants at scene?</td><td>"+sceneData.accelerantsAtScene+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Accelerants used:</td><td>"+sceneData.accelerantsUsed+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Igniter at scene?</td><td>"+sceneData.igniterAtScene+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Igniter used:</td><td>"+sceneData.igniterUsed+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Foul play suspected?</td><td>"+sceneData.foulPlaySuspected+"</td>";
                        data += "</tr>";
                        var inside = sceneData.burnInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Crush injury":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.crushIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        var inside = sceneData.crushinjuryInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "deathregister":     
                        break;
                    case "Drowning":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.drowningIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drowning type:</td><td>"+sceneData.drowningType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        var inside = sceneData.drowningInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Lightning/ electrocution":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.electrocutionLightningIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any open wire?</td><td>"+sceneData.anyOpenWire+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the scene wet?</td><td>"+sceneData.sceneWet+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Debarking of trees?</td><td>"+sceneData.deBarkingOfTrees+"</td>";
                        data += "</tr>";
                        var inside = sceneData.electrocutionlightningInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Firearm discharge/  gunshot wound":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.firearmIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any gunshot wounds?</td><td>"+sceneData.gunshotWounds+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Where are the gunshot wounds located:</td><td>"+sceneData.gunshotWoundsLocation+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Where are the gunshot wounds area?</td><td>"+sceneData.gunshotWoundsArea+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the firearm on scene?</td><td>"+sceneData.firearmOnScene+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Accelerants used:</td><td>"+sceneData.accelerantsUsed+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Firearm calibre:</td><td>"+sceneData.firearmCalibre+"</td>";
                        data += "</tr>";
                        var inside = sceneData.firearmInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Fall/push/jump from height":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.heightIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Where did the victim fall from?</td><td>"+sceneData.fromWhat+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>How high was the fall?</td><td>"+sceneData.howHigh+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>On what did the victim land?</td><td>"+sceneData.onWhatVictimLanded+"</td>";
                        data += "</tr>";
                        var inside = sceneData.heightInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Gassing":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.gassingIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        var inside = sceneData.gassingInside;
                        var outside = sceneData.gassingOutside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Any gassing appliances?</td><td>"+inside.gassingAppliances+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Gassing aplliances used:</td><td>"+inside.gassingAppliancesUsed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was there a gassing smell?</td><td>"+inside.gassingSmell+"</td>";
                            data += "</tr>";
                        }else if(outside !== null){
                            data += "<tr>";
                            data += "<td>Was the victim inside a car?</td><td>"+inside.gassingVictimInCar+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Description of the scene inside the car:</td><td>"+inside.victimInCarDescription+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Ingestion/overdose /poisoning":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.ingestionOverdosePoisoningIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        var inside = sceneData.ingestionOverdosePoisoningInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Motor vehicle accident":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.mvaOutsideType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the victim found in car?</td><td>"+sceneData.victimFoundInCar+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Occupants:</td><td>"+sceneData.occupants+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Number of occupants:</td><td>"+sceneData.numberOfOccupants+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Victim was:</td><td>"+sceneData.victimWas+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Car was hit from:</td><td>"+sceneData.carWasHitFrom+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Victim Type:</td><td>"+sceneData.victimType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the car burnt?</td><td>"+sceneData.carBurnt+"</td>";
                        data += "</tr>"
                        break;
                    case "Motorbike accident":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.mbaOutsideType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the victim wearing protective clothing?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Victims on motorcycle?</td><td>"+sceneData.victimsOnMotorcycle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Where was the motorbike hit from?</td><td>"+sceneData.motorbikeHitFrom+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Type of accident:</td><td>"+sceneData.typeOfAccident+"</td>";
                        data += "</tr>";
                        break;
                    case "Pedestrian vehicle accident":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.perdestrianOutsideType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was it a hit and run?</td><td>"+sceneData.hitAndRun+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Pedestrian type:</td><td>"+sceneData.pedestrianType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Number of cars drove over the body:</td><td>"+sceneData.numberOfCarsDroveOverBody+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Victim was:</td><td>"+sceneData.victimWas+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Weather condition type:</td><td>"+sceneData.weatherConditionType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Weather condition:</td><td>"+sceneData.weatherCondition+"</td>";
                        data += "</tr>";
                        break;
                    case "Railway accident":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.railwayIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Victim type:</td><td>"+sceneData.victimType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Railway type:</td><td>"+sceneData.railwayType+"</td>";
                        data += "</tr>";
                        break;
                    case "Sharp force injury/ stab injury":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.sharpIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the sharp object at scene?</td><td>"+sceneData.sharpObjectAtScene+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>What are the sharp force injuries of victim?</td><td>"+sceneData.sharpForceInjuries+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>The injury:</td><td>"+sceneData.theInjury+"</td>";
                        data += "</tr>";
                        var inside = sceneData.sharpInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Sudden unexpected death of an infant (SUDI)":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.sidIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Resuscitation attemped?</td><td>"+sceneData.resuscitationAttemped+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the infant sick lately?</td><td>"+sceneData.infantSickLately+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Description of infant sickness:</td><td>"+sceneData.infantSickLatelyDescription+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the infant on medication?</td><td>"+sceneData.infantOnMedication+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any falls or inury experience?</td><td>"+sceneData.fallsOrInjuryExperience+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>What was the infant wearing?</td><td>"+sceneData.infantWearing+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was the infant tightly wrapped?</td><td>"+sceneData.infantTightlyWrapped+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Bedding over infant?</td><td>"+sceneData.beddingOverInfant+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Date and time last placed:</td><td>"+sceneData.dateAndTimeLastPlaced+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Date and time death discovered:</td><td>"+sceneData.dateAndTimeDeathDiscovered+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Date and time last seen alive:</td><td>"+sceneData.dateAndTimeLastSeenAlive+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any SID deaths?</td><td>"+sceneData.anySIDSdeaths+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Photo after body removed:</td><td>"+sceneData.photoAfterBodyRemoved+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Infant last placed:</td><td>"+sceneData.infantLastPlaced+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Infant last seen alive:</td><td>"+sceneData.infantLastSeenAlive+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Where was the infant found dead?</td><td>"+sceneData.whereInfantFoundDead+"</td>";
                        data += "</tr>";
                        break;
                    case "Sudden unexpected death of an adult/ found dead":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.sudaIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was strangulation suspected?</td><td>"+sceneData.strangulationSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was smothering suspected?</td><td>"+sceneData.smotheringSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was chocking suspected?</td><td>"+sceneData.chockingSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Appliances?</td><td>"+sceneData.sudaAppliances+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was there a weird smell in the air?</td><td>"+sceneData.wierdSmellInAir+"</td>";
                        data += "</tr>";
                        
                        var inside = sceneData.sudaInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Sudden unexpected death of a child  (1 – 18 years)":
                        data += "<tr>";
                        data += "<td>Where did the scene take place?</td><td>"+sceneData.sudcIOType+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Any signs of struggle?</td><td>"+sceneData.signsOfStruggle+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was an alcohol bottle around?</td><td>"+sceneData.alcoholBottleAround+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Drug Paraphernalia?</td><td>"+sceneData.drugParaphernalia+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was strangulation suspected?</td><td>"+sceneData.strangulationSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was smothering suspected?</td><td>"+sceneData.smotheringSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was chocking suspected?</td><td>"+sceneData.chockingSuspected+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Appliances?</td><td>"+sceneData.sudaAppliances+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Was there a weird smell in the air?</td><td>"+sceneData.wierdSmellInAir+"</td>";
                        data += "</tr>";
                        
                        var inside = sceneData.sudcInside;
                        if(inside !== null)
                        {
                            data += "<tr>";
                            data += "<td>Was the door locked?</td><td>"+inside.doorLocked+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows closed?</td><td>"+inside.windowsClosed+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the windows broken?</td><td>"+inside.windowsBroken+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Was the victim alone?</td><td>"+inside.victimAlone+"</td>";
                            data += "</tr>";
                            data += "<tr>";
                            data += "<td>Who was with the victim?</td><td>"+inside.peopleWithVictim+"</td>";
                            data += "</tr>";
                        }
                        break;
                    case "Section 48  death –surgical case":
                        data += "<tr>";
                        data += "<td>Was the victim hospitalized?</td><td>"+sceneData.victimHospitalized+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Medical equipment in situ?</td><td>"+sceneData.medicalEquipmentInSitu+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>gw714file:</td><td>"+sceneData.gw714file+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Names of doctors:</td><td>"+sceneData.DrNames+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Doctor Cell Number:</td><td>"+sceneData.DrCellNumber+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Nurses Names:</td><td>"+sceneData.NurseNames+"</td>";
                        data += "</tr>";
                        data += "<tr>";
                        data += "<td>Nurse Cell Number:</td><td>"+sceneData.NurseCellNumber+"</td>";
                        data += "</tr>";
                        break;
                    default:
                        break;
    }
    return data;
}

function loadUsers(){
    try{
        $(".response").remove();
        var query = new FormData();
        query.append("rquest","users");
        query.append("utype","all");
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            
            var obj = JSON.parse(request.responseText);
            var data = "";
            for(var i = 0; i < obj.count;i++)
            {
                data += "<tr class='appendUser'>";
                data += "<td>"+obj[i].userName+"</td>";
                data += "<td>"+obj[i].userFirstname+"</td>";
                data += "<td>"+obj[i].userSurname+"</td>";
               // data += "<td>"+obj[i].userTypeDescription+"</td>";
                var sid = obj[i].userID;
                //Add the delete.php to delete users by ID
                if(obj[i].userActive === "1")
                {
                    data += "<td>"+"<a href='#' onclick='deactivateUser(this);' title='"+obj[i].userName+"' id='"+sid+"'>Deactivate</a>"+"</td>";
                }else{
                    data += "<td>"+"<a href='#' onclick='activateUser(this);' title='"+obj[i].userName+"' id='"+sid+"'>Activate</a>"+"</td>";
                }
                data += "</tr>";
            }
            $(".appendUser").remove();
            $("#users .table-headers").after(data);
        }};


        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}

function loadAuditLog(){
    try{
        $(".response").remove();
        var query = new FormData();
        query.append("rquest","getAudit");
        query.append("platform","webapp");
        
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            
            var obj = JSON.parse(request.responseText);
            
            var data = "";
            for(var i = 0; i < obj.length;i++)
            {
                data += "<tr class='appendAudit'>";
                data += "<td>"+obj[i].username+"</td>";
                data += "<td>"+obj[i].audit_date+" "+obj[i].audit_time+"</td>";
                data += "<td>"+obj[i].audit_action+"</td>";
               // data += "<td>"+obj[i].userTypeDescription+"</td>";
                var sid = obj[i].audit_id;
                
                data += "</tr>";
            }
            $(".appendAudit").remove();
            $("#audit .table-headers").after(data);
        }};


        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}

function logout(){
    var query = new FormData();
    query.append("rquest","logout");
    query.append("platform","webapp");
    var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
       
        document.location.href = LOGIN_PAGE;
    }};
    
    
    request.open("POST",URL);
    
    request.send(query);
   
}

function login(username,pass){
    var query = new FormData();
    
    
    query.append("rquest","login");
    query.append("username",username);
    query.append("password",pass);
    query.append("platform","webapp");
    /*
    $.ajax({
     url: URL,
     type: "POST",
     data: query,
     processData: false,  // tell jQuery not to process the data
     contentType: false,   // tell jQuery not to set contentType
     success:function(result){
         //alert(result.responseText);
         var obj = JSON.parse(result.responseText);
           if(obj.status === "Success"){
               document.location = "main.php";
           }else{
               $("#login-form").before("<div class='response error'>"+obj.msg+"<br/><br/></div>")
           }
     },
     error:function(result){
         //alert(result.responseText);
         var obj = JSON.parse(result.responseText);
           if(obj.status === "Success"){
               document.location = "main.php";
           }else{
               $("#login-form").before("<div class='response error'>"+obj.msg+"<br/><br/></div>")
           }
     }
   });*/
   var request = new XMLHttpRequest();
   request.onreadystatechange = function(){if(request.readyState == 4)
    {
       
        var obj = JSON.parse(request.responseText);
           if(obj.status === "Success"){
               document.location = "main.php";
           }else{
               $("#login-form").before("<div class='response error'>"+obj.msg+"<br/><br/></div>")
           }
    }};
    
    
    request.open("POST",URL);
    
    request.send(query);
}

function passwordCheck(pword1, pword2) {
	if (pword1.length<8 || pword2.length<8) {
            alertResponse("Password must be at least 8 characters long!","error");
            return false;
	}
	if (pword1 != pword2) {
            alertResponse("Passwords do not match!","error");
            return false;
	}
	return true;
 }
 
function getUserForm(){
    var combobox = document.getElementById("userType").options[document.getElementById("userType").selectedIndex].value;
    //alert(form["userType"].options[form["userType"].selectedIndex].value);
    $("#removeTr").remove();
    if(combobox==="Forensic practitioner")
    {
        $(".table tr:last").before("<tr id='removeTr'><td>Cell phone number: <br/><input class='formInput' placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></td></tr>");
        
    }else if(combobox==="Forensic officer")
    {
        $(".table tr:last").before("<tr id='removeTr'><td>Cell phone number: <br/><input class='formInput' placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></td></tr>");
    }else if(combobox==="Student")
    {
        $(".table tr:last").before("<tr id='removeTr'><td>Cell phone number: <br/><input class='formInput' placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></td></tr>");
    }else if(combobox==="Guest")
    {
       $(".table tr:last").before("<tr id='removeTr'><td>Cell phone number: <br/><input class='formInput' placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></td></tr>");
    }else if(combobox==="Forensic practitioner/Administrator")
    {
       $(".table tr:last").before("<tr id='removeTr'><td>Cell phone number: <br/><input class='formInput' placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></td></tr>");
    }  
}

function addUser(name,pass,firstname,surname,combobox,cell){
    var query = new FormData();
    query.append("rquest","addUser");
    if(combobox==="Administrator")
    {
        query.append("utype","admin");
        
    }else if(combobox==="Forensic practitioner")
    {
        query.append("utype","fp");
        query.append("cellphoneNumber",cell);
    }else if(combobox==="Forensic officer")
    {
        query.append("utype","fo");
        
    }else if(combobox==="Student")
    {
        query.append("utype","student");
    }else if(combobox==="Guest")
    {
        query.append("utype","guest");
    }else if(combobox==="Forensic practitioner/Administrator")
    {
        
        query.append("utype","afp");
        query.append("cellphoneNumber",cell);
    } 
    query.append("userName",name);
    query.append("userPassword",pass);
    query.append("userFirstname",firstname);
    query.append("userSurname",surname);
    
    /*$.ajax({
     url: URL,
     type: "POST",
     data: query,
     processData: false,  // tell jQuery not to process the data
     contentType: false,   // tell jQuery not to set contentType
     success:function(result){
         addUserResponse(result);
     },
     error:function(result){
         addUserResponse(result);
     }
   });*/
   var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
            addUserResponse(request);
            
    }};
    
    
    request.open("POST",URL);
    request.send(query);
    
}
function alertResponse(message,status){
    $(".response").remove();
    $(".main").after("<div class='response "+status+"'></div>");
    $(".response").html(message);
}

function decodeMessage(message){
    try{
        var obj = JSON.parse(message);
        
        if(obj.status === "Failed")
        {
            return "<p class='error'>"+obj.msg+"</p>";
        }else if(obj.status === "Success")
        {
            return "<p class='success'>"+obj.msg+"</p>";
        }else if(obj.rtype === "users"){
            var content = "<table>";
            
            for(var i = 0; i < obj.count;i++){
                content += "<tr><td>"+obj[i].userName+"</td></tr>";
            }
            
            content += "</table>";
            return content;
        }else if(obj.rtype === "student"){
            var content = "<table>";
            
            for(var i = 0; i < obj.count;i++){
                content += "<tr><td>"+obj[i].userData.userName+"</td></tr>";
            }
            
            content += "</table>";
            return content;
        }else if(obj.rtype === "administrator"){
            var content = "<table>";
            
            for(var i = 0; i < obj.count;i++){
                content += "<tr><td>"+obj[i].userData.userName+"</td></tr>";
            }
            
            content += "</table>";
            return content;
        }
    }catch (e){
        
    }
}

function sendRequest(data){
                
    var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
        
    }};
    
    
    request.open("POST",URL);
    
    request.send(data);
    
}

function addUserResponse(req){
    var a = req.responseText;
    
    var obj = JSON.parse(a);
    if(obj.status === "Failed")
    {
        alertResponse(obj.msg,"error");
    }else{
        alertResponse(obj.msg,"success");
    }
   
}

function deactivateUser(link){
    var query = new FormData();
    query.append("rquest","removeUser");
    query.append("userID",link.id);
    $.ajax({
     url: URL,
     type: "POST",
     data: query,
     processData: false,  // tell jQuery not to process the data
     contentType: false,   // tell jQuery not to set contentType
     success:function(result){
            searchUser(link.title);
     },
     error:function(result){
         searchUser(link.title);
     }
   });
}

function activateUser(link){
    var query = new FormData();
    query.append("rquest","activateUser");
    query.append("userID",link.id);
    $.ajax({
     url: URL,
     type: "POST",
     data: query,
     processData: false,  // tell jQuery not to process the data
     contentType: false,   // tell jQuery not to set contentType
     success:function(result){
         searchUser(link.title);
     },
     error:function(result){
         searchUser(link.title);
     }
   });
}

 function assignDeathRegister(dr){
     if(currentCaseNumber > 0)
     {
        var query = new FormData();
        query.append("rquest","addCase");
        query.append("category","deathregister");
        query.append("dr",dr);
        query.append("cn",currentCaseNumber);
        
         var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
                //alert(request.responseText);

        }};


        request.open("POST",URL);
        request.send(query);
   }
 }           