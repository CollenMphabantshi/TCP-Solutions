<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FoetusabandonedBaby
 *
 * @author BANCHI
 */
class FoetusabandonedBaby extends Scene{
    //put your code here
     private $foetusabandonedbabyID;
     private $sceneID;
     private $foetusabandonedbabyIOType;
     private $howWasBodyDiscovered;
     private $wasBodyCovered;
     private $coveredWith;
     public function __construct($formData,$api){
         $this->api = $api;
	if($formData == NULL)
        {
            parent::__construct(null);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"FoetusabandonedBaby",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->foetusabandonedbabyIOType = $formData['object'][$i]['foetusabandonedbabyIOType'];
                $this->howWasBodyDiscovered = $formData['object'][$i]['howWasBodyDiscovered'];
                $this->wasBodyCovered = $formData['object'][$i]['wasBodyCovered'];
                $this->coveredWith = $formData['object'][$i]['coveredWith'];
                    //
                $sceneID = $this->createScene();
                if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addFoetusabandonedBaby($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addFoetusabandonedBaby($sceneID,FALSE,null);
                }
            }
            
            
        }
    }
    private function addFoetusabandonedBaby($sceneID) {
            $h_res = mysql_query("insert into foetusabandonedbaby values(0,".$sceneID.",'$this->foetusabandonedbabyIOType','$this->howWasBodyDiscovered','$this->wasBodyCovered','$this->coveredWith')");    
    }
    public function getAllFoetusabandonedBaby() {
        try{
            
            $h_res = mysql_query("select * from foetusabandonedbaby");
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
                $h_array['foetusabandonedbabyID'] = $array['foetusabandonedbabyID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['foetusabandonedbabyIOType'] = $array['foetusabandonedbabyIOType'];
                $h_array['howWasBodyDiscovered'] = $array['howWasBodyDiscovered'];
                $h_array['wasBodyCovered'] = $array['wasBodyCovered'];
                $h_array['coveredWith'] = $array['coveredWith'];
                
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
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from foetusabandonedbaby where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
     public function getFoetusabandonedBaby($foetusabandonedbabyID) {
        try{
            
            $h_res = mysql_query("select * from foetusabandonedbaby where foetusabandonedbabyID=".$foetusabandonedbabyID);
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
                $h_array['foetusabandonedbabyIOType'] = $array['foetusabandonedbabyIOType'];
                $h_array['howWasBodyDiscovered'] = $array['howWasBodyDiscovered'];
                $h_array['wasBodyCovered'] = $array['wasBodyCovered'];
                $h_array['coveredWith'] = $array['coveredWith'];
                
                $hi_res = mysql_query("select * from foetusabandonedbaby where foetusabandonedbabyID=".$h_array['foetusabandonedbabyID']);
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
