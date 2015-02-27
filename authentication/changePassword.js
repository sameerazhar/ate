function getXmlHttpObject()
{
	var xmlhttp;
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	return xmlhttp;		
}
function encodeNameAndValue(sName, sValue)
{
	var sParam = encodeURIComponent(sName);
	sParam += "=";
	sParam += encodeURIComponent(sValue);
	return sParam;
}
function update_password()
{
	old_pwd=document.getElementById("old_password").value;
	new_pwd=document.getElementById("new_password").value;
	conf_pwd=document.getElementById("confirm_password").value;
	error_msg=document.getElementById("error_msg");
	if(conf_pwd!=new_pwd)
	{
		error_msg.innerHTML="New password and confirm password are not matched.";
	}
	else
	{
		var encodedOldPasswod = encodeNameAndValue("old_pwd", old_pwd);
		var encodedNewPassword = encodeNameAndValue("new_pwd", new_pwd);	
		xhr=getXmlHttpObject();
		xhr.open("POST","/ate/authentication/changePassword.php",true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange=update_result;      
		xhr.send(encodedOldPasswod + "&" + encodedNewPassword );
	}
}
function update_result()
{
	if(xhr.readyState == 4)
	{
		if(xhr.status == 200 || xhr.status == 304)
		{
			error_msg.innerHTML=xhr.responseText;
		}
		else
		{
			alert("Error");
		}
	}
}
function cancel()
{
	location="/ate/index.php";
}
