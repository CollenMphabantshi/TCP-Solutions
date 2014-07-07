<?php
error_reporting(E_ERROR | E_PARSE);
require_once("Rest.inc.php");
require_once("Administrator.php");
require_once("Aviation.php");
require_once("Bicycle.php");
require_once("Blunt.php");
require_once("Burn.php");
require_once("Cases.php");
require_once("CrushInjury.php");
require_once("DeathRegister.php");
require_once("Drowning.php");
require_once("ElectrocutionLightning.php");
require_once("Firearm.php");
require_once("FoetusabandonedBaby.php");
require_once("ForensicOfficer.php");
require_once("ForensicPractitioner.php");
require_once("FromHeight.php");
require_once("Gassing.php");
require_once("Hanging.php");
require_once("IngestionOverdosePoisoning.php");
require_once("MotorVehicleAccident.php");
require_once("MotorbikeAccident.php");
require_once("Perdestrian.php");
require_once("Railway.php");
require_once("Scene.php");
require_once("SceneVictims.php");
require_once("SharpForceInjury.php");
require_once("Sid.php");
require_once("Student.php");
require_once("Suda.php");
require_once("Sudc.php");
require_once("User.php");
require_once("Validations.inc.php");
require_once("Victims.php");
require_once("section48.php");


class API extends REST
{
public $data = "";


private $db = NULL;

public function __construct()
{
    parent::__construct();// Init parent contructor
    
}

//Public method for access api.
//This method dynmically call the method based on the query string
public function processApi()
{
    
    $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));

    if((int)method_exists($this,$func) > 0)
    {
        
        $this->$func();
        
    }
    else
    {
        $this->response('',404);   
    }
// If the method not exist with in this class, response would be "Page not found".
    
    
}

private function login()
{
    
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {

        $this->response('',406);
    }

    $username = $this->_request['username'];
    $password = $this->_request['password'];

    // Input validations
    if(!empty($username) and !empty($password))
    {

        if(validateUsername($email)){
            $sql = mysql_query("SELECT * FROM users WHERE userName = '$email' AND userPassword = '".md5($password)."' LIMIT 1", $this->db);
            
            if(mysql_num_rows($sql) > 0){
                $result = mysql_fetch_array($sql,MYSQL_ASSOC);

                // If success everythig is good send header as "OK" and user details

                $this->response($this->json($result), 200);

            }

            $this->response('', 204); // If no records "No Content" status
        }
    }
    
    // If invalid inputs "Bad Request" status message and reason
    $error = array('status' => "Failed", "msg" => "Invalid username or Password");
    $this->response($this->json($error), 400);
}

private function users()
{
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "GET")
    {
        $this->response('',406);
    }
    
    $sql = mysql_query("SELECT userID, userFirstname, userSurname FROM users", $this->db);
    
    if(mysql_num_rows($sql) > 0)
    {
        $result = array();
        while($rlt = mysql_fetch_array($sql,MYSQL_ASSOC))
        {
            $result[] = $rlt;
        }
        // If success everythig is good send header as "OK" and return list of users in JSON format
        $this->response($this->json($result), 200);
    }
    
    $this->response('',204); // If no records "No Content" status
}


private function viewCases() {
    if($this->get_request_method() != "GET")
    {
        $this->response('',406);
    }
    
    try {
        
        $category= $this->_request['category'];
        switch ($category) {
            case "all":
                break;
            case "hanging":
                $hanging = new Hanging();
                if(empty($this->_request['hanging'])){
                    $h = $hanging->getAllHangings();
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No hanging cases were found.");
                        $this->response($this->json($error), 400);
                    }
                }else{
                    $h = $hanging->getHanging($this->_request['hanging']);
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No hanging cases were found.");
                        $this->response($this->json($error), 400);
                    }
                }
                break;
            default:
                break;
        }
    } catch (Exception $exc) {
        $error = array('status' => "Failed", "msg" => "Request to view cases was denied.");
        $this->response($this->json($error), 400);
    }

    
    
}

private function addCase() {
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    
    try {
        
        $category= $this->_request['category'];
        
        switch ($category) {
            case "aviation":
                break;
            case "hanging":
                
                if(!empty($this->_request['caseData']))
                {
                    
                    $formData = $this->jsonToArray($this->_request['caseData']);
                    if($formData != NULL){
                        $hanging = new Hanging($formData);
                    }
                }
                break;
            default:
                break;
        }
    } catch (Exception $exc) {
        $error = array('status' => "Failed", "msg" => "Request to view cases was denied.");
        $this->response($this->json($error), 400);
    }
}

private function assignDR() {
    
}


//Encode array into JSON
private function json($data)
{
    if(is_array($data)){
        return json_encode($data);
    }
}

//Decode JSON into array
private function jsonToArray($data)
{

    $array = json_decode($data,TRUE);
    
    return $array;
}

}

// Initiiate Library
$api = new API;

$api->processApi();

?>
