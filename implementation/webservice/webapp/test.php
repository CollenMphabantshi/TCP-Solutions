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
        <script type="text/javascript" src="jspdf.plugin.addhtml.js"></script>
        <script type="text/javascript" src="jspdf.plugin.autoprint.js"></script>
        <script type="text/javascript" src="jspdf.plugin.javascript.js"></script>
        <script type="text/javascript" src="jspdf.plugin.cell.js"></script>
        <script type="text/javascript" src="jspdf.plugin.total_pages.js"></script>
        <script type="text/javascript" src="js/html2canvas.js"></script>
        <script type="text/javascript" src="rasterizeHTML.js"></script>
        <script type="text/javascript" src="js/jspdf.debug.js"></script>
	<script type="text/javascript" src="js/basic.js"></script>
        
        
        <script type="text/javascript">
 
            
                $(document).ready(function(){
                   /* var doc = new jsPDF("landscape", "mm", "a4");

                    doc.setFontSize(22);
                    doc.text(20, 20, 'This is a exmaple of jsPDF');

                    doc.setFontSize(16);
                    doc.text(20, 30, 'This example was created by CodersGrid (http://www.codersgrid.com). Hope you guys enjoy!');

                    var iframe = document.getElementById('preview-pane');
                    
                    iframe.src = doc.output('datauristring');*/
        
                    $("#cmd").click(function(){
                    var doc = new jsPDF();

                    // We'll make our own renderer to skip this editor
                    var specialElementHandlers = {
                            '#editor': function(element, renderer){
                                    return true;
                            }
                    };

                    // All units are in the set measurement for the document
                    // This can be changed to "pt" (points), "mm" (Default), "cm", "in"

                    doc.fromHTML($("#tables").get(0), 15, 15, {
                            'width': 170, 
                            'elementHandlers': specialElementHandlers
                    });

                    $(".preview-pane").attr("src",doc.output("datauristring"));
  
                    });
        });
    
                
        </script>
    </head>
        <body>
        <div id="header">
            <header class="header-content">
                
            </header>
            <a id="bypassme">OOO</a>
        </div>
            
            <iframe class="preview-pane" id="preview-pane" type="application/pdf" width="100%" height="600px" frameborder="0" style="position:relative;z-index:999" >
                
            </iframe>
            <div id="tables">
            <table id="mytable" class="zui-table zui-table-zebra zui-table-horizontal">
                    <thead>
                        <tr>
                            <th>Case Number (#)</th>
                            <th>Scene Type</th>
                        </tr>
                    </thead>
                    <tbody class="case-table">
                        <tr>
                            <td>1</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button id="cmd">Download</button>
           
        
    </body>
</html>
<form>