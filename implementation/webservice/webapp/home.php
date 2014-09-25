<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Forensics</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <div class="main">
            <nav>
                <ul>
                    <?php
                        require_once './encryptions.php';
                        $enc = new Encryption(); 
                        $sac = $_SESSION[$enc->md5_encrypt('s_ac')];
                        
                        if($sac === $enc->md5_encrypt("1")) // Admin
                        {
                            echo '<li><a href="#" id="1"class="pages active listUsers">List Users</a></li>
                            <li><a href="#" id="2" class="pages">Add User</a></li>
                            <li><a href="#" id="3" class="pages">Audit Log</a></li>
                            ';
                        }else if($sac === $enc->md5_encrypt("2")){ // FP
                            echo '<li><a href="#" class="pages" id="1"class="active listCases">Cases</a></li>
                            ';
                        }else if($sac === $enc->md5_encrypt("4")){ // Student
                            echo '<li><a href="#" class="pages" id="1"class="active listCases">Cases</a></li>
                            ';
                        }
                        else if($sac === $enc->md5_encrypt("6")){ // Admin and FP
                            echo '<li><a href="#" id="1"class="pages active listUsers">List Users</a></li>
                            <li><a href="#" id="2" class="pages">Add User</a></li>
                            <li><a href="#" id="3"class="pages listCases">List Cases</a></li>
                            <li><a href="#" id="4" class="pages">Audit Log</a></li>
                            ';
                        }   
                    ?>
                    <li><a href="#" id="logout">Logout</a></li>
                </ul>
            </nav>
        </div>  
    </body>
</html>
