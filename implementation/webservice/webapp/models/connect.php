<?php
    error_reporting(E_ERROR | E_PARSE);
    require_once './secure.php';
    try{
        $DB_SERVER = "localhost";
        $DB_USER = "root";
        //$DB_USER = "forenlnm_super";
        $DB_PASSWORD = "latitude@mysql";
        //$DB_PASSWORD = "a~~KqT9ZMt}m";
        $DB_NAME = "forenlnm_mobileforensics";
        $database = mysql_connect($DB_SERVER ,$DB_USER ,$DB_PASSWORD);
	if ( !($database))
	{
            $error = array('status' => "Failed", "msg" => "Sorry we could not establish connection. Please contact administrator.");
            $secure->response($secure->json($error));
            //die( "Could not connect to database" );
        }	
	if ( !mysql_select_db( $DB_NAME) ){
            $error = array('status' => "Failed", "msg" => "Sorry we could not establish connection. Please contact administrator.");
            $secure->response($secure->json($error));
        }
    }catch(Exception $ex){
        $error = array('status' => "Failed", "msg" => "Sorry we could not establish connection. Please contact administrator.");
        $secure->response($secure->json($error));
    }
       
?>