
var URL = "models/webapi.php";
var LOGIN_PAGE = "/webapp/";
var caseList = new Object();
var victim_count = 0;
var currentCaseNumber = -1;
var currentCase = null;
var currentSceneType = null;

$(document).ready(function(p){
    showPage(1);
    $("#pdfView").hide();
          $(".sceneView").show();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };
    $("#loginButton").click(function(){
        login(); 
    });
    
    $("input").focus(function(){
        $(".response").remove();
    });
    
    $(".pages").click(function(){
        showPage($(this).attr("id"));
    });
    
    $(".listUsers").click(function(){
        $(".response").remove();    
        getUsers();
        $("#page-heading").html("User Information");
    });
    
    $(".listCases").click(function(){
        
        $(".response").remove();
        getCases();
        $("#page-heading").html("Cases");
    });
    
    $(".listAudit").click(function(){
        $(".response").remove();
        getAuditLog();
        $("#page-heading").html("Audit log");
    });
    
    $("#userSearch").change(function(){
        
        var searchValue = $(this).val();
        if(searchValue !== "" && searchValue !== undefined)
        {
            findUser(searchValue);
        }
    });
    
    $("#caseSearch").change(function(){
        
        var searchValue = $(this).val();
        if(searchValue !== "" && searchValue !== undefined)
        {
            findCase(searchValue);
        }
    });
    
    $("#auditSearch").change(function(){
        
        var searchValue = $(this).val();
        if(searchValue !== "" && searchValue !== undefined)
        {
            findAudit(searchValue);
        }
    });
    
    $("form label input").focus(function(){
        $(this).css("border","1px solid inherit");
    });
    
    $("#addUserButton").click(function(){
        //p.preventDefault();
        
        var name = document.getElementById("name").value;
        var pass = document.getElementById("pass").value;
        var cpass = document.getElementById("cpass").value;
        var firstname = document.getElementById("firstname").value;
        
        var surname = document.getElementById("surname").value;
        
        var combobox = document.getElementById("userType").options[document.getElementById("userType").selectedIndex].value;
        
         if(name !== "" && pass !== "" && cpass !== "" && firstname !== "" && surname !== "" && combobox !== ""){
             if(!passwordCheck(pass,cpass)){
                 return;
             }
             if(combobox !== "Administrator")
             {
                 var cell = document.getElementById("cellphone").value;
                 if(cell !== "" && cell !== undefined)
                 {
                    addUser(name,pass,firstname,surname,combobox,cell);
                 }else{
                     alertResponse("Please fill in all fields.","error");
                     highlightErrorFields();
                 }
             }else{
                 addUser(name,pass,firstname,surname,combobox,null);
             }
         }else{
             
             alertResponse("Please fill in the  missing information","error");
             highlightErrorFields();
         }
         
    });
    
    
    
    $('#print').click(function () {
        
       
       var doc = new jsPDF();

                    // We'll make our own renderer to skip this editor
                    var specialElementHandlers = {
                            '#editor': function(element, renderer){
                                    return true;
                            }
                    };

                    // All units are in the set measurement for the document
                    // This can be changed to "pt" (points), "mm" (Default), "cm", "in"

                    doc.fromHTML($("#tables").get(0), 15, 15, {
                            'width': 170, 
                            'elementHandlers': specialElementHandlers
                    });
          $("#pdfView").show();
          $(".sceneView").hide();
          $("#downloadPdf").remove();
          
          $("#pdfView").before("<a id='downloadPdf' href='"+doc.output('datauristring')+"' class='btn-lg'>Download</a>");
         $("#viewer").attr("src",doc.output('datauristring'));
    });
    
    $('#printAudit').click(function () {
        
       
       var doc = new jsPDF();

                    // We'll make our own renderer to skip this editor
                    var specialElementHandlers = {
                            '#editor': function(element, renderer){
                                    return true;
                            }
                    };

                    // All units are in the set measurement for the document
                    // This can be changed to "pt" (points), "mm" (Default), "cm", "in"

                    doc.fromHTML($("#audits").get(0), 15, 15, {
                            'width': 170, 
                            'elementHandlers': specialElementHandlers
                    });
          
         
         $("#auditPdf").attr("src",doc.output('datauristring'));
    });
    
    $("#close").click(function(){
        $("#pdfView").hide();
          $(".sceneView").show();
    });
    
    $("#logout").click(function(){
        logout();
    });
    p.preventDefault();
});


