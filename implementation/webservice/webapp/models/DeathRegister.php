<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DeathRegister
 *
 * @author Latitude
 */
require_once './connect.php';
class DeathRegister {
    //put your code here
    private  $deathRegisterNumber;
    private $caseNumber;
    private $api;

    public function __construct($api,$dr,$cn){
	$this->api = $api;
        $this->deathRegisterNumber = $dr;
        $this->caseNumber = $cn;
    }
    
    public function addToDR() {
        $d_res = mysql_query("select * from deathRegister where assignedDRNumber='$this->deathRegisterNumber'");
        if(mysql_num_rows($d_res) <= 0)
        {
            $dr_res = mysql_query("insert into deathRegister values(0,$this->caseNumber,'$this->deathRegisterNumber')");
            return $dr_res;
        }else{
            return FALSE;
        }
        
    }
    
}
