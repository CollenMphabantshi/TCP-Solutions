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
	public $remainSkeletonized;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    public $strangulationSuspected;
    public $smotheringSuspected;
    public $chockingSuspected;
    public $anyHeatingDevices;
    public $wierdSmellInAir;
    public $victimHistory;
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
                parent::__construct($formData['object'][$i]['sceneTime'],"Sudden unexpected death of an adult/ found dead",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->sudaIOType = $formData['object'][$i]['sudaIOType'];
				$this->paraObjAll->remainSkeletonized = $formData['object'][$i]['remainSkeletonized'];
                $this->paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->paraObjAll->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->paraObjAll->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->paraObjAll->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->paraObjAll->anyHeatingDevices = $formData['object'][$i]['anyHeatingDevices'];
                $this->paraObjAll->wierdSmellInAir = $formData['object'][$i]['wierdSmellInAir'];
                $this->paraObjAll->victimHistory = $formData['object'][$i]['victimHistory'];
                $this->paraObjAll->familyMedicalHistory = $formData['object'][$i]['familyMedicalHistory'];
                $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addSuda($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addSuda($sceneID,FALSE,null);
                }
            }
            
            
        }
    }
    
    public function addSuda($sceneID,$inside,$object) {
        
        $h_res = mysql_query("insert into suda values(0,".$sceneID.",'$this->paraObjAll->sudaIOType','$this->paraObjAll->remainSkeletonized','$this->paraObjAll->signsOfStruggle','$this->paraObjAll->alcoholBottleAround','$this->paraObjAll->drugParaphernalia','$this->paraObjAll->strangulationSuspected','$this->paraObjAll->smotheringSuspected','$this->paraObjAll->chockingSuspected','$this->paraObjAll->anyHeatingDevices','$this->paraObjAll->wierdSmellInAir','$this->paraObjAll->victimHistory','$this->paraObjAll->familyMedicalHistory')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
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
            $enc = new Encryption();
            $h_res = mysql_query("select * from suda where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from sudainside where sudaID=".$h_array['sudaID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $hi_array['doorLocked'] = $enc->decrypt_request($hi_array['doorLocked']);
                    $hi_array['windowsClosed'] = $enc->decrypt_request($hi_array['windowsClosed']);
                    $hi_array['windowsBroken'] = $enc->decrypt_request($hi_array['windowsBroken']);
                    $hi_array['victimAlone'] = $enc->decrypt_request($hi_array['victimAlone']);
                    if($hi_array['peopleWithVictim'] !== NULL)
                    {
                        $hi_array['peopleWithVictim'] = $enc->decrypt_request($hi_array['peopleWithVictim']);
                    }else{
                        $hi_array['peopleWithVictim'] = "none";
                    }
                    $h_array['sudaInside'] = $hi_array;
                }else{
                    $h_array['sudaInside'] = "null";
                }
                
                $h_array['sudaIOType'] = $enc->decrypt_request($h_array['sudaIOType']);
		$h_array['remainSkeletonized'] = $enc->decrypt_request($h_array['remainSkeletonized']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['strangulationSuspected'] = $enc->decrypt_request($h_array['strangulationSuspected']);
                $h_array['smotheringSuspected'] = $enc->decrypt_request($h_array['smotheringSuspected']);
                $h_array['chockingSuspected'] = $enc->decrypt_request($h_array['chockingSuspected']);
                $h_array['anyHeatingDevices'] = $enc->decrypt_request($h_array['anyHeatingDevices']);
                $h_array['wierdSmellInAir'] = $enc->decrypt_request($h_array['wierdSmellInAir']);
                $h_array['victimHistory'] = $enc->decrypt_request($h_array['victimHistory']);
                $h_array['familyMedicalHistory'] = $enc->decrypt_request($h_array['familyMedicalHistory']);
                
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
			$this->paraObj->remainSkeletonized = $info['remainSkeletonized'];
                        $this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $this->paraObj->strangulationSuspected = $info['strangulationSuspected'];
                        $this->paraObj->smotheringSuspected = $info['smotheringSuspected'];
                        $this->paraObj->chockingSuspected = $info['chockingSuspected'];
                        $this->paraObj->anyHeatingDevices = $info['anyHeatingDevices'];
                        $this->paraObj->wierdSmellInAir = $info['wierdSmellInAir'];
                        $this->paraObj->victimHistory = $info['victimHistory'];
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