function login(){
    
    var username = document.getElementById("username");
    var pass = document.getElementById("password");
    
    if(username.value !== "" && pass.value !== "")
    { 
        var query = new FormData();
        query.append("rquest","login");
        query.append("username",username.value);
        query.append("password",pass.value);
        query.append("platform","webapp");
        
        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){if(request.readyState == 4)
         {
             var obj = JSON.parse(request.responseText);
                if(obj.status === "Success"){
                    document.location = "main.php";
                }else{
                    alertResponse(obj.msg,"error");
                }
         }};
         request.open("POST",URL);
         request.send(query);
    }
    else{
        alertResponse("Please fill all fields.","error");
    }
    
}

function alertResponse(message,status){
    $(".response").remove();
    $("hr").after("<div class='response "+status+"'></div>");
    $(".response").html(message);
}

function hidePages(){
    $(".page").hide();
}
function showPage(page){
    hidePages();
    $("#Page"+page).show();
}

function runMe(){
    getCases();
    getUsers();
    getAuditLog();
}


function getCases(){
   
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
                $(".case-table").after("<tr class='noresult'><td colspan='4'>There are no cases available.</td></tr>");
                $("#assignDR").attr("disabled","true");
                $("#print").attr("disabled","true");
            }else{
                $(".noresult").remove();
                $("#assignDR").removeAttr("disabled");
                $("#print").removeAttr("disabled");
            }
            $(".appendCase").remove();
            $(".case-table").html(data);
        }};

        
        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}
function getUsers(){
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
            
            $(".user-table").html(data);
        }};


        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}
function getAuditLog(){
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
            $(".audit-table").html(data);
        }};


        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}
function loadSceneInfo(view){
    $("#pdfView").hide();
    $(".sceneView").show();
    $("#downloadPdf").remove();
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
            
            var location = JSON.parse(obj.sceneLocation);
            var locations = JSON.parse(location.Location);
            
            data += "<tr>";
            data += "<td>Time of scene:</td><td>"+obj.sceneTime+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Date of scene:</td><td>"+obj.sceneDate+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Location of scene:</td><td>"+locations.Address+", Latitude:"+locations.Latitude+", Longitude:"+locations.Longitude+"</td>";
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
            
            $(".sceneInfo-table").html(data);
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

function findUser(search){
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
            $(".user-table").html(data);
        }};
        request.open("POST",URL);
        request.send(query);
    }catch(e){
        
    }
}
function findCase(search){
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
            $(".case-table").after(data);
        }};


        request.open("POST",URL);

        request.send(query);
    }catch(e){
        
    }
}
function findAudit(search){
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
            $(".audit-table").html(data);
        }};
        request.open("POST",URL);
        request.send(query);
    }catch(e){
        
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
            findUser(link.title);
     },
     error:function(result){
         findUser(link.title);
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
         findUser(link.title);
     },
     error:function(result){
         findUser(link.title);
     }
   });
}

