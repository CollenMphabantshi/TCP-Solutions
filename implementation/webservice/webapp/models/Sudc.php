<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sudc
 *
 * @author BANCHI
 */
class Sudc extends Scene{
    //put your code here
    private $sudcIOType;
    private $signsOfStruggle;
    private $alcoholBottleAround;
    private $drugParaphernalia;
    private $strangulationSuspected;
    private $smotheringSuspected;
    private $chockingSuspected;
    private $anyHeatingDevices;
    private $specifiedAppliences;
    private $wierdSmellInAir;
    private $specifiedSmell;
    private $victimBusy;
    private $victimBusySpecified;
    private $physicalExercise;
    private $familyMedicalHistory;
    private $familyMembersSufferingFrom;
    private $familyMembersSuffering;
    private $victimFell;
    private $victimComplain;
    private $victimComplainSpecified;
    private $victimTakeMedication;
    private $victimTakeMedicationSpecified;
    private $suspisionOfAssault;
    private $suspisionOfOverdose;
    
     public function __construct($formData,$api){
         $this->api = $api;
	if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Sudden unexpected death of a child  (1 – 18 years)",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                
                $this->sudcIOType = $formData['object'][$i]['sudcIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->anyHeatingDevices = $formData['object'][$i]['anyHeatingDevices'];
                $this->specifiedAppliences = $formData['object'][$i]['specifiedAppliences'];
                $this->wierdSmellInAir = $formData['object'][$i]['wierdSmellInAir'];
                $this->specifiedSmell = $formData['object'][$i]['specifiedSmell'];
                $this->victimBusy = $formData['object'][$i]['victimBusy'];
                $this->victimBusySpecified = $formData['object'][$i]['victimBusySpecified'];
                $this->physicalExercise = $formData['object'][$i]['physicalExercise'];
                $this->familyMedicalHistory = $formData['object'][$i]['familyMedicalHistory'];
                $this->familyMembersSufferingFrom = $formData['object'][$i]['familyMembersSufferingFrom'];
                $this->familyMembersSuffering = $formData['object'][$i]['familyMembersSuffering'];
                $this->victimFell = $formData['object'][$i]['victimFell'];
                $this->victimComplain = $formData['object'][$i]['victimComplain'];
                $this->victimComplainSpecified = $formData['object'][$i]['victimComplainSpecified'];
                $this->victimTakeMedication = $formData['object'][$i]['victimTakeMedication'];
                $this->victimTakeMedicationSpecified = $formData['object'][$i]['victimTakeMedicationSpecified'];
                $this->suspisionOfAssault = $formData['object'][$i]['suspisionOfAssault'];
                $this->suspisionOfOverdose = $formData['object'][$i]['suspisionOfOverdose'];
                    //
                $sceneID = $this->createScene();
                
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                $enc = new Encryption();
                $vinside = $enc->decrypt_request($formData['object'][$i]['victims'][0]['victimInside']);
                if($vinside === "Yes"){
                    $this->addSudc($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addSudc($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addSudc($sceneID,$inside,$object) {
        $enc = new Encryption();
        $h_res = mysql_query("insert into sudc values(0,$sceneID,"
                . "'$this->sudcIOType',"
                . "'$this->signsOfStruggle',"
                . "'$this->alcoholBottleAround',"
                . "'$this->drugParaphernalia',"
                . "'$this->strangulationSuspected',"
                . "'$this->smotheringSuspected',"
                . "'$this->chockingSuspected',"
                . "'$this->anyHeatingDevices',"
                . "'$this->anyHeatingDevices',"
                . "'$this->wierdSmellInAir',"
                . "'$this->specifiedSmell',"
                . "'$this->victimBusy',"
                . "'$this->victimBusySpecified',"
                . "'$this->physicalExercise',"
                . "'$this->familyMedicalHistory',"
                . "'$this->familyMembersSufferingFrom',"
                . "'$this->familyMembersSuffering',"
                . "'$this->victimFell',"
                . "'$this->victimComplain',"
                . "'$this->victimComplainSpecified',"
                . "'$this->victimTakeMedication',"
                . "'$this->victimTakeMedicationSpecified',"
                . "'$this->suspisionOfAssault',"
                . "'$this->suspisionOfOverdose')");
        
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
        
        if($inside === TRUE){
            $h_res = mysql_query("select sudcID from sudc where sceneID=".$sceneID);
            $sudcID = mysql_result($h_res,0,'sudcID');
            
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            
            $enc = new Encryption();
            if($enc->decrypt_request($va) !== "Yes")
            {
                $hi_res = mysql_query("insert into sudcinside values(0,$sudcID,'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into sudcinside values(0,$sudcID,'$dl','$wc','$wb','$va',null)");
            }
        }
        
        $error = array('status' => "Failed", "msg" => "Request to create a scene was successful.");
        $this->api->response($this->api->json($error), 400);
    }
    public function getAllSudc() {
        try{
            
            $h_res = mysql_query("select * from sudc");
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
                $h_array['sudcID'] = $array['sudcID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['sudcIOType'] = $array['sudcIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['anyHeatingDevices'] = $array['anyHeatingDevices'];
                $h_array['specifiedAppliences'] = $array['specifiedAppliences'];
                $h_array['wierdSmellInAir'] = $array['wierdSmellInAir'];
                $h_array['specifiedSmell'] = $array['specifiedSmell'];
                $h_array['victimBusy'] = $array['victimBusy'];
                $h_array['victimBusySpecified'] = $array['victimBusySpecified'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['physicalExercise'] = $array['physicalExercise'];
                $h_array['familyMedicalHistory'] = $array['familyMedicalHistory'];
                $h_array['familyMembersSufferingFrom'] = $array['familyMembersSufferingFrom'];
                $h_array['familyMembersSuffering'] = $array['familyMembersSuffering'];
                $h_array['victimFell'] = $array['victimFell'];
                $h_array['victimComplain'] = $array['victimComplain'];
                $h_array['victimComplainSpecified'] = $array['victimComplainSpecified'];
                $h_array['victimTakeMedication'] = $array['victimTakeMedication'];
                $h_array['victimTakeMedicationSpecified'] = $array['victimTakeMedicationSpecified'];
                $h_array['suspisionOfAssault'] = $array['suspisionOfAssault'];
                $h_array['suspisionOfOverdose'] = $array['suspisionOfOverdose'];
                
                $hi_res = mysql_query("select * from sudcinside where sudcID=".$h_array['sudcID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['sudcInside'] = $hi_array;
                }else{
                    $h_array['sudcInside'] = NULL;
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
    
    public function getDataBySceneID($sceneID) {
        try{
            $enc = new Encryption();
            $h_res = mysql_query("select * from sudc where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from sudcinside where sudcID=".$h_array['sudcID']);
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
                    $h_array['sudcInside'] = $hi_array;
                }else{
                    $h_array['sudcInside'] = "null";
                }
                
                $h_array['sudcIOType'] = $enc->decrypt_request($h_array['sudcIOType']);
                $h_array['signsOfStruggle'] = $enc->decrypt_request($h_array['signsOfStruggle']);
                $h_array['alcoholBottleAround'] = $enc->decrypt_request($h_array['alcoholBottleAround']);
                $h_array['drugParaphernalia'] = $enc->decrypt_request($h_array['drugParaphernalia']);
                $h_array['anyHeatingDevices'] = $enc->decrypt_request($h_array['anyHeatingDevices']);
                $h_array['specifiedAppliences'] = $enc->decrypt_request($h_array['specifiedAppliences']);
                $h_array['wierdSmellInAir'] = $enc->decrypt_request($h_array['wierdSmellInAir']);
                $h_array['specifiedSmell'] = $enc->decrypt_request($h_array['specifiedSmell']);
                $h_array['victimBusy'] = $enc->decrypt_request($h_array['victimBusy']);
                $h_array['victimBusySpecified'] = $enc->decrypt_request($h_array['victimBusySpecified']);
                $h_array['strangulationSuspected'] = $enc->decrypt_request($h_array['strangulationSuspected']);
                $h_array['smotheringSuspected'] = $enc->decrypt_request($h_array['smotheringSuspected']);
                $h_array['chockingSuspected'] = $enc->decrypt_request($h_array['chockingSuspected']);
                $h_array['physicalExercise'] = $enc->decrypt_request($h_array['physicalExercise']);
                $h_array['familyMedicalHistory'] = $enc->decrypt_request($h_array['familyMedicalHistory']);
                $h_array['familyMembersSufferingFrom'] = $enc->decrypt_request($h_array['familyMembersSufferingFrom']);
                $h_array['familyMembersSuffering'] = $enc->decrypt_request($h_array['familyMembersSuffering']);
                $h_array['victimFell'] = $enc->decrypt_request($h_array['victimFell']);
                $h_array['victimComplain'] = $enc->decrypt_request($h_array['victimComplain']);
                $h_array['victimComplainSpecified'] = $enc->decrypt_request($h_array['victimComplainSpecified']);
                $h_array['victimTakeMedication'] = $enc->decrypt_request($h_array['victimTakeMedication']);
                $h_array['victimTakeMedicationSpecified'] = $enc->decrypt_request($h_array['victimTakeMedicationSpecified']);
                $h_array['suspisionOfAssault'] = $enc->decrypt_request($h_array['suspisionOfAssault']);
                $h_array['suspisionOfOverdose'] = $enc->decrypt_request($h_array['suspisionOfOverdose']);
                
            return $h_array;
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getSudc($hangingID) {
        try{
            
            $h_res = mysql_query("select * from sudc where sudcID=".$hangingID);
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
                $h_array['sudcID'] = $array['sudcID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['sudcIOType'] = $array['sudcIOType'];
                $h_array['signsOfStruggle'] = $array['signsOfStruggle'];
                $h_array['alcoholBottleAround'] = $array['alcoholBottleAround'];
                $h_array['drugParaphernalia'] = $array['drugParaphernalia'];
                $h_array['anyHeatingDevices'] = $array['anyHeatingDevices'];
                $h_array['specifiedAppliences'] = $array['specifiedAppliences'];
                $h_array['wierdSmellInAir'] = $array['wierdSmellInAir'];
                $h_array['specifiedSmell'] = $array['specifiedSmell'];
                $h_array['victimBusy'] = $array['victimBusy'];
                $h_array['victimBusySpecified'] = $array['victimBusySpecified'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['physicalExercise'] = $array['physicalExercise'];
                $h_array['familyMedicalHistory'] = $array['familyMedicalHistory'];
                $h_array['familyMembersSufferingFrom'] = $array['familyMembersSufferingFrom'];
                $h_array['familyMembersSuffering'] = $array['familyMembersSuffering'];
                $h_array['victimFell'] = $array['victimFell'];
                $h_array['victimComplain'] = $array['victimComplain'];
                $h_array['victimComplainSpecified'] = $array['victimComplainSpecified'];
                $h_array['victimTakeMedication'] = $array['victimTakeMedication'];
                $h_array['victimTakeMedicationSpecified'] = $array['victimTakeMedicationSpecified'];
                $h_array['suspisionOfAssault'] = $array['suspisionOfAssault'];
                $h_array['suspisionOfOverdose'] = $array['suspisionOfOverdose'];
                
                $hi_res = mysql_query("select * from sudcinside where sudcID=".$h_array['sudcID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['sudcInside'] = $hi_array;
                }else{
                    $h_array['sudcInside'] = NULL;
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
