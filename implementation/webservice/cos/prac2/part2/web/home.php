<html>



<?php
@session_start();

error_reporting (0);
/*if (!isset($_SESSION['Username'])) {
header('Location: index.html');
}*/
$username = $_REQUEST['account'];
$user_name = "root";
$password = "";
$database = "COS330";
$server = "localhost";
$bank;
$db_handle= mysqli_connect($server,$user_name ,$password,$database);

if (mysqli_connect_errno())
	{
	echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
	}
	else
	{
		
		$result = mysqli_query($db_handle,"SELECT * FROM accounts WHERE accountnumber = '".$username."'");						
		while($row = mysqli_fetch_array($result))
		{
			echo 'BALANCE : '.$row['balance'].'<br>  BANK : '.$row['bank'].'<br>  ACCOUNT NUMBER : '.$row['accountnumber'];
			
		}
	
	}


?>
<body></body>

</html>