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
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="pdfobject.js"></script>
        <script type="text/javascript" src="libs/base64.js"></script>
	<script type="text/javascript" src="libs/sprintf.js"></script>
	<script type="text/javascript" src="jspdf.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                startPDF();
                alert("a");
            });
                function startPDF(){
                    var pdf = new jsPDF('p', 'pt', 'letter'

// source can be HTML-formatted string, or a reference
// to an actual DOM element from which the text will be scraped.
, source = $('#header')[0]

// we support special element handlers. Register them with jQuery-style
// ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
// There is no support for any other type of selectors
// (class, of compound) at this time.
, specialElementHandlers = {
	// element with id of "bypass" - jQuery style selector
	'#bypassme': function(element, renderer){
		// true = "handled elsewhere, bypass text extraction"
		return true
	}
});

margins = {
    top: 80,
    bottom: 60,
    left: 40,
    width: 522
  };
  // all coords and widths are in jsPDF instance's declared units
  // 'inches' in this case
pdf.fromHTML(
  	source // HTML string or DOM elem ref.
  	, margins.left // x coord
  	, margins.top // y coord
  	, {
  		'width': margins.width // max width of content on PDF
  		, 'elementHandlers': specialElementHandlers
  	},
  	function (dispose) {
  	  // dispose: object with X, Y of the last line add to the PDF
  	  //          this allow the insertion of new lines after html
        pdf.save('Test.pdf');
      },
  	margins
  );
                }
        </script>
    </head>
        <body>
        <div id="header">
            <header class="header-content">
                sdffsdfsdfsdfsdf
            </header>
            <a id="bypassme">OOO</a>
        </div>
        
    </body>
</html>
<form>