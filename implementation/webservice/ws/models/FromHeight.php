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
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->heightIOType = $formData['object'][$i]['heightIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->fromWhat = $formData['object'][$i]['fromWhat'];
                $this->howHigh = $formData['object'][$i]['howHigh'];
                $this->onWhatVictimLanded = $formData['object'][$i]['onWhatVictimLanded'];
                 //
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.  $sceneID".$sceneID);
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addHeight($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addHeight($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addHeight($sceneID,$inside,$object) {
        
        $h_res1 = mysql_query("insert into height values(0,".$sceneID.",'$this->heightIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->fromWhat','$this->howHigh','$this->onWhatVictimLanded')");
        if($h_res1 == FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.1");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select heightID from height where sceneID=".$sceneID);
            $heightID = mysql_result($h_res,0,'heightID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into heightinside values(0,".$heightID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into heightinside values(0,".$heightID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        
         $error = array('status' => "Success", "msg" => "Request to add case was successful.");
        $this->api->response($this->api->json($error), 200);
        
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
