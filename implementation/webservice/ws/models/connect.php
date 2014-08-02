<?php
error_reporting(E_ERROR | E_PARSE);

        $DB_SERVER = "localhost";
        $DB_USER = "root";
        $DB_PASSWORD = "latitude@mysql";
        $DB_NAME = "forenlnm_mobileForensics";
        $database = mysql_connect($DB_SERVER ,$DB_USER ,$DB_PASSWORD);
	if ( !($database))
	{
            die( "Could not connect to database" );
        }	
	if ( !mysql_select_db( $DB_NAME) ){
		die( "Could not open database" );
        }
       
?>