<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FromHeight
 *
 * @author BANCHI
 */
class heightParameters{
    private $heightID;
    private $sceneID;
    private $heightIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $fromWhat;
    private $howHigh;
    private $onWhatVictimLanded;
    
    
    public  $heightCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
    public function __construct(){
	
    }
    
    
}
class FromHeight extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    public $paraHeight;
    
    public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new heightParameters();
        $paraObjAll =new heightParameters();
        
        $heightCases = array();
	
    }
    
    public function getAllHeightCases() {
        $query ="SELECT * FROM height;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->heightCases[] = $this->getFromHeightCases($info['heightID']);
               
            }
            
            return $paraObjAll;
        
    }
    
    public function getFromHeightCases($id) {
        $query ="SELECT * FROM height WHERE heightID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->heightID = $info['heightID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->heightIOType = $info['heightIOType'];
                        $paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $paraObj->fromWhat = $info['fromWhat'];
                        $paraObj->howHigh = $info['howHigh'];
                        $paraObj->onWhatVictimLanded = $info['onWhatVictimLanded'];
                        
                        
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
