<?php
session_start();
require_once './connect.php';
require_once '../encryptions.php';
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
    private $victimAge;
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
            $enc = new Encryption();
            $this->victimIdentityNumber = $formData['victimIdentityNumber'];
            $this->victimGender = $formData['victimGender'];
            $this->victimRace = $formData['victimRace'];
            $this->victimName = $formData['victimName'];
            $this->victimSurname = $formData['victimSurname'];
            $this->victimAge = $formData['victimAge'];
            $this->whoFoundVictimBody = $formData['whoFoundVictimBody'];
            $this->bodyDecompose = $formData['bodyDecomposed'];
            $this->medicalIntervention = $formData['medicalIntervention'];
            if(isset($formData['bodyBurned']) && isset($formData['bodyIntact']))
            {
                if($formData['bodyBurned'] === "null" && $formData['bodyIntact'] !== "null")
                {
                    $this->bodyBurned = null;
                    $this->bodyIntact = $formData['bodyIntact'];
                }else if($formData['bodyBurned'] !== "null" && $formData['bodyIntact'] === "null"){
                    $this->bodyBurned = $formData['bodyBurned'];
                    $this->bodyIntact = null;
                }else if($formData['bodyBurned'] !== "null" && $formData['bodyIntact'] !== "null"){
                    $this->bodyBurned = $formData['bodyBurned'];
                    $this->bodyIntact = $formData['bodyIntact'];
                }else{
                    $this->bodyBurned = null;
                    $this->bodyIntact = null;
                }
            }else{
                $this->bodyBurned = null;
                $this->bodyIntact = null;
            }
            $this->victimInside = $formData['victimInside'];
            $this->victimOutside = $formData['victimOutside'];
            $this->victimFoundCloseToWater = $formData['victimFoundCloseToWater'];
            $this->victimSuicideNoteFound = $formData['victimSuicideNoteFound'];
            $this->victimGeneralHistory = $formData['victimGeneralHistory'];
            $this->rapeHomicideSuspected = $formData['rapeHomicideSuspected'];
            $this->suicideSuspected = $formData['suicideSuspected'];
            $this->previousAttempts = $formData['previousAttempts'];
            $this->numberOfPreviousAttempts = $enc->decrypt_request($formData['numberOfPreviousAttempts']);
        }
   }
    
   public function addVictim() {
       
       if($this->bodyIntact != null && $this->bodyBurned != null)
       {
        $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention','$this->bodyBurned','$this->bodyIntact','$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.",'$this->victimAge')");
       }else if($this->bodyIntact == null && $this->bodyBurned != null){
           $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention','$this->bodyBurned',null,'$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.",'$this->victimAge')");
       }else if($this->bodyIntact != null && $this->bodyBurned == null){
           $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention',null,'$this->bodyIntact','$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.",'$this->victimAge')");
       }else {
           $v = mysql_query("insert into victims values(0,'$this->victimIdentityNumber','$this->victimGender','$this->victimRace','$this->victimName','$this->victimSurname','$this->whoFoundVictimBody','$this->bodyDecompose','$this->medicalIntervention',null,null,'$this->victimInside','$this->victimOutside','$this->victimFoundCloseToWater','$this->victimSuicideNoteFound','$this->victimGeneralHistory','$this->rapeHomicideSuspected','$this->suicideSuspected','$this->previousAttempts',".$this->numberOfPreviousAttempts.",'$this->victimAge')");
       }
       if($v)
       {
        $v_res = mysql_query("select * from victims where victimIdentityNumber='$this->victimIdentityNumber'");
        $v_array = mysql_fetch_array($v_res);
        $this->victimID = $v_array['victimID'];
        /*
         * add scene photo here
         */

        return $v_array['victimID'];
       }else{
           return NULL;
       }
   }
    public function getVictim($victimID) {
        
        try{
            $enc = new Encryption();
            
            $v_res = mysql_query("select * from victims where victimID=".$victimID);
             
            $v_array = mysql_fetch_array($v_res);
            $arr = array();
            if(empty($_SESSION[$enc->md5_encrypt('s_nomor')]))
            {
            $arr['victimID'] = $v_array['victimID'];
            $arr['victimIdentityNumber'] = $v_array['victimIdentityNumber'];
            //echo var_dump($arr);
            $arr['victimGender'] = $v_array['victimGender'];
            $arr['victimRace'] = $v_array['victimRace'];
            $arr['victimName'] = $v_array['victimName'];
            $arr['victimSurname'] = $v_array['victimSurname'];
            $arr['victimAge'] = $v_array['victimAge'];
            $arr['whoFoundVictimBody'] = $v_array['whoFoundVictimBody'];
            $arr['bodyDecompose'] = $v_array['bodyDecompose'];
            $arr['medicalIntervention'] = $v_array['medicalIntervention'];
            $arr['bodyBurned'] = $v_array['bodyBurned'];
            $arr['bodyIntact'] = $v_array['bodyIntact'];
            $arr['victimInside'] = $v_array['victimInside'];
            $arr['victimOutside'] = $v_array['victimOutside'];
            $arr['victimFoundCloseToWater'] = $v_array['victimFoundCloseToWater'];
            $arr['victimSuicideNoteFound'] = $v_array['victimSuicideNoteFound'];
            $arr['victimGeneralHistory'] = $v_array['victimGeneralHistory'];
            $arr['rapeHomicideSuspected'] = $v_array['rapeHomicideSuspected'];
            $arr['suicideSuspected'] = $v_array['suicideSuspected'];
            $arr['previousAttempts'] = $v_array['previousAttempts'];
            $arr['numberOfPreviousAttempts'] = $v_array['numberOfPreviousAttempts'];
            $arr['vicName'] = $enc->decrypt_request($v_array['victimName']).' '.$enc->decrypt_request($v_array['victimSurname']);
            $arr['vicName'] = $enc->encrypt_request($arr['vicName']);
            }  else {
                $arr['victimID'] = $v_array['victimID'];
            $arr['victimIdentityNumber'] = $enc->decrypt_request($v_array['victimIdentityNumber']);
            //echo var_dump($arr);
            $arr['victimGender'] = $enc->decrypt_request($v_array['victimGender']);
            $arr['victimRace'] = $enc->decrypt_request($v_array['victimRace']);
            $arr['victimName'] = $enc->decrypt_request($v_array['victimName']);
            $arr['victimSurname'] = $enc->decrypt_request($v_array['victimSurname']);
            $arr['whoFoundVictimBody'] = $enc->decrypt_request($v_array['whoFoundVictimBody']);
            $arr['bodyDecompose'] = $enc->decrypt_request($v_array['bodyDecompose']);
            $arr['medicalIntervention'] = $enc->decrypt_request($v_array['medicalIntervention']);
            $arr['bodyBurned'] = $enc->decrypt_request($v_array['bodyBurned']);
            $arr['bodyIntact'] = $enc->decrypt_request($v_array['bodyIntact']);
            $arr['victimInside'] = $enc->decrypt_request($v_array['victimInside']);
            $arr['victimOutside'] = $enc->decrypt_request($v_array['victimOutside']);
            $arr['victimFoundCloseToWater'] = $enc->decrypt_request($v_array['victimFoundCloseToWater']);
            $arr['victimSuicideNoteFound'] = $enc->decrypt_request($v_array['victimSuicideNoteFound']);
            $arr['victimGeneralHistory'] = $enc->decrypt_request($v_array['victimGeneralHistory']);
            $arr['rapeHomicideSuspected'] = $enc->decrypt_request($v_array['rapeHomicideSuspected']);
            $arr['suicideSuspected'] = $enc->decrypt_request($v_array['suicideSuspected']);
            $arr['previousAttempts'] = $enc->decrypt_request($v_array['previousAttempts']);
            $arr['numberOfPreviousAttempts'] = $v_array['numberOfPreviousAttempts'];
            $arr['vicName'] = $enc->decrypt_request($v_array['victimName']).' '.$enc->decrypt_request($v_array['victimSurname']);
            
            }
            /*
            $arr['victimID'] = $enc->encrypt_request($v_array['victimID']);
            $arr['victimIdentityNumber'] = $enc->encrypt_request($v_array['victimIdentityNumber']);
            $arr['victimGender'] = $enc->encrypt_request($v_array['victimGender']);
            $arr['victimRace'] = $enc->encrypt_request($v_array['victimRace']);
            $arr['victimName'] = $enc->encrypt_request($v_array['victimName']);
            $arr['victimSurname'] = $enc->encrypt_request($v_array['victimSurname']);
            $arr['whoFoundVictimBody'] = $enc->encrypt_request($v_array['whoFoundVictimBody']);
            $arr['bodyDecompose'] = $enc->encrypt_request($v_array['bodyDecompose']);
            $arr['medicalIntervention'] = $enc->encrypt_request($v_array['medicalIntervention']);
            $arr['bodyBurned'] = $enc->encrypt_request($v_array['bodyBurned']);
            $arr['bodyIntact'] = $enc->encrypt_request($v_array['bodyIntact']);
            $arr['victimInside'] = $enc->encrypt_request($v_array['victimInside']);
            $arr['victimOutside'] = $enc->encrypt_request($v_array['victimOutside']);
            $arr['victimFoundCloseToWater'] = $enc->encrypt_request($v_array['victimFoundCloseToWater']);
            $arr['victimSuicideNoteFound'] = $enc->encrypt_request($v_array['victimSuicideNoteFound']);
            $arr['victimGeneralHistory'] = $enc->encrypt_request($v_array['victimGeneralHistory']);
            $arr['rapeHomicideSuspected'] = $enc->encrypt_request($v_array['rapeHomicideSuspected']);
            $arr['suicideSuspected'] = $enc->encrypt_request($v_array['suicideSuspected']);
            $arr['previousAttempts'] = $enc->encrypt_request($v_array['previousAttempts']);
            $arr['numberOfPreviousAttempts'] = $enc->encrypt_request($v_array['numberOfPreviousAttempts']);
            $arr['vicName'] = $enc->encrypt_request($v_array['victimName'].' '.$v_array['victimSurname']);
            
             
             */
            return $arr;
        }catch(Exception $ex){
            
        }
    }
    
    private function isFound() {
       
    }
}
