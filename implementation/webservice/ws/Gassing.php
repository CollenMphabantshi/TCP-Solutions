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
    private $gassingID;
    private $sceneID;
    private $gassingIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    
    public  $GassingCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
    public function __construct() {
        
    }
}
class Gassing extends Scene{
    //put your code here
    
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new gassingParameters();
        $paraObjAll =new gassingParameters();
        
        $GassingCases = array();
	
    }
    
    public function getAllGassingCases() {
        $query ="SELECT * FROM gassing;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->GassingCases[] = $this->getElectrocutionLightningCases($info['gassingID']);
               
            }
            
        return $paraObjAll;
        
    }
    
    public function getGassingCases($id) {
        
        $query ="SELECT * FROM gassing WHERE gassingID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->gassingID = $info['gassingID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->gassingIOType = $info['gassingIOType'];
                        $paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        
                        
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

