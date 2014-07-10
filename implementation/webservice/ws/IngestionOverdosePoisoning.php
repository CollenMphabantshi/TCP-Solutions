<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IngestionOverdosePoisoning
 *
 * @author BANCHI
 */
class ingestionParameters{
    private $ingestionOverdosePoisoningID;
    private $sceneID;
    private $ingestionOverdosePoisoningIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    
    
    public  $ingestionCases;
    private $caseObj;
    private $victimsObj;
    private $sceneObj;
    
}
class IngestionOverdosePoisoning extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
     public function __construct($formData,$api){
        $this->api = $api;
        $paraObj = new ingestionParameters();
        $paraObjAll =new ingestionParameters();
        
        $ingestionCases = array();
	
    }
    
    public function getAllIngestionOverdosePoisoningCases() {
        $query ="SELECT * FROM ingestionoverdosepoisoning;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->ingestionCases[] = $this->getRailwayCases($info['ingestionOverdosePoisoningID']);
               
            }
            
            return $paraObjAll;
        
    }
    
    public function getIngestionOverdosePoisoningCases($id) {
        $query ="SELECT * FROM ingestionoverdosepoisoning WHERE ingestionOverdosePoisoningID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->ingestionOverdosePoisoningID = $info['ingestionOverdosePoisoningID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->ingestionOverdosePoisoningIOType = $info['ingestionOverdosePoisoningIOType'];
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

        
            return $paraObj;
        
    }
}
