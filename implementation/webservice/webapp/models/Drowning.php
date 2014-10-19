<?php
require_once("Scene.php");
require_once './ScenePhotos.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Drowning
 *
 * @author BANCHI
 */
class Drowning extends Scene{
    //put your code here
    private $drowningIOType;
    private $drowningType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $wasBodyInsideWater;
    private $whoRemovedBody;
    private $fencedOff;
    private $wasGateClosed;
    private $waterType;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected;
    public $images;
     public function __construct($formData,$api){
         $this->api = $api;
         
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Drowning",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
               
                $this->drowningIOType = $formData['object'][$i]['drowningIOType'];
                $this->drowningType = $formData['object'][$i]['drowningType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->wasBodyInsideWater = $formData['object'][$i]['wasBodyInsideWater'];
                $this->whoRemovedBody = $formData['object'][$i]['whoRemovedBody'];
                $this->fencedOff = $formData['object'][$i]['fencedOff'];
                $this->wasGateClosed = $formData['object'][$i]['wasGateClosed'];
                $this->waterType = $formData['object'][$i]['waterType'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                
				$this->images = $formData['object'][$i]['images'][0];
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                $enc = new Encryption();
                $vinside = $enc->decrypt_request($formData['object'][$i]['victims'][0]['victimInside']);
                if($vinside === "Yes"){
                    $this->addDrowning($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addDrowning($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addDrowning($sceneID,$inside,$object) {
       $d_res = mysql_query("insert into drowning values(0,$sceneID,"
        . "'$this->drowningIOType',"
        . "'$this->drowningType',"
        . "'$this->signsOfStruggle',"
        . "'$this->alcoholBottleAround',"
        . "'$this->drugParaphernalia',"
               . "'$this->wasBodyInsideWater',"
               . "'$this->whoRemovedBody',"
               . "'$this->fencedOff',"
               . "'$this->wasGateClosed',"
               . "'$this->waterType',"
               . "'$this->strangulationSuspected',"
               . "'$this->smotheringSuspected',"
               . "'$this->chockingSuspected')");
        
       
       if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
       if($inside === TRUE){
            $h_res = mysql_query("select * from drowning where sceneID=".$sceneID);
            $drowningID = mysql_result($h_res,0,'drowningID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            $enc = new Encryption();
            if($enc->decrypt_request($va) !== "Yes")
            {
                $hi_res = mysql_query("insert into drowninginside values(0,".$drowningID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into drowninginside values(0,".$drowningID.",'$dl','$wc','$wb','$va',null)");
            }
        }
        $scenePhoto = new ScenePhotos($this->api);
        
        
        for($i = 0; $i < count($this->images);$i++)
        {
            $scenePhoto->upload($this->images['names'.$i], $this->images['data'.$i], $sceneID);
        }
        $error = array('status' => "Success", "msg" => "Request to create a scene was successful.");
            $this->api->response($this->api->json($error), 200);
    }
    public function getAllDrowning() {
        try{
            
            $h_res = mysql_query("select * from drowning");
            $h_rows = mysql_num_rows($h_res);
            $h_i = 0;
            $sv_i = 0;
            $v_i = 0;
            $h_array = array();
            $f_array = array();
            $final_array = array();
            $sv_array = array();
            while(($array = mysql_fetch_array($h_res)))
            {
                $h_i++;
                $h_array['drowningID'] = $array['drowningID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['drowningIOType'] = $array['drowningIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['wasBodyInsideWater'] = $array['wasBodyInsideWater'];
                $h_array['whoRemovedBody'] = $array['whoRemovedBody'];
                $h_array['fencedOff'] = $array['fencedOff'];
                $h_array['wasGateClosed'] = $array['wasGateClosed'];
                $h_array['waterType'] = $array['waterType'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                
                $hi_res = mysql_query("select * from drowninginside where drowningID=".$h_array['drowningID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['drowningInside'] = $hi_array;
                }else{
                    $h_array['drowningInside'] = NULL;
                }
                $f_array[] = $h_array; 
                
                
                $tmp = $this->sceneVictim->getSceneVictims($h_array['sceneID']);
                $v_i = $v_i + count($tmp);
                $sv_array[] = $tmp;
            }
            
            $final_array['victims'] = $sv_array;
            $final_array['objectlist'] = $f_array;
            $final_array['count'] = $h_i;
            $final_array['victimNumber'] = $v_i;
            return $final_array;
        }catch(Exception $ex){
            
            $error = array('status' => "Failed", "msg" => "Request to get hanging scenes was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from drowning where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from drowninginside where drowningID=".$h_array['drowningID']);
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
                    $h_array['drowningInside'] = $hi_array;
                }else{
                    $h_array['drowningInside'] = "null";
                }
                
                $h_array['drowningIOType'] = $enc->decrypt_request($h_array['drowningIOType']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['wasBodyInsideWater'] = $enc->decrypt_request($h_array['wasBodyInsideWater']);
                $h_array['whoRemovedBody'] = $enc->decrypt_request($h_array['whoRemovedBody']);
                $h_array['fencedOff'] = $enc->decrypt_request($h_array['fencedOff']);
                $h_array['wasGateClosed'] = $enc->decrypt_request($h_array['wasGateClosed']);
                $h_array['waterType'] = $enc->decrypt_request($h_array['waterType']);
                $h_array['strangulationSuspected'] = $enc->decrypt_request($h_array['strangulationSuspected']);
                $h_array['smotheringSuspected'] = $enc->decrypt_request($h_array['smotheringSuspected']);
                $h_array['chockingSuspected'] = $enc->decrypt_request($h_array['chockingSuspected']);
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
    public function getDrowning($drowningID) {
        try{
            
            $h_res = mysql_query("select * from drowning where drowningID=".$drowningID);
            $h_rows = mysql_num_rows($h_res);
            $h_i = 0;
            $sv_i = 0;
            $v_i = 0;
            $h_array = array();
            $f_array = array();
            $final_array = array();
            $sv_array = array();
            while(($array = mysql_fetch_array($h_res)))
            {
                 $h_i++;
                $h_array['drowningID'] = $array['drowningID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['drowningIOType'] = $array['drowningIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['wasBodyInsideWater'] = $array['wasBodyInsideWater'];
                $h_array['whoRemovedBody'] = $array['whoRemovedBody'];
                $h_array['fencedOff'] = $array['fencedOff'];
                $h_array['wasGateClosed'] = $array['wasGateClosed'];
                $h_array['waterType'] = $array['waterType'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                
                $hi_res = mysql_query("select * from drowninginside where drowningID=".$h_array['drowningID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['drowningInside'] = $hi_array;
                }else{
                    $h_array['drowningInside'] = NULL;
                }
                $f_array[] = $h_array; 
                
                
                $tmp = $this->sceneVictim->getSceneVictims($h_array['sceneID']);
                $v_i = $v_i + count($tmp);
                $sv_array[] = $tmp;
            }
            
            $final_array['victims'] = $sv_array;
            $final_array['objectlist'] = $f_array;
            $final_array['count'] = $h_i;
            $final_array['victimNumber'] = $v_i;
            return $final_array;
        }catch(Exception $ex){
            
            $error = array('status' => "Failed", "msg" => "Request to get hanging scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
}
