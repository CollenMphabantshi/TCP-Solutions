<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bicycle
 *
 * @author BANCHI
 */
class BicycleParameters {
    public $bicycleID;
    public $sceneID;
    public $bicycleOType;
    public $bicycleNumPeople;
    public $bicycleHit;
    public $bicycleType;
    public $weatherCondition;
    public $weatherType;
    public $eyewitnesses;
    public $wasBodyMoved;
    
    public $BicycleCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
  

    function __construct() {

    }
 }
class Bicycle extends Scene {
    
    public $paraObj;
    public $paraObjAll;
    //put your code here
     public function __construct($formData,$api){
        $this->api = $api;
        $this->paraObj = new BicycleParameters();
        $this->paraObjAll =new BicycleParameters();
        $this->paraObjAll->BicycleCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Bicycle",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->bicycleOType = $formData['object'][$i]['bicycleOType'];
                $this->paraObjAll->bicycleNumPeople = $formData['object'][$i]['bicycleNumPeople'];
                $this->paraObjAll->bicycleHit = $formData['object'][$i]['bicycleHit'];
                $this->paraObjAll->bicycleType = $formData['object'][$i]['bicycleType'];
                $this->paraObjAll->weatherCondition = $formData['object'][$i]['weatherCondition'];
                $this->paraObjAll->weatherType = $formData['object'][$i]['weatherType'];
                $this->paraObjAll->eyewitnesses = $formData['object'][$i]['eyewitnesses'];
                $this->paraObjAll->wasBodyMoved = $formData['object'][$i]['wasBodyMoved'];
                    //
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                $this->addBicycle($sceneID);
                
            }
            
            
        }
	
    }
    
    public function addBicycle($sceneID) {
       
        $h_res = mysql_query("insert into bicycle values(0,".$sceneID.",'$this->paraObjAll->bicycleOType',$this->paraObjAll->bicycleNumPeople','$this->paraObjAll->bicycleHit','$this->paraObjAll->bicycleType','$this->paraObjAll->weatherCondition','$this->paraObjAll->weatherType','$this->paraObjAll->eyewitnesses','$this->paraObjAll->wasBodyMoved')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getAllBicycleCases() {
        
        $query ="SELECT * FROM bicycle;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $this->paraObjAll->BicycleCases[] = $this->getBicycleCases($info['bicycleID']);
               
            }
            
            return $paraObjAll;
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from bicycle where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getBicycleCases($id) {
        
        $query ="SELECT * FROM bicycle WHERE bicycleID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->bicycleID = $info['bicycleID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->bicycleNumPeople = $info['bicycleNumPeople'];
                        $this->paraObj->bicycleHit = $info['bicycleHit'];
                        $this->paraObj->bicycleType = $info['bicycleType'];
                        $this->paraObj->weatherCondition = $info['weatherCondition'];
                        $this->paraObj->weatherType = $info['weatherType'];
                        $this->paraObj->eyewitnesses = $info['eyewitnesses'];
                        $this->paraObj->wasBodyMoved = $info['wasBodyMoved'];
                        
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
                       $this->paraObj-> victimsObj = $sceneVictimsObj;

                       }

        
            return $this->paraObj;
        
        
    }
    
  
}

    