<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: /ate/index.php");
	}
	extract($_GET);
	$usn = $_SESSION["username"];
	$course = trim($course);
	$week = trim($week);
	$que = trim($que);
	$lang = trim($lang);
	$main_file = trim($main_file);
	$cmplfiles = trim($cmplfiles);
	
	
	$cwd = getcwd();
	chdir("../../python/");

	$resource = popen("python3 execute.py " . $usn . " " . $course . " week_" . $week . "_" . $que . " " . $lang . " " . $main_file . " " . $cmplfiles . " 2>&1", "r");
	if (is_resource($resource))
	{
		while( !feof($resource) )
		{
			echo fgets($resource);
		}
		return;
	}
	
	chdir($cwd);
	echo "ERROR";
?>
