<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: ../../index.php");
	}
	extract($_GET);
	$usn = $_SESSION["username"];
	$course = trim($course);
	$week = trim($week);
	$que = trim($que);
	$file = trim($file);
	$lang = trim($lang);
	require_once '../../sql_connect.php';

	$query = "SELECT * FROM program WHERE usn='" . $usn . "' and assign_id='week_" . $week . "_" . $que . "' and course_code='" . $course . "'";
	
	$result = mysql_query($query);
	
	$num = mysql_num_rows($result);
	if( $num == 0 )
	{
		echo "ERROROK";
		return;
	}
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
	$files = $row["files"];

	if( strcasecmp($lang, "C") == 0 )
	{
		$fd = fopen("../../" . $row["file_path"] . $file, "w") or die("ERROR");
		$files = $files . $file . ";";
		fclose($fd);
	}
	if( strcasecmp($lang, "cpp") == 0 )
	{
		$fd = fopen("../../" . $row["file_path"] . $file, "w") or die("ERROR");
		$files = $files . $file . ";";
		fclose($fd);
	}
	if( strcasecmp($lang, "Java") == 0 )
	{
		$fd = fopen("../../" . $row["file_path"] . $file, "w") or die("ERROR");
		$files = $files . $file . ";";
		fclose($fd);
	}
	if( strcasecmp($lang, "Python") == 0 )
	{
		$fd = fopen("../../" . $row["file_path"] . $file, "w") or die("ERROR");
		$files = $files . $file . ";";
		fclose($fd);
	}
	$query = $query = "UPDATE program SET files='" . $files . "' WHERE usn='" . $usn . "' and course_code='" . $course . "' and assign_id='week_" . $week . "_" . $que ."'";
	$result = mysql_query($query);
	echo "../../" . $row["file_path"] . $file;

?>
