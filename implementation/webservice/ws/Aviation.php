<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aviation
 *
 * @author BANCHI
 */
class Aviation extends Scene{
    //put your code here
    var $name;
     public function __construct(){
         
    }
    
    public function setName($param) {
        $this->name = $param;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function testInsertFunction() {
        $strn = "INSERT INTO aviation (aviationOutsideType, aircraftType, aircraftNumPeople, weatherCondition, weatherType)
        VALUES (15,'jetta', '25','35 c','rainy')";
        return $strn;
    }
    
    public function printF() {
        print "My name is ".$this->getName(). "\n\n\n\n";
        }
}
