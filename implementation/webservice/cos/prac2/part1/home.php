<!DOCTYPE  HTML>
<html>
<head>

<title>Collen Banchi Mphabantshi</title>

<script type="text/javascript">


function CheckEmptyFields(){

var username=document.forms["MyForm"]["username"].value

var password=document.forms["MyForm"]["password"].value

var code=document.forms["MyForm"]["code"].value

if((username == null || username =="")|| (password == null || password =="") || (code == null || code == "" ))
	{
		alert("sorry!! all fields must be filled");
		return false;
	}else{
		return true;
	}
}


function createJSON(){ 
  var myJSONobj={ 
		
        "Username" : document.getElementById("username").value,
		
		"Password" : document.getElementById("password").value,
		
		"AuthenticationCode" : document.getElementById("code").value,
	
}
   
var myJSONstr =JSON.stringify(myJSONobj);

return myJSONstr;
}

function SubmitForm(){

if(!CheckEmptyFields()){
	
	return false;
	
}
else{
	document.getElementById('formValues').value = createJSON();
	alert(document.getElementById('formValues').value);
	document.MyForm.submit();
	}
}



</script>

</head>
<body align="center">

<h2 align="center"> PLEASE FILL IN YOUR LOGIN DETAILS</h2>

<table border="0" align="center">
<form  action="web/home.php"  id="MyForm" name="MyForm"  method="get" autocomplete="on"   >


<p>
<?php
@session_start();
	//$_SESSION['Username'] = $Username;
	echo "Enter this account to view your details : ".$_SESSION['Username'];
?>
</p>
<input type="text" id="account" name="account" placeholder="account number" autofocus="autofocus"/>
<input type="hidden" name="formValues"  id="formValues" />
<tr><td><input type="submit" value="view my details" /></td></tr>

</form>

</table>

</body>
</html>