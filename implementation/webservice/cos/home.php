<html>



<?php
@session_start();

error_reporting (0);
if (!isset($_SESSION['Username'])) {
header('Location: index.html');
}
$user_name = "root";
$password = "";
$database = "COS330";
$server = "localhost";
 $Level;
$db_handle= mysqli_connect($server,$user_name ,$password,$database);

if (mysqli_connect_errno())
	{
	echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	else
	{
		$result = mysqli_query($db_handle,"SELECT level FROM users WHERE username = '".$_SESSION['Username']."'");						
		while($row = mysqli_fetch_array($result))
		{
			$Level = $row['level'];
			//echo "sessions  ".$_SESSION['Username']." Level ".$Level;
		}
	
	}
		


if($Level == "1"){
	echo "Sorry user ".$_SESSION['Username']." is a student have access level ".$Level." has no read or write permission...<br>";
	
	echo "
	<form action='logout.php' method='post'> 
	 
	<input type='submit' name='clear file' value = 'logout'/> 
	</form>
	";
	
}else if($Level == "2"){
	echo "User ".$_SESSION['Username']." is a lecture have access level ".$Level." has read permission, but no write permission...<br>";
	echo "The content below is read from file.txt...<br>";
	echo readfile("file.txt");
	
	echo "
	<form action='logout.php' method='post'> 
	 
	<input type='submit' name='clear file' value = 'logout'/> 
	</form>
	";
}else if($Level == "3"){


$fn = "file.txt"; 
$file = fopen($fn, "a+"); 
$size = filesize($fn); 

if($_POST['addition']) fwrite($file, $_POST['addition']); 

$text = fread($file, $size); 
fclose($file); 
	echo"
	<form action='".$PHP_SELF."' method='post'> 
	This text area displays the contents of the file<br/>
	<textarea cols='50' rows='5'>".$text."</textarea><br/> 
	<input type='text' name='addition'/> 
	<input type='submit' name='write' value = 'write to file'/> 
	</form>
	
	<form action='".$PHP_SELF."' method='post'> 
	 
	<input type='submit' name='refresh' value = 'refresh file'/> 
	</form>
	
	<form action='fileWriter.php' method='post'> 
	 
	<input type='submit' name='clear file' value = 'clear file'/> 
	</form>
	";
    echo "<br><br>The content below is read from file.txt...<br>";
	echo readfile("file.txt");

	echo "
	<form action='logout.php' method='post'> 
	 
	<input type='submit' name='clear file' value = 'logout'/> 
	</form>
	";



}


?>
<body></body>

</html>