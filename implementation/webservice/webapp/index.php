<?php
    error_reporting(E_ERROR | E_PARSE);
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Forensics</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <div id="header">
            <header class="header-content">
                
            </header>
        </div>
        <div id="login-content">
            
            <div id="login-form">
                <label for="username">
                    Username:<br><input class="login-form-input" type="text" name="username" id="username" placeholder="personel number" /><br><br>
                </label>
                <label for="password">
                    Password:<br><input  class="login-form-input" type="password" name="password" id="password" placeholder="password" /><br><br>
                </label>
                <button id="login-form-button">Login</button>
            </div>
        </div>
        <div id="footer">
            
        </div>
    </body>
</html>
