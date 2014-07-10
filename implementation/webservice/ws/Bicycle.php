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
    public $bicycleNumPeople;
    public $bicycleHit;
    public $bicycleType;
    public $weatherCondition;
    
    public $BicycleCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
  

    function __construct() {

    }
 }
class Bicycle extends Scene {
    
    public $paraObj;
    public $paraObjAll;
    //put your code here
     public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new BicycleParameters();
        $paraObjAll =new BicycleParameters();
        $BicycleCases = array();
	
    }
    public function getAllBicycleCases() {
        
        $query ="SELECT * FROM bicycle;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->BicycleCases[] = $this->getBicycleCases($info['bicycleID']);
               
            }
            
            return $paraObjAll;
    }
    public function getBicycleCases($id) {
        
        $query ="SELECT * FROM bicycle WHERE bicycleID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->bicycleID = $info['bicycleID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->bicycleNumPeople = $info['bicycleNumPeople'];
                        $paraObj->bicycleHit = $info['bicycleHit'];
                        $paraObj->bicycleType = $info['bicycleType'];
                        $paraObj->weatherCondition = $info['weatherCondition'];
                        
                        
                        
                        
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

    