<?php
@session_start();
error_reporting (E_ALL ^ E_NOTICE);

$usernameLoged = $_SESSION['Username'];


if (!isset($_SESSION['Username'])) {
/*echo "
		<script>  
		window.location = 'index.html';  
		</script>
		";*/
		echo "sessions  ".$usernameLoged;
}else{
	/*echo "
		<script>  
		window.location = 'home.php';  
		</script>
		";*/
		echo "sessions  ".$usernameLoged."iiiiiiiiii";
}

?>