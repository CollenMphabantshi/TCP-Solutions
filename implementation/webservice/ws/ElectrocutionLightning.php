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
    private $electrocutionLightningID;
    private $sceneID;
    private $electrocutionLightningIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $anyOpenWire;
    private $sceneWet;
    private $deBarkingOfTrees;
    
    public  $ElectrocutionCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
    public function __construct(){}
}
class ElectrocutionLightning extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
         $this->api = $api;
        $paraObj = new ElectrocutionParameters();
        $paraObjAll =new ElectrocutionParameters();
        
        $ElectrocutionCases = array();
	
    }
    
    public function getAllElectrocutionLightningCases() {
        $query ="SELECT * FROM electrocutionlightning;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->ElectrocutionCases[] = $this->getElectrocutionLightningCases($info['electrocutionLightningID']);
               
            }
            
        return $paraObjAll;
    }
    
    public function getElectrocutionLightningCases($id) {
        $query ="SELECT * FROM electrocutionlightning WHERE electrocutionLightningID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->electrocutionLightningID = $info['electrocutionLightningID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->electrocutionLightningIOType = $info['electrocutionLightningIOType'];
                        $paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $paraObj->anyOpenWire = $info['anyOpenWire'];
                        $paraObj->sceneWet = $info['sceneWet'];
                        $paraObj->deBarkingOfTrees = $info['deBarkingOfTrees'];
                        
                        
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

            //print $query;
            return $paraObj;
        
    }
}
