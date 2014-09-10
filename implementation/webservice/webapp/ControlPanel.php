<?php
    error_reporting(E_ERROR | E_PARSE);
    //session_start();
    require_once 'ph.php';
    $vu = new PreventHijack();
    if($vu->isValidUser("admin"))
    {
        
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Control Panel</title>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="aes.js"></script>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
        
</head>

<body onload="loadUsers();">
        <?php include_once("home.php");?>
        <div class="response"></div>
        <div class="center">    
            <div id="Page1" class="page">
                <div id="afpHome-left">
                    <div class="searchForm">

                        <input type="search" name="search" id="search"  /> <input type="image" name="searchButton" id="searchButton" src="images/icons/search-black.png" />
                        <br/> <br/> <br/>
                    </div>
                    <div class="userList">
                        <table id="users">
                            <tr class="table-headers">
                                <th>User Name </th>
                                <th>User Firstname </th>
                                <th>User Surname </th>
                                <th>User Active </th>
                                <th>Options </th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
            <div id="Page2" class="page">
                 <table class="insert">
                    <tr>
                        <td>User Name:<br/> 
                            <input type="text" class="formInput" id="name" name="name" placeholder="Username" /></td>
                    </tr>
                    <tr>
                        <td>User Password:<br/>
                        <input type="password" class="formInput" id="pass" name="pass" placeholder="Password" /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:<br/>
                        <input type="password" class="formInput" id="cpass" name="cpass" placeholder="Confirm Password"/></td>
                    </tr>
                    <tr>
                        <td>User Firstname:<br/>
                        <input type="text" class="formInput" id="firstname" name="firstname" placeholder="Firstname"/></td>
                    </tr>
                    <tr>
                        <td>User Surname:<br/>
                        <input type="text" class="formInput" id="surnname" name="surname" placeholder="Surname" /></td>
                    </tr>
                    <tr>
                        <td>User Type:<br/>
                       
                            <select class="formInput" id="userType" id="userType" name="userType" onchange="getUserForm()">
                                <option>Administrator</option>
                                <option>Forensic practitioner</option>
				<option>Forensic officer</option>
				<option>Student</option>
                                <option>Guest</option>
                                <option>Forensic practitioner/Administrator</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <button id="addButton" >Add user</button>
                           
                            <br/>
                        </td>
                    </tr>
                </table>
            <br/><br/>
                
            </div>
            <div id="Page3" class="page">
                
            </div>
            
        </div>
    
        <div class="bottom">
            
        </div>
</body>
</html>
<?php
    }else{
        include_once 'errorPage.php';
    }
?>