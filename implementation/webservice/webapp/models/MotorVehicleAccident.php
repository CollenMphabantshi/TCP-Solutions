<?php
require_once("Scene.php");
require_once './ScenePhotos.php';
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
	private $alcoholBottleAround;
	private $drugParaphernalia;
    private $weatherType;
    private $weatherCondition;
    private $anyWitnessest;
    private $seatBeltOnt;
    private $airbagDiploid;
    private $trappedInCar;
    private $bodyHit;
    private $numberOfHit;
    public $images;
     public function __construct($formData,$api){
         $this->api = $api;
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Motor vehicle accident",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->victimFoundInCar = $formData['object'][$i]['victimFoundInCar'];
                $this->mvaOutsideType = $formData['object'][$i]['mvaOutsideType'];
                $this->occupants = $formData['object'][$i]['occupants'];
                $this->numberOfOccupants = $formData['object'][$i]['numberOfOccupants'];
                $this->victimWas = $formData['object'][$i]['victimWas'];
                $this->carWasHitFrom = $formData['object'][$i]['carWasHitFrom'];
                $this->victimType = $formData['object'][$i]['victimType'];
                $this->carBurnt = $formData['object'][$i]['carBurnt'];
		$this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
		$this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->weatherType = $formData['object'][$i]['weatherType'];
                $this->weatherCondition = $formData['object'][$i]['weatherCondition'];
                $this->anyWitnesses = $formData['object'][$i]['anyWitnesses'];
                $this->seatBeltOn = $formData['object'][$i]['seatBeltOn'];
                $this->airbagDiploid = $formData['object'][$i]['airbagDiploid'];
                $this->trappedInCar = $formData['object'][$i]['trappedInCar'];
                $this->bodyHit = $formData['object'][$i]['bodyHit'];
                $this->numberOfHit = $formData['object'][$i]['numberOfHit'];
                $this->images = $formData['object'][$i]['images'][0];
                $sceneID = $this->createScene();
                if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
		$this->addMotorVehicleAccident($sceneID);
            }
            
            
        }
        
    }
    
    private function addMotorVehicleAccident($sceneID) {
     
            $h_res = mysql_query("insert into mva values(0,$sceneID,"
                    . "'$this->victimFoundInCar',"
                    . "'$this->mvaOutsideType',"
                    . "'$this->occupants',"
                    . "'$this->numberOfOccupants',"
                    . "'$this->victimWas',"
                    . "'$this->carWasHitFrom',"
                    . "'$this->victimType',"
                    . "'$this->carBurnt',"
                    . "'$this->alcoholBottleAround',"
                    . "'$this->drugParaphernalia',"
                    . "'$this->weatherType',"
                    . "'$this->weatherCondition',"
                    . "'$this->anyWitnesses',"
                    . "'$this->seatBeltOn',"
                    . "'$this->airbagDiploid',"
                    . "'$this->trappedInCar',"
                    . "'$this->bodyHit',"
                    . "'$this->numberOfHit')");
             
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        $scenePhoto = new ScenePhotos($this->api);
        
        
        for($i = 0; $i < count($this->images);$i++)
        {
            $scenePhoto->upload($this->images['names'.$i], $this->images['data'.$i], $sceneID);
        }
        $error = array('status' => "Success", "msg" => "Request to create a scene was successful.");
            $this->api->response($this->api->json($error), 200);
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
		$h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
		$h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['weatherType'] = $array['weatherType'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['anyWitnesses'] = $array['anyWitnesses'];
                $h_array['seatBeltOn'] = $array['seatBeltOn'];
                $h_array['airbagDiploid'] = $array['airbagDiploid'];
                $h_array['trappedInCar'] = $array['trappedInCar'];
                $h_array['bodyHit'] = $array['bodyHit'];
                $h_array['numberOfHit'] = $array['numberOfHit'];
                
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
            $enc = new Encryption();
            $h_res = mysql_query("select * from mva where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            
            $h_array['victimFoundInCar'] = $enc->decrypt_request($h_array['victimFoundInCar']);
            $h_array['mvaOutsideType'] = $enc->decrypt_request($h_array['mvaOutsideType']);
            $h_array['occupants'] = $enc->decrypt_request($h_array['occupants']);
            $h_array['numberOfOccupants'] = $enc->decrypt_request($h_array['numberOfOccupants']);
            $h_array['victimWas'] = $enc->decrypt_request($h_array['victimWas']);
            $h_array['carWasHitFrom'] = $enc->decrypt_request($h_array['carWasHitFrom']);
            $h_array['victimType'] = $enc->decrypt_request($h_array['victimType']);
            $h_array['carBurnt'] = $enc->decrypt_request($h_array['carBurnt']);
            $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
            $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
            $h_array['weatherType'] = $enc->decrypt_request($h_array['weatherType']);
            $h_array['weatherCondition'] = $enc->decrypt_request($h_array['weatherCondition']);
            $h_array['anyWitnesses'] = $enc->decrypt_request($h_array['anyWitnesses']);
            $h_array['seatBeltOn'] = $enc->decrypt_request($h_array['seatBeltOn']);
            $h_array['airbagDiploid'] = $enc->decrypt_request($h_array['airbagDiploid']);
            $h_array['trappedInCar'] = $enc->decrypt_request($h_array['trappedInCar']);
            $h_array['bodyHit'] = $enc->decrypt_request($h_array['bodyHit']);
            $h_array['numberOfHit'] = $enc->decrypt_request($h_array['numberOfHit']);
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
				$h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
				$h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['weatherType'] = $array['weatherType'];
                $h_array['weatherCondition'] = $array['weatherCondition'];
                $h_array['anyWitnesses'] = $array['anyWitnesses'];
                $h_array['seatBeltOn'] = $array['seatBeltOn'];
                $h_array['airbagDiploid'] = $array['airbagDiploid'];
                $h_array['trappedInCar'] = $array['trappedInCar'];
                $h_array['bodyHit'] = $array['bodyHit'];
                $h_array['numberOfHit'] = $array['numberOfHit'];
                
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
