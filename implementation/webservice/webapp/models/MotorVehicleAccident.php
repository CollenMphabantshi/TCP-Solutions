<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MotorVehicleAccident
 *
 * @author BANCHI
 */
class MotorVehicleAccident extends Scene{
    //put your code here
    private $victimFoundInCar;
    private $mvaOutsideType;
    private $occupants;
    private $numberOfOccupants;
    private $victimWas;
    private $carWasHitFrom;
    private $victimType;
    private $carBurnt;
    
     public function __construct($formData,$api){
         $this->api = $api;
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"MotorVehicleAccident",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->victimFoundInCar = $formData['object'][$i]['victimFoundInCar'];
                $this->mvaOutsideType = $formData['object'][$i]['mvaOutsideType'];
                $this->occupants = $formData['object'][$i]['occupants'];
                $this->numberOfOccupants = $formData['object'][$i]['numberOfOccupants'];
                $this->victimWas = $formData['object'][$i]['victimWas'];
                $this->carWasHitFrom = $formData['object'][$i]['carWasHitFrom'];
                $this->victimType = $formData['object'][$i]['victimType'];
                $this->carBurnt = $formData['object'][$i]['carBurnt'];
                
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
    
    private function addMotorVehicleAccident($sceneID) {
     
            $h_res = mysql_query("insert into mva values(0,".$sceneID.",'$this->victimFoundInCar','$this->mvaOutsideType','$this->occupants','$this->numberOfOccupants','$this->victimWas','$this->carWasHitFrom','$this->victimType','$this->carBurnt')");
        
    }
    public function getAllMotorVehicleAccident() {
        try{
            
            $h_res = mysql_query("select * from mva");
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
                $h_array['mvaID'] = $array['mvaID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['victimFoundInCar'] = $array['victimFoundInCar'];
                $h_array['mvaOutsideType'] = $array['mvaOutsideType'];
                $h_array['occupants'] = $array['occupants'];
                $h_array['numberOfOccupants'] = $array['numberOfOccupants'];
                $h_array['victimWas'] = $array['victimWas'];
                $h_array['carWasHitFrom'] = $array['carWasHitFrom'];
                $h_array['victimType'] = $array['victimType'];
                $h_array['carBurnt'] = $array['carBurnt'];
                
                
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
            $h_res = mysql_query("select * from mva where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getMotorVehicleAccident($hangingID) {
        try{
            
            $h_res = mysql_query("select * from mva where mvaID=".$mvaID);
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
                $$h_i++;
                $h_array['mvaID'] = $array['mvaID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['victimFoundInCar'] = $array['victimFoundInCar'];
                $h_array['mvaOutsideType'] = $array['mvaOutsideType'];
                $h_array['occupants'] = $array['occupants'];
                $h_array['numberOfOccupants'] = $array['numberOfOccupants'];
                $h_array['victimWas'] = $array['victimWas'];
                $h_array['carWasHitFrom'] = $array['carWasHitFrom'];
                $h_array['victimType'] = $array['victimType'];
                $h_array['carBurnt'] = $array['carBurnt'];
                
                $hi_res = mysql_query("select * from hanginginside where mvaID=".$h_array['mvaID']);
                
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
