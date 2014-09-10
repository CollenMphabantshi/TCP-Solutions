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
class DeathRegister {
    //put your code here
    private  $deathRegisterNumber;
    private $caseNumber;
    private $api;

    public function __construct($formData,$api){
	$this->api = $api;
    }
    
    public function getCase($param) {
        
    }
    public function addCaseToDR($param) {
        
    }
}
