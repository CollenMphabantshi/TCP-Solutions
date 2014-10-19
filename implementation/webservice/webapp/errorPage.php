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
    <body>
        <div class="container">

            <!-- Heading Row -->
            <div class="row">
                <h1 id="page-heading">You do not have permission to view this page or connection was not established. Try again.</h1>
            </div>
            <!-- /.row -->

            <hr>
           
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
