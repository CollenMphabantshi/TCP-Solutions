<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perdestrian
 *
 * @author BANCHI
 */
class Perdestrian extends Scene{
    //put your code here
    private $perdestrianOutside;
    private $hitAndRun;
    private $pedestrianType;
    private $numberOfCarsDroveOverBody;
    private $weatherConditionType;
    private $weatherCondition;
    
      public function __construct($formData,$api){
        $this->api = $api;
        if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Pedestrian",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
               
                $this->perdestrianOutside = $formData['object'][$i]['perdestrianOutside'];
                $this->hitAndRun = $formData['object'][$i]['hitAndRun'];
                $this->pedestrianType = $formData['object'][$i]['pedestrianType'];
                $this->numberOfCarsDroveOverBody = $formData['object'][$i]['numberOfCarsDroveOverBody'];
                $this->weatherConditionType = $formData['object'][$i]['weatherConditionType'];
                $this->weatherCondition = $formData['object'][$i]['weatherCondition'];
                    //
                $sceneID = $this->createScene();
                
                 if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
            }
            
            
        }
        
    }
    
    private function addPedestrian($sceneID) {
        
            $h_res = mysql_query("insert into pedestrian values(0,".$sceneID.",'$this->perdestrianOutside','$this->hitAndRun','$this->pedestrianType','$this->numberOfCarsDroveOverBody','$this->weatherConditionType','$this->weatherCondition')");
    }
    public function getAllPedestrian() {
        try{
            
            $h_res = mysql_query("select * from pedestrian");
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
                $h_array['perdestrianID'] = $array['perdestrianID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['perdestrianOutsideType'] = $array['perdestrianOutsideType'];
                $h_array['hitAndRun'] = $array['hitAndRun'];
                $h_array['pedestrianType'] = $array['pedestrianType'];
                $h_array['numberOfCarsDroveOverBody'] = $array['numberOfCarsDroveOverBody'];
                $h_array['weatherConditionType'] = $array['weatherConditionType'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
               
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
            
            $error = array('status' => "Failed", "msg" => "Request to get pedestrian scenes was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getDataBySceneID($sceneID) {
        try{
            $h_res = mysql_query("select * from pedestrian where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getPedestrian($perdestrianID) {
        try{
            
            $h_res = mysql_query("select * from pedestrian where perdestrianID=".$perdestrianID);
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
                $h_array['perdestrianID'] = $array['perdestrianID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['perdestrianOutsideType'] = $array['perdestrianOutsideType'];
                $h_array['hitAndRun'] = $array['hitAndRun'];
                $h_array['pedestrianType'] = $array['pedestrianType'];
                $h_array['numberOfCarsDroveOverBody'] = $array['numberOfCarsDroveOverBody'];
                $h_array['weatherConditionType'] = $array['weatherConditionType'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                
               
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
            
            $error = array('status' => "Failed", "msg" => "Request to get pedestrian scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
    }
}
