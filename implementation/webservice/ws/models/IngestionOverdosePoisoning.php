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
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->ingestionOverdosePoisoningIOType = $formData['object'][$i]['ingestionOverdosePoisoningIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addIngestionOverdosePoisoning($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addIngestionOverdosePoisoning($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addIngestionOverdosePoisoning($sceneID,$inside,$object) {
        
        $h_res = mysql_query("insert into ingestionoverdosepoisoning values(0,".$sceneID.",'$this->ingestionOverdosePoisoningIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia')");
        if($h_res == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select ingestionOverdosePoisoningID from ingestionoverdosepoisoning where sceneID=".$sceneID);
            $ingestionOverdosePoisoningID = mysql_result($h_res,0,'ingestionOverdosePoisoningID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into ingestionoverdosepoisoninginside values(0,".$ingestionOverdosePoisoningID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into ingestionoverdosepoisoninginside values(0,".$ingestionOverdosePoisoningID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
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
