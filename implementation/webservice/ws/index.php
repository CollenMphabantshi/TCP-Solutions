<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="jquery.js"></script>
        <script src="script.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#cases").click(function(p){

                    var q = "?rquest=viewCases&category=hanging";

                        var request = new XMLHttpRequest();

                        request.onreadystatechange = function(){if(request.readyState == 4)
                        {
                            alert(request.responseText);
                            $("body .test").html(request.responseText+"<br/>"+getCases(request));
                        }};
                        request.open("GET","api.php"+q);

                        request.send();
                       // p.preventDefault();
                });
                
                $("#add").click(function(){
                    var _scenePhotos = document.getElementById("scenePhotos");
                    var postData = {
                        object:[{
                            FOPersonelNumber:"p33333333",
                            sceneTime:"00:10:10",
                            sceneDate:"2014-01-03",
                            sceneLocation:"GPS -2333 034433 Maynlyn",
                            sceneTemparature:"34 degrees C",
                            investigatingOfficerName:"Romny Doloski",
                            investigatingOfficerRank:"Detective",
                            investigatingOfficerCellNo:"02303303031",
                            firstOfficerOnSceneName:"Ralph",
                            firstOfficerOnSceneRank:"Surgent",
                            victims: [{
                                victimIdentityNumber:"3334444444",
                                victimGender:"Female",
                                victimRace:"Chinees",
                                victimName:"Rupurd",
                                victimSurame:"Modoc",
                                scenePhoto:_scenePhotos.files,
                                bodyDecomposed: "no",
                                medicalIntervention: "no",
                                bodyBurned:null,
                                bodyIntact:null,
                                whoFoundVictimBody: "Chan Sui",
                                victimFoundCloseToWater: "no",
                                suicideSuspected: "yes",
                                previousAttempts: "yes",
                                numberOfPreviousAttempts: 2,
                                victimInside: "yes",
                                victimOutside: "no"
                            }],
                            hangingIOType: "Bar, shebeen, night club, disco",
                            signsOfStruggle: "yes",
                            alcoholBottleAround: "yes",
                            victimBodyDecomposed: "no",
                            drugParaphernalia: "yes",
                            autoeroticAsphyxia: "yes",
                            partialHangingType: "Half-lying",
                            completeHanging: "fully suspended",
                            ligatureAroundNeck: "yes",
                            whoRemovedLigature: null,
                            ligatureType: "Tie",
                            strangulationSuspected: "yes",
                            smotheringSuspected: "yes",
                            chockingSuspected: "no",
                            doorLocked: "no",
                            windowsClosed: "no",
                            windowsBroken: "no",
                            victimAlone: "yes",
                            peopleWithVictim: null
                        }]
                    };
                    var query = new FormData();
                    query.append("rquest","addCase");
                    query.append("category","hanging");
                    query.append("caseData",JSON.stringify(postData));
                    sendRequest(query);
                });
                
                $("#login").click(function(){
                    var query = new FormData();
                    query.append("rquest","login");
                    query.append("username",$("#username").val());
                    query.append("password",$("#password").val());
                    query.append("platform","webapp");
                    sendRequest(query);
                });
                
                $("#addUser").click(function(){
                    var query = new FormData();
                    var postData ={
                        userName:"p82432420",
                        userPassword:"xibroman",
                        userFirstname:"odTloolos",
                        userSurname:"paKropso",
                        userTypeID:103,
                        userActive:1,
                        cellphoneNumber: "041203023"
                    };
                    query.append("rquest","addUser");
                    query.append("utype","student");
                    query.append("userData",JSON.stringify(postData));
                    sendRequest(query);
                });
                
                $("#users").click(function(){
                    var query = new FormData();
                    query.append("rquest","users");
                    query.append("utype","fp");
                    query.append("id",2);
                    sendRequest(query);
                });

            });
            
            
        </script>
    </head>
    <body id="body">
        <a href="#" id="cases">View Case</a> <a href="#" id="add">Add Case</a> <a href="#" id="addUser">Add User</a> <a href="#" id="users">View Users</a>
        <br/>
        <div class="preview"></div><br/>
        <input type="file" id="scenePhotos" multiple="" />
        <br/>
        
        <div class="test"></div>
        <?php
        // put your code here
            //echo md5("open");
        ?>
        
        <label>Username:</label><br/>
        <input type="text" name="username" id="username"><br/>
        <label>Password:</label><br/>
        <input type="password" name="password" id="password"><br/>
        <button id="login">Login</button>
    </body>
</html>
