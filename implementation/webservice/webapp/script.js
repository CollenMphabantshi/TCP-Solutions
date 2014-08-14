var URL = "https://localhost/ws/models/api.php";
var LOGIN_PAGE = "https://localhost/webapp/";
var caseList = new Object();
var victim_count = 0;
$(document).ready(function (p){
    
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
    
       $("#addButton").click(function(){
      
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
        alert("msmsm");
        //loadCaseInfo($(this).attr("id"));
    });
    $(".pages").click(function(){
        showPage($(this).attr("id"));
    });
    
    $("#logout").click(function(){
        logout();
    });
});


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
    try{
       
        var query = new FormData();
        query.append("rquest","getSceneData");
        query.append("caseNumber",view.id);
        query.append("platform","webapp");
        var request = new XMLHttpRequest();
        var res = null;
        request.onreadystatechange = function(){if(request.readyState == 4)
        {
            var data = "<tr><td colspan='2' class='table-header'>Scene Information</td></tr>";
            
            var obj = JSON.parse(request.responseText);
            
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
            data += "<td>Who found the victim&apos;s Body?</td><td>"+obj.victim[victim_count].whoFoundVictimBody+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Was the body decomposed?</td><td>"+obj.victim[victim_count].bodyDecompose+"</td>";
            data += "</tr>";
            data += "<tr>";
            data += "<td>Medical Intervention?</td><td>"+obj.victim[victim_count].medicalIntervention+"</td>";
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
            
            $(".right-content table").html(data);
        }};

        request.open("POST",URL);
        request.send(query);
    }catch(e){
        
    }
}


function loadCases(){
    try{
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
                data += "<tr>";
                data += "<td>"+obj[i].caseNumber+"</td>";
                data += "<td>"+obj[i].sceneType+"</td>";
                data += "<td>"+obj[i].FOPersonelNumber+"</td>";
                var sid = obj[i].sceneID*4501;
                
                data += "<td>"+"<a href='#' onclick='loadSceneInfo(this)' id='"+sid+"'>view</a>"+"</td>";
                data += "</tr>";
            }
            
            $("#table-headers").after(data);
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
    var request = new XMLHttpRequest();
    var res = null;
    
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
    //alertResponse(sendRequest(query),"error");
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
        $("table tr:last").before("<tr id='removeTr'><td>Cell phone number<input class='formInput' type='tel' id='cellphone' name='cellphone'/></td></tr>");
        
    }else if(combobox==="Forensic officer")
    {
        $("table tr:last").before("<tr id='removeTr'><td>Cell phone number<input class='formInput' type='tel' id='cellphone' name='cellphone'/></td></tr>");
    }else if(combobox==="Student")
    {
        $("table tr:last").before("<tr id='removeTr'><td>Cell phone number<input class='formInput' type='tel' id='cellphone' name='cellphone'/></td></tr>");
    }else if(combobox==="Guest")
    {
       
    }  
}
function addUser(name,pass,firstname,surname,combobox,cell){
    var add = new FormData();
    add.append("rquest","addUser");
    if(combobox==="Administrator")
    {
        add.append("utype","admin");
        
    }else if(combobox==="Forensic practitioner")
    {
        add.append("utype","fp");
        add.append("cellphoneNumber",cell);
    }else if(combobox==="Forensic officer")
    {
        add.append("utype","fo");
        
    }else if(combobox==="Student")
    {
        add.append("utype","student");
    }else if(combobox==="Guest")
    {
        add.append("utype","guest");
    } 
    add.append("userName",name);
    add.append("userPassword",pass);
    add.append("userFirstname",firstname);
    add.append("userSurname",surname);
    
   var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
            addUserResponse(request);
            return;
    }};
    
    
    request.open("POST",URL);
    request.send(add);
    
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
    var obj = JSON.parse(req.responseText);
    if(obj.status === "Failed")
    {
        alertResponse(obj.msg,"error");
    }else{
        alertResponse(obj.msg,"success");
    }
   //document.location.reload();
}

            