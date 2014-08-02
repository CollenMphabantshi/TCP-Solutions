<?php 
    session_start();
    if(!empty($_SESSION['s_id']))
    {
?>

<html>
    <head>
        <title>Add user</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
        <!--script type="text/javascript">
		 function validateFields(fName, lName, username, email, paswrd1, paswrd2, date) {
                if (fName.length==0 || lName.length==0 || username.length==0) {
                    alert("Please ensure that all fields contain values!");
                    return false;
                }
                //validate passwords
                if (passwordCheck(paswrd1, paswrd2)==false)
                    return false;
                //validate email
                if (emailCheck(email)==false)
                    return false;
                //validate date
                if (dateCheck(date)==false)
                    return false;
                return true;
            }

            function passwordCheck(pword1, pword2) {
	            if (pword1.length==0 || pword2.length==0) {
		            alert("Please enter values for both password fields!");
		            return false;
	            }
	            if (pword1.length<4 || pword2.length<4) {
		            alert("Password must be at least 4 digits long!");
		            return false;
	            }
	            if (pword1 != pword2) {
		            alert("Passwords do not match!");
		            return false;
	            }
	            return true;
            }

            function emailCheck(emailStr) {
	            var emailExpr = /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/;
	            if(emailExpr.test(emailStr)==false) {
		            alert("Please enter a valid email!");
		            return false;
	            }
	            return true;
            }

            function dateCheck(date) {
	            var dateExpr = /^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/;
	            var regEx=new RegExp(dateExpr);
	            if(regEx.test(date)==false) {
		            alert("Please enter a date in the format specified \"yyyy-mm-dd\" !");
		            return false;
	            }
	            return true;
            }
		
		</script-->
</head>

<body>
        <?php include("home.php");?>
        <div class="center">
            
            <!-- <form name="adduserForm">-->
                <br/>
                <br/>
                <table class="insert">
                    <tr>
                        <td>User Name:<br/> 
                        <input type="text" class="formInput" id="name" name="name" /></td>
                    </tr>
                    <tr>
                        <td>User Password:<br/>
                        <input type="password" class="formInput" id="pass" name="pass" /></td>
                    </tr>
                    <tr>
                        <td>User Firstname:<br/>
                        <input type="text" class="formInput" id="firstname" name="firstname" /></td>
                    </tr>
                    <tr>
                        <td>User Surname:<br/>
                        <input type="text" class="formInput" id="surnname" name="surname" /></td>
                    </tr>
                    <tr>
                        <td>User Type:<br/>
                       
                            <select class="formInput" id="userType" id="userType" name="userType" onchange="getUserForm()">
                                <option>Administrator</option>
                                <option>Forensic practitioner</option>
				<option>Forensic officer</option>
				<option>Student</option>
                                <option>Guest</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <button id="button" >Add user</button>
                           
                            <br/>
                        </td>
                    </tr>
                </table>
            <!--</form>-->
            <br/><br/>
            <div class="response"></div>
        </div>
    
        <div class="bottom"></div>
</body>
</html>
<?php
    }else{
        echo "<h1>Access Restricted to this page.</h1>";
    }
?>