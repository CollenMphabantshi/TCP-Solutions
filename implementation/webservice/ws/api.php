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
    $platform = $this->_request['platform'];
    $user = new User($this);
    
    $user->login($username, $password, $platform);
    // If invalid inputs "Bad Request" status message and reason
    $error = array('status' => "Failed", "msg" => "Invalid username or Password");
    $this->response($this->json($error), 400);
}

private function addUser()
{
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    
    $type = $this->_request['utype'];
    switch ($type) {
        case "admin":
            
            $json = $this->jsonToArray($this->_request['userData']);
            $admin = new Administrator($this, $json['userName'], $json['userPassword'], $json['userFirstname'], $json['userSurname'], $json['userTypeID'], $json['userActive']);
            
            if($admin->addUser($json['userName'], $admin->getUserID())){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        case "fo":
            $json = $this->jsonToArray($this->_request['userData']);
            $admin = new ForensicOfficer($this, $json['userName'], $json['userPassword'], $json['userFirstname'], $json['userSurname'], $json['userTypeID'], $json['userActive']);
            
            if($admin->addUser($json['userName'], $admin->getUserID(),$json['cellphoneNumber'])){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        case "fp":
            $json = $this->jsonToArray($this->_request['userData']);
            $admin = new ForensicPractitioner($this, $json['userName'], $json['userPassword'], $json['userFirstname'], $json['userSurname'], $json['userTypeID'], $json['userActive']);
            
            if($admin->addUser($json['userName'], $admin->getUserID(),$json['cellphoneNumber'])){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        case "student":
            $json = $this->jsonToArray($this->_request['userData']);
            $admin = new Student($this, $json['userName'], $json['userPassword'], $json['userFirstname'], $json['userSurname'], $json['userTypeID'], $json['userActive']);
            
            if($admin->addUser($json['userName'], $admin->getUserID(),$json['cellphoneNumber'])){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        default:
            break;
    }
    
}

private function users()
{
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    
    $type = $this->_request['utype'];
    switch ($type) {
        case "all":
            $user = new User($this);
            $this->response($this->json($user->getAllUsers()),406);
            break;
        case "admin":
            $admin = new Administrator($this);
            if(empty($this->_request['id']) && empty($this->_request['uid']))
            {
                $this->response($this->json($admin->getAllAdmins()),406);
            }else if(!empty($this->_request['id']) && empty($this->_request['uid'])){
                
                $this->response($this->json($admin->getAdminByUserID($this->_request['id'])),406);
            }else if(empty($this->_request['id']) && !empty($this->_request['uid'])){
                
                $this->response($this->json($admin->getAdminByUsername($this->_request['uid'])),406);
            }
            break;
        case "fo":
            $fo = new ForensicOfficer($this);
            if(empty($this->_request['id']) && empty($this->_request['uid']))
            {
                $this->response($this->json($fo->getAllFOs()),406);
            }else if(!empty($this->_request['id']) && empty($this->_request['uid'])){
                
                $this->response($this->json($fo->getFOByUserID($this->_request['id'])),406);
            }else if(empty($this->_request['id']) && !empty($this->_request['uid'])){
                
                $this->response($this->json($fo->getFOByUsername($this->_request['uid'])),406);
            }
            break;
        case "fp":
            $fp = new ForensicPractitioner($this);
            if(empty($this->_request['id']) && empty($this->_request['uid']))
            {
                $this->response($this->json($fp->getAllFPs()),406);
            }else if(!empty($this->_request['id']) && empty($this->_request['uid'])){
                
                $this->response($this->json($fp->getFPByUserID($this->_request['id'])),406);
            }else if(empty($this->_request['id']) && !empty($this->_request['uid'])){
                
                $this->response($this->json($fp->getFPByUsername($this->_request['uid'])),406);
            }
            break;
        case "student":
            $student = new Student($this);
            
            if(empty($this->_request['id']) && empty($this->_request['uid']))
            {
                $this->response($this->json($student->getAllStudents()),406);
            }else if(!empty($this->_request['id']) && empty($this->_request['uid'])){
                
                $this->response($this->json($student->getStudentByUserID($this->_request['id'])),406);
            }else if(empty($this->_request['id']) && !empty($this->_request['uid'])){
                
                $this->response($this->json($student->getStudentByUsername($this->_request['uid'])),406);
            }
            break;
        default:
            break;
    }
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
                if(empty($this->_request['id'])){
                    $h = $hanging->getAllHangings();

                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No aviation cases were found.");
                        $this->response($this->json($error), 400);
                    }
                }else{
                    $h = $hanging->getHanging($this->_request['id']);
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No aviation cases were found.");
                        $this->response($this->json($error), 400);
                    }
                }
                break;
            case "aviation":
                $aviation = new Aviation();
                if(empty($this->_request['id'])){
                    $h = $aviation->getAllAviation();
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No aviation cases were found.");
                        $this->response($this->json($error), 400);
                    }
                    
                }else{
                    $h = $aviation->getAviation($this->_request['id']);
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No aviation cases were found.");
                        $this->response($this->json($error), 400);
                    }
                }
                
                break;
                case "burn":
                $burn = new Burn();
                if(empty($this->_request['id'])){
                    $h = $burn->getAllBurn();
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                        $this->response($this->json($error), 400);
                    }
                    
                }else{
                    $h = $burn->getBurn($this->_request['id']);
                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No burn cases were found.");
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
            case "foetus":
                break;
            case "aviation":
                
                if(!empty($this->_request['caseData']))
                {
                    
                    $formData = $this->jsonToArray($this->_request['caseData']);
                    
                    if($formData != NULL){
                        $aviation = new Aviation($formData);
                        $hanging = new Hanging($formData,$this);
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
    public function json($data)
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
