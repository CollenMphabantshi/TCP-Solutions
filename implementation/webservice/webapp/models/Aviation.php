<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aviation
 *
 * @author BANCHI
 */
class Aviation extends Scene{
    //put your code here
    private $aviationOutsideType;
    private $aircraftType;
    private $aircraftNumPeople;
    private $weatherCondition;
    private $weatherType;
    
     public function __construct($formData,$api){
         $this->api = $api;
         if($formData == NULL)
        {
            parent::__construct(null,null,"","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Aviation",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->aviationOutsideType = $formData['object'][$i]['aviationOutsideType'];
                $this->aircraftType = $formData['object'][$i]['autoeroticAsphyxia'];
                $this->aircraftNumPeople = $formData['object'][$i]['aircraftNumPeople'];
                $this->weatherCondition = $formData['object'][$i]['weatherCondition'];
                $this->weatherType = $formData['object'][$i]['weatherType'];
                    //
                $sceneID = $this->createScene();
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
               
                $error = array('status' => "Success", "msg" => "Request to create a scene was accepted.");
                $this->api->response($this->api->json($error), 400);
            }
            
            
        }
    }
    private function addAviation($sceneID) {
     
            $h_res = mysql_query("insert into aviation values(0,".$sceneID.",'$this->aviationOutsideType','$this->aircraftType','$this->aircraftNumPeople','$this->weatherCondition','$this->weatherType')");
        
            $h_res = mysql_query("select aviationID from aviation where sceneID=".$sceneID);
            $aviationID = mysql_result($h_res,0,'aviationID');
        
        
    }
    public function getAllAviation() {
        try{
            
            $h_res = mysql_query("select * from aviation");
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
                $h_array['aviationID'] = $array['aviationID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['aviationOutsideType'] = $array['aviationOutsideType'];
                $h_array['aircraftType'] = $array['aircraftType'];
                $h_array['aircraftNumPeople'] = $array['aircraftNumPeople'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['weatherType'] = $array['weatherType'];
                          
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
            $h_res = mysql_query("select * from aviation where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getAviation($aviationID) {
        try{
            
            $h_res = mysql_query("select * from aviation where aviationID=".$aviationID);
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
                $h_array['aviationID'] = $array['aviationID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['aviationOutsideType'] = $array['aviationOutsideType'];
                $h_array['aircraftType'] = $array['aircraftType'];
                $h_array['aircraftNumPeople'] = $array['aircraftNumPeople'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['weatherType'] = $array['weatherType'];
                
                
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
