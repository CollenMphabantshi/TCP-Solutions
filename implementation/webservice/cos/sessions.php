<?php

error_reporting (E_ALL ^ E_NOTICE);

$usernameLoged = $_SESSION['Username'];
echo "sessions  ".$usernameLoged;

if (!isset($_SESSION['Username'])) {
echo "
		<script>  
		window.location = 'index.html';  
		</script>
		";
}

?>