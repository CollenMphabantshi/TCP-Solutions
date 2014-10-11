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
                     var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

   $('#cmd').click(function () {

        var table = tableToJson($('#mytable').get(0))
        var doc = new jsPDF('p','pt', 'a4', true);
        doc.cellInitialize();
        $.each(table, function (i, row){
            console.debug(row);
            $.each(row, function (j, cell){
                doc.cell(10, 50,150, 50, cell, i);  // 2nd parameter=top margin,1st=left margin 3rd=row cell width 4th=Row height
            })
        })


        doc.save('sample-file.pdf');
    });
    function tableToJson(table) {
            var data = [];

            // first row needs to be headers
            var headers = [];
            for (var i=0; i<table.rows[0].cells.length; i++) {
                headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
            }


            // go through cells
            for (var i=0; i<table.rows.length; i++) {

                var tableRow = table.rows[i];
                var rowData = {};

                for (var j=0; j<tableRow.cells.length; j++) {

                    rowData[ headers[j] ] = tableRow.cells[j].innerHTML;

                }

                data.push(rowData);
            }       

            return data;
        }
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
            <table id="mytable" class="zui-table zui-table-zebra zui-table-horizontal">
                    <thead>
                        <tr>
                            <th>Case Number (#)</th>
                            <th>Scene Type</th>
                            <th>Forensic Officer Assigned</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody class="case-table">
                        <tr>
                            <td>A</td>
                            <td>B</td>
                            <td>C</td>
                            <td>D</td>
                        </tr>
                    </tbody>
                </table>
            <button id="cmd">Download</button>
           
        
    </body>
</html>
<form>