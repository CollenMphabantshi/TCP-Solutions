<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SharpForceInjury
 *
 * @author BANCHI
 */
class sharpParameters{
    private $sharpID;
    private $sceneID;
    private $sharpIOType;
    private $sharpObjectAtScene;
    private $sharpForceInjuries;
    private $theInjury;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    
    public  $sharpCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
}
class SharpForceInjury extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new sharpParameters();
        $paraObjAll =new sharpParameters();
        
        $sharpCases = array();
	
    }
    
    public function getAllSharpForceInjuryCases() {
        $query ="SELECT * FROM sharp;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->sharpCases [] = $this->getSharpForceInjuryCases($info['gassingID']);
               
            }
            
        return $paraObjAll;
        
    }
    
    public function getSharpForceInjuryCases($id) {
        $query ="SELECT * FROM sharp WHERE sharpID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->sharpID = $info['sharpID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->sharpIOType = $info['sharpIOType'];
                        $paraObj->sharpObjectAtScene = $info['sharpObjectAtScene'];
                        $paraObj->sharpForceInjuries = $info['sharpForceInjuries'];
                        $paraObj->theInjury = $info['theInjury'];
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

            print $query;
            return $paraObj;
    }
}
