<?php

	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: ../../index.php");
	}
	extract($_GET);
	require_once "../../sql_connect.php";

	if( isset($disable) && $disable == "yes" )
	{
		$query = "SELECT * FROM quiz WHERE quiz_id='" . $quiz_id . "'";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if( $num == 0 )
		{
			echo "ERROR";
			return;
		}

		$row = mysql_fetch_assoc($result, MYSQL_ASSOC);
		$query = "";
		if( $row["enable"] == 1 )
		{
			$query = "UPDATE quiz SET enable=0 WHERE quiz_id='" . $quiz_id . "'";
		}
		else
		{
			$query = "UPDATE quiz SET enable=1 WHERE quiz_id='" . $quiz_id . "'";
		}
		$result = mysql_query($query);
		return;
	}

	if( isset($delete) && $delete == "yes" )
	{
		$query = "DELETE FROM quiz_student WHERE quiz_id='" . $quiz_id . "'";
		$result = mysql_query($query);
		$query = "DELETE FROM quiz WHERE quiz_id='" . $quiz_id . "'";
		$result = mysql_query($query);
	}

?>