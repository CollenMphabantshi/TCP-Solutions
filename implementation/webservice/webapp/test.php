<?php
 require_once './encryptions.php';
?>
<?php 
                    $enc = new Encryption();
                    $username = "p";
                    
?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="jquery.jcryption.3.0.1.js"></script>
        <script type="text/javascript">
            $(function(){
                
            });
            
        </script>
    </head>
        <body>
        <div id="header">
            <header class="header-content">
                
            </header>
        </div>
        <div id="login-content">
            
            <div id="login-form">
                <form id="test-form" method="POST" action="testa.php" onsubmit="submitThis();">
                <label for="username">
                    Username:<br><input class="login-form-input" type="text" name="username" id="username" placeholder="personel number" value="<?php echo $enc->encrypt_request("<script type='text/javascript'>document.write(v);</script>"); ?>" /><br><br>
                </label>
                <label for="password">
                    Password:<br><input  class="login-form-input" type="password" name="password" id="password" placeholder="password" /><br><br>
                </label>
                    <input
                        type="submit" id="login-form-button" value="Login"/>
                </form>
            </div>
        </div>
        <div id="footer">
            
        </div>
    </body>
</html>
<form>