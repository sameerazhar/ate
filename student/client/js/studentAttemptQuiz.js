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

function getAttemptedAnswers()
{
	var input = document.getElementsByTagName("input");
	var attempted_answers=""
	for( var i = 0; i < input.length; i++ )
	{
		if( input[i].type == "checkbox" && input[i].checked )
		{
			attempted_answers += ","+input[i].value;
		}
	}
	return attempted_answers;
}


function submit_quiz()
{
	var attempted_answers = getAttemptedAnswers();
	var encodedAnswers = encodeNameAndValue("answers", attempted_answers.substring(1));
	var encodedQuiz_id = encodeNameAndValue("quiz_id", quiz_id);
	var timer=document.getElementById( "timer" ).innerHTML.split("-")[1].trim().split(":");
	var time=parseInt(timer[0]) * 60 + parseInt(timer[1]);
	var encodedTime = encodeNameAndValue("time", time);
	xhr_submit_quiz = getXmlHttpObject();
	xhr_submit_quiz.open("POST","../server/studentEvaluateQuiz.php",true);
	xhr_submit_quiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_submit_quiz.onreadystatechange = submit_quiz_response;      
	xhr_submit_quiz.send(encodedAnswers + "&" + encodedQuiz_id + "&" + encodedTime );
}

function submit_quiz_response()
{
	if(xhr_submit_quiz.readyState == 4)
	{
		if(xhr_submit_quiz.status == 200 || xhr_submit_quiz.status == 304)
		{
			window.location = "./studentQuizSubmitted.php?course=" + course;
		}
		else
		{
			alert("Error!! Please try again!!");
		}
	}
}

var w = null; // initialize variable
// function to start the timer
function startTimer()
{
	// First check whether Web Workers are supported
	if( typeof( Worker) !== "undefined" )
	{
		// Check whether Web Worker has been created. If not, create a new Web Worker based on
		if( w == null)
		{
			w = new Worker("./js/timerWorker.js");
		}
		// Update timer div with output from Web Worker
		w.onmessage = function (event)
		{
			if(event.data=="timeout")
			{
				w.terminate();
				w=null;
				document.getElementById("submit_btn").click();
				document.getElementById( "timer" ).innerHTML = "Timer - 00:00";
			}
			else
			{
				document.getElementById( "timer" ).innerHTML = "Timer - " + event.data;
			}
		};
		w.postMessage(time);
	}
	else
	{
		// Web workers are not supported by your browser
		document.getElementById( "timer" ).innerHTML = "Sorry, your browser does not support Web worker";
	}
}
startTimer();

function update_quiz()
{
	var attempted_answers = getAttemptedAnswers();
	var timer=document.getElementById( "timer" ).innerHTML.split("-")[1].trim().split(":");
	var time=parseInt(timer[0]) * 60 + parseInt(timer[1]);
	var encodedAnswers = encodeNameAndValue("answers", attempted_answers.substring(1));
	var encodedQuiz_id = encodeNameAndValue("quiz_id", quiz_id);
	var encodedTime = encodeNameAndValue("time", time);
	xhr_update_quiz = getXmlHttpObject();
	xhr_update_quiz.open("POST", "../server/studentUpdateQuiz.php", true);
	xhr_update_quiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_update_quiz.onreadystatechange = update_quiz_response;
	xhr_update_quiz.send(encodedAnswers + "&" + encodedQuiz_id + "&" + encodedTime);
}

function update_quiz_response()
{
	/*if(xhr_update_quiz.readyState == 4)
	{
		if(xhr_update_quiz.status == 200 || xhr_update_quiz.status == 304)
		{
			alert("update" + xhr_update_quiz.responseText);
			
		}
		else
		{
			alert("Error!! Please try again!!");
		}
	}*/
}

window.onload= function()
{
	t=setInterval(update_quiz,10000);
}