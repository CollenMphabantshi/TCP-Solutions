<?php
    error_reporting(E_ERROR | E_PARSE);
    require_once 'ph.php';
    $vu = new PreventHijack();
    if($vu->isValidUser("fp"))
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

    <title>mForensics</title>
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
     
        
	<script type="text/javascript" src="jspdf.js"></script>
        <script type="text/javascript" src="libs/FileSaver.js"></script>
	<script type="text/javascript" src="libs/BlobBuilder.js"></script>
	<script type="text/javascript" src="jspdf.plugin.standard_fonts_metrics.js"></script>
	<script type="text/javascript" src="jspdf.plugin.split_text_to_size.js"></script>
	<script type="text/javascript" src="jspdf.plugin.from_html.js"></script>
        <script type="text/javascript" src="jspdf.plugin.addimage.js"></script>
        <script type="text/javascript" src="jspdf.plugin.addhtml.js"></script>
        <script type="text/javascript" src="jspdf.plugin.autoprint.js"></script>
        <script type="text/javascript" src="jspdf.plugin.javascript.js"></script>
        <script type="text/javascript" src="jspdf.plugin.cell.js"></script>
        <script type="text/javascript" src="jspdf.plugin.total_pages.js"></script>
        <script type="text/javascript" src="jspdf.PLUGINTEMPLATE.js"></script>
        <script type="text/javascript" src="js/html2canvas.js"></script>
        <script type="text/javascript" src="rasterizeHTML.js"></script>
        <script type="text/javascript" src="js/jspdf.debug.js"></script>
	<script type="text/javascript" src="js/basic.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
</head>

<body onload="getCases()">

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
                    <img src="images/logo-white.png" alt="">
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
                <div>
                    <label for="caseSearch">
                        <input type="search" name="caseSearch" id="caseSearch" placeholder="search case by sceneType or forensic officer"  />
                    </label>
                </div><br/>
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
                <div class="sceneInfo">
                    <div id="pdfView">
                        <!-- <a href="#" id="close" class="btn-lg btn-block">Close</a> -->
                        <br/>
                    <iframe id='viewer' width='100%' height='600px' type='application/pdf' frameborder='0' style='position:relative;z-index:999;hight:auto'></iframe>
                    </div>
                    <div class="sceneView">
                        <input type="text" name="deathreg" id="deathreg" class="deathreg" placeholder="death register number" />
                        <button id="assignDR" class="btn-lg">Assign Death register number</button>
                        <button id="print" class="btn-lg">Create Print Out</button>
                        <br/><br/>
                        <div id="tables">
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
                        
                    </div>
                </div>
            </div>
            <!-- /.col-md-4 -->
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