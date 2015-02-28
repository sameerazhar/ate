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


function getQuizQuestion(quiz_id)
{
	xhr_getQuiz = getXmlHttpObject();
	xhr_getQuiz.onreadystatechange = getQuizQuestion_response;
	var quiz = encodeNameAndValue("quiz_id", quiz_id);
	xhr_getQuiz.open("GET", "../server/facultyViewQuiz.php?" + quiz, true);
	xhr_getQuiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_getQuiz.send();
}

function getQuizQuestion_response()
{
	if( xhr_getQuiz.readyState == 4 )
	{
		if( xhr_getQuiz.status == 200 || xhr_getQuiz.status == 304 )
		{
		}
		else
		{
			alert("Some error occured, try later.");
		}
	}
}