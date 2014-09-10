<!DOCTYPE  HTML>
<html>
<head>

<title>Collen Banchi Mphabantshi</title>

<script type="text/javascript">


function CheckEmptyFields(){

var username=document.forms["MyForm"]["account"].value


if((username == null || username ==""))
	{
		alert("sorry!! all fields must be filled");
		return false;
	}else{
		return true;
	}
}


function createJSON(){ 
  var myJSONobj={ 
		
        "Username" : document.getElementById("account").value,
	
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
<form  action="web/home.php"  id="MyForm" name="MyForm"  method="post" autocomplete="on"   >


<p>
<?php
@session_start();
	//$_SESSION['Username'] = $Username;
	echo "Enter this account to view your details : ".$_SESSION['Username'];
?>
</p>
<input type="text" id="account" name="account" placeholder="account number" autofocus="autofocus"/>
<input type="hidden" name="formValues"  id="formValues" />
<tr><td><input type="button" value="view my details" onClick="javascript:SubmitForm()" /></td></tr>

</form>

</table>

</body>
</html>