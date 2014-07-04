<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="jquery.js"></script>
        <script src="script.js"></script>
        <script type="text/javascript">
            var query = new FormData();
            var id = "";
    
    
    
    //var reqObj = {"email":"aa@aa.com","pwd":"open"};
    
    query.append("rquest","login");
    query.append("email","u11111111");
    query.append("pwd","open");
    
    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){if(request.readyState == 4)
    {
        
        //$("body").html(request.responseText);
    }};
    request.open("POST","api.php");request.send(query);
        </script>
    </head>
    <body>
        <?php
        // put your code here
            echo md5("open");
        ?>
        <form>
            
        </form>
    </body>
</html>
