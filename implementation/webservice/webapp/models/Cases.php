<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Case
 *
 * @author Latitude
 */
require_once '../encryptions.php';
class Cases {
//put your code here
    private $caseNumber;
    private $sceneID;
    private $FOPersonalNumber;
    private $api;
    public function __construct($sceneID = null,$FOPersonelNumber=null,$api){
        $this->api = $api;
	if($sceneID != null && $FOPersonelNumber!= null)
        {
            $enc = new Encryption();
            $this->FOPersonalNumber = $enc->decrypt_request($FOPersonelNumber);
            $this->sceneID = $sceneID;
            $this->addCase();
        }
    }
    
    private function addCase() {
        $enc = new Encryption();
        $c_res = mysql_query("select * from cases where sceneID=".$this->sceneID);
        if(mysql_num_rows($c_res) <= 0)
        {
            $c_res = mysql_query("insert into cases values(0,".$this->sceneID.",'$this->FOPersonalNumber')");
            $c_res = mysql_query("select * from cases where sceneID=".$this->sceneID);
            $c_array = mysql_fetch_array($c_res);
            $this->caseNumber = $c_array['caseNumber'];
        }else{
            $error = array('status' => "Failed", "msg" => "Request to create a case was denied. Duplication was detected.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    public function getAllCases() {
        $c_res = mysql_query("select * from cases order by caseNumber desc");
        $cases = array();
        
        while($c_array = mysql_fetch_array($c_res)){
            $res = mysql_query("select * from scene s, sceneType st where sceneID=".$c_array['sceneID']." and s.sceneTypeID=st.sceneTypeID");
            
            $c_array['sceneType'] = mysql_result($res, 0, 'sceneTypeDescription');
            $cases[] = $c_array; 
        }
        return $cases;
    }

    public function getCase($caseNumber) {
        $c_res = mysql_query("select * from cases where caseNumber=".$caseNumber);
        $c_array = mysql_fetch_array($c_res);
        return $c_array;
    }
    
    public function getCasesByFO($FOPersonelNumber){
        try{
            $enc = new Encryption();
            
            $c_res = mysql_query("select * from cases where FOPersonelNumber='$FOPersonelNumber' order by sceneID desc");
            $arr = array();
            while($a = mysql_fetch_array($c_res))
            {
                $carr = array();
                $res = mysql_query("select * from scene where sceneID=".$a['sceneID']);
                $c_arr = array();
                while($scene = mysql_fetch_array($res)){
                    $s_arr = array();
                    $sv = new Victims();
                   
                    $sv_res = mysql_query("select * from sceneVictims where sceneID=".$a['sceneID']);
                    $victim = $sv->getVictim(mysql_result($sv_res, 0,'victimID'));
                    
                    $s_arr['vicName'] = $victim['vicName'];
                    $s_arr['vicID'] = $victim['victimIdentityNumber'];
                    $s_arr['vicAge'] = $victim['victimAge'];
                    $st_res = mysql_query("select * from sceneType where sceneTypeID=".$scene['sceneTypeID']);
                    $s_arr['sceneTypeID'] = $enc->encrypt_request(mysql_result($st_res,0, 'sceneTypeDescription'));
                    $sceneID = $scene['sceneID'];
                    $s_arr['sceneID'] = $enc->encrypt_request($scene['sceneID']);
                    $s_arr['sceneTime'] = $scene['sceneTime'];
                    $s_arr['sceneDate'] = $scene['sceneDate'];
                    $s_arr['sceneLocation'] = $scene['sceneLocation'];
                    $s_arr['sceneTemparature'] = $scene['sceneTemparature'];
                    $s_arr['ioName'] = $enc->decrypt_request($scene['sceneInvestigatingOfficerRank']).' '.$enc->decrypt_request($scene['sceneInvestigatingOfficerName']);
                    $s_arr['ioName'] = $enc->encrypt_request($s_arr['ioName']);
                    $s_arr['ioCellNumber'] = $enc->encrypt_request($scene['sceneInvestigatingOfficerCellNumber']);
                    $s_arr['foosName'] = $enc->decrypt_request($scene['firstOfficerOnSceneRank']).' '.$enc->decrypt_request($scene['firstOfficerOnSceneName']);
                    $s_arr['foosName'] = $enc->encrypt_request($s_arr['foosName']);

                    $c_arr[] = $s_arr;
                    
                }
                $carr['caseNumber'] = $enc->encrypt_request($a['caseNumber']);
                $carr['FOPersonelNumber'] = $enc->encrypt_request($a['FOPersonelNumber']);
                $carr['sceneData'] = $c_arr;
                $arr[] = $carr;
            }
            return $arr;
        }catch(Exception $ex){
            $error = array('status' => "Failed", "msg" => "The case information is not available.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function findCases($search){
        try{
            $enc = new Encryption();
            
            $c_res = mysql_query("select * from scene where sceneTime LIKE '$search%' or sceneDate LIKE '$search%' or sceneLocation LIKE '$search%' order by sceneID desc");
            
            $array = array();
            $sceneID = 0; 
            $i = 0;
            
            while($scene = mysql_fetch_array($c_res)){
                
                $c_array = array();
                $s_arr = array();
                $sv = new Victims();
                $sv_res = mysql_query("select * from sceneVictims where sceneID=".$scene['sceneID']);
                $victim = $sv->getVictim(mysql_result($sv_res, 0,'victimID'));
                    
                $s_arr['vicName'] = $victim['vicName'];
                $s_arr['vicID'] = $victim['victimIdentityNumber'];
                $s_arr['vicAge'] = $victim['victimAge'];
                
                $st_res = mysql_query("select * from sceneType where sceneTypeID=".$scene['sceneTypeID']);
                
                $s_arr['sceneTypeID'] = $enc->encrypt_request(mysql_result($st_res,0, 'sceneTypeDescription'));
                $sceneID = $scene['sceneID'];
                
                $s_arr['sceneID'] = $enc->encrypt_request($scene['sceneID']);
                $s_arr['sceneTime'] = $scene['sceneTime'];
                $s_arr['sceneDate'] = $scene['sceneDate'];
                $s_arr['sceneLocation'] = $scene['sceneLocation'];
                $s_arr['sceneTemparature'] = $scene['sceneTemparature'];
                $s_arr['ioName'] = $enc->decrypt_request($scene['sceneInvestigatingOfficerRank']).' '.$enc->decrypt_request($scene['sceneInvestigatingOfficerName']);
                $s_arr['ioName'] = $enc->encrypt_request($s_arr['ioName']);
                $s_arr['ioCellNumber'] = $enc->encrypt_request($scene['sceneInvestigatingOfficerCellNumber']);
                $s_arr['foosName'] = $enc->decrypt_request($scene['firstOfficerOnSceneRank']).' '.$enc->decrypt_request($scene['firstOfficerOnSceneName']);
                $s_arr['foosName'] = $enc->encrypt_request($s_arr['foosName']);
                
                $c_array[] = $s_arr;
                $carr = array();
                $ca_res = mysql_query("select * from cases where sceneID=".$sceneID);
                if(mysql_num_rows($ca_res) > 0)
                {
                    $carr['caseNumber'] = $enc->encrypt_request(mysql_result($ca_res, 0,'caseNumber'));
                }
                $carr['sceneData'] = $c_array; 
                $array[] = $carr;
                
            }
            
            return $array;
        }catch(Exception $ex){
            $error = array('status' => "Failed", "msg" => "The case information is not available.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
    public function searchCase($param) {
        $c_res = mysql_query("select * from scene s, sceneType st, cases c where s.sceneTypeID=st.sceneTypeID and s.sceneID=c.sceneID and (st.sceneTypeDescription LIKE '$param%' or c.FOPersonelNumber LIKE '$param%' )");
        
        $cases = array();
        
        while($c_array = mysql_fetch_array($c_res)){
            $res = mysql_query("select * from cases where sceneID=".$c_array['sceneID']);
            $c_array['caseNumber'] = mysql_result($res, 0, 'caseNumber');
            $c_array['FOPersonelNumber'] = mysql_result($res, 0, 'FOPersonelNumber');
            //$c_array['sceneType'] = $c_array['sceneTypeDescription'];
            $cases[] = $c_array; 
        }
        return $cases;
    }
    public function getCaseByScene($sceneID) {
        $c_res = mysql_query("select * from cases where sceneID=".$sceneID);
        $c_array = mysql_fetch_array($c_res);
        return $c_array;
    }
    
    public function getBasicCaseInfo($search){
        try{
            $c_res = mysql_query("select * from cases where caseNumber=".$caseNumber);
            $c_array = mysql_fetch_array($c_res);
            return $c_array;
        }catch(Exception $ex){
            $error = array('status' => "Failed", "msg" => "The case information is not available.");
            $this->api->response($this->api->json($error), 400);
        }
    }
    
}
