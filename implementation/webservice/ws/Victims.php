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
    private  $victimID;
    private $victimGender;
    private $victimRace;
    private  $victimName;
    private $victimSurname;
    
    
   public function __construct($formData = NULL){
	if($formData != NULL){
            
        }
   }
    
   public function addVictim() {
       
       return null;
   }
    public function getVictim($victimID) {
        $v_res = mysql_query("select * from victims where victimID=".$victimID);
        $v_array = mysql_fetch_array($v_res);
        return $v_array;
    }
}
