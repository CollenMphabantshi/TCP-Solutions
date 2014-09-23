<?php
    error_reporting(E_ERROR | E_PARSE);
    require_once 'ph.php';
    $vu = new PreventHijack();
    if($vu->isValidUser("fp"))
    {
        
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Forensics App</title>
        <link rel="stylesheet" type="text/css" href="styles.css"/>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body onload="loadCases();">
       <?php include_once("home.php");?>
        <div class="response"></div>
        <div class="content">
            <div id="Page1" class="page">
                <div id="Page1-left">
                    <div class="searchForm">

                        <input type="search" name="search" id="search" placeholder=" search by scene type or forensic officer"  /> <input type="image" name="searchButton" id="searchButton" src="images/icons/search-black.png" />
                        <br/> <br/> <br/>
                    </div>
                    <div class="caseList">
                        <table id="cases">
                            <tr class="table-headers">
                                <th>Case Number (#)</th>
                                <th>Scene Type</th>
                                <th>Forensic Officer Assigned</th>
                                <th>Options</th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
                <div id="Page1-right">
                    <h1>Case Information</h1>
                    <div class="right-content">
                        <div class="toolbar">
                            <input type="text" name="deathreg" id="deathreg" class="deathreg" placeholder="death register number" /><button id="assignDR" class="deathreg-btn">Assign Death register number</button>
                            <button id="print">Create Print Out</button>
                            <br/>
                        </div>
                        <table>
                            
                        </table><br/>
                       
                    </div>
                </div>
            </div>
            <div id="Page2" class="page"></div>
            <div id="Page3" class="page"></div>
        </div>
    </body>
</html>
<?php
    }else{
        include_once 'errorPage.php';
    }
?>