<?php
	require_once "../../sql_connect.php";

	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: /ate/index.php");
	}

	extract($_POST);
	

	$query = "SELECT * FROM quiz_qstn_repository WHERE course_code='$course' AND qstn_summary LIKE '%$qstn_summary%'";
	
	$result = mysql_query($query) or die("ERROR");
	$result_arr = array();
	$num = mysql_num_rows($result);

	while( $row = mysql_fetch_array($result,MYSQL_ASSOC) )
	{
		$values = explode("/", $row["qstn_summary"]);
		$len = count($values);
		for( $var = 0; $var < $len; $var++ )
		{
			if( in_array( $values[$var], $result_arr) == false )
			{
				if( strpos($qstn_summary, $values[$var]) == false )
				{
					$result_arr[] = $values[$var];
				}
			}
		}
	}
	echo json_encode($result_arr);
?>