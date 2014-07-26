$(document).ready(function (p){
    
    $("#login-form-button").click(function(){
        var username = $("#username").val();
        var pass = $("#password").val();
        
        if(username !== "" && pass !== ""){
            login(username,pass);
        }else{
            alertResponse("Please fill in both username and password","error");
        }
    });
    
       $("#button").click(function(p){
      
       /* var form = document.forms["adduserForm"];
        var name = form["name"].value;
        var pass = form["pass"].value;
        var firstname = form["firstname"].value;
        var surname = form["surname"].value;
        var combobox = form["userType"].options[form["userType"].selectedIndex].value;
        */
       var name = document.getElementById("name").value;
        var pass = document.getElementById("pass").value;
        var firstname = document.getElementById("firstname").value;
        var surname = document.getElementById("surnname").value;
        var combobox = document.getElementById("userType").options[document.getElementById("userType").selectedIndex].value;

         if(name !== "" && pass !== "" && firstname !== "" && surname !== "" && combobox !== ""){
             if(combobox !== "Administrator")
             {
                 var cell = document.getElementById("cellphone").value;
                 addUser(name,pass,firstname,surname,combobox,cell);
             }else{
                 ;
                 addUser(name,pass,firstname,surname,combobox,null);
             }
         }else{
             alertResponse("Please fill in the  missing information","error");
         }
         
    });
    
    $("#logout").click(function(){
        logout();
    });
});


function logout(){
    var query = new FormData();
    query.append("rquest","logout");
    query.append("platform","webapp");
    sendRequest(query);
   document.location.href = "http://localhost/webapp/";
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
            document.location = "adduser.php";
        }else{
            $("#login-form").before("<div class='response'><br/><br/></div>")
        }
    }};
    
    
    request.open("POST","http://localhost/ws/models/api.php");
    
    request.send(query);
    //alertResponse(sendRequest(query),"error");
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
    var adduser = new FormData();
    adduser.append("rquest","addUser");
    if(combobox==="Administrator")
    {
        adduser.append("utype","admin");
        
    }else if(combobox==="Forensic practitioner")
    {
        adduser.append("utype","fp");
        adduser.append("cellphoneNumber",cell);
    }else if(combobox==="Forensic officer")
    {
        adduser.append("utype","fo");
        
    }else if(combobox==="Student")
    {
        adduser.append("utype","student");
    }else if(combobox==="Guest")
    {
        adduser.append("utype","guest");
    } 
    adduser.append("userName",name);
    adduser.append("userPassword",pass);
    adduser.append("userFirstname",firstname);
    adduser.append("userSurname",surname);
    
   var request = new XMLHttpRequest();
    var res = null;
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
            addUserResponse(request);
    }};
    
    
    request.open("POST","http://localhost/ws/models/api.php");
    request.send(adduser);
    
}
function alertResponse(message,status){
    $(".response").remove();
    $(".response").html("");
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
    
    
    request.open("POST","http://localhost/ws/models/api.php");
    
    request.send(data);
    
}

function addUserResponse(req){
    var obj = JSON.parse(req.responseText);
    /*$(".response").html("");
    $(".response").html(obj.msg);
    */
   document.location.reload();
}

            