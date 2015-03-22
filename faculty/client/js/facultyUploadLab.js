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

var app = angular.module("facultyApp", []);


var _t_c = 0;

function set(data)
{
	outputType = data;
}

function upload_labAssign()
{
	try
	{
		xhr_labAssign = getXmlHttpObject();
		form = new FormData();
		var week_num = document.getElementById("week_num").value;
		var assign_num = document.getElementById("assign_num").value;
		var que = document.getElementById("que").value;
		form.append("week_num", week_num);
		form.append("assign_num", assign_num);
		form.append("que", que);
		for( var i = 1; i <= _t_c; i++ )
		{
			var inputfile = document.getElementById("inputfile" + i);
			var outputfile = document.getElementById("outputfile" + i);
			form.append("inputfile" + i, inputfile.files[0]);
			form.append("outputfile" + i, outputfile.files[0]);
		}
		xhr_labAssign.onreadystatechange = upload_labAssign_response;
	}
	catch(e)
	{
		alert(e);
	}
}

function upload_labAssign_response()
{

}


app.controller("facultyController", function($scope) {
	$scope.data = {};
});

app.filter("range", function() {
	return function(arr, high) {
		_t_c = parseInt(high);
		for(var i = 1; i <= high; i++)
		{
			arr.push(i);
		}
		return arr;
	}
});

function show_output_div()
{
	var exact_output = document.getElementById("exact_output");
	var output_div = document.getElementById("output_para");
	if( exact_output.checked )
	{
		output_div.style.display = "none";
	}
	else
	{
		output_div.style.display = "block";
	}
}