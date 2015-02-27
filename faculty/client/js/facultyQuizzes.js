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

function disable_quiz(quiz_id)
{
	disable_anchor = document.getElementById("enable" + quiz_id);
	xhr_disable_quiz = getXmlHttpObject();
	xhr_disable_quiz.onreadystatechange = disable_quiz_response;

	var quiz = encodeNameAndValue("quiz_id", quiz_id);
	var disable = encodeNameAndValue("disable", "yes");
	xhr_disable_quiz.open("GET", "/ate/faculty/server/facultyQuizzes.php?" + quiz + "&" + disable, true);
	xhr_disable_quiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_disable_quiz.send();
}

function disable_quiz_response()
{
	if( xhr_disable_quiz.readyState == 4 )
	{
		if( xhr_disable_quiz.status == 200 || xhr_disable_quiz.status == 304 )
		{
			if( xhr_disable_quiz.responseText == "ERROR" )
			{
				alert("Some error occured, try later.");
			}
			else
			{
				if( disable_anchor.innerHTML == "Enable" )
				{
					disable_anchor.innerHTML = "Disable";
				}
				else
				{
					disable_anchor.innerHTML = "Enable";
				}
			}
		}
		else
		{
			alert("Some error occured, try later.");
		}
	}
}

function delete_quiz(quiz_id)
{
	var del = confirm("You want to delete this quiz?");
	if( del == false )
	{
	}
	else
	{
		delete_row = document.getElementById("row" + quiz_id);
		xhr_delte_quiz = getXmlHttpObject();
		xhr_delte_quiz.onreadystatechange = delete_quiz_response;

		var quiz = encodeNameAndValue("quiz_id", quiz_id);
		var delete_q = encodeNameAndValue("delete", "yes");
		xhr_delte_quiz.open("GET", "/ate/faculty/server/facultyQuizzes.php?" + quiz + "&" + delete_q, true);
		xhr_delte_quiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr_delte_quiz.send();
	}
}


function delete_quiz_response()
{
	if( xhr_delte_quiz.readyState == 4 )
	{
		if( xhr_delte_quiz.status == 200 || xhr_delte_quiz.status == 304 )
		{
			if( xhr_delte_quiz.responseText == "ERROR" )
			{
				alert("Some error occured, try later.");
			}
			else
			{
				delete_row.parentNode.removeChild(delete_row);
			}
		}
		else
		{
			alert("Some error occured, try later.");
		}
	}
}

function evaluate_quiz(quiz_id, course)
{
	var encodedQuiz_id = encodeNameAndValue("quiz_id", quiz_id);
	var encodedCourse = encodeNameAndValue("course", course);
	window.location = "/ate/faculty/client/facultyEvaluateQuiz.php?" + encodedQuiz_id + "&" + encodedCourse;
}