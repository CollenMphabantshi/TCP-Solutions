<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hanging
 *
 * @author BANCHI
 */
class Hanging extends Scene{
    //put your code here
    private $hangingIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $autoeroticAsphyxia;
    private $partialHangingType;
    private $completeHanging;
    private $ligatureAroundNeck;
    private $whoRemovedLigature;
    private $ligatureType;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected; 
    private $bodyCutDown;
    private $whoCutDownBody;
    private $suspensionPointUsed;
    
    public function __construct($formData,$api){
        $this->api = $api;
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Hanging",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
               
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->autoeroticAsphyxia = $formData['object'][$i]['autoeroticAsphyxia'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->completeHanging = $formData['object'][$i]['completeHanging'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->hangingIOType = $formData['object'][$i]['hangingIOType'];
                $this->ligatureAroundNeck = $formData['object'][$i]['ligatureAroundNeck'];
                $this->ligatureType = $formData['object'][$i]['ligatureType'];
                $this->partialHangingType = $formData['object'][$i]['partialHangingType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->whoRemovedLigature = $formData['object'][$i]['whoRemovedLigature'];
                $this->bodyCutDown = $formData['object'][$i]['bodyCutDown'];
                $this->whoCutDownBody = $formData['object'][$i]['whoCutDownBody'];
                $this->suspensionPointUsed = $formData['object'][$i]['suspensionPointUsed'];
                    //
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
                    $this->addHanging($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addHanging($sceneID,FALSE,null);
                }
                
            }
            $error = array('status' => "Success", "msg" => "Your data was successfully saved.");
            $this->api->response($this->api->json($error), 200);
            
        }
        
    }
    
    private function addHanging($sceneID,$inside,$object) {
         $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
         
        if($this->whoRemovedLigature != NULL)
        {
            $h_res = mysql_query("insert into hanging values(0,"
            .$sceneID.",'$this->hangingIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->autoeroticAsphyxia','$this->partialHangingType','$this->completeHanging','$this->ligatureAroundNeck','$this->whoRemovedLigature','$this->ligatureType','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected','$this->bodyCutDown','$this->whoCutDownBody','$this->suspensionPointUsed')")
                or $this->api->response($this->api->json($error), 400);
        }else{
            $h_res = mysql_query("insert into hanging values(0,"
            .$sceneID.",'$this->hangingIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->autoeroticAsphyxia','$this->partialHangingType','$this->completeHanging','$this->ligatureAroundNeck',null,'$this->ligatureType','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected','$this->bodyCutDown','$this->whoCutDownBody','$this->suspensionPointUsed')")
              or  $this->api->response($this->api->json($error), 400);
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select hangingID from hanging where sceneID=".$sceneID) or $this->api->response($this->api->json($error), 400);
            $hangingID = mysql_result($h_res,0,'hangingID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            $enc = new Encryption();
            if($enc->decrypt_request($va) !== "Yes")
            {
                $hi_res = mysql_query("insert into hanginginside values(0,".$hangingID.",'$dl','$wc','$wb','$va','$pv')") or $this->api->response($this->api->json($error), 400);
            }else{
                $hi_res = mysql_query("insert into hanginginside values(0,".$hangingID.",'$dl','$wc','$wb','$va',null)") or $this->api->response($this->api->json($error), 400);
            }
        }
    }
    public function getAllHangings() {
        $error = array('status' => "Failed", "msg" => "Request to get hanging scenea was denied.");
        try{
            
            $h_res = mysql_query("select * from hanging") or $this->api->response($this->api->json($error), 400);
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
                $h_array['hangingID'] = $array['hangingID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['hangingIOType'] = $array['hangingIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['autoeroticAsphyxia'] = $array['autoeroticAsphyxia'];
                $h_array['partialHangingType'] = $array['partialHangingType'];
                $h_array['completeHanging'] = $array['completeHanging'];
                $h_array['ligatureAroundNeck'] = $array['ligatureAroundNeck'];
                $h_array['whoRemovedLigature'] = $array['whoRemovedLigature'];
                $h_array['ligatureType'] = $array['ligatureType'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['bodyCutDown'] = $array['bodyCutDown'];
                $h_array['whoCutDownBody'] = $array['whoCutDownBody'];
                $h_array['suspensionPointUsed'] = $array['suspensionPointUsed'];
                
                $hi_res = mysql_query("select * from hanginginside where hangingID=".$h_array['hangingID']) or $this->api->response($this->api->json($error), 400);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['hangingInside'] = $hi_array;
                }else{
                    $h_array['hangingInside'] = NULL;
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
            $h_res = mysql_query("select * from hanging where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from hanginginside where hangingID=".$h_array['hangingID']);
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
                    $h_array['hangingInside'] = $hi_array;
                }else{
                    $h_array['hangingInside'] = NULL;
                }
                
                $h_array['hangingIOType'] = $enc->decrypt_request($h_array['hangingIOType']);
                $h_array['autoeroticAsphyxia'] = $enc->decrypt_request($h_array['autoeroticAsphyxia']);
                $h_array['partialHangingType'] = $enc->decrypt_request($h_array['partialHangingType']);
                $h_array['completeHanging'] = $enc->decrypt_request($h_array['completeHanging']);
                $h_array['ligatureAroundNeck'] = $enc->decrypt_request($h_array['ligatureAroundNeck']);
                $h_array['whoRemovedLigature'] = $enc->decrypt_request($h_array['whoRemovedLigature']);
                $h_array['ligatureType'] = $enc->decrypt_request($h_array['ligatureType']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['strangulationSuspected'] = $enc->decrypt_request($h_array['strangulationSuspected']);
                $h_array['smotheringSuspected'] = $enc->decrypt_request($h_array['smotheringSuspected']);
                $h_array['chockingSuspected'] = $enc->decrypt_request($h_array['chockingSuspected']);
                $h_array['bodyCutDown'] = $enc->decrypt_request($h_array['bodyCutDown']);
                $h_array['whoCutDownBody'] = $enc->decrypt_request($h_array['whoCutDownBody']);
                $h_array['suspensionPointUsed'] = $enc->decrypt_request($h_array['suspensionPointUsed']);
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getHanging($hangingID) {
        try{
            
            $h_res = mysql_query("select * from hanging where hangingID=".$hangingID);
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
                $h_array['hangingID'] = $array['hangingID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['hangingIOType'] = $array['hangingIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['autoeroticAsphyxia'] = $array['autoeroticAsphyxia'];
                $h_array['partialHangingType'] = $array['partialHangingType'];
                $h_array['completeHanging'] = $array['completeHanging'];
                $h_array['ligatureAroundNeck'] = $array['ligatureAroundNeck'];
                $h_array['whoRemovedLigature'] = $array['whoRemovedLigature'];
                $h_array['ligatureType'] = $array['ligatureType'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['bodyCutDown'] = $array['bodyCutDown'];
                $h_array['whoCutDownBody'] = $array['whoCutDownBody'];
                $h_array['suspensionPointUsed'] = $array['suspensionPointUsed'];
                
                $hi_res = mysql_query("select * from hanginginside where hangingID=".$h_array['hangingID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['hangingInside'] = $hi_array;
                }else{
                    $h_array['hangingInside'] = NULL;
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
