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
function get_que(week, course)
{
	xhr = getXmlHttpObject();
	que_div = document.getElementById( "que" + week );
	jque_div = $("#que"+week);
	que_row = document.getElementById( "class_que" + week );
	week_no = week;
	course_code = course;
	xhr.onreadystatechange = display_que;
	xhr.open("GET", "../server/studentGetLabQuestion.php?course=" + course + "&week=" + week, true);
	xhr.send();
}

function display_que()
{
	if(xhr.readyState == 4)
	{
		if(xhr.status == 200 || xhr.status == 304)
		{
			
			if( xhr.responseText == "NA" )
			{
				que_div.innerHTML = "<div style=\"padding-left:5%\"><br>No Questions<br><br></div>";
				que_div.style.color = "red";
			}
			else
			{
				arr = JSON.parse(xhr.responseText);
				que_div.innerHTML = "";
				var que = arr[0];
				var start_time = arr[1];
				var end_time = arr[2];
				var today = arr[3];
				var div1 = document.createElement("div");
				jque_div.addClass("panel panel-default");
				div1.className = "panel-body";
				for( var i = 0; i < que.length; i++ )
				{
					if( today[0] > start_time[i] )
					{
						var div2 = document.createElement("div");
						div2.setAttribute("id", "dw" + week_no + "q" + i);
						var button = document.createElement("button");
						button.setAttribute("id", "bw" + week_no + "q" + i);
						button.setAttribute("onclick", "attempt(" + week_no + "," + i + ")");
						button.setAttribute("class", "btn btn-md btn-success");
						button.innerHTML = "Attempt";
						var que_str = document.createElement("div");
						que_str.innerHTML = i + 1 + ".  " + que[i];
						var due_date = document.createElement("small");
						due_date.innerHTML = "Due Date : " + end_time[i];
						var br1 = document.createElement("br");
						var br2 = document.createElement("br");
						var br3 = document.createElement("br");
						div2.appendChild(que_str);
						div2.appendChild(br1);
						div2.appendChild(due_date);
						div2.appendChild(br2);
						div2.appendChild(br3);
						div2.appendChild(button);
						div1.appendChild(div2);
						var hr = document.createElement("hr");
						div1.appendChild(hr);
						if( end_time[i] < today[0] )
						{
							button.disabled = true;
						}
					}
				}
				que_div.appendChild(div1);
			}
			$(".class_que" + week_no).slideToggle("slow");
		}
	}
}


function attempt(week, que)
{
	que++;
	window.location = "./studentAttemptLab.php?course=" + course_code + "&week=" + week + "&que=" + que;
}