function getSceneTypeData(type,sceneData){
    var data = "<tr><td colspan='2' class='table-header'>"+type+" Information</td></tr>";
    var foetusDesc = ["Where did the scene take place?"];
    var foetusValue = [sceneData.babyIOType];
    
    var aviationDesc = ["Where did the scene take place?","Aircraft type:","Number of people on aircraft:",
    "Weather condition:","Weather type:"];
    var aviationValue = [sceneData.aviationOutsideType,sceneData.aircraftType,sceneData.aircraftNumPeople,
    sceneData.weatherCondition,sceneData.weatherType];
    
    var hangingDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Autoerotic Asphyxia?","Partial hanging type:","Complete hanging?","Was ligature around neck?",
    "Who removed ligature:","Ligature type:","Was strangulation suspected?","Was smothering suspected?",
    "Was chocking suspected?","Was the door locked?","Was the windows closed?","Was the windows broken?",
    "Was the victim alone?","Who was with the victim?"];
    var hangingValue = [sceneData.hangingIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.autoeroticAsphyxia,sceneData.partialHangingType,sceneData.completeHanging,
        sceneData.ligatureAroundNeck,sceneData.whoRemovedLigature,sceneData.ligatureType,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    
    var bicycleDesc = ["Where did the scene take place?","Bicycle type:","Number of people on bicycle:",
    "Weather condition:","Bicycle hit:"];
    var bicycleValue = [sceneData.bicycleOutputType,sceneData.bicycleType,sceneData.bicycleNumPeople,
    sceneData.weatherCondition,sceneData.bicycleHit];

    var bluntDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Blunt force object suspected:","Was the blunt force object still on scene?",
    "Was it a community assult?","Was strangulation suspected?","Was smothering suspected?",
    "Was chocking suspected?","Was the door locked?","Was the windows closed?","Was the windows broken?",
    "Was the victim alone?","Who was with the victim?"];
    var bluntValue = [sceneData.bluntIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.bluntForceObjectSuspected,sceneData.bluntForceObjectStillOnScene,
    sceneData.wasCommunityAssult,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    
    var burnDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Accelerants at scene?","Accelerants used:","Igniter at scene?","Igniter used:",
    "Foul play suspected?","Was the door locked?","Was the windows closed?","Was the windows broken?",
    "Was the victim alone?","Who was with the victim?"];
    var burnValue = [sceneData.burnIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.accelerantsAtScene,sceneData.accelerantsUsed,sceneData.igniterAtScene,
    sceneData.igniterUsed,sceneData.foulPlaySuspected,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    
    var crushDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the body moved?","Crush between which objects?","Was there any witnesses?",
    "What was the victim doing?","Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    var crushValue = [sceneData.crushIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.wasBodyMoved,sceneData.betweenWhichObjects,sceneData.anyWitness,
        sceneData.whatWasVictimDoing,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    
    var drowningDesc = ["Where did the scene take place?","Drowning type:","Any signs of struggle?",
    "Was an alcohol bottle around?","Drug Paraphernalia?","Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    var drowningValue = [sceneData.drowningIOType,sceneData.drowningType,sceneData.signsOfStruggle,
        sceneData.alcoholBottleAround,sceneData.drugParaphernalia,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    
    var lightningDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Any open wire?","Was the scene wet?","Debarking of trees?","Was the door locked?",
    "Was the windows closed?","Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    var lightningValue = [sceneData.crushIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.anyOpenWire,sceneData.sceneWet,sceneData.deBarkingOfTrees,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    
    var firearmDesc = ["Where did the scene take place?","Any gunshot wounds?","Where are the gunshot wounds located:",
    "Where are the gunshot wounds area?","Was the firearm on scene?","Accelerants used:","Firearm calibre:",
    "Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    var firearmValue = [sceneData.firearmIOType,sceneData.gunshotWounds,sceneData.gunshotWoundsLocation,
        sceneData.gunshotWoundsArea,sceneData.firearmOnScene,sceneData.accelerantsUsed,sceneData.firearmCalibre,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    
    var heightDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Where did the victim fall from?","How high was the fall?","On what did the victim land?",
    "Was the door locked?","Was the windows closed?","Was the windows broken?","Was the victim alone?",
    "Who was with the victim?"];
    var heightValue = [sceneData.heightIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.fromWhat,sceneData.howHigh,sceneData.onWhatVictimLanded,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    
    var gassingDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the door locked?","Was the windows closed?","Was the windows broken?","Was the victim alone?",
    "Who was with the victim?","Any gassing appliances?","Gassing aplliances used:","Was there a gassing smell?",
    "Was the victim inside a car?","Description of the scene inside the car:"];
    var gassingValue = [sceneData.sceneData.gassingIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,
        inside.peopleWithVictim,inside.gassingAppliances,inside.gassingAppliancesUsed,inside.gassingSmell,
        inside.gassingVictimInCar,inside.victimInCarDescription];
    
    var ingestionDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    var ingestionValue = [sceneData.ingestionOverdosePoisoningIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    
    var mvaDesc = ["Where did the scene take place?","Was the victim found in car?","Occupants:",
        "Number of occupants:","Victim was:","Car was hit from:","Victim Type:","Was the car burnt?"];
    var mvaValue = [sceneData.mvaOutsideType,sceneData.victimFoundInCar,sceneData.occupants,
    sceneData.numberOfOccupants,sceneData.victimWas,sceneData.carWasHitFrom,sceneData.victimType,sceneData.carBurnt];
    
    var mbaDesc = ["Where did the scene take place?","Was the victim wearing protective clothing?",
        "Victims on motorcycle?","Where was the motorbike hit from?","Type of accident:"];
    var mbaValue = [sceneData.mbaOutsideType,sceneData.signsOfStruggle,sceneData.victimsOnMotorcycle,
        sceneData.motorbikeHitFrom,sceneData.typeOfAccident];
    
    var pedestrianDesc = ["Where did the scene take place?","Was it a hit and run?","Pedestrian type:",
        "Number of cars drove over the body:","Victim was:","Weather condition type:",
        "Weather condition:"];
    var pedestrianValue = [sceneData.perdestrianOutsideType,sceneData.hitAndRun,sceneData.pedestrianType,
        sceneData.numberOfCarsDroveOverBody,sceneData.victimJumped,sceneData.weatherType,
        sceneData.weatherCondition];
    
    var railwayDesc = ["Where did the scene take place?","Victim type:","Railway type:"];
    var railwayValue = [sceneData.railwayIOType,sceneData.victimType,sceneData.railwayType];
    
    var sharpDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the sharp object at scene?",
    "What are the sharp force injuries of victim?","The injury:",
    "Was the door locked?","Was the windows closed?","Was the windows broken?","Was the victim alone?",
    "Who was with the victim?"];
    var sharpValue = [sceneData.sharpIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.sharpObjectAtScene,sceneData.sharpForceInjuries,sceneData.theInjury,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    
    var sudiDesc = ["Where did the scene take place?","Resuscitation attemped?","Was the infant sick lately?",
        "Description of infant sickness:","Was the infant on medication?","Any falls or inury experience?",
        "What was the infant wearing?","Was the infant tightly wrapped?","Bedding over infant?","Date and time last placed:",
        "Date and time death discovered:","Date and time last seen alive:","Any SID deaths?",
        "Photo after body removed:","Infant last placed:","Infant last seen alive:","Where was the infant found dead?"];
    var sudiValue = [sceneData.sidIOType,sceneData.resuscitationAttemped,sceneData.infantSickLately
        ,sceneData.infantSickLatelyDescription,sceneData.infantOnMedication,sceneData.fallsOrInjuryExperience,
        sceneData.infantWearing,sceneData.infantTightlyWrapped,sceneData.beddingOverInfant,sceneData.dateAndTimeLastPlaced,
        sceneData.dateAndTimeDeathDiscovered,sceneData.dateAndTimeLastSeenAlive,sceneData.anySIDSdeaths,
        sceneData.photoAfterBodyRemoved,sceneData.infantLastPlaced,sceneData.infantLastSeenAlive,
        sceneData.whereInfantFoundDead];
    
    var sudaDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was strangulation suspected?","Was smothering suspected?",
    "Was chocking suspected?","Appliances?","Was there a weird smell in the air?"];
    var sudaValue = [sceneData.sudaIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,sceneData.sudaAppliances,sceneData.wierdSmellInAir,
    inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    
    var sudcDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was strangulation suspected?","Was smothering suspected?",
    "Was chocking suspected?","Appliances?","Was there a weird smell in the air?"];
    var sudcValue =[sceneData.sudcIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,sceneData.sudcAppliances,sceneData.wierdSmellInAir,
    inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    
    var sec48Desc = ["Was the victim hospitalized?","Medical equipment in situ?","gw714file:",
        "Names of doctors:","Doctor Cell Number:","Nurses Names:","Nurse Cell Number:","Hospital name:",
        "Who removed equipment?","Is gw7_24 file fully complete?","Any medical records?",
        "Importantinformation from medical staff:"];
    var sec48Value = [sceneData.victimHospitalized,sceneData.medicalEquipmentInSitu,sceneData.gw7_24file,
        sceneData.DrNames,sceneData.DrCellNumber,sceneData.NurseNames,sceneData.NurseCellNumber,sceneData.hospitalName,
        sceneData.whoRemovedEquipment,sceneData.gw7_24fileFullyComplete,sceneData.medicalRecords,
        sceneData.importantInfoFromMedicalStuff];
    
    
    switch (type) {
                    case "Foetus / Abandoned baby":
                        for(var i = 0;i < foetusDesc.length;i++)
                        {
                            if(foetusValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+foetusDesc[i]+"</td><td>"+foetusValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Aviation accident":    
                        for(var i = 0;i < aviationDesc.length;i++)
                        {
                            if(aviationValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+aviationDesc[i]+"</td><td>"+aviationValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                     case "Hanging":
                        var inside = sceneData.hangingInside;
                        for(var i = 0;i < hangingDesc.length;i++)
                        {
                            if(hangingValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+hangingDesc[i]+"</td><td>"+hangingValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Bicycle accident":
                       
                        for(var i = 0;i < bicycleDesc.length;i++)
                        {
                            if(bicycleValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+bicycleDesc[i]+"</td><td>"+bicycleValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Blunt force injury/ assault":
                        
                        var inside = sceneData.bluntInside;
                        for(var i = 0;i < bluntDesc.length;i++)
                        {
                            if(bluntValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+bluntDesc[i]+"</td><td>"+bluntValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Burns":
                        
                        var inside = sceneData.burnInside;
                        for(var i = 0;i < burnDesc.length;i++)
                        {
                            if(burnValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+burnDesc[i]+"</td><td>"+burnValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Crush injury":
                        
                        var inside = sceneData.crushinjuryInside;
                        for(var i = 0;i < crushDesc.length;i++)
                        {
                            if(crushValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+crushDesc[i]+"</td><td>"+crushValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "deathregister":     
                        break;
                    case "Drowning":
                        
                        var inside = sceneData.drowningInside;
                        for(var i = 0;i < drowningDesc.length;i++)
                        {
                            if(drowningValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+drowningDesc[i]+"</td><td>"+drowningValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Lightning/ electrocution":
                       
                        var inside = sceneData.electrocutionlightningInside;
                       for(var i = 0;i < lightningDesc.length;i++)
                        {
                            if(lightningValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+lightningDesc[i]+"</td><td>"+lightningValue[i]+"</td>";
                                data += "</tr>";
                            }
                        } 
                        break;
                    case "Firearm discharge/  gunshot wound":
                        
                        var inside = sceneData.firearmInside;
                       for(var i = 0;i < firearmDesc.length;i++)
                        {
                            if(firearmValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+firearmDesc[i]+"</td><td>"+firearmValue[i]+"</td>";
                                data += "</tr>";
                            }
                        } 
                        break;
                    case "Fall/push/jump from height":
                        
                        var inside = sceneData.heightInside;
                        for(var i = 0;i < heightDesc.length;i++)
                        {
                            if(heightValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+heightDesc[i]+"</td><td>"+heightValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Gassing":
                        
                        var inside = sceneData.gassingInside;
                        for(var i = 0;i < gassingDesc.length;i++)
                        {
                            if(gassingValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+gassingDesc[i]+"</td><td>"+gassingValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        
                        break;
                    case "Ingestion/overdose /poisoning":
                        
                        var inside = sceneData.ingestionOverdosePoisoningInside;
                        for(var i = 0;i < ingestionDesc.length;i++)
                        {
                            if(ingestionValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+ingestionDesc[i]+"</td><td>"+ingestionValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Motor vehicle accident":
                        for(var i = 0;i < mvaDesc.length;i++)
                        {
                            if(mvaValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+mvaDesc[i]+"</td><td>"+mvaValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Motorbike accident":
                        for(var i = 0;i < mbaDesc.length;i++)
                        {
                            if(mvaValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+mbaDesc[i]+"</td><td>"+mbaValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Pedestrian vehicle accident":
                        for(var i = 0;i < pedestrianDesc.length;i++)
                        {
                            if(pedestrianValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+pedestrianDesc[i]+"</td><td>"+pedestrianValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Railway accident":
                       for(var i = 0;i < railwayDesc.length;i++)
                        {
                            if(railwayValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+railwayDesc[i]+"</td><td>"+railwayValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Sharp force injury/ stab injury":
                        for(var i = 0;i < sharpDesc.length;i++)
                        {
                            if(sharpValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+sharpDesc[i]+"</td><td>"+sharpValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        var inside = sceneData.sharpInside;
                        
                        break;
                    case "Sudden unexpected death of an infant (SUDI)":
                        for(var i = 0;i < sudiDesc.length;i++)
                        {
                            if(sudiValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+sudiDesc[i]+"</td><td>"+sudiValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Sudden unexpected death of an adult/ found dead":
                        var inside = sceneData.sudaInside;
                        for(var i = 0;i < sudaDesc.length;i++)
                        {
                            if(sudaValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+sudaDesc[i]+"</td><td>"+sudaValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        
                        
                        break;
                    case "Sudden unexpected death of a child  (1 – 18 years)":
                        
                        var inside = sceneData.sudcInside;
                        for(var i = 0;i < sudcDesc.length;i++)
                        {
                            if(sudcValue[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+sudcDesc[i]+"</td><td>"+sudcValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Section 48  death –surgical case":
                        for(var i = 0;i < sec48Desc.length;i++)
                        {
                            if(sec48Value[i] !== "null")
                            {
                                data += "<tr>";
                                data += "<td>"+sec48Desc[i]+"</td><td>"+sec48Value[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    default:
                        break;
    }
    return data;
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
         $("#addUserButton").before("<label for='cellphone' id='removeTr'><span>Cell phone number: </span><input  placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></label>");
        
    }else if(combobox==="Forensic officer")
    {
         $("#addUserButton").before("<label for='cellphone' id='removeTr'><span>Cell phone number: </span><input  placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></label>");
    }else if(combobox==="Student")
    {
         $("#addUserButton").before("<label for='cellphone' id='removeTr'><span>Cell phone number: </span><input  placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></label>");
    }else if(combobox==="Guest")
    {
        $("#addUserButton").before("<label for='cellphone' id='removeTr'><span>Cell phone number: </span><input  placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></label>");
    }else if(combobox==="Forensic practitioner/Administrator")
    {
       $("#addUserButton").before("<label for='cellphone' id='removeTr'><span>Cell phone number </span><input  placeholder='cellphone' type='tel' id='cellphone' name='cellphone'/></label>");
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
    
   var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
        addUserResponse(request);
            
    }};
    
    request.open("POST",URL);
    request.send(query);
}

function addUserResponse(req){
    var a = req.responseText;
    
    var obj = JSON.parse(a);
    if(obj.status === "Failed")
    {
        alertResponse(obj.msg,"error");
        
    }else{
        alertResponse(obj.msg,"success");
        resetAllFields();
    }
   
}

function highlightErrorFields(){
    var name = document.getElementById("name");
    var pass = document.getElementById("pass");
    var cpass = document.getElementById("cpass");
    var firstname = document.getElementById("firstname");
    var surname = document.getElementById("surname");
    
    if(name.value === "" || name.value === undefined){
        $("#name").css("border","1px solid red");
        //name.style.border = "1px solid red";
    }
    if(pass.value === "" || pass.value === undefined){
        $("#pass").css("border","1px solid red");
        //name.style.border = "1px solid red";
    }
    if(cpass.value === "" || cpass.value === undefined){
        $("#cpass").css("border","1px solid red");
        //name.style.border = "1px solid red";
    }
    if(firstname.value === "" || firstname.value === undefined){
        $("#firstname").css("border","1px solid red");
        //name.style.border = "1px solid red";
    }
    
    if(surname.value === "" || surname.value === undefined){
        $("#surname").css("border","1px solid red");
        //name.style.border = "1px solid red";
    }
}

function resetAllFields(){
    var name = document.getElementById("name");
        var pass = document.getElementById("pass");
        var cpass = document.getElementById("cpass");
        var firstname = document.getElementById("firstname");
        var surname = document.getElementById("surname");
        name.value = "";
        pass.value = "";
        cpass.value = "";
        firstname.value = "";
        surname.value = "";
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
 
function pdfRender(){
    alert("...");
    $(".caseInfo-table").hide();
    
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



function tableToJson(table) {
            var data = [];

            // first row needs to be headers
            var headers = [];
            for (var i=0; i<table.rows[0].cells.length; i++) {
                headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
            }

            //alert(table.rows.length);
            // go through cells
            for (var i=0; i<table.rows.length; i++) {

                var tableRow = table.rows[i];
                var rowData = {};

                for (var j=0; j<tableRow.cells.length; j++) {

                    rowData[ headers[j] ] = tableRow.cells[j].innerHTML;

                }

                data.push(rowData);
            }       

            return data;
        }