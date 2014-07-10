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
                    //
                $sceneID = $this->createScene();
                
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addHanging($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addHanging($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addHanging($sceneID,$inside,$object) {
        if($this->whoRemovedLigature != NULL)
        {
            $h_res = mysql_query("insert into hanging values(0,".$sceneID.",'$this->hangingIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->autoeroticAsphyxia','$this->partialHangingType','$this->completeHanging','$this->ligatureAroundNeck','$this->whoRemovedLigature','$this->ligatureType','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected')");
        }else{
            $h_res = mysql_query("insert into hanging values(0,".$sceneID.",'$this->hangingIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->autoeroticAsphyxia','$this->partialHangingType','$this->completeHanging','$this->ligatureAroundNeck',null,'$this->ligatureType','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected')");
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select hangingID from hanging where sceneID=".$sceneID);
            $hangingID = mysql_result($h_res,0,'hangingID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into hanginginside values(0,".$hangingID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into hanginginside values(0,".$hangingID.",'$dl','$wc','$wb','$va',null)");
            }
        }
    }
    public function getAllHangings() {
        try{
            
            $h_res = mysql_query("select * from hanging");
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
            
            $error = array('status' => "Failed", "msg" => "Request to get hanging scenes was denied.");
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
