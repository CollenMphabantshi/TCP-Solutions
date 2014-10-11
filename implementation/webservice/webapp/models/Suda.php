<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suda
 *
 * @author BANCHI
 */
class sudaParameters{
    
    public $sudaID;
    public $sceneID;
    public $sudaIOType;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    public $strangulationSuspected;
    public $smotheringSuspected;
    public $chockingSuspected;
    public $anyHeatingDevices;
    public $wierdSmellInAir;
    public $victimHistory;
    public $victimTakeMedication;
    public $victimHadAnySymptoms;
    public $familyMedicalHistory;
    
    public  $sudaCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
}
class Suda extends Scene{
    
    public $paraObj ;
    public $paraObjAll;
   

    //put your code here
     public function __construct($formData,$api){
        $this->api = $api;
	$this->paraObj = new sudaParameters();
        $this->paraObjAll =new sudaParameters();
        
        $this->paraObjAll->sudaCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $paraObjAll->sudaIOType = $formData['object'][$i]['sudaIOType'];
                $paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $paraObjAll->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $paraObjAll->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $paraObjAll->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $paraObjAll->anyHeatingDevices = $formData['object'][$i]['anyHeatingDevices'];
                $paraObjAll->wierdSmellInAir = $formData['object'][$i]['wierdSmellInAir'];
                $paraObjAll->victimHistory = $formData['object'][$i]['victimHistory'];
                $paraObjAll->victimTakeMedication = $formData['object'][$i]['victimTakeMedication'];
                $paraObjAll->victimHadAnySymptoms = $formData['object'][$i]['victimHadAnySymptoms'];
               $paraObjAll->familyMedicalHistory = $formData['object'][$i]['familyMedicalHistory'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addSharpForceInjury($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addSharpForceInjury($sceneID,FALSE,null);
                }
            }
            
            
        }
    }
    
    public function addSuda($sceneID,$inside,$object) {
        $sudaIOType = $this->paraObjAll->sudaIOType;
        $signsOfStruggle = $this->paraObjAll->signsOfStruggle;
        $alcoholBottleAround = $this->paraObjAll->alcoholBottleAround;
        $drugParaphernalia = $this->paraObjAll->drugParaphernalia;
        $strangulationSuspected = $this->paraObjAll->strangulationSuspected;
        $smotheringSuspected = $this->paraObjAll->smotheringSuspected;
        $chockingSuspected = $this->paraObjAll->chockingSuspected;
        $anyHeatingDevices = $this->paraObjAll->anyHeatingDevices;
        $wierdSmellInAir = $this->paraObjAll->wierdSmellInAir;
        $victimHistory = $this->paraObjAll->victimHistory;
        $victimHadAnySymptoms = $this->paraObjAll->victimHadAnySymptoms;
        $victimTakeMedication = $this->paraObjAll->victimTakeMedication;
        $familyMedicalHistory = $this->paraObjAll->familyMedicalHistory;
        
        
        $h_res = mysql_query("insert into suda values(0,".$sceneID.",'$sudaIOType','$signsOfStruggle','$alcoholBottleAround','$drugParaphernalia','$strangulationSuspected','$smotheringSuspected','$chockingSuspected','$anyHeatingDevices','$wierdSmellInAir','$victimHistory','$victimTakeMedication','$victimHadAnySymptoms','$familyMedicalHistory')");
        
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }else{
            $error = array('status' => "Success", "msg" => "Request to create a scene was successful.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select sudaID from suda where sceneID=".$sceneID);
            $sudaID= mysql_result($h_res,0,'sudaID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into sudainside values(0,".$sudaID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into sudainside values(0,".$sudaID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
    }
    
    public function getAllSudaCases() {
        $query ="SELECT * FROM suda";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $this->paraObjAll->sudaCases[] = $this->getSudaCases($info['sudaID']);
               
            }
            
            return $this->paraObjAll;
        
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from suda where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from sudainside where sudaID=".$h_array['sudaID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['sudaInside'] = $hi_array;
                }else{
                    $h_array['sudaInside'] = NULL;
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getSudaCases($id) {
        $query ="SELECT * FROM suda WHERE sudaID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->sudaID = $info['sudaID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->sudaIOType = $info['sudaIOType'];
                        $this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $this->paraObj->strangulationSuspected = $info['strangulationSuspected'];
                        $this->paraObj->smotheringSuspected = $info['smotheringSuspected'];
                        $this->paraObj->chockingSuspected = $info['chockingSuspected'];
                        $this->paraObj->anyHeatingDevices = $info['anyHeatingDevices'];
                        $this->paraObj->wierdSmellInAir = $info['wierdSmellInAir'];
                        $this->paraObj->victimHistory = $info['victimHistory'];
                        $this->paraObj->victimTakeMedication = $info['victimTakeMedication'];
                        $this->paraObj->victimHadAnySymptoms = $info['victimHadAnySymptoms'];
                        $this->paraObj->familyMedicalHistory = $info['familyMedicalHistory'];
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
