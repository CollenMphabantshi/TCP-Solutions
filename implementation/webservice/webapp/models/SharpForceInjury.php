<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SharpForceInjury
 *
 * @author BANCHI
 */
class sharpParameters{
    public $sharpID;
    public $sceneID;
    public $sharpIOType;
    public $sharpObjectSuspected;
    public $sharpObjectAtScene;
    public $sharpForceInjuries;
    public $theInjuryConcentrated;
    public $theInjuryMainlyOn;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    
    public  $sharpCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
}
class SharpForceInjury extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $this->paraObj = new sharpParameters();
        $this->paraObjAll =new sharpParameters();
        
        $this->paraObjAll->sharpCases = array();
       $enc = new Encryption(); 
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Sharp force injury/ stab injury",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->sharpIOType = $formData['object'][$i]['sharpIOType'];
                $this->paraObjAll->sharpObjectSuspected = $formData['object'][$i]['sharpObjectSuspected'];
                $this->paraObjAll->sharpObjectAtScene = $formData['object'][$i]['sharpObjectAtScene'];
                $this->paraObjAll->sharpForceInjuries = $formData['object'][$i]['sharpForceInjuries'];
                $this->paraObjAll->theInjuryConcentrated = $formData['object'][$i]['theInjuryConcentrated'];
                $this->paraObjAll->theInjuryMainlyOn = $formData['object'][$i]['theInjuryMainlyOn'];
                $this->paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                
                $vinside = $enc->decrypt_request($formData['object'][$i]['victims'][0]['victimInside']);
                if($vinside === "Yes"){
                    $this->addSharpForceInjury($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addSharpForceInjury($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addSharpForceInjury($sceneID,$inside,$object) {
        $sharpIOType = $this->paraObjAll->sharpIOType;
        $sharpObjectSuspected = $this->paraObjAll->sharpObjectSuspected;
        $sharpObjectAtScene = $this->paraObjAll->sharpObjectAtScene;
        $sharpForceInjuries = $this->paraObjAll->sharpForceInjuries;
        $theInjuryConcentrated = $this->paraObjAll->theInjuryConcentrated;
        $theInjuryMainlyOn = $this->paraObjAll->theInjuryMainlyOn;
        $signsOfStruggle = $this->paraObjAll->signsOfStruggle;
        $alcoholBottleAround = $this->paraObjAll->alcoholBottleAround;
        $drugParaphernalia = $this->paraObjAll->drugParaphernalia;
        
        $h_res = mysql_query("insert into sharp values(0,$sceneID,"
                . "'$sharpIOType',"
                . "'$sharpObjectSuspected',"
                . "'$sharpObjectAtScene',"
                . "'$sharpForceInjuries',"
                . "'$theInjuryConcentrated',"
                . "'$theInjuryMainlyOn',"
                . "'$signsOfStruggle',"
                . "'$alcoholBottleAround',"
                . "'$drugParaphernalia')");
        
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside === TRUE){
            $h_res = mysql_query("select sharpID from sharp where sceneID=".$sceneID);
            $sharpID= mysql_result($h_res,0,'sharpID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            $enc = new Encryption();
            if($enc->decrypt_request($va) !== "Yes")
            {
                $hi_res = mysql_query("insert into sharpinside values(0,".$sharpID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into sharpinside values(0,".$sharpID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
        $error = array('status' => "Failed", "msg" => "Request to create a scene was successful.");
        $this->api->response($this->api->json($error), 400);
        
    }
    
    public function getAllSharpForceInjuryCases() {
        $query ="SELECT * FROM sharp";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
           $this->paraObjAll->sharpCases [] = $this->getSharpForceInjuryCases($info['sharpID']);
               
            }
            
        return $this->paraObjAll;
        
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from sharp where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from sharpinside where sharpID=".$h_array['sharpID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $hi_array['doorLocked'] = $enc->decrypt_request($hi_array['doorLocked']);
                    $hi_array['windowsClosed'] = $enc->decrypt_request($hi_array['windowsClosed']);
                    $hi_array['windowsBroken'] = $enc->decrypt_request($hi_array['windowsBroken']);
                    $hi_array['victimAlone'] = $enc->decrypt_request($hi_array['victimAlone']);
                    if($hi_array['peopleWithVictim'] !== NULL && $enc->decrypt_request($hi_array['peopleWithVictim']) !== "null")
                    {
                        $hi_array['peopleWithVictim'] = $enc->decrypt_request($hi_array['peopleWithVictim']);
                    }else{
                        $hi_array['peopleWithVictim'] = "none";
                    }
                    $h_array['sharpInside'] = $hi_array;
                }else{
                    $h_array['sharpInside'] = "null";
                }
                
                $h_array['sharpIOType'] = $enc->decrypt_request($h_array['sharpIOType']);
                $h_array['sharpObjectSuspected'] = $enc->decrypt_request($h_array['sharpObjectSuspected']);
                $h_array['sharpObjectAtScene'] = $enc->decrypt_request($h_array['sharpObjectAtScene']);
                $h_array['sharpForceInjuries'] = $enc->decrypt_request($h_array['sharpForceInjuries']);
                $h_array['theInjuryConcentrated'] = $enc->decrypt_request($h_array['theInjuryConcentrated']);
                $h_array['theInjuryMainlyOn'] = $enc->decrypt_request($h_array['theInjuryMainlyOn']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getSharpForceInjuryCases($id) {
        $query ="SELECT * FROM sharp WHERE sharpID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->sharpID = $info['sharpID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->sharpIOType = $info['sharpIOType'];
                        $this->paraObj->sharpObjectSuspected = $info['sharpObjectSuspected'];
                        $this->paraObj->sharpObjectAtScene = $info['sharpObjectAtScene'];
                        $this->paraObj->sharpForceInjuries = $info['sharpForceInjuries'];
                        $this->paraObj->theInjuryConcentrated = $info['theInjuryConcentrated'];
                        $this->paraObj->theInjuryMainlyOn = $info['theInjuryMainlyOn'];
                        $this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        
                        
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj-> sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($this->paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj->caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj->victimsObj = $sceneVictimsObj;

                       }

            
            return $this->paraObj;
    }
}
