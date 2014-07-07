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
class Cases {
//put your code here
    private $caseNumber;
    private $sceneID;
    private $FOPersonalNumber;
    
    public function __construct($sceneID = null,$FOPersonelNumber=null){
	if($sceneID != null && $FOPersonelNumber!= null)
        {
            $this->FOPersonalNumber = $FOPersonelNumber;
            $this->sceneID = $sceneID;
            $this->addCase();
        }
    }
    
    private function addCase() {
        $c_res = mysql_query("insert into cases values(0,".$this->sceneID.",'$this->FOPersonalNumber')");
        $c_res = mysql_query("select * from cases where sceneID=".$this->sceneID);
        $c_array = mysql_fetch_array($c_res);
        $this->caseNumber = $c_array['caseNumber'];
    }
    public function getAllCases() {
        $c_res = mysql_query("select * from cases");
        $cases = array();
        
        while($c_array = mysql_fetch_array($c_res)){
            $cases[] = $c_array; 
        }
        return $cases;
    }
    
    public function getCase($caseNumber) {
        $c_res = mysql_query("select * from cases where caseNumber=".$caseNumber);
        $c_array = mysql_fetch_array($c_res);
        return $c_array;
    }
    
    public function getCaseByScene($sceneID) {
        $c_res = mysql_query("select * from cases where sceneID=".$sceneID);
        $c_array = mysql_fetch_array($c_res);
        return $c_array;
    }
    
    public function getBasicCaseInfo($caseNumber) {
        $c_res = mysql_query("select * from cases where caseNumber=".$caseNumber);
        $c_array = mysql_fetch_array($c_res);
        return $c_array;
    }
}
