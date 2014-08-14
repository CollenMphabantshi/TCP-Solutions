<?php

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
			echo $bool;
		
			echo "<script>  
				alert('Thank you . ".$Username." your have successfully logged!');  
				</script>";
				
					@session_start();
					include('sessions.php');
					$_SESSION['Username'] = $Username;
					$_SESSION['code'] = $AuthenticationCode;
					
					
			echo "
				<script>  
				window.location = 'home.php';  
				</script>";
		}
		else
		{
			echo "<script>  
				alert('Sorry User ".$Username." doesn't exist');  
				</script>";
			echo "
				<script>  
				window.location = 'index.html'; 
				</script>";
		}
	
	mysqli_close($db_handle);
	
	}



 ?>