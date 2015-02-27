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
	require_once "../../sql_connect.php";
	$query = "SELECT * FROM program WHERE usn='" . $usn . "' and course_code='" . $course . "' and assign_id='week_" . $week . "_" . $que ."'";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	if( $num == 0 )
	{
		echo "ERROR";
		return;
	}
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
	$data = array();
	$files = array();
	if( $row["status"] == 0 )
	{
		$query = "UPDATE program SET status='1' WHERE usn='" . $usn . "' and course_code='" . $course . "' and assign_id='week_" . $week . "_" . $que ."'";
		$result = mysql_query($query);
		echo "NF";
		return;
	}
	if( strcasecmp($lang, "C") == 0 )
	{
		$cfiles = glob( "/var/www/html" . $row["file_path"] . "*.c");
		$hfiles = glob( "/var/www/html" . $row["file_path"] . "*.h");
		foreach( $cfiles as $file )
		{
			$files[] = $file;
		}

		foreach ($hfiles as $file)
		{
			$files[] = $file;
		}
	}
	else if( strcasecmp($lang, "C++") == 0 )
	{
		$cfiles = glob( "/var/www/html" . $row["file_path"] . "*.cpp");
		$hfiles = glob( "/var/www/html" . $row["file_path"] . "*.h");
		$files = array();
		foreach( $cfiles as $file )
		{
			$files[] = $file;
		}

		foreach ($hfiles as $file)
		{
			$files[] = $file;
		}
	}
	else if( strcasecmp($lang, "Java") == 0 )
	{
		$jfiles = glob( "/var/www/html" . $row["file_path"] . "*.java");
		$files = array();
		foreach( $jfiles as $file )
		{
			$files[] = $file;
		}
	}
	else if( strcasecmp($lang, "Python") == 0 )
	{
		$pfiles = glob( "/var/www/html" . $row["file_path"] . "*.py");
		$files = array();
		foreach( $pfiles as $file )
		{
			$files[] = $file;
		}
	}

	

	foreach( $files as $file )
	{
		$data[$file] = file_get_contents($file);
	}

	$ret = array($files, $data);
	echo json_encode($ret);
?>
