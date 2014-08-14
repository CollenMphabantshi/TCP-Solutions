<?php
    error_reporting(E_ERROR | E_PARSE);
    session_start();
    if(!empty($_SESSION['s_id']) && $_SESSION['s_ac'] == md5("6"))
    {  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Control Panel</title>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
<?php
    }else{
        include_once 'errorPage.php';
    }
?>