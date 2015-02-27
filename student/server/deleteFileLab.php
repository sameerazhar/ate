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
	$file = trim($file);
	$lang = trim($lang);
	require_once '../../sql_connect.php';

	function myremove($arr, $elem)
	{
		$temp = array();
		for( $i = 0; $i < sizeof($arr); $i++ )
		{
			if( $arr[$i] != $elem )
			{
				array_push($temp, $arr[$i]);
			}
		}
		return $temp;
	}

	$query = "SELECT * FROM program WHERE usn='" . $usn . "' and assign_id='week_" . $week . "_" . $que . "' and course_code='" . $course . "'";
	
	$result = mysql_query($query);
	
	$num = mysql_num_rows($result);
	if( $num == 0 )
	{
		echo "ERROR";
		return;
	}
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);

	unlink("/var/www/html" . $row["file_path"] . $file) or die("ERROR");
	$files = $row["files"];
	$list = explode(";", $files);
	$list = myremove($list, $file);
	$files = join(";", $list);
	$query = $query = "UPDATE program SET files='" . $files . "' WHERE usn='" . $usn . "' and course_code='" . $course . "' and assign_id='week_" . $week . "_" . $que ."'";
	$result = mysql_query($query);

	echo "/var/www/html" . $row["file_path"] . $file;
?>
