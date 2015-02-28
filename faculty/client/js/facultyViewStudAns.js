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

function evaluate_quiz(quiz_id, usn)
{
	var encodedQuiz_id = encodeNameAndValue("quiz_id", quiz_id);
	var encodedUsn = encodeNameAndValue("usn", usn);
	xhr_eval_quiz = getXmlHttpObject();
	xhr_eval_quiz.open("POST","../server/facultyEvaluateQuiz.php",true);
	xhr_eval_quiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_eval_quiz.onreadystatechange = evaluate_quiz_response;      
	xhr_eval_quiz.send( encodedQuiz_id + "&" + encodedUsn );
}

function evaluate_quiz_response()
{
	if( xhr_eval_quiz.readyState == 4 )
	{
		if( xhr_eval_quiz.status == 200 || xhr_eval_quiz.status == 304 )
		{
			//alert(xhr_eval_quiz.responseText);
			window.location = window.location;
		}
		else
		{
			alert("Error!! Please try again!!");
		}
	}
}