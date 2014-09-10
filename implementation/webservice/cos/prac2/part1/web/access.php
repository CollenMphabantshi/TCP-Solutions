<html>

<body>
<?php
@session_start();

echo "Your access code is : ".$_SESSION['code'];
echo "<br><br>  copy it and keep it safe, you will use it every time you log it...<br> <br> <br> ";

?>
<a href="../index.html">login here...</a>
</body>
</html>