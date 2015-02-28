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

function upload_file(course_code)
{
	try
	{
		if(!checkExtension())
		{
			alert("Upload only excel format.")
		}
		else
		{
			xhr_upload_file = getXmlHttpObject();
			xhr_upload_file.onreadystatechange = upload_file_response;
		
			//Get the file that needs to be uploaded
			file = document.getElementById("quiz");
	
		
			form = new FormData();
			form.append("quiz", file.files[0]);
			form.append("course_code", course_code);
			if(document.getElementById("quiz").value.match(/\.([^\.]+)$/)[1] == 'xml')
			{
				xhr_upload_file.open("POST", "../server/facultyUploadQuizXML.php", true);
			}
			else
			{
				xhr_upload_file.open("POST", "../server/facultyUploadQuiz.php", true);
			}
			xhr_upload_file.send(form);
		}
	}
	catch(exception)
	{
		alert(exception);
	}
}


function upload_file_response()
{
	if( xhr_upload_file.readyState == 4 )
	{
		if( xhr_upload_file.status == 200 || xhr_upload_file.status == 304)
		{
			var status = document.getElementById("status");
			status.innerHTML = xhr_upload_file.responseText;
			status.style.color = "blue";
		}
		else
		{
			alert("Some error occured, try later.")
		}
	}
}

function checkExtension()
{
    var ext = document.getElementById("quiz").value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'xls':
        case 'xlsx':
        case 'ods':
        case 'xml':
       		return true;
            break;
        default:
            return false;
    }
    // check if fname has the desired extension
    return false;
}


function encodeNameAndValue(sName, sValue)
{
	var sParam = encodeURIComponent(sName);
	sParam += "=";
	sParam += encodeURIComponent(sValue);
	return sParam;
}
function generate_quiz(course_code)
{
	quiz_name = document.getElementById("quiz_name").value.trim();
	qstn_summary = document.getElementById("qstn_summary").value.trim();
	easy = document.getElementById("easy").value;
	med = document.getElementById("med").value;
	hard = document.getElementById("hard").value;
	time_period = document.getElementById("time_period").value;
	enabled = document.getElementById("enabled").checked;
	var error_msg = document.getElementById("msg");
	if( time_period == "" || time_period == null )
	{
		error_msg.innerHTML = "Enter the time period";
		return;
	}
	if( quiz_name == "" || qstn_summary == "" )
	{
		error_msg.innerHTML = "Quiz name and type of question can not be left empty.";
	}
	else
	{
		var encodedquizname = encodeNameAndValue("quiz_name", quiz_name);
		var encodedqstntype = encodeNameAndValue("summary", qstn_summary);
		var encodedeasy = encodeNameAndValue("easy", easy);
		var encodedmed = encodeNameAndValue("med", med);	
		var encodedhard = encodeNameAndValue("hard", hard);
		var encodedcourse = encodeNameAndValue("course_code", course_code);
		var encodedtime = encodeNameAndValue("time_period", time_period);
		var encodedenabled = encodeNameAndValue("enabled", enabled);
		xhr_generate_quiz = getXmlHttpObject();
		xhr_generate_quiz.open("POST","../server/facultyCreateQuiz.php",true);
		xhr_generate_quiz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr_generate_quiz.onreadystatechange = generate_quiz_response;      
		xhr_generate_quiz.send(encodedquizname + "&" + encodedqstntype + "&" + encodedeasy + "&" + encodedmed + "&" + encodedhard + "&" + encodedcourse + "&" + encodedtime + "&" + encodedenabled);
	}
}
function generate_quiz_response()
{
	if( xhr_generate_quiz.readyState == 4 )
	{
		if( xhr_generate_quiz.status == 200 || xhr_generate_quiz.status == 304)
		{
			var msg = document.getElementById("msg");
			msg.innerHTML = xhr_generate_quiz.responseText;
			msg.style.color = "blue";
		}
		else
		{
			alert("Some error occured, try later.");
		}
	}
}
function cancel()
{
	window.location="./faculty.php";
}