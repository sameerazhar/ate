<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: ../../index.php");
	}
	require_once "../../sql_connect.php";

	extract($_POST);

	$query = "update quiz_student set attempted_answers='".$answers."', remaining_time=".$time." where quiz_id=$quiz_id and usn='".$_SESSION["username"]."'";
	mysql_query($query);

	echo $query;
?>