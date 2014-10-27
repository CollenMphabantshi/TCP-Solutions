
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
                 $("#pass").css("border","1px solid red");
                 $("#cpass").css("border","1px solid red");
                 return;
             }
             if(combobox !== "Administrator")
             {
                 var cell = document.getElementById("cellphone").value;
                 if(cell !== "" && cell !== undefined)
                 {
                    if(validateCellNo(cell))
                    {
                        addUser(name,pass,firstname,surname,combobox,cell);
                    }else{
                        $("#cellphone").before("<span class='cellError error'> invalid cell phone number. </span>");
                        $("#cellphone").focus(function(){
                            $(".cellError").remove();
                        });
                    }
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
    
     $("#assignDR").click(function(){ 
        assignDeathRegister($("#deathreg").val());
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

function validateCellNo(cell){
    if(cell.length === 10)
    {
        return true;
    }
    return false;
}

function alertResponse(message,status){
    $(".response").remove();
    $("hr").after("<div id='responsePanel' class='response "+status+"'></div>");
    $(".response").html(message);
    if(status === "success")
    {
        getUsers();
    }
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
           // alert("ccc");
            var location = JSON.parse(obj.sceneLocation);
            var locations = JSON.parse(location.Location);
            
            var sceneDesc = ["Time of scene:","Date of scene:","Location of scene:","Temperature of scene:",
            "Scene Investigating Officer Name:","Scene Investigating Officer Rank:",
            "Scene Investigating Officer Cell Number:","First Officer On Scene Name:",
            "First Officer On Scene Rank:"];
        var sceneValue = [obj.sceneTime,obj.sceneDate,
            locations.Address+", Latitude:"+locations.Latitude+", Longitude:"+locations.Longitude,
            obj.sceneTemparature,obj.sceneInvestigatingOfficerName,obj.sceneInvestigatingOfficerRank,
            obj.sceneInvestigatingOfficerCellNumber,obj.firstOfficerOnSceneName,obj.firstOfficerOnSceneRank];
        
            for(var i = 0; i < sceneDesc.length;i++)
            {
                if(sceneValue[i] !== "null" && sceneValue[i] !== null && sceneValue[i] !== undefined)
                {
                    data += "<tr>";
                    data += "<td>"+sceneDesc[i]+"</td><td>"+sceneValue[i]+"</td>";
                    data += "</tr>";
                }
            }
            
            data += "<tr><td colspan='2' class='table-header'>Victim Information</td></tr>";
            var vicsDesc = ["Victim Name:","Victim Surname:","Victim Gender:","Victim Race:","Victim ID Number:",
            "Victim Estimated Age:","Who found the victim&apos;s Body?","Was the body decomposed?",
            "Was there any Medical Intervention?","Was the body burned?","Was the body intact?",
            "Was the victim inside?","Was the victim outside?","Was the victim found close to water?",
            "Was the victim suicide note found?","Was rape homicide suspected?","Was suicide Suspected?",
            "Any previous attempts?","Number of previous attempts:","Victim general history:"];
            var vicsValue = [obj.victim[victim_count].victimName,obj.victim[victim_count].victimSurname,
            obj.victim[victim_count].victimGender,obj.victim[victim_count].victimRace,
            obj.victim[victim_count].victimIdentityNumber,
            obj.victim[victim_count].victimAge,obj.victim[victim_count].whoFoundVictimBody,
            obj.victim[victim_count].bodyDecompose,
            obj.victim[victim_count].medicalIntervention,obj.victim[victim_count].bodyBurned,
            obj.victim[victim_count].bodyIntact,obj.victim[victim_count].victimInside,
            obj.victim[victim_count].victimOutside,obj.victim[victim_count].victimFoundCloseToWater,
            obj.victim[victim_count].victimSuicideNoteFound,obj.victim[victim_count].rapeHomicideSuspected,
            obj.victim[victim_count].suicideSuspected,obj.victim[victim_count].previousAttempts,
            obj.victim[victim_count].numberOfPreviousAttempts,obj.victim[victim_count].victimGeneralHistory];
        
            for(var i = 0; i < vicsDesc.length;i++)
            {
                if(vicsValue[i] !== "null" && vicsValue[i] !== null && vicsValue[i] !== undefined)
                {
                    data += "<tr>";
                    data += "<td>"+vicsDesc[i]+"</td><td>"+vicsValue[i]+"</td>";
                    data += "</tr>";
                }
            }
            currentSceneType = view.title;
                //alert();
                
                
                data += getSceneTypeData(view.title,obj.sceneTypeData);
            
            $(".sceneInfo-table").html(data);
            appendPhotos(obj.sceneTypeData.photos);
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

    var inside = sceneData.hangingInside;
    var hangingValue = null;
    
    if(inside !== undefined)
    {
        hangingValue = [sceneData.hangingIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround,
        sceneData.drugParaphernalia,sceneData.autoeroticAsphyxia,sceneData.partialHangingType,sceneData.completeHanging,
        sceneData.ligatureAroundNeck,sceneData.whoRemovedLigature,sceneData.ligatureType,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    }else{
        hangingValue = [sceneData.hangingIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround,
        sceneData.drugParaphernalia,sceneData.autoeroticAsphyxia,sceneData.partialHangingType,sceneData.completeHanging,
        sceneData.ligatureAroundNeck,sceneData.whoRemovedLigature,sceneData.ligatureType,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected];
    }
    
    
        
    var bicycleDesc = ["Where did the scene take place?","Bicycle type:","Number of people on bicycle:",
    "Weather condition:","Bicycle hit:"];
    var bicycleValue = [sceneData.bicycleOType,sceneData.bicycleType,sceneData.bicycleNumPeople,
    sceneData.weatherCondition,sceneData.bicycleHit];

    var bluntDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Blunt force object suspected:","Was the blunt force object still on scene?",
    "Was it a community assult?","Was strangulation suspected?","Was smothering suspected?",
    "Was chocking suspected?","Was the door locked?","Was the windows closed?","Was the windows broken?",
    "Was the victim alone?","Who was with the victim?"];
    inside = sceneData.bluntInside;
    
    var bluntValue = null;
    if(inside !== undefined)
    {
        
        bluntValue = [sceneData.bluntIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.bluntForceObjectSuspected,sceneData.bluntForceObjectStillOnScene,
        sceneData.wasCommunityAssult,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
        
    }else{
        
        bluntValue = [sceneData.bluntIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.bluntForceObjectSuspected,sceneData.bluntForceObjectStillOnScene,
    sceneData.wasCommunityAssult,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected];
    }
    
    
    var burnDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Accelerants at scene?","Accelerants used:","Igniter at scene?","Igniter used:",
    "Foul play suspected?","Was the door locked?","Was the windows closed?","Was the windows broken?",
    "Was the victim alone?","Who was with the victim?","Was Building damaged?"];
    inside = sceneData.burnInside;
    var burnValue = null;
    if(inside !== undefined)
    {
        burnValue = [sceneData.burnIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.accelerantsAtScene,sceneData.accelerantsUsed,sceneData.igniterAtScene,
    sceneData.igniterUsed,sceneData.foulPlaySuspected,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim,inside.buildingDamaged];
    }else{
        burnValue = [sceneData.burnIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.accelerantsAtScene,sceneData.accelerantsUsed,sceneData.igniterAtScene,
    sceneData.igniterUsed,sceneData.foulPlaySuspected];
    }
    
    
    var crushDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the body moved?","Crush between which objects?","Was there any witnesses?",
    "What was the victim doing?","Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    inside = sceneData.crushinjuryInside;
    var crushValue = null;
    if(inside !== undefined)
    {
        crushValue = [sceneData.crushIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.wasBodyMoved,sceneData.betweenWhichObjects,sceneData.anyWitness,
        sceneData.whatWasVictimDoing,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    }else{
        crushValue = [sceneData.crushIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.wasBodyMoved,sceneData.betweenWhichObjects,sceneData.anyWitness,
        sceneData.whatWasVictimDoing];
    }
    
    
    var drowningDesc = ["Where did the scene take place?","Drowning type:","Any signs of struggle?",
    "Was an alcohol bottle around?","Drug Paraphernalia?","Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    inside = sceneData.drowningInside;
    var drowningValue = null;
    if(inside !== undefined)
    {
        drowningValue = [sceneData.drowningIOType,sceneData.drowningType,sceneData.signsOfStruggle,
        sceneData.alcoholBottleAround,sceneData.drugParaphernalia,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    }else{
        drowningValue = [sceneData.drowningIOType,sceneData.drowningType,sceneData.signsOfStruggle,
        sceneData.alcoholBottleAround,sceneData.drugParaphernalia];
    }
        
    
    var lightningDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Any open wire?","Was the scene wet?","Debarking of trees?","Was the door locked?",
    "Was the windows closed?","Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    inside = sceneData.electrocutionlightningInside;
    var lightningValue = null;
    if(inside !== undefined)
    {
        lightningValue = [sceneData.crushIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.anyOpenWire,sceneData.sceneWet,sceneData.deBarkingOfTrees,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    }
    else{
        lightningValue = [sceneData.crushIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.anyOpenWire,sceneData.sceneWet,sceneData.deBarkingOfTrees];
    }
    
    
    var firearmDesc = ["Where did the scene take place?","Any gunshot wounds?","Where are the gunshot wounds located:",
    "Where are the gunshot wounds area?","Was the firearm on scene?","Accelerants used:","Firearm calibre:",
    "Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    inside = sceneData.firearmInside;
    var firearmValue = null;
    if(inside !== undefined)
    {
        firearmValue = [sceneData.firearmIOType,sceneData.gunshotWounds,sceneData.gunshotWoundsLocation,
        sceneData.gunshotWoundsArea,sceneData.firearmOnScene,sceneData.accelerantsUsed,sceneData.firearmCalibre,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    }else{
        firearmValue = [sceneData.firearmIOType,sceneData.gunshotWounds,sceneData.gunshotWoundsLocation,
        sceneData.gunshotWoundsArea,sceneData.firearmOnScene,sceneData.accelerantsUsed,sceneData.firearmCalibre];
    }
    
    
    var heightDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Where did the victim fall from?","How high was the fall?","On what did the victim land?",
    "Was the door locked?","Was the windows closed?","Was the windows broken?","Was the victim alone?",
    "Who was with the victim?"];
    inside = sceneData.heightInside;
    var heightValue = null;
    if(inside !== undefined)
    {
       heightValue = [sceneData.heightIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.fromWhat,sceneData.howHigh,sceneData.onWhatVictimLanded,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim]; 
    }else{
        heightValue = [sceneData.heightIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.fromWhat,sceneData.howHigh,sceneData.onWhatVictimLanded];
    }
    
    
    var gassingDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the door locked?","Was the windows closed?","Was the windows broken?","Was the victim alone?",
    "Who was with the victim?","Any gassing appliances?","Gassing aplliances used:","Was there a gassing smell?",
    "Was the victim inside a car?","Description of the scene inside the car:"];
    inside = sceneData.gassingInside;
    var gassingValue = null;
    
    if(inside !== undefined)
    {
        gassingValue = [sceneData.gassingIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,
        inside.peopleWithVictim,inside.gassingAppliances,inside.gassingAppliancesUsed,inside.gassingSmell,
        inside.gassingVictimInCar,inside.victimInCarDescription];
    }
    else{
        
        gassingValue = [sceneData.gassingIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround,sceneData.drugParaphernalia];
    }
    
    var ingestionDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was the door locked?","Was the windows closed?",
    "Was the windows broken?","Was the victim alone?","Who was with the victim?"];
    inside = sceneData.ingestionOverdosePoisoningInside;
    var ingestionValue = null;
    if(inside !== undefined)
    {
        ingestionValue = [sceneData.ingestionOverdosePoisoningIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,inside.doorLocked,inside.windowsClosed,inside.windowsBroken,
        inside.victimAlone,inside.peopleWithVictim];
    }else{
        ingestionValue = [sceneData.ingestionOverdosePoisoningIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround,
        sceneData.drugParaphernalia];
    }
    
    
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
    ,"Drug Paraphernalia?","Was the sharp object at scene?","What are the sharp force injuries of victim?",
    "The injury concentrated on:","The injury mainly on:",
    "Was the door locked?","Was the windows closed?","Was the windows broken?","Was the victim alone?",
    "Who was with the victim?"];
    inside = sceneData.sharpInside;
    
    var sharpValue = null;
    if(inside !== undefined)
    {
        
        sharpValue = [sceneData.sharpIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.sharpObjectAtScene,sceneData.sharpForceInjuries,sceneData.theInjuryConcentrated,
        sceneData.theInjuryMainlyOn,
        inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    }
    else{
        
        sharpValue = [sceneData.sharpIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.sharpObjectAtScene,sceneData.sharpForceInjuries,sceneData.theInjury];
    }
    
    
    
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
    inside = sceneData.sudaInside;
    var sudaValue = null;
    if(inside !== undefined)
    {
        sudaValue = [sceneData.sudaIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,sceneData.sudaAppliances,sceneData.wierdSmellInAir,
    inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    }
    else{
        sudaValue = [sceneData.sudaIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,sceneData.sudaAppliances,sceneData.wierdSmellInAir];
    }
    
    
    var sudcDesc = ["Where did the scene take place?","Any signs of struggle?","Was an alcohol bottle around?"
    ,"Drug Paraphernalia?","Was strangulation suspected?","Was smothering suspected?",
    "Was chocking suspected?","Appliances?","Was there a weird smell in the air?","Was victim busy with physical exercise?",
    "History of other family members of dying of sudden death in a young age:",
    "History of other family members dying during sporting activities:","Family suffering from:",
    "Did the victim fell/ sustain injury during the past week?","Did the victim take any medication?"];
    inside = sceneData.sudcInside;
    var sudcValue = null;
    
    if(inside !== undefined)
    {
        //alert("Tompo");
        sudcValue =[sceneData.sudcIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,sceneData.anyHeatingDevices,sceneData.wierdSmellInAir,
        sceneData.victimBusy,sceneData.familyMedicalHistory,sceneData.physicalExercise,sceneData.familyMembersSufferingFrom,
        sceneData.victimFell,sceneData.victimTakeMedication,sceneData.suspisionOfAssault,sceneData.suspisionOfOverdose,
    inside.doorLocked,inside.windowsClosed,inside.windowsBroken,inside.victimAlone,inside.peopleWithVictim];
    }
    else{
        //alert("Tompo2");
        sudcValue =[sceneData.sudcIOType,sceneData.signsOfStruggle,sceneData.alcoholBottleAround
        ,sceneData.drugParaphernalia,sceneData.strangulationSuspected,
        sceneData.smotheringSuspected,sceneData.chockingSuspected,sceneData.anyHeatingDevices,sceneData.wierdSmellInAir,
        sceneData.victimBusy,sceneData.familyMedicalHistory,sceneData.physicalExercise,sceneData.familyMembersSufferingFrom,
        sceneData.victimFell,sceneData.victimTakeMedication,sceneData.suspisionOfAssault,sceneData.suspisionOfOverdose];
    }
    
    
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
                            if(foetusValue[i] !== "null" && foetusValue[i] !== null && foetusValue[i] !== undefined)
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
                            if(aviationValue[i] !== "null" && aviationValue[i] !== null && aviationValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+aviationDesc[i]+"</td><td>"+aviationValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                     case "Hanging":
                        
                        for(var i = 0;i < hangingDesc.length;i++)
                        {
                            if(hangingValue[i] !== "null" && hangingValue[i] !== null && hangingValue[i] !== undefined)
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
                            if(bicycleValue[i] !== "null" && bicycleValue[i] !== null && bicycleValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+bicycleDesc[i]+"</td><td>"+bicycleValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Blunt force injury/ assault":
                        
                        for(var i = 0;i < bluntDesc.length;i++)
                        {
                            if(bluntValue[i] !== "null" && bluntValue[i] !== null && bluntValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+bluntDesc[i]+"</td><td>"+bluntValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Burns":
                        
                        
                        for(var i = 0;i < burnDesc.length;i++)
                        {
                            if(burnValue[i] !== "null" && burnValue[i] !== null && burnValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+burnDesc[i]+"</td><td>"+burnValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Crush injury":
                        
                        
                        for(var i = 0;i < crushDesc.length;i++)
                        {
                            if(crushValue[i] !== "null" && crushValue[i] !== null && crushValue[i] !== undefined)
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
                        
                        
                        for(var i = 0;i < drowningDesc.length;i++)
                        {
                            if(drowningValue[i] !== "null" && drowningValue[i] !== null && drowningValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+drowningDesc[i]+"</td><td>"+drowningValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Lightning/ electrocution":
                      
                       for(var i = 0;i < lightningDesc.length;i++)
                        {
                            if(lightningValue[i] !== "null" && lightningValue[i] !== null && lightningValue[i] !== undefined)
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
                            if(firearmValue[i] !== "null" && firearmValue[i] !== null && firearmValue[i] !== undefined)
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
                            if(heightValue[i] !== null && heightValue[i] !== null && heightValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+heightDesc[i]+"</td><td>"+heightValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Gassing":
                        
                        
                        for(var i = 0;i < gassingDesc.length;i++)
                        {
                            if(gassingValue[i] !== "null" && gassingValue[i] !== null && gassingValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+gassingDesc[i]+"</td><td>"+gassingValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        
                        break;
                    case "Ingestion/overdose /poisoning":
                        
                        for(var i = 0;i < ingestionDesc.length;i++)
                        {
                            if(ingestionValue[i] !== "null" && ingestionValue[i] !== null && ingestionValue[i] !== undefined)
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
                            if(mvaValue[i] !== "null" && mvaValue[i] !== null && mvaValue[i] !== undefined)
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
                            if(mbaValue[i] !== "null" && mbaValue[i] !== null && mbaValue[i] !== undefined)
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
                            if(pedestrianValue[i] !== "null" && pedestrianValue[i] !== null && pedestrianValue[i] !== undefined)
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
                            if(railwayValue[i] !== "null" && railwayValue[i] !== null && railwayValue[i] !== undefined)
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
                            if(sharpValue[i] !== "null" && sharpValue[i] !== null && sharpValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+sharpDesc[i]+"</td><td>"+sharpValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        
                        
                        break;
                    case "Sudden unexpected death of an infant (SUDI)":
                        for(var i = 0;i < sudiDesc.length;i++)
                        {
                            if(sudiValue[i] !== "null" && sudiValue[i] !== null && sudiValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+sudiDesc[i]+"</td><td>"+sudiValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Sudden unexpected death of an adult/ found dead":
                        
                        for(var i = 0;i < sudaDesc.length;i++)
                        {
                            if(sudaValue[i] !== "null" && sudaValue[i] !== null && sudaValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+sudaDesc[i]+"</td><td>"+sudaValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        
                        
                        break;
                    case "SUDC":
                        
                        
                        for(var i = 0;i < sudcDesc.length;i++)
                        {
                            if(sudcValue[i] !== "null" && sudcValue[i] !== null && sudcValue[i] !== undefined)
                            {
                                data += "<tr>";
                                data += "<td>"+sudcDesc[i]+"</td><td>"+sudcValue[i]+"</td>";
                                data += "</tr>";
                            }
                        }
                        break;
                    case "Section 56 death(surgical case)":
                        for(var i = 0;i < sec48Desc.length;i++)
                        {
                            if(sec48Value[i] !== "null" && sec48Value[i] !== null && sec48Value[i] !== undefined)
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
        var cell = document.getElementById("cellphone");
        name.value = "";
        pass.value = "";
        cpass.value = "";
        firstname.value = "";
        surname.value = "";
        
        if(cell !== undefined && cell !== null)
        {
            cell.value = "";
        }
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
                var obj = JSON.parse(request.responseText);
                
                if(obj.status === "Success")
                {
                    $(".dregister").remove();
                    
                    $(".sceneInfo-table").prepend("<tr class='dregister'><td>Death Register Number:</td><td>"+dr+"</td></tr>");
                }else{
                    $(".res").remove();
                    $("#deathreg").before("<span class='res error'> "+obj.msg+" <br/></span>");
                    $("#deathreg").focus(function(){
                        $(".res").remove();
                    });
                }

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
 

function str2ab(str) {
  var buf = new ArrayBuffer(str.length*2); // 2 bytes for each char
  var bufView = new Uint16Array(buf);
  for (var i=0, strLen=str.length; i < strLen; i++) {
    bufView[i] = str.charCodeAt(i);
  }
  return buf;
}

function appendPhotos(photos){
    
    
    var data = "<div id='pics'><br/><br/><br/>";
    for(var i = 0;i <photos.length;i++)
    {
        if((i+1)%3 === 0 && i !== 0)
        {
            data += "<a href='data:image/jpg;base64,"+photos[i].photoData+"'><img width='200px' height='200px' src='data:image/jpg;base64,"+photos[i].photoData+"' title='"+photos[i].photoFilename+"'/></a><br/>";
        }else{
            data += "<a href='data:image/jpg;base64,"+photos[i].photoData+"'><img width='200px' height='200px' src='data:image/jpg;base64,"+photos[i].photoData+"' title='"+photos[i].photoFilename+"'/></a>";
        }
        //data += data += "<div class='col-md-4'><img width='200px' height='200px' src='data:image/jpg;base64,"+photos[i].photoData+"' title='"+photos[i].photoFilename+"'/></div>";
    }
    data += "</div>";
    $("#pics").remove();
    $("#tables").after(data);
    //document.body.appendChild(image);
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