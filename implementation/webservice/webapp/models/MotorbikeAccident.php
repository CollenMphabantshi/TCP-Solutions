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
    public $helmetStillOn;
    public $helmetRemovedBy;
    
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
                parent::__construct($formData['object'][$i]['sceneTime'],"Motorbike accident",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
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
                $this->paraObjAll->helmetStillOn = $formData['object'][$i]['helmetStillOn'];
                $this->paraObjAll->helmetRemovedBy = $formData['object'][$i]['helmetRemovedBy'];
                 
                //
               $sceneID = $this->createScene();
                
               if($sceneID === NULL){
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
        $victimWearingProtectiveClothing = $this->paraObjAll->victimWearingProtectiveClothing;
        $mbaOutsideType = $this->paraObjAll->mbaOutsideType;
        $victimsOnMotorcycle = $this->paraObjAll->victimsOnMotorcycle;
        $motorbikeHitFrom = $this->paraObjAll->motorbikeHitFrom;
        $typeOfAccident = $this->paraObjAll->typeOfAccident;
        $victimFlungRoad = $this->paraObjAll->victimFlungRoad;
        $victimFlungBanister = $this->paraObjAll->victimFlungBanister;
        $victimFlungCar = $this->paraObjAll->victimFlungCar;
        $motorBikeFellOnVictim = $this->paraObjAll->motorBikeFellOnVictim;
        $anyWitnesses = $this->paraObjAll->anyWitnesses;
        $bodyMoved = $this->paraObjAll->bodyMoved;
        $victimWearingHelmet = $this->paraObjAll->victimWearingHelmet;
        $weatherType = $this->paraObjAll->weatherType;
        $weatherCondition = $this->paraObjAll->weatherCondition;
        $helmetStillOn = $this->paraObjAll->helmetStillOn;
        $helmetRemovedBy = $this->paraObjAll->helmetRemovedBy;
        
        
       $q = "INSERT INTO mba(mbaID, sceneID, victimWearingProtectiveClothing, mbaOutsideType, victimsOnMotorcycle, motorbikeHitFrom, typeOfAccident, victimFlungRoad, victimFlungBanister, victimFlungCar, motorBikeFellOnVictim, anyWitnesses, bodyMoved, victimWearingHelmet, weatherType, weatherCondition, helmetStillOn, helmetRemovedBy)"
        . " VALUES(0,$sceneID,'$victimWearingProtectiveClothing','$mbaOutsideType','$victimsOnMotorcycle','$motorbikeHitFrom','$typeOfAccident','$victimFlungRoad','$victimFlungBanister','$victimFlungCar','$motorBikeFellOnVictim','$anyWitnesses','$bodyMoved','$victimWearingHelmet','$weatherType','$weatherCondition','$helmetStillOn','$helmetRemovedBy')";
        //$this->api->response($this->api->json($error), 400);
       
        $h_res = mysql_query($q);
        
        if($h_res === FALSE){
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
            $enc = new Encryption();
            $h_res = mysql_query("select * from mba where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            
            $h_array['victimWearingProtectiveClothing'] = $enc->decrypt_request($h_array['victimWearingProtectiveClothing']);
            $h_array['mbaOutsideType'] = $enc->decrypt_request($h_array['mbaOutsideType']);
            $h_array['victimsOnMotorcycle'] = $enc->decrypt_request($h_array['victimsOnMotorcycle']);
            $h_array['motorbikeHitFrom'] = $enc->decrypt_request($h_array['motorbikeHitFrom']);
            $h_array['typeOfAccident'] = $enc->decrypt_request($h_array['typeOfAccident']);
            $h_array['victimFlungRoad'] = $enc->decrypt_request($h_array['victimFlungRoad']);
            $h_array['victimFlungBanister'] = $enc->decrypt_request($h_array['victimFlungBanister']);
            $h_array['victimFlungCar'] = $enc->decrypt_request($h_array['victimFlungCar']);
            $h_array['motorBikeFellOnVictim'] = $enc->decrypt_request($h_array['motorBikeFellOnVictim']);
            $h_array['anyWitnesses'] = $enc->decrypt_request($h_array['anyWitnesses']);
            $h_array['bodyMoved'] = $enc->decrypt_request($h_array['bodyMoved']);
            $h_array['victimWearingHelmet'] = $enc->decrypt_request($h_array['victimWearingHelmet']);
            $h_array['weatherType'] = $enc->decrypt_request($h_array['weatherType']);
            $h_array['weatherCondition'] = $enc->decrypt_request($h_array['weatherCondition']);
            
            return $h_array;
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
