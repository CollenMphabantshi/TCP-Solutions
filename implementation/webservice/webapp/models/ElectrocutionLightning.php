<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ElectrocutionLightning
 *
 * @author BANCHI
 */
class ElectrocutionParameters{
    public $electrocutionLightningID;
    public $sceneID;
    public $electrocutionLightningIOType;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    public $anyOpenWire;
    public $sceneWet;
    public $deBarkingOfTrees;
    public $anyWitnesses;
    public $whenDidVictimDie;
    public $whatWasVictimDoing;
    public $victimFallFromHeight;
    public $voltage;
    public $anyOtherEvidence;
    
    public $ElectrocutionCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
    public function __construct(){}
}
class ElectrocutionLightning extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $this->paraObj = new ElectrocutionParameters();
        $this->paraObjAll =new ElectrocutionParameters();
        
        $this->paraObjAll->ElectrocutionCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->electrocutionLightningIOType = $formData['object'][$i]['electrocutionLightningIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->anyOpenWire = $formData['object'][$i]['anyOpenWire'];
                $this->sceneWet = $formData['object'][$i]['sceneWet'];
                $this->deBarkingOfTrees = $formData['object'][$i]['deBarkingOfTrees'];
                $this->anyWitnesses = $formData['object'][$i]['anyWitnesses'];
                $this->whenDidVictimDie = $formData['object'][$i]['whenDidVictimDie'];
                $this->whatWasVictimDoing = $formData['object'][$i]['whatWasVictimDoing'];
                $this->victimFallFromHeight = $formData['object'][$i]['victimFallFromHeight'];
                $this->voltage = $formData['object'][$i]['voltage'];
                $this->anyOtherEvidence = $formData['object'][$i]['anyOtherEvidence'];
                 //
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addElectrocutionLightning($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addElectrocutionLightning($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addElectrocutionLightning($sceneID,$inside,$object) {
        
       
       $h_res = mysql_query("insert into electrocutionlightning values(0,"
        .$sceneID.",'$this->paraObjAll->electrocutionLightningIOType','$this->paraObjAll->signsOfStruggle','$this->paraObjAll->alcoholBottleAround','$this->paraObjAll->drugParaphernalia','$this->paraObjAll->anyOpenWire','$this->paraObjAll->sceneWet','$this->paraObjAll->deBarkingOfTrees','$this->paraObjAll->paraObjAll->anyWitnesses','$this->paraObjAll->paraObjAll->whenDidVictimDie','$this->paraObjAll->paraObjAll->whatWasVictimDoing','$this->paraObjAll->victimFallFromHeight','$this->paraObjAll->voltage','$this->paraObjAll->anyOtherEvidence')");
        
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select electrocutionLightningID from electrocutionlightning where sceneID=".$sceneID);
            $electrocutionLightningID = mysql_result($h_res,0,'electrocutionLightningID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into electrocutionlightninginside values(0,".$electrocutionLightningID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into electrocutionlightninginside values(0,".$electrocutionLightningID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
    }
    
    public function getAllElectrocutionLightningCases() {
        $query ="SELECT * FROM electrocutionlightning";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $this->paraObjAll->ElectrocutionCases[] = $this->getElectrocutionLightningCases($info['electrocutionLightningID']);
               
            }
            
        return $this->paraObjAll;
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from electrocutionlightning where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from electrocutionlightning where electrocutionlightningID=".$h_array['electrocutionlightningID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['electrocutionlightningInside'] = $hi_array;
                }else{
                    $h_array['electrocutionlightningInside'] = NULL;
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getElectrocutionLightningCases($id) {
        $query ="SELECT * FROM electrocutionlightning WHERE electrocutionLightningID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        $this->paraObj->electrocutionLightningID = $info['electrocutionLightningID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->electrocutionLightningIOType = $info['electrocutionLightningIOType'];
                        $$this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $this->paraObj->anyOpenWire = $info['anyOpenWire'];
                        $this->paraObj->sceneWet = $info['sceneWet'];
                        $this->paraObj->deBarkingOfTrees = $info['deBarkingOfTrees'];
                        $this->paraObj->anyWitnesses = $info['anyWitnesses'];
                        $this->paraObj->whenDidVictimDie = $info['whenDidVictimDie'];
                        $this->paraObj->whatWasVictimDoing = $info['whatWasVictimDoing'];
                        $this->paraObj->victimFallFromHeight = $info['victimFallFromHeight'];
                        $this->paraObj->voltage = $info['voltage'];
                        $this->paraObj->anyOtherEvidence = $info['anyOtherEvidence'];
                        
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj->sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($this->paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj->caseObj = $case ; 
                        
                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj->victimsObj = $sceneVictimsObj;

                       }

            //print $query;
            return $this->paraObj;
        
    }
}
