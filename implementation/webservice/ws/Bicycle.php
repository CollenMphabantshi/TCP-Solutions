<?php
require_once("Scene.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bicycle
 *
 * @author BANCHI
 */
class Bicycle extends Scene {
    //put your code here
     public function __construct($formData){
	
    }
    public function getAllBicycleCases($database) {
        
        
        $query ="SELECT * FROM sec48;";

         if ( !( $result = mysql_query( $query, $database ) ) )
           {
           print( "Could not execute query!" );
           die( mysql_error() );
           }
        while($info = mysql_fetch_array($result))
            {
            
                /* This part selects main scenes*/
		//print $info['sec48ID']." -- ".$info['sceneID']." -- ".$info['victimHospitalized']." -- ".$info['medicalEquipmentInSitu']." -- ".$info['gw714file']." -- ".$info['DrNames']." -- ".$info['DrCellNumber']." -- ".$info['NurseNames']." -- ".$info['NurseCellNumber']."\n";	
                $query2 ="SELECT * FROM sec48;";
                
            }
        
    }
}

    