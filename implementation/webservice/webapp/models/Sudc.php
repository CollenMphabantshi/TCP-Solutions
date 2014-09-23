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
    private $wierdSmellInAir;
    private $physicalExercise;
    private $familyMedicalHistory;
    private $familyMembersSufferingFrom;
    private $victimSustainInjury;
    private $victimHadSymptomsBefore;
    private $victimTakeMedication;
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
                parent::__construct($formData['object'][$i]['sceneTime'],"Sudc",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->sudcIOType = $formData['object'][$i]['sudcIOType'];
                $this->signsOfStruggle = $formData['object'][$i]['signsOfStruggle'];
                $this->alcoholBottleAround = $formData['object'][$i]['alcoholBottleAround'];
                $this->drugParaphernalia = $formData['object'][$i]['drugParaphernalia'];
                $this->strangulationSuspected = $formData['object'][$i]['strangulationSuspected'];
                $this->smotheringSuspected = $formData['object'][$i]['smotheringSuspected'];
                $this->chockingSuspected = $formData['object'][$i]['chockingSuspected'];
                $this->anyHeatingDevices = $formData['object'][$i]['anyHeatingDevices'];
                $this->wierdSmellInAir = $formData['object'][$i]['wierdSmellInAir'];
                $this->physicalExercise = $formData['object'][$i]['physicalExercise'];
                $this->familyMedicalHistory = $formData['object'][$i]['familyMedicalHistory'];
                $this->familyMembersSufferingFrom = $formData['object'][$i]['familyMembersSufferingFrom'];
                $this->victimSustainInjury = $formData['object'][$i]['victimSustainInjury'];
                $this->victimHadSymptomsBefore = $formData['object'][$i]['victimHadSymptomsBefore'];
                $this->victimTakeMedication = $formData['object'][$i]['victimTakeMedication'];
                $this->suspisionOfAssault = $formData['object'][$i]['suspisionOfAssault'];
                $this->suspisionOfOverdose = $formData['object'][$i]['suspisionOfOverdose'];
                    //
                $sceneID = $this->createScene();
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                
                if($formData['object'][$i]['victims']['victimInside'] == "yes"){
                    $this->addSudc($sceneID,TRUE,$formData['object'][$i]);
                }else{
                    $this->addSudc($sceneID,FALSE,null);
                }
            }
            
            
        }
        
    }
    
    private function addSudc($sceneID,$inside,$object) {
        $h_res = mysql_query("insert into sudc values(0,".$sceneID.",'$this->sudcIOType','$this->signsOfStruggle','$this->alcoholBottleAround','$this->drugParaphernalia','$this->strangulationSuspected','$this->smotheringSuspected','$this->chockingSuspected','$this->anyHeatingDevices','$this->wierdSmellInAir','$this->physicalExercise','$this->familyMedicalHistory','$this->familyMembersSufferingFrom','$this->victimSustainInjury','$this->victimHadSymptomsBefore','$this->suspisionOfAssault','$this->suspisionOfOverdose')");
        
        if($inside == TRUE){
            $h_res = mysql_query("select sudcID from sudc where sceneID=".$sceneID);
            $sudcID = mysql_result($h_res,0,'sudcID');
            $dl = $object['doorLocked'];
            $wc = $object['windowsClosed'];
            $wb = $object['windowsBroken'];
            $va = $object['victimAlone'];
            $pv = $object['peopleWithVictim'];
            if($va != "yes")
            {
                $hi_res = mysql_query("insert into sudcinside values(0,".$sudcID.",'$dl','$wc','$wb','$va','$pv')");
            }else{
                $hi_res = mysql_query("insert into sudcinside values(0,".$sudcID.",'$dl','$wc','$wb','$va',null)");
            }
        }
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
                $h_array['wierdSmellInAir'] = $array['wierdSmellInAir'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['physicalExercise'] = $array['physicalExercise'];
                $h_array['familyMedicalHistory'] = $array['familyMedicalHistory'];
                $h_array['familyMembersSufferingFrom'] = $array['familyMembersSufferingFrom'];
                $h_array['victimSustainInjury'] = $array['victimSustainInjury'];
                $h_array['victimHadSymptomsBefore'] = $array['victimHadSymptomsBefore'];
                $h_array['victimTakeMedication'] = $array['victimTakeMedication'];
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
            $h_res = mysql_query("select * from sudc where sceneID=".$sceneID);
            $h_array = mysql_fetch_array($h_res);
            $hi_res = mysql_query("select * from sudcinside where sudcID=".$h_array['sudcID']);
                if(mysql_num_rows($hi_res) > 0)
                {
                    $hi_array = mysql_fetch_array($hi_res);
                    $h_array['sudcInside'] = $hi_array;
                }else{
                    $h_array['sudcInside'] = NULL;
                }
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
                $h_array['wierdSmellInAir'] = $array['wierdSmellInAir'];
                $h_array['strangulationSuspected'] = $array['strangulationSuspected'];
                $h_array['smotheringSuspected'] = $array['smotheringSuspected'];
                $h_array['chockingSuspected'] = $array['chockingSuspected'];
                $h_array['physicalExercise'] = $array['physicalExercise'];
                $h_array['familyMedicalHistory'] = $array['familyMedicalHistory'];
                $h_array['familyMembersSufferingFrom'] = $array['familyMembersSufferingFrom'];
                $h_array['victimSustainInjury'] = $array['victimSustainInjury'];
                $h_array['victimHadSymptomsBefore'] = $array['victimHadSymptomsBefore'];
                $h_array['victimTakeMedication'] = $array['victimTakeMedication'];
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
