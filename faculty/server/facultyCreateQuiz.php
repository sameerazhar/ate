<?php
	require_once "../../sql_connect.php";

	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: ../../index.php");
	}

	extract($_POST);
	if( $enabled == "true" )
	{
		$enable = 1;
	}
	else
	{
		$enable = 0;
	}

	$qstns=array([],[],[]);

	for($i=0;$i<3;$i++)
	{
		$query="select qstn_id from quiz_qstn_repository where course_code='$course_code' and qstn_summary REGEXP '$summary' and difficulty = ". ($i +1);
	//	echo $query;
		$result = mysql_query($query);

	//	echo $result;
		while($row = mysql_fetch_assoc($result,MYSQL_ASSOC))
		{
			$qstns[$i][]=$row['qstn_id'];
		}
	}

	if( sizeof($qstns[0]) < $easy || sizeof($qstns[1]) < $med || sizeof($qstns[2]) < $hard )
	{
		echo " Available Questions: Easy: ". sizeof($qstns[0]).", Medium: " .sizeof($qstns[1]). ", Difficult: " . sizeof($qstns[2]);
		echo "<br> Please make the changes according to that.";
	}

	else
	{
		shuffle($qstns[0]);
		shuffle($qstns[1]);
		shuffle($qstns[2]);

		$qstn=array();
		for( $i=0; $i< $easy;$i++)
		{
			$qstn[]=$qstns[0][$i];
		}
		for( $i=0; $i< $med;$i++)
		{
			$qstn[]=$qstns[1][$i];
		}
		for( $i=0; $i< $hard;$i++)
		{
			$qstn[]=$qstns[2][$i];
		}
		//echo json_encode($qstn);
	



		$qstn_order=implode(",",$qstn);
		$time_period = $time_period * 60;
		$query = "insert into quiz ( course_code, quiz_name, enable, time_period, question_order ) values ('$course_code','$quiz_name', '$enable' , $time_period, '$qstn_order' )";
		mysql_query($query);
		$query= "SELECT max(quiz_id) quiz_id from quiz";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result,MYSQL_ASSOC);						
		$quiz_id = $row["quiz_id"];

	
		$query="SELECT usn from course_reg where course_code='$course_code'";
		$result = mysql_query($query);
		while($row = mysql_fetch_assoc($result,MYSQL_ASSOC))
		{
			$query = "insert into quiz_student ( usn, quiz_id, started, remaining_time, attempted_answers, marks, question_order ) values ( '" . $row["usn"] . "', $quiz_id, 0 , $time_period, '', 0, '')";
			mysql_query($query);
		}
		echo "Quiz created successfully.";
	}



?>



	
	
