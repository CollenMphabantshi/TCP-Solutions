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
     public function __construct($formData){
         $this->$name = $formData;
    }
    
    public function getName() {
        return $this->$name;
    }
}
