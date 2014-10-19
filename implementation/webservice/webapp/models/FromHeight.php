<?php
require_once("Scene.php");
require_once './ScenePhotos.php';
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
    public $images;
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
                parent::__construct($formData['object'][$i]['sceneTime'],"Fall/push/jump from height",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->paraObjAll->heightIOType = $formData['object'][$i]['heightIOType'];
                $this->paraObjAll->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->paraObjAll->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->paraObjAll->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->paraObjAll->fromWhat = $formData['object'][$i]['fromWhat'];
                $this->paraObjAll->howHigh = $formData['object'][$i]['howHigh'];
                $this->paraObjAll->onWhatSurface = $formData['object'][$i]['onWhatSurface'];
                $this->paraObjAll->anyWitnesses = $formData['object'][$i]['anyWitnesses']; 
                $this->images = $formData['object'][$i]['images'][0];
               $sceneID = $this->createScene();
                 if($sceneID === NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.  $sceneID".$sceneID);
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                $enc = new Encryption();
                $vinside = $enc->decrypt_request($formData['object'][$i]['victims'][0]['victimInside']);
                if($vinside === "Yes"){
                    $this->addHeight($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addHeight($sceneID,FALSE,null);
                }
            }
            
            
        }
	
    }
    
    public function addHeight($sceneID,$inside,$object) {
        $heightIOType = $this->paraObjAll->heightIOType;
        $signsOfStruggle = $this->paraObjAll->signsOfStruggle;
        $alcoholBottleAround = $this->paraObjAll->alcoholBottleAround;
        $drugParaphernalia = $this->paraObjAll->drugParaphernalia;
        $fromWhat = $this->paraObjAll->fromWhat;
        $howHigh = $this->paraObjAll->howHigh;
        $onWhatVictimLanded = $this->paraObjAll->onWhatVictimLanded;
        $anyWitnesses = $this->paraObjAll->anyWitnesses;
        $h_res = mysql_query("insert into height values(0,$sceneID,"
                . "'$heightIOType',"
                . "'$signsOfStruggle',"
                . "'$alcoholBottleAround',"
                . "'$drugParaphernalia',"
                . "'$fromWhat',"
                . "'$howHigh',"
                . "'$onWhatVictimLanded',"
                . "'$anyWitnesses')");
        
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside === TRUE){
            $h_res = mysql_query("select heightID from height where sceneID=".$sceneID);
            $heightID = mysql_result($h_res,0,'heightID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            $enc = new Encryption();
            if($enc->decrypt_request($va) !== "Yes")
            {
                $hi_res = mysql_query("insert into heightinside values(0,".$heightID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into heightinside values(0,".$heightID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        $scenePhoto = new ScenePhotos($this->api);
        
        
        for($i = 0; $i < count($this->images);$i++)
        {
            $scenePhoto->upload($this->images['names'.$i], $this->images['data'.$i], $sceneID);
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
            $enc = new Encryption();
            $h_res = mysql_query("select * from height where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from heightinside where heightID=".$h_array['heightID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $hi_array['doorLocked'] = $enc->decrypt_request($hi_array['doorLocked']);
                    $hi_array['windowsClosed'] = $enc->decrypt_request($hi_array['windowsClosed']);
                    $hi_array['windowsBroken'] = $enc->decrypt_request($hi_array['windowsBroken']);
                    $hi_array['victimAlone'] = $enc->decrypt_request($hi_array['victimAlone']);
                    if($hi_array['peopleWithVictim'] !== NULL)
                    {
                        $hi_array['peopleWithVictim'] = $enc->decrypt_request($hi_array['peopleWithVictim']);
                    }else{
                        $hi_array['peopleWithVictim'] = "none";
                    }
                    
                    $h_array['heightInside'] = $hi_array;
                }else{
                    $h_array['heightInside'] = "null";
                }
                
                $h_array['heightIOType'] = $enc->decrypt_request($h_array['heightIOType']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['fromWhat'] = $enc->decrypt_request($h_array['fromWhat']);
                $h_array['howHigh'] = $enc->decrypt_request($h_array['howHigh']);
                $h_array['onWhatSurface'] = $enc->decrypt_request($h_array['onWhatSurface']);
                $h_array['anyWitnesses'] = $enc->decrypt_request($h_array['anyWitnesses']);
                $sp = new ScenePhotos($this->api);
                $files = $sp->getPhotos($sceneID);
                if($files !== NULL)
                {
                    $h_array['photos'] = $files;
                }else{
                    $h_array['photos'] = "unavailable";
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
