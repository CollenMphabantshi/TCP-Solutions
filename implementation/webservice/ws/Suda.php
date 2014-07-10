<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suda
 *
 * @author BANCHI
 */
class sudaParameters{
    
    private $sudaID;
    private $sceneID;
    private $sudaIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected;
    private $sudaAppliances;
    private $wierdSmellInAir;
   
    public  $sudaCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
}
class Suda extends Scene{
    
    public $paraObj ;
    public $paraObjAll;
   

    //put your code here
     public function __construct($formData,$api){
        $this->api = $api;
	$paraObj = new sudaParameters();
        $paraObjAll =new sudaParameters();
        
        $sudaCases = array();
    }
    
    public function getAllSudaCases() {
        $query ="SELECT * FROM suda;";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $paraObjAll->sudaCases[] = $this->getSudaCases($info['sudaID']);
               
            }
            
            return $paraObjAll;
        
    }
    
    public function getSudaCases($id) {
        $query ="SELECT * FROM suda WHERE sudaID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $paraObj->sudaID = $info['sudaID'];
                        $paraObj->sceneID = $info['sceneID'];
                        $paraObj->sudaIOType = $info['sudaIOType'];
                        $paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $paraObj->strangulationSuspected = $info['strangulationSuspected'];
                        $paraObj->smotheringSuspected = $info['smotheringSuspected'];
                        $paraObj->chockingSuspected = $info['chockingSuspected'];
                        $paraObj->sudaAppliances = $info['sudaAppliances'];
                        $paraObj->wierdSmellInAir = $info['wierdSmellInAir'];
                        
                        
                        
                        
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
