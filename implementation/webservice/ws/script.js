

function getCases(request){
                var obj = JSON.parse(request.responseText);
                
                    
                var content = "<table border='1'>";
                
                
                for(var i = 0; i < obj.count;i++)
                {
                    content += "<tr><td colspan='2'>Case Number: "+obj.objectlist[i]['caseData'].caseNumber+"</td></tr>";
                    content += "<tr><td colspan='2'>Forensic Officer On scene: "+obj.objectlist[i]['caseData'].FOPersonelNumber+"</td></tr>";
                    content += "<tr><td colspan='2'>Scene Arrival Time: "+obj.objectlist[i]['sceneData'].sceneTime+"</td></tr>";
                    content += "<tr><td colspan='2'>Scene Date: "+obj.objectlist[i]['sceneData'].sceneDate+"</td></tr>";
                    content += "<tr><td colspan='2'>Scene Location: "+obj.objectlist[i]['sceneData'].sceneLocation+"</td></tr>";
                    content += "<tr><td colspan='2'>Scene Temparature: "+obj.objectlist[i]['sceneData'].sceneTemparature+"</td></tr>";
                    content += "<tr><td colspan='2'>Investigating Officer&apos;s Name: "+obj.objectlist[i]['sceneData'].sceneInvestigatingOfficerRank+" "+obj.objectlist[i]['sceneData'].sceneInvestigatingOfficerName+"</td></tr>";
                    
                    content += "<tr>";
                    for(var j = 0; j < obj.victims.length;j++)
                    {
                        
                        content += "<td>";
                        for(var k = 0; k < obj.victims[j].length;k++)
                        {
                            content += "<tr><td>Victim Fullname:</td><td>"+obj.victims[j][k]['victimName']+" "+obj.victims[j][k]['victimSurname']+"</td></tr>";
                            content += "<tr><td>Victim Gender:</td><td>"+obj.victims[j][k]['victimGender']+"</td></tr>";
                            content += "<tr><td>Victim Race:</td><td>"+obj.victims[j][k]['victimRace']+"</td></tr>";
                            content += "<tr><td>Victim General History:</td><td>"+obj.victims[j][k]['victimGeneralHistory']+"</td></tr>";
                            content += "<tr><td>Rape Homicide Suspected</td><td>"+obj.victims[j][k]['rapeHomicideSuspected']+"</td></tr>";
                            content += "<tr><td>Victim&apos;s Body Found By:</td><td>"+ obj.victims[j][k]['whoFoundVictimBody'] +"</td></tr>";
                        }
                        content += "</td>";
                    }
                    
                    content += "<td colspan='2'>Scene Number:  #"+obj.objectlist[i]['sceneID']+"</td>";
                    var data = "";
                    
                    
                    data += "<tr><td>Any signs of struggle:</td><td>"+ obj.objectlist[i]['signsOfStruggle'] +"</td></tr>";
                    data += "<tr><td>Any alcohol bottle around:</td><td>"+ obj.objectlist[i]['alcoholBottleAround'] +"</td></tr>";
                    data += "<tr><td>Was there Drugs:</td><td>"+ obj.objectlist[i]['drugParaphernalia'] +"</td></tr>";
                    data += "<tr><td>Was there Auto Erotic Asphyxia:</td><td>"+ obj.objectlist[i]['autoeroticAsphyxia'] +"</td></tr>";
                    data += "<tr><td>What type of partial hanging:</td><td>"+ obj.objectlist[i]['partialHangingType'] +"</td></tr>";
                    data += "<tr><td>What type of complete Hanging:</td><td>"+ obj.objectlist[i]['completeHanging'] +"</td></tr>";
                    data += "<tr><td>Was there ligature Around Neck:</td><td>"+ obj.objectlist[i]['ligatureAroundNeck'] +"</td></tr>";
                    data += "<tr><td>Who Removed Ligature:</td><td>"+ obj.objectlist[i]['whoRemovedLigature'] +"</td></tr>";
                    data += "<tr><td>What type of ligature:</td><td>"+ obj.objectlist[i]['ligatureType'] +"</td></tr>";
                    data += "<tr><td>Was Strangulation Suspected:</td><td>"+ obj.objectlist[i]['strangulationSuspected'] +"</td></tr>";
                    data += "<tr><td>Was Smothering Suspected:</td><td>"+ obj.objectlist[i]['smotheringSuspected'] +"</td></tr>";
                    data += "<tr><td>Was Choking Suspected:</td><td>"+ obj.objectlist[i]['chockingSuspected'] +"</td></tr>";
                    if(obj.objectlist[i]['hangingInside'] != null)
                    {
                        data += "<tr><td colspan='2'>Inside Hanging Type: "+ obj.objectlist[i]['hangingIOType'] +"</td></tr>";
                        data += "<tr><td>Was Door Locked:</td><td>"+ obj.objectlist[i]['hangingInside'].doorLocked +"</td></tr>";
                        data += "<tr><td>Was Windows Opened:</td><td>"+ obj.objectlist[i]['hangingInside'].windowsClosed +"</td></tr>";
                        data += "<tr><td>Was Windows Broken:</td><td>"+ obj.objectlist[i]['hangingInside'].windowsBroken +"</td></tr>";
                        data += "<tr><td>Was the victim alone:</td><td>"+ obj.objectlist[i]['hangingInside'].victimAlone +"</td></tr>";
                        if(obj.objectlist[i]['hangingInside'].victimAlone === "no")
                        {
                            data += "<tr><td>Who was with victim:</td><td>"+ obj.objectlist[i]['hangingInside'].peopleWithVictim +"</td></tr>";
                        }
                        
                    }else{
                        data += "<tr><td colspan='2'>Outside Hanging Type: "+ obj.objectlist[i]['hangingIOType'] +"</td></tr>";
                    }
                
                    content += "<td colspan='2'>"+data+"</td>";
                    content += "</tr>";
                }
                content += "</table>";
                return content;
            }