<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CrushInjury
 *
 * @author BANCHI
 */
class CrushInjury extends Scene{
    //put your code here
    private $crushIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $wasBodyMoved;
    private $betweenWhichObjects;
    private $anyWitness;
    private $whatWasVictimDoing;
    
    public function __construct($formData,$api){
        $this->api = $api;
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"CrushInjury",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->crushIO = $formData['object'][$i]['crushIO'];
                 $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->wasBodyMoved = $formData['object'][$i]['wasBodyMoved'];
                $this->betweenWhichObjects = $formData['object'][$i]['betweenWhichObjects'];
                $this->anyWitness = $formData['object'][$i]['anyWitness'];
                $this->whatWasVictimDoing = $formData['object'][$i]['whatWasVictimDoing'];
                    //
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);    
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addCrushInjury($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addCrushInjury($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addCrushInjury($sceneID,$inside,$object) {
        $c_res = mysql_query("insert into crushinjury values(0,$sceneID"
        . ",'$this->crushIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->wasBodyMoved','$this->betweenWhichObjects','$this->anyWitness','$this->whatWasVictimDoing')");
        if($inside == TRUE){
            $h_res = mysql_query("select * from crushinjury where sceneID=".$sceneID);
            $crushinjuryID = mysql_result($h_res,0,'crushinjuryID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "Yes")
            {
                $hi_res = mysql_query("insert into crushinjuryinside values(0,".$crushinjuryID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into crushinjuryinside values(0,".$crushinjuryID.",'$dl','$wc','$wb','$va',null)");
            }
        }
    }
    public function getAllCrushInjury() {
        try{
            
            $h_res = mysql_query("select * from crushinjury");
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
                $h_array['crushinjuryID'] = $array['crushinjuryID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['crushIOType'] = $array['crushIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['wasBodyMoved'] = $array['wasBodyMoved'];
                $h_array['betweenWhichObjects'] = $array['betweenWhichObjects'];
                $h_array['anyWitness'] = $array['anyWitness'];
                $h_array['whatWasVictimDoing'] = $array['whatWasVictimDoing'];
                
                $hi_res = mysql_query("select * from crushinjuryinside where crushinjuryID=".$h_array['crushinjuryID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['crushInside'] = $hi_array;
                }else{
                    $h_array['crushInside'] = NULL;
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
            $h_res = mysql_query("select * from crushinjury where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from crushinjuryinside where crushinjuryID=".$h_array['crushinjuryID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['crushinjuryInside'] = $hi_array;
                }else{
                    $h_array['crushinjuryInside'] = NULL;
                }
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getCrushInjury($crushinjuryID) {
        try{
            
            $h_res = mysql_query("select * from crushinjury where crushinjuryID=".$crushinjuryID);
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
                $h_array['crushinjuryID'] = $array['crushinjuryID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['crushIO'] = $array['crushIO'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['wasBodyMoved'] = $array['wasBodyMoved'];
                $h_array['betweenWhichObjects'] = $array['betweenWhichObjects'];
                $h_array['anyWitness'] = $array['anyWitness'];
                $h_array['whatWasVictimDoing'] = $array['whatWasVictimDoing'];
                
                $hi_res = mysql_query("select * from crushinjuryinside where crushinjuryID=".$h_array['crushinjuryID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['crushInside'] = $hi_array;
                }else{
                    $h_array['crushInside'] = NULL;
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
