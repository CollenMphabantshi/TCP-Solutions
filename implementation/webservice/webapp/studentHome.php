<?php
    error_reporting(E_ERROR | E_PARSE);
    require_once 'ph.php';
    $vu = new PreventHijack();
    if($vu->isValidUser("student"))
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

                        <input type="search" name="search" id="search"  /> <input type="image" name="searchButton" id="searchButton" src="images/icons/search-black.png" />
                        <br/> <br/> <br/>
                    </div>
                    <div class="caseList">
                        <table id="cases">
                            <tr id="table-headers">
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
                            <button>Create Print Out</button>
                            <br/>
                        </div>
                        <table>
                            
                        </table><br/>
                       <!-- 
                        <div class="photos">
                            <section class="pagedImages">
                                <input id="page1" accesskey="1" type="radio" name="pagedImages1" title="Images page 1" checked="checked" />
                                <input id="page2" accesskey="2" type="radio" name="pagedImages1" title="Images page 2" />
                                <input id="page3" accesskey="3" type="radio" name="pagedImages1" title="Images page 3" />
                                <label for="page1" title="To page 1">1</label>
                                <label for="page2" title="To page 2">2</label>
                                <label for="page3" title="To page 3">3</label>
                                <ul title="This is page 1">
                                    <li id="image1">
                                    <a href="#image1"><img alt="" src="http://placekitten.com/400/400" /></a>
                                    <article>
                                        <h3>Image 1</h3>
                                        <p>Have here whatever you like.</p>
                                        <p><a href="#">Close</a></p>
                                    </article>
                                    </li>
                                    <li id="image2">
                                        <a href="#image2"><img alt="" src="https://placekitten.com/300/400" /></a>
                                    <article>
                                        <h3>Image 2</h3>
                                        <p>Have here whatever you like.</p>
                                        <p><a href="#">Close</a></p>
                                    </article>
                                    <aside>
                                    <p>You can have more than one element here and it doesn't need to be article.</p>
                                    </aside>
                                    </li>
                                            <li id="image3">
                                                    <a href="#image3"><img alt="" src="https://placekitten.com/400/300" /></a>
                                                    <article>
                                                            <h3>Image 3</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                            <li id="image4">
                                                    <a href="#image4"><img alt="" src="https://placekitten.com/250/400" /></a>
                                                    <article>
                                                            <h3>Image 4</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                    </ul>
                                    <ul title="This is page 2">
                                            <li id="image5">
                                                    <a href="#image5"><img alt="" src="https://placekitten.com/400/250" /></a>
                                                    <article>
                                                            <h3>Image 5</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                            <li id="image6">
                                                    <a href="#image6"><img alt="" src="https://placekitten.com/400/200" /></a>
                                                    <article>
                                                            <h3>Image 6</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                            <li id="image7">
                                                    <a href="#image7"><img alt="" src="https://placekitten.com/200/400" /></a>
                                                    <article>
                                                            <h3>Image 7</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                            <li id="image8">
                                                    <a href="#image8"><img alt="" src="http://placekitten.com/275/400" /></a>
                                                    <article>
                                                            <h3>Image 8</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                    </ul>
                                    <ul title="This is page 3">
                                            <li id="image9">
                                                    <a href="#image9"><img alt="" src="https://placekitten.com/400/275" /></a>
                                                    <article>
                                                            <h3>Image 9</h3>
                                                            <p>Have here whatever you like.</p>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                            <li id="image10">
                                                    <a href="#image10"><img alt="" src="https://placekitten.com/350/400" /></a>
                                                    <article>
                                                            <h3>Image 10</h3>
                                                            <p><a href="#">Close</a></p>
                                                    </article>
                                            </li>
                                    </ul>
                            </section>
                        </div>-->
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