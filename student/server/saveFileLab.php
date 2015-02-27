<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: /ate/index.php");
	}
	extract($_POST);
	$usn = $_SESSION["username"];
	$course = trim($course);
	$week = trim($week);
	$que = trim($que);
	$content = trim($content);
	$file = trim($file);
	require_once '../../sql_connect.php';

	$query = "SELECT * FROM program WHERE usn='" . $usn . "' and assign_id='week_" . $week . "_" . $que . "' and course_code='" . $course . "'";
	
	$result = mysql_query($query);
	
	$num = mysql_num_rows($result);
	if( $num == 0 )
	{
		echo "ERROR";
		return;
	}
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
	
	$fd = fopen("/var/www/html" . $row["file_path"] . $file, "w") or die("ERROR");
	if( strcasecmp($content, "") == 0 )
	{
		fwrite($fd, " ") or die("ERROR");
	}
	else
	{
		fwrite($fd, $content) or die("ERROR");
	}
	fclose($fd);
	echo "OK";
	
?>
