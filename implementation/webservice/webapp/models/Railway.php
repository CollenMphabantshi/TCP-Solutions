<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Railway
 *
 * @author BANCHI
 */
class railwayParameters{
    
    public $railwayID;
    public $sceneID;
    public $railwayIOType;
    public $victimType;
    public $railwayType;
    public $anyWitnesses;
    public $driverSeeWhatHappened;
    public $weatherType;
    public $weatherCondition;
    public  $railwayCases;
    public $caseObj;
    public $victimsObj;
    public $sceneObj;
    
    public function __construct() {
        
    }
    
}
class Railway extends Scene{
    //put your code here
    public $paraObj ;
    public $paraObjAll;
    
    
    
     public function __construct($formData,$api){
        $this->api = $api;
	$this->paraObj = new railwayParameters();
        $this->paraObjAll =new railwayParameters();
        
        $this->paraObjAll->railwayCases = array();
        
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Railway accident",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->railwayIOType = $formData['object'][$i]['railwayIOType'];
                $this->paraObjAll->victimType = $formData['object'][$i]['victimType'];
                $this->paraObjAll->railwayType = $formData['object'][$i]['railwayType'];
                $this->paraObjAll->anyWitnesses = $formData['object'][$i]['anyWitnesses'];
                $this->paraObjAll->driverSeeWhatHappened = $formData['object'][$i]['driverSeeWhatHappened'];
                $this->paraObjAll->weatherType = $formData['object'][$i]['weatherType'];
                $this->paraObjAll->weatherCondition = $formData['object'][$i]['weatherCondition'];
                
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                $this->addRailway($sceneID);
            }
            
            
        }
    }
     public function addRailway($sceneID) {
       $railwayIOType = $this->paraObjAll->railwayIOType;
       $victimType = $this->paraObjAll->victimType;
       $railwayType = $this->paraObjAll->railwayType;
       $anyWitnesses = $this->paraObjAll->anyWitnesses;
       $driverSeeWhatHappened = $this->paraObjAll->driverSeeWhatHappened;
       $weatherType = $this->paraObjAll->weatherType;
       $weatherCondition = $this->paraObjAll->weatherCondition;
        
       $h_res = mysql_query("insert into railway values(0,$sceneID,"
                . "'$railwayIOType',"
                . "'$victimType',"
                . "'$railwayType',"
                . "'$anyWitnesses',"
                . "'$driverSeeWhatHappened',"
                . "'$weatherType',"
                . "'$weatherCondition')");
        
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
	$error = array('status' => "Failed", "msg" => "Request to create scene was successful.");
        $this->api->response($this->api->json($error), 400);
    }
    
    public function getAllRailwayCases() {
        $query ="SELECT * FROM railway";

        $result = mysql_query($query);
       
       while($info = mysql_fetch_array($result))
            {
                $this->paraObjAll->railwayCases[] = $this->getRailwayCases($info['railwayID']);
               
            }
            
            return $this->paraObjAll;
        
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from railway where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            
            $h_array['railwayIOType'] = $enc->decrypt_request($h_array['railwayIOType']);
            $h_array['victimType'] = $enc->decrypt_request($h_array['victimType']);
            $h_array['railwayType'] = $enc->decrypt_request($h_array['railwayType']);
            $h_array['anyWitnesses'] = $enc->decrypt_request($h_array['anyWitnesses']);
            $h_array['driverSeeWhatHappened'] = $enc->decrypt_request($h_array['driverSeeWhatHappened']);
            $h_array['weatherType'] = $enc->decrypt_request($h_array['weatherType']);
            $h_array['weatherCondition'] = $enc->decrypt_request($h_array['weatherCondition']);
            
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getRailwayCases($id) {
        $query ="SELECT * FROM railway WHERE railwayID=".$id;

        $result = mysql_query($query);
        
        while($info = mysql_fetch_array($result))
            {
                        
                        $this->paraObj->railwayID = $info['railwayID'];
                        $this->paraObj->sceneID = $info['sceneID'];
                        $this->paraObj->sceneOfInjury = $info['railwayIOType'];
                        $this->paraObj->victimType = $info['victimType'];
                        $this->paraObj->railwayType = $info['railwayType'];
			$this->paraObj->anyWitnesses = $info['anyWitnesses'];
			$this->paraObj->driverSeeWhatHappened = $info['driverSeeWhatHappened'];
			$this->paraObj->weatherType = $info['weatherType'];
                        $this->paraObj->weatherCondition = $info['weatherCondition'];
                        
                        
                        //get scene related data
                        $scene = $this->getSceneByID($this->paraObj->sceneID);
                        $this->paraObj->sceneObj =  $scene;

                        //get case related data
                        $caseInstance = new Cases($this->paraObj->sceneID, null);
                        $case = $caseInstance->getCaseByScene($this->paraObj->sceneID);
                        $this->paraObj->caseObj = $case ; 
                        


                        //get victims of the scene
                       $sceneVictims = new SceneVictims($this->paraObj->sceneID, null);
                       $sceneVictimsObj = $sceneVictims->getSceneVictims($this->paraObj->sceneID);
                       $this->paraObj->victimsObj = $sceneVictimsObj;

                       }

        
            return $this->paraObj;
    }
    
    
        
    
}
