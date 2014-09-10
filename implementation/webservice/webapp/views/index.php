<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Forensics</title>
        <link rel="stylesheet" type="text/css" href="../models/css/style.css" />
        <script type="text/javascript" src="../controls/jquery.js"></script>
        <script type="text/javascript" src="../controls/script.js"></script>
    </head>
    <body>
        <div id="header">
            <header class="header-content">
                
            </header>
        </div>
        <div id="login-content">
            <p class="warning">
                <label>Access Restricted</label><br/><br/><br/>
                You do not have permission to access this page.<br/><br/>
                <p>
                <?php
                    echo $_SERVER['REMOTE_ADDR'].'<br/>';
                    echo $_SERVER['HTTP_USER_AGENT'].'<br/>';
                    echo $_SERVER['REQUEST_TIME'].'<br/>';
                ?>
                </p>
            </p>
        </div>
        <div id="footer">
            
        </div>
    </body>
</html>
