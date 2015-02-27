<?php
	session_start();
	if( !isset($_SESSION["username"]) )
	{
		header("Location: /ate/index.php");
	}

	extract($_POST);
	//echo $courses;

	require_once '../../sql_connect.php';

	$query = "DELETE FROM course_reg WHERE usn='" . $_SESSION["username"] . "'";
	$result = mysql_query($query);
	
	

	$courses = explode(",", $courses);
	for( $i = 0; $i < count($courses); $i++ )
	{
		$query = "INSERT INTO course_reg VALUES('" . $_SESSION["username"] . "','" . $courses[$i] . "')";
		$result = mysql_query($query);
		if( mysql_affected_rows() == 0 )
		{
			echo "ERROR";
			return;
		}
	}
	echo json_encode($courses);
	
?>
