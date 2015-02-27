var app = angular.module("facultyApp", []);


var _t_c = 0;

function upload_labAssign()
{
	//alert("OK IN");
	try
	{
		xhr_labAssign = new XMLHttpRequest();
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
		xhr_labAssign.onreadystatechange = labAssign_response;
	}
	catch(e)
	{
		alert(e);
	}
}

app.controller("facultyController", function($scope) {
	//$scope.tpl = {};
	$scope.data = {};
	/*$scope.ids = new Array("lab", "assign", "exam", "quiz");
	$scope.tpl.url = "labAssign.php";
	$("#lab").on("click", function(){
		$scope.tpl.url="labAssign.php";
		$scope.$apply();
		for(var i = 0; i < $scope.ids.length; i++)
		{
			document.getElementById($scope.ids[i]).setAttribute("class", "");	
		}
		document.getElementById("lab").setAttribute("class", "active");
	});
	$("#assign").on("click", function(){
		$scope.tpl.url="regAssign.php";
		$scope.$apply();
		for(var i = 0; i < $scope.ids.length; i++)
		{
			document.getElementById($scope.ids[i]).setAttribute("class", "");	
		}
		document.getElementById("assign").setAttribute("class", "active");
	});
	$("#exam").on("click", function(){
		$scope.tpl.url="examAssign.php";
		$scope.$apply();
		for(var i = 0; i < $scope.ids.length; i++)
		{
			document.getElementById($scope.ids[i]).setAttribute("class", "");	
		}
		document.getElementById("exam").setAttribute("class", "active");
	});
	$("#quiz").on("click", function(){
		$scope.tpl.url="quizAssign.php";
		$scope.$apply();
		for(var i = 0; i < $scope.ids.length; i++)
		{
			document.getElementById($scope.ids[i]).setAttribute("class", "");	
		}
		document.getElementById("quiz").setAttribute("class", "active");
	});
*/
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