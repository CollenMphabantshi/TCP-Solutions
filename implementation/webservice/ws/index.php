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

                    var q = "?rquest=viewCases&category=hanging&hanging=2";

                        var request = new XMLHttpRequest();

                        request.onreadystatechange = function(){if(request.readyState == 4)
                        {

                            $("body").append(request.responseText+"<br/>"+getCases(request));
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
                            sceneLocation:"GPS -2333,034433 Maynlyn",
                            sceneTemparature:"34 degrees C",
                            investigatingOfficerName:"Romny Doloski",
                            investigatingOfficerRank:"Detective",
                            investigatingOfficerCellNo:"02303303031",
                            firstOfficerOnSceneName:"Ralph",
                            firstOfficerOnSceneRank:"Surgent",
                            victims: [{
                                victimGender:"Female",
                                victimRace:"Chinees",
                                victimID:"420202090099999",
                                victimName:"Rupurd",
                                victimSurame:"Modoc",
                                scenePhoto:_scenePhotos.files,
                                bodyDecomposed: "no",
                                medicalIntervention: "no",
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
                    
                    
                        var request = new XMLHttpRequest();

                        request.onreadystatechange = function(){if(request.readyState == 4)
                        {
                            alert(request.responseText);
                            $("body").append("<br/>"+request.responseText+"<br/>");
                        }};
                        request.open("POST","api.php");
                        //request.setRequestHeader("Content-Type","application/json;charset=utf-8");
                        request.send(query);
                });

            });
        </script>
    </head>
    <body id="body">
        <a href="#" id="cases">View Case</a> <a href="#" id="add">Add Case</a>
        <br/>
        <div class="preview"></div><br/>
        <input type="file" id="scenePhotos" multiple="" />
            
        <?php
        // put your code here
            //echo md5("open");
        ?>
        <form>
            
        </form>
    </body>
</html>
