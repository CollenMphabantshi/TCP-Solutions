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
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="jspdf.js"></script>
        <script type="text/javascript" src="libs/FileSaver.js"></script>
	<script type="text/javascript" src="libs/BlobBuilder.js"></script>
	<script type="text/javascript" src="jspdf.plugin.addimage.js"></script>
	<script type="text/javascript" src="jspdf.plugin.standard_fonts_metrics.js"></script>
	<script type="text/javascript" src="jspdf.plugin.split_text_to_size.js"></script>
	<script type="text/javascript" src="jspdf.plugin.from_html.js"></script>
        <script type="text/javascript" src="js/html2canvas.js"></script>
        <script type="text/javascript" src="addHtml.js"></script>
        <script type="text/javascript" src="rasterizeHTML.js"></script>
        <script type="text/javascript" src="js/jspdf.debug.js"></script>
	<script type="text/javascript" src="js/basic.js"></script>
        <script type="text/javascript" src="js/"></script>
        
        <script type="text/javascript">
 
            
                $(document).ready(function(){
                   /* var doc = new jsPDF("landscape", "mm", "a4");

                    doc.setFontSize(22);
                    doc.text(20, 20, 'This is a exmaple of jsPDF');

                    doc.setFontSize(16);
                    doc.text(20, 30, 'This example was created by CodersGrid (http://www.codersgrid.com). Hope you guys enjoy!');

                    var iframe = document.getElementById('preview-pane');
                    
                    iframe.src = doc.output('datauristring');*/
                    var pdf = new jsPDF('p','pt','a4');

pdf.addHTML(document.body,function() {
	var string = pdf.output('datauristring');
	$('.preview-pane').attr('src', string);
});
                });
        </script>
    </head>
        <body>
        <div id="header">
            <header class="header-content">
                sdffsdfsdfsdfsdf
            </header>
            <a id="bypassme">OOO</a>
        </div>
            
            <iframe class="preview-pane" id="preview-pane" type="application/pdf" width="100%" frameborder="0" style="position:relative;z-index:999" >
                
            </iframe>
            <div id="editor"><h1>ffff</h1></div>
                
           
        
    </body>
</html>
<form>