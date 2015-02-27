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
function encodeNameAndValue(sName, sValue) //faculty
{
	var sParam = encodeURIComponent(sName);
	sParam += "=";
	sParam += encodeURIComponent(sValue);
	return sParam;
}
function generate_quiz()
{
	quiz_name=document.getElementById("quiz_name").value.trim();
	qstn_summary=document.getElementById("qstn_summary").value.trim();
	easy=document.getElementById("easy").value;
	med=document.getElementById("med").value;
	hard=document.getElementById("hard").value;
	set=document.getElementById("no_set").value;
	error_msg=document.getElementById("msg");
	if(quiz_name=="" || qstn_summary=="")
	{
		error_msg.innerHTML="Quiz name and type of question can not be left empty.";
	}
	else
	{
		var encodedquizname = encodeNameAndValue("quiz_name", quiz_name);
		var encodedqstntype = encodeNameAndValue("summary", qstn_summary);
		var encodedeasy = encodeNameAndValue("easy", easy);
		var encodedmed = encodeNameAndValue("med", med);	
		var encodedhard = encodeNameAndValue("hard", hard);
		var encodedset = encodeNameAndValue("no_set", set);
		var encodedcourse = encodeNameAndValue("course_code","11CS206");
		xhr=getXmlHttpObject();
		xhr.open("POST","/ate/faculty/server/createQuizDatabase.php",true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange=update_result;      
		xhr.send(encodedquizname + "&" + encodedqstntype + "&" + encodedset + "&" + encodedeasy + "&" + encodedmed + "&" + encodedhard + "&" + encodedcourse);
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
