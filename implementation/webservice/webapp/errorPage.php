<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>ERROR PAGE</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <div class="forbiden">
           
            <h1>You do not have permission to view this page</h1>
            <p>
                <?php
                        echo $_SERVER['REMOTE_ADDR'].'<br/>';
                        echo $_SERVER['HTTP_USER_AGENT'].'<br/>';
                        //echo $_SERVER['HTTP_HOST'].'<br/>';
                        echo '<br/><a href="#" class="ui-button" id="logout">Login Page</a>';
                ?>
            </p>
        </div>
    </body>
</html>
