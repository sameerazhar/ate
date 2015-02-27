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

function register()
{
	var checkBox = document.getElementsByTagName("input");

	var course = "";
	var f = true;
	for( i = 0; i < checkBox.length; i++ )
	{
		if( checkBox[i].checked )
		{
			if( f )
			{
				course = checkBox[i].value;
				f = false;
			}
			else
			{
				course = course + "," + checkBox[i].value;
			} 
		}
	}
	xhr_register = getXmlHttpObject();
	xhr_register.onreadystatechange = register_response;
	xhr_register.open("POST", "/ate/student/server/registerStudentCourses.php", true);
	xhr_register.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr_register.send("courses=" + course);
}


function register_response()
{
	if(xhr_register.readyState == 4)
	{
		if(xhr_register.status == 200 || xhr_register.status == 304)
		{
			if( xhr_register.responseText == "ERROR" )
			{
				alert("Some error occured, try after some time.");
			}
			else
			{
				alert("Courses registered successfully.");
				window.location = "/ate/student/client/student.php";
			}
		}
	}
}
