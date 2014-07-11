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
        $paraObj = new MotorbikeParameters();
        $paraObjAll =new MotorbikeParameters();
        $MotorbikeCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Bicycle",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->victimWearingProtectiveClothing = $formData['object'][$i]['victimWearingProtectiveClothing'];
                $this->mbaOutsideType = $formData['object'][$i]['mbaOutsideType'];
                $this->victimsOnMotorcycle = $formData['object'][$i]['victimsOnMotorcycle'];
                $this->motorbikeHitFrom = $formData['object'][$i]['motorbikeHitFrom'];
                $this->typeOfAccident = $formData['object'][$i]['typeOfAccident'];
                
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
       
        $h_res = mysql_query("insert into mba values(0,".$sceneID.",'$this->victimWearingProtectiveClothing','$this->mbaOutsideType','$this->victimsOnMotorcycle','$this->motorbikeHitFrom','$this->typeOfAccident')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getAllMotorbikeAccidents() {
        $query ="SELECT * FROM mba;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->MotorbikeCases [] = $this->getMotorbikeAccident($info['mbaID']);
               
            }
            
            return $paraObjAll;
    }
    
    public function getMotorbikeAccident($id) {
        $query ="SELECT * FROM mba WHERE mbaID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->mbaID = $info['mbaID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->victimWearingProtectiveClothing = $info['victimWearingProtectiveClothing'];
                        $paraObj->mbaOutsideType = $info['mbaOutsideType'];
                        $paraObj->victimsOnMotorcycle = $info['victimsOnMotorcycle'];
                        $paraObj->motorbikeHitFrom = $info['motorbikeHitFrom'];
                        $paraObj->typeOfAccident = $info['typeOfAccident'];
                        
                        
                        
                        
                        //get scene related data
                        $scene = $this->getSceneByID($paraObj->sceneID);
                        $paraObj-> sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($paraObj->sceneID);
                        $paraObj-> caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($paraObj->sceneID);
                       $paraObj-> victimsObj = $sceneVictimsObj;

                       }

        
            return $paraObj;
        
    }
}
