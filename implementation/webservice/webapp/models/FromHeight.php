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
    public $heightID;
    public $sceneID;
    public $heightIOType;
    public $signsOfStruggle;
    public $alcoholBottleAround;
    public $drugParaphernalia;
    public $fromWhat;
    public $howHigh;
    public $onWhatSurface;
    public $anyWitnesses;
    
    public  $heightCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
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
        $this->paraObj = new heightParameters();
        $this->paraObjAll =new heightParameters();
        
        $this->paraObjAll->heightCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->heightIOType = $formData['object'][$i]['heightIOType'];
                $this->paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->paraObjAll->fromWhat = $formData['object'][$i]['fromWhat'];
                $this->paraObjAll->howHigh = $formData['object'][$i]['howHigh'];
                $this->paraObjAll->onWhatSurface = $formData['object'][$i]['onWhatSurface'];
                $this->paraObjAll->anyWitnesses = $formData['object'][$i]['anyWitnesses']; 
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
        
        $h_res1 = mysql_query("insert into height values(0,"
        .$sceneID.",'$this->paraObjAll->heightIOType','$this->paraObjAll->signsOfStruggle','$this->paraObjAll->alcoholBottleAround','$this->paraObjAll->drugParaphernalia','$this->paraObjAll->fromWhat','$this->paraObjAll->howHigh','$this->paraObjAll->onWhatVictimLanded','$this->paraObjAll->anyWitnesses')");
        
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
            $this->paraObjAll->heightCases[] = $this->getFromHeightCases($info['heightID']);
               
            }
            
            return $this->paraObjAll;
        
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from height where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from heightinside where heightID=".$h_array['heightID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['heightInside'] = $hi_array;
                }else{
                    $h_array['heightInside'] = NULL;
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getFromHeightCases($id) {
        $query ="SELECT * FROM height WHERE heightID=".$id.";";

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->heightID = $info['heightID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->heightIOType = $info['heightIOType'];
                        $this->paraObj->signsOfStruggle = $info['signsOfStruggle'];
                        $this->paraObj->alcoholBottleAround = $info['alcoholBottleAround'];
                        $this->paraObj->drugParaphernalia = $info['drugParaphernalia'];
                        $this->paraObj->fromWhat = $info['fromWhat'];
                        $this->paraObj->howHigh = $info['howHigh'];
                        $this->paraObj->onWhatSurface = $info['onWhatSurface'];
                        $this->paraObj->anyWitnesses = $info['anyWitnesses'];
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj-> sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($this->paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj-> caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj-> victimsObj = $sceneVictimsObj;

                       }

        
            return $this->paraObj;
        
    }
    
}
