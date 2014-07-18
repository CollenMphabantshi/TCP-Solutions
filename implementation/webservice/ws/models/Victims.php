<?php
require_once './connect.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Victims
 *
 * @author BANCHI
 */
class Victims {
    //put your code here
    private $victimID;
    private $victimIdentityNumber;
    private $victimGender;
    private $victimRace;
    private $victimName;
    private $victimSurname;
    private $whoFoundVictimBody;
    private $bodyDecompose;
    private $medicalIntervention;
    private $bodyBurned;
    private $bodyIntact;
    private $victimInside;
    private $victimOutside;
    private $victimFoundCloseToWater;
    private $victimSuicideNoteFound;
    private $victimGeneralHistory;
    private $rapeHomicideSuspected;
    private $suicideSuspected;
    private $previousAttempts;
    private $numberOfPreviousAttempts;
    private $api;
    
   public function __construct($formData = NULL,$api){
       $this->api = $api;
	if($formData != NULL){
            $this->victimIdentityNumber = $formData['victimIdentityNumber'];
            $this->victimGender = $formData['victimGender'];
            $this->victimRace = $formData['victimRace'];
            $this->victimName = $formData['victimName'];
            $this->victimSurname = $formData['victimSurname'];
            $this->whoFoundVictimBody = $formData['whoFoundVictimBody'];
            $this->bodyDecompose = $formData['bodyDecomposed'];
            $this->medicalIntervention = $formData['medicalIntervention'];
            $this->bodyBurned = $formData['bodyBurned'];
            $this->bodyIntact = $formData['bodyIntact'];
            $this->victimInside = $formData['victimInside'];
            $this->victimOutside = $formData['victimOutside'];
            $this->victimFoundCloseToWater = $formData['victimFoundCloseToWater'];
            $this->victimSuicideNoteFound = $formData['victimSuicideNoteFound'];
            $this->victimGeneralHistory = $formData['victimGeneralHistory'];
            $this->rapeHomicideSuspected = $formData['rapeHomicideSuspected'];
            $this->suicideSuspected = $formData['suicideSuspected'];
            $this->previousAttempts = $formData['previousAttempts'];
            $this->numberOfPreviousAttempts = $formData['numberOfPreviousAttempts'];
        }
   }
    
   public function addVictim() {
       if($this->isFound()) return null;
       
       if($this->bodyIntact != null && $this->bodyBurned != null)
       {
        $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention','$this->bodyBurned','$this->bodyIntact','$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.")");
       }else if($this->bodyIntact == null && $this->bodyBurned != null){
           $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention','$this->bodyBurned',null,'$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.")");
       }else if($this->bodyIntact != null && $this->bodyBurned == null){
           $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention',null,'$this->bodyIntact','$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.")");
       }else if($this->bodyIntact == null && $this->bodyBurned == null){
           $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention',null,null,'$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.")");
       }
       
       $v_res = mysql_query("select * from victims where victimIdentityNumber='$this->victimIdentityNumber'");
       $v_array = mysql_fetch_array($v_res);
       $this->victimID = $v_array['victimID'];
       /*
        * add scene photo here
        */
       
       return $this->victimID;
   }
    public function getVictim($victimID) {
        $v_res = mysql_query("select * from victims where victimID=".$victimID);
        $v_array = mysql_fetch_array($v_res);
        return $v_array;
    }
    
    private function isFound() {
        $v = mysql_query("select * from victims where victimIdentityNumber='$this->victimIdentityNumber'");
        if(mysql_num_rows($v) > 0)
            return TRUE;
        else {
            return FALSE;
        }
    }
}
