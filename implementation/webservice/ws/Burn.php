<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Burn
 *
 * @author BANCHI
 */
class Burn extends Scene{
    //put your code here
    private $burnIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $accelerantsAtScene;
    private $accelerantsUsed;
    private $igniterAtScene;
    private $igniterUsed;
    private $foulPlaySuspected;
             
     public function __construct($formData,$api){
         $this->api = $api;
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Burn",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->burnIOType = $formData['object'][$i]['burnIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->accelerantsAtScene = $formData['object'][$i]['accelerantsAtScene'];
                $this->accelerantsUsed = $formData['object'][$i]['accelerantsUsed'];
                $this->igniterAtScene = $formData['object'][$i]['igniterAtScene'];
                $this->igniterUsed = $formData['object'][$i]['igniterUsed'];
                $this->foulPlaySuspected = $formData['object'][$i]['foulPlaySuspected'];
                    //
               $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addBurn($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addBurn($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    private function addBurn($sceneID,$inside,$object) {
        if($this->accelerantsUsed != NULL && $this->igniterAtScene != NULL)
        {
            $h_res = mysql_query("insert into burn values(0,".$sceneID.",'$this->burnIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->accelerantsAtScene','$this->accelerantsUsed','$this->igniterAtScene','$this->igniterUsed','$this->foulPlaySuspected')");
        }else if($this->accelerantsUsed == NULL && $this->igniterAtScene != NULL){
            $h_res = mysql_query("insert into burn values(0,".$sceneID.",'$this->burnIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->accelerantsAtScene',null,'$this->igniterAtScene','$this->igniterUsed','$this->foulPlaySuspected')");
        }  else if($this->accelerantsUsed != NULL && $this->igniterAtScene == NULL) {
              $h_res = mysql_query("insert into burn values(0,".$sceneID.",'$this->burnIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->accelerantsAtScene','$this->accelerantsUsed','$this->igniterAtScene',null,'$this->foulPlaySuspected')");
        }  else if($this->accelerantsUsed == NULL && $this->igniterAtScene == NULL) {
            $h_res = mysql_query("insert into burn values(0,".$sceneID.",'$this->burnIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->accelerantsAtScene',null,'$this->igniterAtScene',null,'$this->foulPlaySuspected')");
        }
        
        if($inside == TRUE){
            $h_res = mysql_query("select burnID from burn where sceneID=".$sceneID);
            $burnID = mysql_result($h_res,0,'burnID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into burninside values(0,".$burnID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into burninside values(0,".$burnID.",'$dl','$wc','$wb','$va',null)");
            }
        }
    }
    public function getAllBurn() {
        try{
            
            $h_res = mysql_query("select * from burn");
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
                $h_array['burnID'] = $array['burnID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['burnIOType'] = $array['burnIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['accelerantsAtScene'] = $array['accelerantsAtScene'];
                $h_array['accelerantsUsed'] = $array['accelerantsUsed'];
                $h_array['igniterAtScene'] = $array['igniterAtScene'];
                $h_array['igniterUsed'] = $array['igniterUsed'];
                $h_array['foulPlaySuspected'] = $array['foulPlaySuspected'];
                
                
                $hi_res = mysql_query("select * from burninside where burnID=".$h_array['burnID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['burnInside'] = $hi_array;
                }else{
                    $h_array['burnInside'] = NULL;
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
            
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
        }
    }
    public function getBurn($burnID) {
        try{
            
            $h_res = mysql_query("select * from burn where burnID=".$burnID);
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
                $h_array['burnID'] = $array['burnID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['burnIOType'] = $array['burnIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['accelerantsAtScene'] = $array['accelerantsAtScene'];
                $h_array['accelerantsUsed'] = $array['accelerantsUsed'];
                $h_array['igniterAtScene'] = $array['igniterAtScene'];
                $h_array['igniterUsed'] = $array['igniterUsed'];
                $h_array['foulPlaySuspected'] = $array['foulPlaySuspected'];
                
                $hi_res = mysql_query("select * from burninside where burnID=".$h_array['burnID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['burnInside'] = $hi_array;
                }else{
                    $h_array['burnInside'] = NULL;
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
            
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
        }
    }
}
