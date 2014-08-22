<?php
error_reporting (E_ALL ^ E_WARNING);
$formData=$_REQUEST["formValues"];
$formObj=json_decode($formData);

$Username = $formObj->Username;
$Password=$formObj->Password;
$AuthenticationCode=$formObj->AuthenticationCode;
$bool = false;

$user_name = "root";
$password = "";
$database = "COS330";
$server = "localhost";

$_SESSION['Username'] = $Username;
$_SESSION['code'] = $AuthenticationCode;
$_COOKIE['Username'] = $Username;


$db_handle= mysqli_connect($server,$user_name ,$password,$database);
				
if (mysqli_connect_errno())
	{
	echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	else
	{
		//check if user has already registered
		$result = mysqli_query($db_handle,"SELECT * FROM users");						
		while($row = mysqli_fetch_array($result))
		{
			if($row['username'] == $Username && $row['password'] == $Password && $row['code'] == $AuthenticationCode  )
			{
				$bool = true;
				
			}
		
		}
		if($bool == true)
		{
			
				
					@session_start();
					
					$_SESSION['Username'] = $Username;
					$_SESSION['code'] = $AuthenticationCode;
					
					
				header('Location: home.php');
		}
		else if($bool == false)
		{
			
			header('Location: index.html');
		}
	
	mysqli_close($db_handle);
	
	}



 ?>