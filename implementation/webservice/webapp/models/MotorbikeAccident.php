<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MotorbikeAccident
 *
 * @author BANCHI
 */
class MotorbikeParameters{
    
    public $mbaID;
    public $sceneID;
    public $victimWearingProtectiveClothing;
    public $mbaOutsideType;
    public $victimsOnMotorcycle;
    public $motorbikeHitFrom;
    public $typeOfAccident;
    public $victimFlungRoad;
    public $victimFlungBanister;
    public $victimFlungCar;
    public $motorBikeFellOnVictim;
    public $anyWitnesses;
    public $bodyMoved;
    public $victimWearingHelmet;
    public $weatherType;
    public $weatherCondition;
    
    public $MotorbikeCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
    
}
class MotorbikeAccident extends Scene{
    //put your code here
    public $paraObj;
    public $paraObjAll;
     public function __construct($formData,$api){
        $this->api = $api;
        $this->paraObj = new MotorbikeParameters();
        $this->paraObjAll =new MotorbikeParameters();
        
        $this->paraObjAll->MotorbikeCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Bicycle",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->victimWearingProtectiveClothing = $formData['object'][$i]['victimWearingProtectiveClothing'];
                $this->paraObjAll->mbaOutsideType = $formData['object'][$i]['mbaOutsideType'];
                $this->paraObjAll->victimsOnMotorcycle = $formData['object'][$i]['victimsOnMotorcycle'];
                $this->paraObjAll->motorbikeHitFrom = $formData['object'][$i]['motorbikeHitFrom'];
                $this->paraObjAll->typeOfAccident = $formData['object'][$i]['typeOfAccident'];
                $this->paraObjAll->victimFlungRoad = $formData['object'][$i]['victimFlungRoad'];
                $this->paraObjAll->victimFlungBanister = $formData['object'][$i]['victimFlungBanister'];
                $this->paraObjAll->victimFlungCar = $formData['object'][$i]['victimFlungCar'];
                $this->paraObjAll->motorBikeFellOnVictim = $formData['object'][$i]['motorBikeFellOnVictim'];
                $this->paraObjAll->anyWitnesses = $formData['object'][$i]['anyWitnesses'];
                $this->paraObjAll->bodyMoved = $formData['object'][$i]['bodyMoved'];
                $this->paraObjAll->victimWearingHelmet = $formData['object'][$i]['victimWearingHelmet'];
                $this->paraObjAll->weatherType = $formData['object'][$i]['weatherType'];
                $this->paraObjAll->weatherCondition = $formData['object'][$i]['weatherCondition'];
                    //
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                $this->addMotorbikeAccidents($sceneID);
                
            }
            
            
        }
    }
    
    public function addMotorbikeAccidents($sceneID) {
       
        $h_res = mysql_query("insert into mba values(0,"
        .$sceneID.",'$this->paraObjAll->victimWearingProtectiveClothing','$this->paraObjAll->mbaOutsideType','$$this->paraObjAll->victimsOnMotorcycle','$this->paraObjAll->motorbikeHitFrom','$this->paraObjAll->typeOfAccident','$this->paraObjAll->victimFlungRoad','$this->paraObjAll->victimFlungBanister','$this->paraObjAll->victimFlungCar','$this->paraObjAll->motorBikeFellOnVictim','$this->paraObjAll->anyWitnesses','$this->paraObjAll->bodyMoved','$this->paraObjAll->victimWearingHelmet','$this->paraObjAll->weatherType','$this->paraObjAll->weatherCondition')");
        
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getAllMotorbikeAccidents() {
        $query ="SELECT * FROM mba";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
           $this->paraObjAll->MotorbikeCases [] = $this->getMotorbikeAccident($info['mbaID']);
               
            }
            
            return $this->paraObjAll;
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from mba where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getMotorbikeAccident($id) {
        $query ="SELECT * FROM mba WHERE mbaID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->mbaID = $info['mbaID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->victimWearingProtectiveClothing = $info['victimWearingProtectiveClothing'];
                        $this->paraObj->mbaOutsideType = $info['mbaOutsideType'];
                        $this->paraObj->victimsOnMotorcycle = $info['victimsOnMotorcycle'];
                        $this->paraObj->motorbikeHitFrom = $info['motorbikeHitFrom'];
                        $this->paraObj->typeOfAccident = $info['typeOfAccident'];
                        $this->paraObj->victimFlungRoad = $info['victimFlungRoad'];
                        $this->paraObj->victimFlungBanister = $info['victimFlungBanister'];
                        $this->paraObj->victimFlungCar = $info['victimFlungCar'];
                        $this->paraObj->motorBikeFellOnVictim = $info['motorBikeFellOnVictim'];
                        $this->paraObj->anyWitnesses = $info['anyWitnesses'];
                        $this->paraObj->bodyMoved = $info['bodyMoved'];
                        $this->paraObj->victimWearingHelmet = $info['victimWearingHelmet'];
                        $this->paraObj->weatherType = $info['weatherType'];
                        $this->paraObj->weatherCondition = $info['weatherCondition'];
                        
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

        
            return $this->paraObj;
        
    }
}
