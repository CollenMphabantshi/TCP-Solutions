<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of section48
 *
 * @author BANCHI
 */
class section48 extends Scene{
    //put your code here
     public function __construct($formData){
	
    }
    
    public function insert() {
        $DB_SERVER = "localhost";
        $DB_USER = "root";
        $DB_PASSWORD = "";
        $DB_NAME = "mobileforensics";
        $database = mysql_connect($DB_SERVER ,$DB_USER ,$DB_PASSWORD);
	if ( !($database))
		die( "Could connect to database" );
		
	if ( !mysql_select_db( $DB_NAME) ){
		die( "Could not open database" );
        }else{
            
        echo "<br>connected to ".$DB_NAME." DataBase";
        $sql = "INSERT INTO sec48 (sceneID, victimHospitalized, medicalEquipmentInSitu, gw714file)
        VALUES (1, 'victim hospitalized for 20 years','yes', 'yes')";
        mysqli_query($sql, $database);
        
        }

        mysqli_close($database);
        
    }
}
    $valu = new section48("yyy");
 
    $valu->insert();
