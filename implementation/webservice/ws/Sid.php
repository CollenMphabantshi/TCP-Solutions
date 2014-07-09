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
    
     public function __construct($formData){
	 if($formData == NULL)
        {
            parent::__construct(null,null,"","","","","","","",null);
        }else {
            for($i = 0; $i < count($formData['object']);$i++)
            {
                parent::__construct($formData['object'][$i]['sceneTime'],"Sid",$formData['object'][$i]['sceneDate'],$formData['object'][$i]['sceneLocation'],$formData['object'][$i]['sceneTemparature']
                        ,$formData['object'][$i]['investigatingOfficerName'],$formData['object'][$i]['investigatingOfficerRank'],$formData['object'][$i]['investigatingOfficerCellNo'],$formData['object'][$i]['firstOfficerOnSceneName'],$formData['object'][$i]['firstOfficerOnSceneRank']);
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
                
                    //
                $sceneID = $this->createScene();
                $this->setVictim($sceneID,$formData['object'][$i]['victims']);
                $this->setCase($sceneID, $formData['object'][$i]['FOPersonelNumber']);
                echo "TEST: ".$formData['object'][$i]['victims']['victimInside'];
            }
            
        }
        
    }
    
    private function addSid($sceneID) {
        if($this->infantSickLately != NULL)
        {
            $h_res = mysql_query("insert into sid values(0,".$sceneID.",'$this->sidIOType','$this->resuscitationAttemped','$this->infantSickLately','$this->infantSickLatelyDescription','$this->infantOnMedication','$this->fallsOrInjuryExperience','$this->infantWearing','$this->infantTightlyWrapped','$this->beddingOverInfant','$this->whoFoundVictimBody','$this->dateAndTimeLastPlaced','$this->dateAndTimeDeathDiscovered','$this->dateAndTimeLastSeenAlive','$this->anySIDSdeeaths','$this->photoAfterBodyRemoved','$this->infantLastPlaced','$this->infantLastSeenAlive','$this->whereInfantFoundDead')");
        }else{
           $h_res = mysql_query("insert into sid values(0,".$sceneID.",'$this->sidIOType','$this->resuscitationAttemped','$this->infantSickLately',null,'$this->infantOnMedication','$this->fallsOrInjuryExperience','$this->infantWearing','$this->infantTightlyWrapped','$this->beddingOverInfant','$this->whoFoundVictimBody','$this->dateAndTimeLastPlaced','$this->dateAndTimeDeathDiscovered','$this->dateAndTimeLastSeenAlive','$this->anySIDSdeeaths','$this->photoAfterBodyRemoved','$this->infantLastPlaced','$this->infantLastSeenAlive','$this->whereInfantFoundDead')");
        
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
            
            return null;
        }
    }
    
    public function getSid($mvaID) {
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
            
            return null;
        }
    }
}
