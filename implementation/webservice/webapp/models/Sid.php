<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sid
 *
 * @author BANCHI
 */
class Sid extends Scene{
    //put your code here
    private $sidIOType;
    private $resuscitationAttemped;
    private $infantSickLately;
    private $infantSickLatelyDescription;
    private $infantOnMedication;
    private $fallsOrInjuryExperience;
    private $infantWearing;
    private $infantTightlyWrapped;
    private $beddingOverInfant;
    private $whoFoundVictimBody;
    private $dateAndTimeLastPlaced;
    private $dateAndTimeDeathDiscovered;
    private $dateAndTimeLastSeenAlive;
    private $anySIDSdeeaths;
    private $photoAfterBodyRemoved;
    private $infantLastPlaced;
    private $infantLastSeenAlive;
    private $whereInfantFoundDead;
    private $dieDuringSleep;
    private $whatWasInfantDoing;
    private $whatHappenedToInfant;
    private $relationshiptoInfant;
    private $whoAttempedResuscitation;
    private $anyHeatingDevices;
    private $anyWeirdSmell;
    private $anySmokeSmell;
    private $infantOneOfTwins;
    
     public function __construct($formData,$api){
         $this->api = $api;
	 if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null,$api);
        }else {
        
        
        		
        
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Sudden unexpected death of an infant (SUDI)",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank'],$api);
                $this->sidIOType = $formData['object'][$i]['sidIOType'];
                $this->resuscitationAttemped = $formData['object'][$i]['resuscitationAttemped'];
                $this->infantSickLately = $formData['object'][$i]['infantSickLately'];
                $this->infantSickLatelyDescription = $formData['object'][$i]['infantSickLatelyDescription'];
                $this->infantOnMedication = $formData['object'][$i]['infantOnMedication'];
                $this->fallsOrInjuryExperience = $formData['object'][$i]['fallsOrInjuryExperience'];
                $this->infantWearing = $formData['object'][$i]['infantWearing'];
                $this->beddingOverInfant = $formData['object'][$i]['beddingOverInfant'];
                $this->whoFoundVictimBody = $formData['object'][$i]['whoFoundVictimBody'];
                $this->dateAndTimeLastPlaced = $formData['object'][$i]['dateAndTimeLastPlaced'];
                $this->dateAndTimeDeathDiscovered = $formData['object'][$i]['dateAndTimeDeathDiscovered'];
                $this->dateAndTimeLastSeenAlive = $formData['object'][$i]['dateAndTimeLastSeenAlive'];
                $this->anySIDSdeeaths = $formData['object'][$i]['anySIDSdeeaths'];
                $this->photoAfterBodyRemoved = $formData['object'][$i]['photoAfterBodyRemoved'];
                $this->infantLastPlaced = $formData['object'][$i]['infantLastPlaced'];
                $this->infantLastSeenAlive = $formData['object'][$i]['infantLastSeenAlive'];
                $this->whereInfantFoundDead = $formData['object'][$i]['whereInfantFoundDead'];
                $this->dieDuringSleep = $formData['object'][$i]['dieDuringSleep'];
                $this->whatWasInfantDoing = $formData['object'][$i]['whatWasInfantDoing'];
                $this->whatHappenedToInfant = $formData['object'][$i]['whatHappenedToInfant'];
                $this->relationshiptoInfant = $formData['object'][$i]['relationshiptoInfant'];
                $this->whoAttempedResuscitation = $formData['object'][$i]['whoAttempedResuscitation'];
                $this->anyHeatingDevices = $formData['object'][$i]['anyHeatingDevices'];
                $this->anyWeirdSmell = $formData['object'][$i]['anyWeirdSmell'];
                $this->anySmokeSmell = $formData['object'][$i]['anySmokeSmell'];
                $this->infantOneOfTwins = $formData['object'][$i]['infantOneOfTwins'];
                
                $sceneID = $this->createScene();
                if($sceneID == NULL){
                     $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                     $this->api->response($this->api->json($error), 400);
                 }
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
               	$this->addSid($sceneID);
            }
            
        }
        
    }
    
    private function addSid($sceneID) {
        if($this->infantSickLately != NULL)
        {
            $h_res = mysql_query("insert into sid values(0,"
            . "".$sceneID.",'$this->sidIOType','$this->resuscitationAttemped','$this->infantSickLately','$this->infantSickLatelyDescription',"
                    . "'$this->infantOnMedication','$this->fallsOrInjuryExperience','$this->infantWearing','$this->infantTightlyWrapped',"
                    . "'$this->beddingOverInfant','$this->whoFoundVictimBody','$this->dateAndTimeLastPlaced','$this->dateAndTimeDeathDiscovered',"
                    . "'$this->dateAndTimeLastSeenAlive','$this->anySIDSdeeaths','$this->photoAfterBodyRemoved','$this->infantLastPlaced',"
                    . "'$this->infantLastSeenAlive','$this->whereInfantFoundDead','$this->dieDuringSleep','$this->whatWasInfantDoing',"
                    . "'$this->whatHappenedToInfant','$this->relationshiptoInfant','$this->whoAttempedResuscitation','$this->anyHeatingDevices',"
                    . "'$this->anyWeirdSmell','$this->anySmokeSmell','$this->infantOneOfTwins')");
         
        if($h_res === FALSE){
            $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
            $this->api->response($this->api->json($error), 400);
        }
            
        }else{
           $h_res = mysql_query("insert into sid values(0,"
            . "".$sceneID.",'$this->sidIOType','$this->resuscitationAttemped','$this->infantSickLately',null,"
            . "'$this->infantOnMedication','$this->fallsOrInjuryExperience','$this->infantWearing','$this->infantTightlyWrapped',"
            . "'$this->beddingOverInfant','$this->whoFoundVictimBody','$this->dateAndTimeLastPlaced','$this->dateAndTimeDeathDiscovered',"
            . "'$this->dateAndTimeLastSeenAlive','$this->anySIDSdeeaths','$this->photoAfterBodyRemoved','$this->infantLastPlaced',"
            . "'$this->infantLastSeenAlive','$this->whereInfantFoundDead','$this->dieDuringSleep','$this->whatWasInfantDoing',"
            . "'$this->whatHappenedToInfant','$this->relationshiptoInfant','$this->whoAttempedResuscitation','$this->anyHeatingDevices',"
            . "'$this->anyWeirdSmell','$this->anySmokeSmell','$this->infantOneOfTwins')");
            
            if($h_res === FALSE){
                 $error = array('status' => "Failed", "msg" => "Request to create a scene was denied.");
                 $this->api->response($this->api->json($error), 400);
             }
            
        
        }

    }
    public function getAllSid() {
        try{
            $h_res = mysql_query("select * from sid");
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
                $h_array['sidID'] = $array['sidID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['sidIOType'] = $array['sidIOType'];
                $h_array['resuscitationAttemped'] = $array['resuscitationAttemped'];
                $h_array['infantSickLately'] = $array['infantSickLately'];
                $h_array['infantSickLatelyDescription'] = $array['infantSickLatelyDescription'];
                $h_array['infantOnMedication'] = $array['infantOnMedication'];
                $h_array['fallsOrInjuryExperience'] = $array['fallsOrInjuryExperience'];
                $h_array['infantWearing'] = $array['infantWearing'];
                $h_array['infantTightlyWrapped'] = $array['infantTightlyWrapped'];
                $h_array['beddingOverInfant'] = $array['beddingOverInfant'];
                $h_array['dateAndTimeLastPlaced'] = $array['dateAndTimeLastPlaced'];
                $h_array['dateAndTimeDeathDiscovered'] = $array['dateAndTimeDeathDiscovered'];
                $h_array['dateAndTimeLastSeenAlive'] = $array['dateAndTimeLastSeenAlive'];
                $h_array['anySIDSdeeaths'] = $array['anySIDSdeeaths'];
                $h_array['photoAfterBodyRemoved'] = $array['photoAfterBodyRemoved'];
                $h_array['infantLastPlaced'] = $array['infantLastPlaced'];
                $h_array['infantLastSeenAlive'] = $array['infantLastSeenAlive'];
                $h_array['whereInfantFoundDead'] = $array['whereInfantFoundDead'];
                $h_array['dieDuringSleep'] = $array['dieDuringSleep'];
                $h_array['whatWasInfantDoing'] = $array['whatWasInfantDoing'];
                $h_array['whatHappenedToInfant'] = $array['whatHappenedToInfant'];
                $h_array['relationshiptoInfant'] = $array['relationshiptoInfant'];
                $h_array['whoAttempedResuscitation'] = $array['whoAttempedResuscitation'];
                $h_array['anyHeatingDevices'] = $array['anyHeatingDevices'];
                $h_array['anyWeirdSmell'] = $array['anyWeirdSmell'];
                $h_array['anySmokeSmell'] = $array['anySmokeSmell'];
                $h_array['infantOneOfTwins'] = $array['infantOneOfTwins'];
                
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
            $h_res = mysql_query("select * from sid where sceneID=".$sceneID);
            return mysql_fetch_array($h_res);
        } catch (Exception $ex) {
            $error = array('status' => "Failed", "msg" => "No data found.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function getSid($sidID) {
        try{
            
            $h_res = mysql_query("select * from sid where sidID=".$sidID);
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
                $h_array['sidID'] = $array['sidID'];
                $h_array['sceneID'] = $array['sceneID'];
                $h_array['caseData'] = $this->case->getCaseByScene($h_array['sceneID']);
                $h_array['sceneData'] = $this->getSceneByID($h_array['sceneID']);
                $h_array['sidIOType'] = $array['sidIOType'];
                $h_array['resuscitationAttemped'] = $array['resuscitationAttemped'];
                $h_array['infantSickLately'] = $array['infantSickLately'];
                $h_array['infantSickLatelyDescription'] = $array['infantSickLatelyDescription'];
                $h_array['infantOnMedication'] = $array['infantOnMedication'];
                $h_array['fallsOrInjuryExperience'] = $array['fallsOrInjuryExperience'];
                $h_array['infantWearing'] = $array['infantWearing'];
                $h_array['infantTightlyWrapped'] = $array['infantTightlyWrapped'];
                $h_array['beddingOverInfant'] = $array['beddingOverInfant'];
                $h_array['dateAndTimeLastPlaced'] = $array['dateAndTimeLastPlaced'];
                $h_array['dateAndTimeDeathDiscovered'] = $array['dateAndTimeDeathDiscovered'];
                $h_array['dateAndTimeLastSeenAlive'] = $array['dateAndTimeLastSeenAlive'];
                $h_array['anySIDSdeeaths'] = $array['anySIDSdeeaths'];
                $h_array['photoAfterBodyRemoved'] = $array['photoAfterBodyRemoved'];
                $h_array['infantLastPlaced'] = $array['infantLastPlaced'];
                $h_array['infantLastSeenAlive'] = $array['infantLastSeenAlive'];
                $h_array['whereInfantFoundDead'] = $array['whereInfantFoundDead'];
                $h_array['dieDuringSleep'] = $array['dieDuringSleep'];
                $h_array['whatWasInfantDoing'] = $array['whatWasInfantDoing'];
                $h_array['whatHappenedToInfant'] = $array['whatHappenedToInfant'];
                $h_array['relationshiptoInfant'] = $array['relationshiptoInfant'];
                $h_array['whoAttempedResuscitation'] = $array['whoAttempedResuscitation'];
                $h_array['anyHeatingDevices'] = $array['anyHeatingDevices'];
                $h_array['anyWeirdSmell'] = $array['anyWeirdSmell'];
                $h_array['anySmokeSmell'] = $array['anySmokeSmell'];
                $h_array['infantOneOfTwins'] = $array['infantOneOfTwins'];
             
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