
<?php
/* File : Rest.inc.php
    * Credit to : Arun Kumar Sekar
*/
error_reporting(E_ERROR | E_PARSE);
require_once("Rest.inc.php");
require_once("Audit.php");
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
require_once '../encryptions.php';
//echo var_dump($_POST);
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
    $enc = new Encryption();
    if($func === "login")
    {
        if((int)method_exists($this,$func) > 0)
        {
           $this->$func();    
        }
        else
        {
           $this->response('',404);   
        }
    }else if(!empty($_SESSION[$enc->md5_encrypt('s_nomor')])){
        if((int)method_exists($this,$func) > 0)
        {
           $this->$func();    
        }
        else
        {
           $this->response('',404);   
        }
    }else{
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
    
    try{
        $enc = new Encryption();
        //$username = $enc->encrypt_request($this->_request['username']);
        $username = $this->_request['username'];
        if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())  || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
        }
        
        $password = $this->_request['password'];
        $platform = $this->_request['platform'];
        
        $user = new User($this);

        $user->login($username, $password, $platform);
    }catch (Exception $exc) {
        $error = array('status' => "Failed", "msg" => "Bad Request.");
        $this->response($this->json($error), 400);
    }

    
    // If invalid inputs "Bad Request" status message and reason
    $error = array('status' => "Failed", "msg" => "Invalid username or Password");
    $this->response($this->json($error), 400);
}
private function logout() {
    if($this->get_request_method() != "POST")
    {

        $this->response('',406);
    }
    $user = new User($this);

        $user->logout();
}
private function addUser()
{
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    $type = $this->_request['utype'];
    switch ($type) {
        case "admin":
            //$json = $this->jsonToArray($this->_request['userData']);
            $un = $this->_request['userName'];
            $up = $this->_request['userPassword'];
            $uf = $this->_request['userFirstname'];
            $us = $this->_request['userSurname'];
            
            $user = new User($this, $un, $up, $uf, $us, 6, 1);
            $admin = new Administrator($this);
            if($admin->addUser($un, $user->getUserID())){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        case "fo":
            $un = $this->_request['userName'];
            $up = $this->_request['userPassword'];
            $uf = $this->_request['userFirstname'];
            $us = $this->_request['userSurname'];
            $cell = $this->_request['cellphoneNumber'];
            $user = new User($this, $un, $up, $uf, $us, 1, 1);
            $admin = new ForensicOfficer($this);
            
            if($admin->addUser($un, $user->getUserID(),$cell)){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        case "fp":
            $un = $this->_request['userName'];
            $up = $this->_request['userPassword'];
            $uf = $this->_request['userFirstname'];
            $us = $this->_request['userSurname'];
            $cell = $this->_request['cellphoneNumber'];
            $user = new User($this, $un, $up, $uf, $us, 1, 1);
            $admin = new ForensicPractitioner($this);
            if($admin->addUser($un, $user->getUserID(),$cell)){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        case "student":
            $un = $this->_request['userName'];
            $up = $this->_request['userPassword'];
            $uf = $this->_request['userFirstname'];
            $us = $this->_request['userSurname'];
            $cell = $this->_request['cellphoneNumber'];
            $user = new User($this, $un, $up, $uf, $us, 1, 1);
            $admin = new Student($this);
            
            if($admin->addUser($un, $user->getUserID(),$cell)){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
         case "afp":
            $un = $this->_request['userName'];
            $up = $this->_request['userPassword'];
            $uf = $this->_request['userFirstname'];
            $us = $this->_request['userSurname'];
            $cell = $this->_request['cellphoneNumber'];
            $user = new User($this, $un, $up, $uf, $us, 1, 1);
            $admin = new Administrator($this);
            $fp = new ForensicPractitioner($this);
            
            if($admin->addUser($un, $user->getUserID()) && $fp->addUser($un, $user->getUserID())){
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

private function removeUser()
{
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    try{
        $un = $this->_request['userID'];
        $admin = new User($this);
            if($admin->removeUser($un)){
                $error = array('status' => "Success", "msg" => "Request to remove user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to remove user was denied.");
            $this->response($this->json($error), 400);
    }catch(Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request to remove user was denied.");
        $this->response($this->json($error), 400);
    }
    
}

private function activateUser() {
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    try{
        $un = $this->_request['userID'];
        $admin = new User($this);
            if($admin->activateUser($un)){
                $error = array('status' => "Success", "msg" => "Request to activate user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to activate user was denied.");
            $this->response($this->json($error), 400);
    }catch(Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request to activate user was denied.");
        $this->response($this->json($error), 400);
    }
}

private function sortUsers() {
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
        stripslashes_deep($_POST);
        stripslashes_deep($_COOKIE);
    }
    
    try {
        $search = $this->_request['by'];
        $users = new User(null, null,$this);
        
        $this->response($this->json($users->sortUsers($search)), 200);
    } catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400); 
    }
}
private function getUser() {
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    
     try {
        $search = $this->_request['search'];
        
        $users = new User(null, null,$this);
        //$error = array('status' => "Success", "msg" => "Request was denied.");
        $this->response($this->json($users->findUsers($search)), 200);
     } catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400); 
     }
}

private function users()
{
    // Cross validation if the request method is GET else it will return "Not Acceptable" status
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
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

// receives request to add a new case

private function viewCases() {
    if($this->get_request_method() != "POST")
    {
        $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    try {
        
        $category= $this->_request['category'];
        
            
        switch ($category) {
            case "all":
                $cases = new Cases();
                $this->response($this->json($cases->getAllCases()),200);
                break;
            case "search":
                $cases = new Cases();
                $this->response($this->json($cases->searchCase($this->_request['m'])),200);
                break;
            case "hanging":
                $hanging = new Hanging(null,$this);
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
                    $aviation = new Aviation(null,$this);
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
                    $burn = new Burn(null,$this);
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
            case "blunt":
                    $obj = new Blunt(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllBlunts();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $obj->getBlunt($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "bicycle":
                    $obj = new Bicycle(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllBicycleCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $obj->getBicycleCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "crushinjury":
                    $obj = new CrushInjury(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllCrushInjury();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $obj->getCrushInjury($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "deathregister":
                    $obj = new DeathRegister(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllDeathRegisterCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getDeathRegisterCase($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "drowning":
                    $obj = new Drowning(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllDrowning();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getDrowning($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "electrocutionlightning":
                    $obj = new ElectrocutionLightning(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllElectrocutionLightningCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getElectrocutionLightningCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "firearm":
                    $obj = new Firearm(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllFirearm();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getFirearm($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "foetus":
                    $obj = new FoetusabandonedBaby(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllFoetusabandonedBaby();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getFoetusabandonedBaby($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "fromheight":
                    $obj = new FromHeight(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllHeightCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getFromHeightCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "gassing":
                    $obj = new Gassing(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllGassingCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getGassingCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "ingestionoverdosepoisoning":
                    $obj = new IngestionOverdosePoisoning(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllIngestionOverdosePoisoningCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getIngestionOverdosePoisoningCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "mva":
                    $obj = new MotorVehicleAccident(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllMotorVehicleAccident();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getMotorVehicleAccident($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "mba":
                    $obj = new MotorbikeAccident(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllMotorbikeAccidents();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getMotorbikeAccident($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "pedestrian":
                    $obj = new Perdestrian(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllPedestrian();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getPedestrian($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "railway":
                    $obj = new Railway(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllRailwayCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getRailwayCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "sharpforceinjury":
                    $obj = new SharpForceInjury(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllSharpForceInjuryCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSharpForceInjuryCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "sid":
                    $obj = new Sid(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllSid();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSid($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "suda":
                    $obj = new Suda(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllSudaCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSudaCases($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "sudc":
                    $obj = new Sudc(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllSudc();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSudc($this->_request['id']);
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }
                    break;
            case "section48":
                    $obj = new section48(null,$this);
                    if(empty($this->_request['id'])){
                        $h = $obj->getAllSection48Cases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSection48Case($this->_request['id']);
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

// receives request to add a new case

private function addCase() {
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    try {
        $category= $this->_request['category'];
        switch ($category) {
            case "foetus":
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new FoetusabandonedBaby($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "aviation":    
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $aviation = new Aviation($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
             case "hanging":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $hanging = new Hanging($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "bicycle":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Bicycle($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "blunt":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Blunt($formData,$this);
                    }else{
                            $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                          $this->response($this->json($error), 400);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "burn":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Burn($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "crushinjury":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new CrushInjury($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "deathregister":
                if(!empty($this->_request['dr']) && !empty($this->_request['cn']))
                {
                    $obj = new DeathRegister($this,$this->_request['dr'],$this->_request['cn']);
                    if($obj->addToDR()){
                        $error = array('status' => "Success", "msg" => "Request to add death register number was successful.");
                        $this->response($this->json($error), 400);
                    }
                }
                $error = array('status' => "Failed", "msg" => "Request to add death register number was denied.");
                $this->response($this->json($error), 400);
                break;
            case "drowning":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Drowning($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "electrocutionlightning":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new ElectrocutionLightning($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "firearm":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Firearm($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "fromheight":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new FromHeight($formData,$this);
                        $error = array('status' => "Success", "msg" => "Request to add case was successful yeah.\n"+$formData);
                    $this->response($this->json($error), 200);
                    }else{
                        
                        $error = array('status' => "Failed", "msg" => "Request to add case was denied 1.\n"+$formData);
                    $this->response($this->json($error), 400);
                    }
                    
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied 2.\n"+$formData);
                    $this->response($this->json($error), 400);
                }
                break;
            case "gassing":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Gassing($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "ingestionoverdosepoisoning":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new IngestionOverdosePoisoning($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "mva":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new MotorVehicleAccident($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "mba":
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new MotorbikeAccident($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "pedestrian":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Perdestrian($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "railway":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Railway($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "sharpforceinjury":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new SharpForceInjury($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "sid":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Sid($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "suda":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Suda($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "sudc":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new Sudc($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "section48":
                
                if(!empty($this->_request['caseData']))
                {
                    $formData = $this->jsonToArray($this->_request['caseData']);   
                    if($formData != NULL){
                        $obj = new section48($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
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

private function getSceneData() {
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    try {
        $cn = $this->_request['caseNumber'];
        $cn = intval($cn);
        if(is_int($cn))
        {
            
            if($cn > 0){
                
                
                $scene = new Scene();
                
                $arr = $scene->getSceneByID($cn);
                $arr['victim'] = $scene->getSceneVictim($cn);
                
                $type= $this->_request['sceneType'];
                switch ($type) {
                    case "Foetus / Abandoned baby":
                        $obj = new FoetusabandonedBaby();
                        $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Aviation accident":    
                        $obj = new Aviation();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                     case "Hanging":
                         $obj = new Hanging();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Bicycle accident":
                        $obj = new Bicycle();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Blunt force injury/ assault":
                        $obj = new Blunt();
                        $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Burns":
                        $obj = new Burn();
                        $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Crush injury":
                        $obj = new CrushInjury();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "deathregister":     
                        break;
                    case "Drowning":
                        $obj = new Drowning();
                        $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Lightning/ electrocution":
                        $obj = new ElectrocutionLightning();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Firearm discharge/  gunshot wound":
                        $obj = new Firearm();
                        $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Fall/push/jump from height":
                        $obj = new FromHeight();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Gassing":
                        $obj = new Gassing();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Ingestion/overdose /poisoning":
                        $obj = new IngestionOverdosePoisoning();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Motor vehicle accident":
                        $obj = new MotorVehicleAccident();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Motorbike accident":
                        $obj = new MotorbikeAccident();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Pedestrian vehicle accident":
                        $obj = new Perdestrian();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Railway accident":
                        $obj = new Railway();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Sharp force injury/ stab injury":
                        $obj = new SharpForceInjury();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Sudden unexpected death of an infant (SUDI)":
                        $obj = new Sid();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Sudden unexpected death of an adult/ found dead":
                        $obj = new Suda();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Sudden unexpected death of a child  (1 – 18 years)":
                        $obj = new Sudc();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    case "Section 48  death –surgical case":
                        $obj = new section48();
                         $arr['sceneTypeData'] = $obj->getDataBySceneID($cn);
                        break;
                    default:
                        break;
                }
                
                $this->response($this->json($arr), 200);
            }
        }
        $error = array('status' => "Failed", "msg" => "Request to get scene information was denied.");
        $this->response($this->json($error), 400);
    }catch(Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400);
    }
    
}

private function getFOCaseList()
{
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    
     try {
        $enc = new Encryption();
        $FOPersonelNumber = $enc->decrypt_request($this->_request['fopnumber']);
        $cases = new Cases(null, null,$this);
        //$error = array('status' => "Success", "msg" => "Request was denied.");
        $this->response($this->json($cases->getCasesByFO($FOPersonelNumber)), 200);
     } catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400); 
     }
}
private function findFOCases()
{
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    
     try {
        $enc = new Encryption();
        $search = $enc->decrypt_request($this->_request['search']);
        $cases = new Cases(null, null,$this);
        //$error = array('status' => "Success", "msg" => "Request was denied.");
        $this->response($this->json($cases->findCases($search)), 200);
     } catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400); 
     }
}

private function getAudit() {
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    
     try {
        $enc = new Encryption();
        
        $audit = new Audit();
        $res = $audit->getAuditLog();
        if($res !== FALSE && $res !== NULL)
        {
            $this->response($this->json($res), 200);
        }else{
            $error = array('status' => "Failed", "msg" => "Request to view audit log was denied.");
            $this->response($this->json($error), 400);
        }
     } catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400); 
     }
}

private function findAudit()
{
    if($this->get_request_method() != "POST")
    {
       $this->response('',406);
    }
    if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())    || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
    }
    
     try {
        $enc = new Encryption();
        $search = $enc->decrypt_request($this->_request['search']);
        $audit = new Audit();
        $res = $audit->findAuditLog($search);
        if($res !== FALSE && $res !== NULL)
        {
            $this->response($this->json($res), 200);
        }else{
            $error = array('status' => "Failed", "msg" => "Request to view audit log was denied.");
            $this->response($this->json($error), 400);
        }
     } catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400); 
     }
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
    try{
        $array = json_decode($data,TRUE);
        return $array;
    }catch(Exception $ex){
        return null;
    }
}

}


    $api = new API;
    $api->processApi();

?>
