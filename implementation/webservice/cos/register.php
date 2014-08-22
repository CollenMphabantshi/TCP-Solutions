<?php
error_reporting (E_ALL ^ E_WARNING);
$formData=$_REQUEST["formValues"];
$formObj=json_decode($formData);

$Username = $formObj->Username;
$Email=$formObj->Email;
$Password=$formObj->Password;
$Level=$formObj->Level;
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
			if($row['username'] == $Username)
			{
				$bool = true;
				echo "<script>  
					alert('Sorry User already exists');  
					</script>";
				echo "
					<script>  
					window.location = 'register.html';  
					</script>";
			}
		
		}
		if($bool == false)
		{
			mysqli_query($db_handle,"INSERT INTO users (username,email,password,level,code) VALUES ('".$Username."','".$Email."','".$Password."','".$Level."','".$AuthenticationCode."')");
			
			echo "<script>  
				alert('Thank you . ".$Username." your have successfully registered!');  
				</script>";
				
				@session_start();
				
				$_SESSION['code'] = $AuthenticationCode;
				echo "
				<script>  
				window.location = 'access.php';  
				</script>";
				
		}
		else
		{
			echo "<script>  
				alert('Sorry User ".$Username." already exists');  
				</script>";
			echo "
				<script>  
				window.location = 'register.html'; 
				</script>";
		}
	
	mysqli_close($db_handle);
	
	}

 ?>