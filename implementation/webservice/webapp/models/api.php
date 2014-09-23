
<?php
/* File : Rest.inc.php
    * Credit to : Arun Kumar Sekar
*/
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
    $enc = new Encryption();
    //echo $enc->encrypt_request('rquest');
    
    
    
    $func = strtolower(trim(str_replace("/","",$enc->decrypt_request($_REQUEST['rquest']))));
    if((int)method_exists($this,$func) > 0)
    {
       $this->$func();    
    }
    else
    {
       $this->response(''.$s,404);   
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
        $username = $enc->decrypt_request($this->_request['username']);
        //$username = $this->_request['username'];
        if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc())  || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){
            stripslashes_deep($_POST);
            stripslashes_deep($_COOKIE);
        }
        
        $password = $enc->decrypt_request($this->_request['password']);
        //$password = $this->_request['password'];
        $platform = $enc->decrypt_request($this->_request['platform']);
        //$platform = $this->_request['platform'];
        
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
    try{
        $enc = new Encryption();
    $type = $enc->decrypt_request($this->_request['utype']);
    switch ($type) {
        case "admin":
            //$json = $this->jsonToArray($this->_request['userData']);
            $un = $this->_request['userName'];
            $up = $this->_request['userPassword'];
            $uf = $this->_request['userFirstname'];
            $us = $this->_request['userSurname'];
            
            $user = new User($this, $un, $up, $uf, $us, 1, 1);
            $admin = new Administrator($this);
            if($admin->addUser($un, $admin->getUserID())){
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
            
            if($admin->addUser($un, $admin->getUserID(),$cell)){
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
            if($admin->addUser($un, $admin->getUserID(),$cell)){
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
            
            if($admin->addUser($un, $admin->getUserID(),$cell)){
                $error = array('status' => "Success", "msg" => "Request to add user was successful.");
                $this->response($this->json($error), 400);
            }
            $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
            break;
        default:
            break;
    }
    }  catch (Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request to add user was denied.");
            $this->response($this->json($error), 400);
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
        $enc = new Encryption();
        $un = $enc->decrypt_request($this->_request['userID']);
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
    try{
    $type = $enc->decrypt_request($this->_request['utype']);
    $id = $enc->decrypt_request($this->_request['id']);
    $uid = $enc->decrypt_request($uid);
    switch ($type) {
        case "all":
            $user = new User($this);
            $this->response($this->json($user->getAllUsers()),406);
            break;
        case "admin":
            $admin = new Administrator($this);
            if(empty($id) && empty($uid))
            {
                $this->response($this->json($admin->getAllAdmins()),406);
            }else if(!empty($id) && empty($uid)){
                
                $this->response($this->json($admin->getAdminByUserID($id)),406);
            }else if(empty($id) && !empty($uid)){
                
                $this->response($this->json($admin->getAdminByUsername($uid)),406);
            }
            break;
        case "fo":
            $fo = new ForensicOfficer($this);
            if(empty($id) && empty($uid))
            {
                $this->response($this->json($fo->getAllFOs()),406);
            }else if(!empty($id) && empty($uid)){
                
                $this->response($this->json($fo->getFOByUserID($id)),406);
            }else if(empty($id) && !empty($uid)){
                
                $this->response($this->json($fo->getFOByUsername($uid)),406);
            }
            break;
        case "fp":
            $fp = new ForensicPractitioner($this);
            if(empty($id) && empty($uid))
            {
                $this->response($this->json($fp->getAllFPs()),406);
            }else if(!empty($id) && empty($uid)){
                
                $this->response($this->json($fp->getFPByUserID($id)),406);
            }else if(empty($id) && !empty($uid)){
                
                $this->response($this->json($fp->getFPByUsername($uid)),406);
            }
            break;
        case "student":
            $student = new Student($this);
            
            if(empty($id) && empty($uid))
            {
                $this->response($this->json($student->getAllStudents()),406);
            }else if(!empty($id) && empty($uid)){
                
                $this->response($this->json($student->getStudentByUserID($id)),406);
            }else if(empty($id) && !empty($uid)){
                
                $this->response($this->json($student->getStudentByUsername($uid)),406);
            }
            break;
        default:
            break;
    }
    }catch(Exception $ex){
        $error = array('status' => "Failed", "msg" => "Request was denied.");
        $this->response($this->json($error), 400);
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
        $enc = new Encryption();
        $category= $enc->decrypt_request($this->_request['category']);
        $id = $enc->decrypt_request($this->_request['id']);
            
        switch ($category) {
            case "all":
                $cases = new Cases();
                $this->response($this->json($cases->getAllCases()),200);
                break;
            case "hanging":
                $hanging = new Hanging(null,$this);
                if(empty($id)){
                    $h = $hanging->getAllHangings();

                    if($h != NULL)
                    {
                        $this->response($this->json($h),200);
                    }else{
                        $error = array('status' => "Failed", "msg" => "No aviation cases were found.");
                        $this->response($this->json($error), 400);
                    }
                }else{
                    $h = $hanging->getHanging($id);
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
                    if(empty($id)){
                        $h = $aviation->getAllAviation();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No aviation cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $aviation->getAviation($id);
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
                    if(empty($id)){
                        $h = $burn->getAllBurn();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $burn->getBurn($id);
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
                    if(empty($id)){
                        $h = $obj->getAllBlunts();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $obj->getBlunt($id);
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
                    if(empty($id)){
                        $h = $obj->getAllBicycleCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $obj->getBicycleCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllCrushInjury();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }

                    }else{
                        $h = $obj->getCrushInjury($id);
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
                    if(empty($id)){
                        $h = $obj->getAllDeathRegisterCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getDeathRegisterCase($id);
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
                    if(empty($id)){
                        $h = $obj->getAllDrowning();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getDrowning($id);
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
                    if(empty($id)){
                        $h = $obj->getAllElectrocutionLightningCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getElectrocutionLightningCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllFirearm();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getFirearm($id);
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
                    if(empty($id)){
                        $h = $obj->getAllFoetusabandonedBaby();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getFoetusabandonedBaby($id);
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
                    if(empty($id)){
                        $h = $obj->getAllHeightCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getFromHeightCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllGassingCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getGassingCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllIngestionOverdosePoisoningCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getIngestionOverdosePoisoningCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllMotorVehicleAccident();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getMotorVehicleAccident($id);
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
                    if(empty($id)){
                        $h = $obj->getAllMotorbikeAccidents();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getMotorbikeAccident($id);
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
                    if(empty($id)){
                        $h = $obj->getAllPedestrian();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getPedestrian($id);
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
                    if(empty($id)){
                        $h = $obj->getAllRailwayCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getRailwayCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllSharpForceInjuryCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSharpForceInjuryCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllSid();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSid($id);
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
                    if(empty($id)){
                        $h = $obj->getAllSudaCases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSudaCases($id);
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
                    if(empty($id)){
                        $h = $obj->getAllSudc();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSudc($id);
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
                    if(empty($id)){
                        $h = $obj->getAllSection48Cases();
                        if($h != NULL)
                        {
                            $this->response($this->json($h),200);
                        }else{
                            $error = array('status' => "Failed", "msg" => "No burn cases were found.");
                            $this->response($this->json($error), 400);
                        }
                    }else{
                        $h = $obj->getSection48Case($id);
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
        $enc = new Encryption();
        $category= $enc->decrypt_request($this->_request['category']);
        $rd = $this->_request['caseData'];
        switch ($category) {
            case "foetus":
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new FoetusabandonedBaby($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "aviation":    
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $aviation = new Aviation($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
             case "hanging":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $hanging = new Hanging($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "bicycle":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Bicycle($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "blunt":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
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
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Burn($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "crushinjury":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new CrushInjury($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "deathregister":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new DeathRegister($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "drowning":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Drowning($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "electrocutionlightning":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new ElectrocutionLightning($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "firearm":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Firearm($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "fromheight":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new FromHeight($formData,$this);
                        $error = array('status' => "Success", "msg" => "Request to add case was successful.");
                    $this->response($this->json($error), 200);
                    }else{
                        
                        $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                    }
                    
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denie.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "gassing":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Gassing($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "ingestionoverdosepoisoning":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new IngestionOverdosePoisoning($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "mva":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new MotorVehicleAccident($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "mba":
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new MotorbikeAccident($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "pedestrian":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Perdestrian($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "railway":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Railway($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "sharpforceinjury":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new SharpForceInjury($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "sid":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Sid($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "suda":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Suda($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "sudc":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new Sudc($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            case "section48":
                
                if(!empty($rd))
                {
                    $formData = $this->jsonToArray($rd);   
                    if($formData != NULL){
                        $obj = new section48($formData,$this);
                    }
                }else{
                    $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                    $this->response($this->json($error), 400);
                }
                break;
            default:
                $error = array('status' => "Failed", "msg" => "Request to add case was denied.");
                $this->response($this->json($error), 400);
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
        $enc = new Encryption();
        $cn = $enc->decrypt_request($this->_request['caseNumber']);
        $cn = intval($cn);
        if(is_int($cn))
        {
            
            if($cn > 0){
                
                $scene = new Scene();
                
                $arr = $scene->getSceneByID($cn);
                $arr['victim'] = $scene->getSceneVictim($cn);
                
                $type= $enc->decrypt_request($this->_request['sceneType']);
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

public function getFOCaseList()
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
public function findFOCases()
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
        $search = $this->_request['search'];
        $cases = new Cases(null, null,$this);
        $this->response($this->json($cases->findCases($search)), 200);
     }catch (Exception $ex){
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

// Initiiate Library
$api = new API;

$api->processApi();

?>
