<?php
require_once("Scene.php");
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
               
                $this->drowningIO = $formData['object'][$i]['drowningIO'];
                $this->drowningType = $formData['object'][$i]['drowningType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->wasBodyInsideWater = $formData['object'][$i]['wasBodyInsideWater'];
                $this->whoRemovedBody = $formData['object'][$i]['whoRemovedBody'];
                $this->fencedOff = $formData['object'][$i]['fencedOff'];
                $this->wasGateClosed = $formData['object'][$i]['dwasGateClosed'];
                $this->waterType = $formData['object'][$i]['waterType'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                    //
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addDrowning($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addDrowning($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addDrowning($sceneID,$inside,$object) {
       $d_res = mysql_query("insert into drowning values(0,$sceneID,"
        . "'$this->drowningIOType','$this->drowningType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->wasBodyInsideWater','$this->whoRemovedBody','$this->fencedOff','$this->wasGateClosed','$this->waterType','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected')");
        if($inside == TRUE){
            $h_res = mysql_query("select * from drowning where sceneID=".$sceneID);
            $drowningID = mysql_result($h_res,0,'drowningID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "Yes")
            {
                $hi_res = mysql_query("insert into drowninginside values(0,".$drowningID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into drowninginside values(0,".$drowningID.",'$dl','$wc','$wb','$va',null)");
            }
        }
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
            $h_res = mysql_query("select * from drowning where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from drowninginside where drowningID=".$h_array['drowningID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['drowningInside'] = $hi_array;
                }else{
                    $h_array['drowningInside'] = NULL;
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
                $h_array['drowningIO'] = $array['hangingIOType'];
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
