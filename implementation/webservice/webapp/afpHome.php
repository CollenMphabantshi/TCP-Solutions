<?php
    error_reporting(E_ERROR | E_PARSE);
    //session_start();
    require_once 'ph.php';
    $vu = new PreventHijack();
    if($vu->isValidUser("afp"))
    {  
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>m-Forensics</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/small-business.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

     <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
     <!-- jQuery Version 1.11.0 -->
     
        <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="jspdf.js"></script>
        <script type="text/javascript" src="libs/FileSaver.js"></script>
	<script type="text/javascript" src="libs/BlobBuilder.js"></script>
	<script type="text/javascript" src="jspdf.plugin.addimage.js"></script>
	<script type="text/javascript" src="jspdf.plugin.standard_fonts_metrics.js"></script>
	<script type="text/javascript" src="jspdf.plugin.split_text_to_size.js"></script>
	<script type="text/javascript" src="jspdf.plugin.from_html.js"></script>
        <script type="text/javascript" src="js/jspdf.debug.js"></script>
	<script type="text/javascript" src="js/basic.js"></script>
        
</head>

<body onload="runMe()">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="images/logo.png" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php
                    include_once './home.php';
                ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Heading Row -->
        <div class="row">
            <h1 id="page-heading"></h1>
        </div>
        <!-- /.row -->

        <hr>

        

        <!-- Content Row -->
        <div class="row page" id="Page1">
            <div class="col-md-4">
                <h2>Case information</h2>
                <table class="zui-table zui-table-zebra zui-table-horizontal">
                    <thead>
                        <tr>
                            <th>Case Number (#)</th>
                            <th>Scene Type</th>
                            <th>Forensic Officer Assigned</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody class="case-table">
                        
                    </tbody>
                </table>
            </div>
            <!-- /.col-md-4 -->
            
            <div class="col-md-8">
                <h2>Scene Information</h2>
                <input type="text" name="deathreg" id="deathreg" class="deathreg" placeholder="death register number" />
                <button id="assignDR" class="btn-lg">Assign Death register number</button>
                <button id="print" class="btn-lg">Create Print Out</button>
                            <br/><br/>
                <table class="zui-table zui-table-vertical table-responsive">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody class="sceneInfo-table">
                        
                    </tbody>
                </table>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <div class="row page" id="Page2">
            <div class="col-md-4">
                <h2>Add New User</h2>
                <form>
                    <label for="username"><span>username *</span>
                        <input type="text" class="formInput" id="name" name="name" placeholder="username" />
                    </label>
                    <label for="pass"><span>password *</span>
                        <input type="password" class="formInput" id="pass" name="pass" placeholder="password" />
                    </label>
                    <label for="cpass"><span>confirm password *</span>
                        <input type="password" class="formInput" id="cpass" name="cpass" placeholder="confirm password" />
                    </label>
                    <label for="firstname"><span>firstname *</span>
                        <input type="text" class="formInput" id="firstname" name="firstname" placeholder="firstname" />
                    </label>
                    <label for="surname"><span>surname *</span>
                        <input type="text" class="formInput" id="surname" name="surname" placeholder="surname" />
                    </label>
                    <label for="userType"><span>user type *</span>
                        <select class="formInput" id="userType"  name="userType" onchange="getUserForm()">
                                <option>Administrator</option>
                                <option>Forensic practitioner</option>
				<option>Forensic officer</option>
				<option>Student</option>
                                <!--<option>Guest</option>-->
                                <option>Forensic practitioner/Administrator</option>
                            </select>
                    </label>
                    
                    <input type="button" value="Add User" id="addUserButton" class="button btn-primary" />
                </form>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-8">
                <h2>User List</h2>
                <div>
                    <label for="userSearch">
                        <input type="search" name="userSearch" id="userSearch" placeholder="search users"  />
                    </label>
                </div><br/>
                <table class="zui-table zui-table-zebra zui-table-horizontal">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Active / Deactivated</th>
                        </tr>
                    </thead>
                    <tbody class="user-table">
                        
                    </tbody>
                </table>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->
        <div class="row page" id="Page3">
            <div class="col-lg-12">
                <div>
                    <label for="auditSearch">
                        <input type="search" name="auditSearch" id="auditSearch" placeholder="search audit log"  />
                    </label>
                </div><br/>
            <table class="zui-table zui-table-zebra zui-table-horizontal">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Audit Date &amp; Time</th>
                            <th>Audit Action</th>
                        </tr>
                    </thead>
                    <tbody class="audit-table">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->
        
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; forensicsapp.co.za 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

   

</body>

</html>

<?php
    }else{
        include_once 'errorPage.php';
    }
?>