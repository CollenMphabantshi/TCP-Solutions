<?php
                echo '<ul class="nav navbar-nav">';
                    
                        require_once './encryptions.php';
                        $enc = new Encryption(); 
                        $sac = $_SESSION[$enc->md5_encrypt('s_ac')];
                        
                        if($sac === $enc->md5_encrypt("1")) // Admin
                        {
                            echo '<li><a href="#" id="1"class="pages active listUsers">Users</a></li>
                            <!-- <li><a href="#" id="2" class="pages">New User</a></li> -->
                            <li><a href="#" id="2" class="pages listAudit">Audit Log</a></li>
                            ';
                        }else if($sac === $enc->md5_encrypt("2")){ // FP
                            echo '<li><a href="#" class="pages" id="1"class="active listCases">Cases</a></li>
                            ';
                        }else if($sac === $enc->md5_encrypt("4")){ // Student
                            echo '<li><a href="#" class="pages" id="1"class="active listCases">Cases</a></li>
                            ';
                        }
                        else if($sac === $enc->md5_encrypt("6")){ // Admin and FP
                            echo '<li><a href="#" id="1"class="pages listCases">Cases</a></li>
                                <li><a href="#" id="2"class="pages active listUsers">Users</a></li>
                            <!--<li><a href="#" id="3" class="pages">New User</a></li> -->
                            <li><a href="#" id="3" class="pages listAudit">Audit Log</a></li>
                            ';
                        }   
                    
                    echo '<li><a href="#" id="logout">Logout</a></li>';
?>