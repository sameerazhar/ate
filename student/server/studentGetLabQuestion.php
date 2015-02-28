<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: ../../index.php");
	}
	extract($_GET);
	require_once "../../sql_connect.php";
	$query = "SELECT * FROM assignment WHERE course_code='" . $course . "'";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	if( $num == 0 )
	{
		echo "NA";
	}
	else
	{
		$que = array();
		$start_time = array();
		$end_time = array();
		$today = array();
		array_push($today, date('Y-m-d H:i:s'));
		$i = 0;
		for( $var = 0; $var < $num; $var++ )
		{
			$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
			$assign = explode("_", $row["assign_id"]);
			if( $week == $assign[1] )
			{
				$que[$i] = file_get_contents( "http://localhost" . $row['que_path']);
				$start_time[$i] = $row["start_time"];
				$end_time[$i] = $row["end_time"];
				$i++;
			}
		}
		$res = array( $que, $start_time, $end_time, $today);
		echo json_encode($res);
	}
?>