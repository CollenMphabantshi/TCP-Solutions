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
                        $sac = $_SESSION[md5('s_ac')];
                        
                        if($sac === md5("1")) // Admin
                        {
                            echo '<li><a href="#" id="1"class="pages active">List Users</a></li>
                            <li><a href="#" id="2" class="pages">Add User</a></li>
                            <li><a href="#" id="3" class="pages">Remove Users</a>';
                        }else if($sac === md5("2")){ // FP
                            echo '<li><a href="#" class="pages" id="1"class="active">Cases</a></li>
                            ';
                        }else {//if($sac === md5("6")){ // Admin and FP
                            echo '<li><a href="#" id="1"class="pages active">List Users</a></li>
                            <li><a href="#" id="2" class="pages">Add User</a></li>
                            <li><a href="#" id="3" class="pages">Remove Users</a>
                            <li><a href="#" id="4"class="pages">List Cases</a></li>
                            <li><a href="#" id="5" class="pages">Assign Death Register</a></li>';
                        }   
                    ?>
                    <li><a href="#" id="logout">Logout</a></li>
                </ul>
            </nav>
        </div>  
    </body>
</html>
