<?php
error_reporting(E_ERROR | E_PARSE);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


        $DB_SERVER = "localhost";
        $DB_USER = "root";
        $DB_PASSWORD = "";
        $DB_NAME = "mobileForensics";
        $database = mysql_connect($DB_SERVER ,$DB_USER ,$DB_PASSWORD);
	if ( !($database))

		die( "Could connect to database" );
		
	if ( !mysql_select_db( $DB_NAME) ){
		die( "Could not open database" );
        }
       
?>