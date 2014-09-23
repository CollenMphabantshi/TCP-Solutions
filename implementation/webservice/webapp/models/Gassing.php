<?php
require_once("Scene.php");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gassing
 *
 * @author BANCHI
 */
class gassingParameters{
    public $gassingID;
    public $sceneID;
    public $gassingIOType;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    public $foundInCar;
    public $wasCarRunning;
    public $carWindowClosed;
    public $pipeConnected;
    public $medicationPoisonOnScene;
    
    public  $GassingCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
    public function __construct() {
        
    }
}
class Gassing extends Scene{
    //put your code here
    
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $this->paraObj = new gassingParameters();
        $this->paraObjAll =new gassingParameters();
        
        $this->paraObjAll->GassingCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->gassingIOType = $formData['object'][$i]['gassingIOType'];
                $this->paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->paraObjAll->foundInCar = $formData['object'][$i]['foundInCar'];
                $this->paraObjAll->wasCarRunning = $formData['object'][$i]['wasCarRunning'];
                $this->paraObjAll->carWindowClosed = $formData['object'][$i]['carWindowClosed'];
                $this->paraObjAll->pipeConnected = $formData['object'][$i]['pipeConnected'];
                $this->paraObjAll->medicationPoisonOnScene = $formData['object'][$i]['medicationPoisonOnScene'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addGassing($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addGassing($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addGassing($sceneID,$inside,$object) {
        
        $h_res = mysql_query("insert into gassing values(0,"
        .$sceneID.",'$this->paraObjAll->gassingIOType','$this->paraObjAll->signsOfStruggle','$this->paraObjAll->alcoholBottleAround','$this->paraObjAll->drugParaphernalia','$this->paraObjAll->foundInCar','$this->paraObjAll->wasCarRunning','$this->paraObjAll->carWindowClosed','$this->paraObjAll->pipeConnected','$this->paraObjAll->medicationPoisonOnScene')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select gassingID from gassing where sceneID=".$sceneID);
            $gassingID = mysql_result($h_res,0,'gassingID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            $ga = $object['gassingAppliances']; 
            $gau = $object['gassingAppliancesUsed'];
            $gs = $object['gassingSmell'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into gassinginside values(0,".$gassingID.",'$dl','$wc','$wb','$va','$pv','$ga','$gau','$gs')");
            }else{
                $hi_res = mysql_query("insert into gassinginside values(0,".$gassingID.",'$dl','$wc','$wb','$va',null','$ga','$gau','$gs)");
            }
        }
        
    }
    
    public function getAllGassingCases() {
        $query ="SELECT * FROM gassing;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
            $this->paraObjAll->GassingCases[] = $this->getElectrocutionLightningCases($info['gassingID']);
               
            }
            
        return $this->paraObjAll;
        
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from gassing where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from gassinginside where gassingID=".$h_array['gassingID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['gassingInside'] = $hi_array;
                }else{
                    $h_array['gassingInside'] = NULL;
                }
            $ho_res = mysql_query("select * from gassingoutside where gassingID=".$h_array['gassingID']);
                if(mysql_num_rows($ho_res) > 0)
                {
                    $hi_array = mysql_fetch_array($ho_res);
                    $h_array['gassingOutside'] = $ho_array;
                }else{
                    $h_array['gassingOutside'] = NULL;
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getGassingCases($id) {
        
        $query ="SELECT * FROM gassing WHERE gassingID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->gassingID = $info['gassingID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->gassingIOType = $info['gassingIOType'];
                        $this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $this->paraObj->foundInCar = $info['foundInCar'];
                        $this->paraObj->wasCarRunning = $info['wasCarRunning'];
                        $this->paraObj->carWindowClosed = $info['carWindowClosed'];
                        $this->paraObj->pipeConnected = $info['pipeConnected'];
                        $this->paraObj->medicationPoisonOnScene = $info['medicationPoisonOnScene'];
                        
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj-> sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($this->paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj-> caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj->victimsObj = $sceneVictimsObj;

                       }

            //print $query;
            return $this->paraObj;
    }
    
}

