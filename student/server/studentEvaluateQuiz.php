<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "student" )
	{
		header("Location: ../../index.php");
	}
	
	require_once "../../sql_connect.php";
	extract($_POST);
	$att_answer=array();
	$correct_answer=array();
	$query = "update quiz_student set attempted_answers='".$answers."', remaining_time=".$time." where quiz_id= " . $quiz_id . " and usn='".$_SESSION["username"]."'";
	mysql_query($query);

	$query = "SELECT question_order FROM quiz WHERE quiz_id=". $quiz_id;
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
	$questions=explode(",",$row["question_order"]);
	$noOfQuestions=0;
	$marks=0;
	foreach ($questions as $question_id)
	{
   		$query = "SELECT correct_answer FROM quiz_qstn_repository WHERE qstn_id=$question_id ";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
		$correct_answer[$question_id]= $row["correct_answer"];
		$att_answer[$question_id]=array();
		$noOfQuestions++;
	}

	$attempted_answers=explode(",",$answers);
	
	foreach($attempted_answers as $value)
	{
		$values=explode("_",$value);
		if( count($values) == 2 )
		{
			$att_answer[$values[0]][]=$values[1];
		}
	}
	
	foreach($att_answer as $key => $value)
	{
		$att_answer[$key]=implode(",",$value);
	}

	foreach($att_answer as $key => $value)
	{
		if(strcmp($value, $correct_answer[$key])== 0 )
		{
			$marks++;
		}
	}

	$query = "update quiz_student set marks=$marks where usn='".$_SESSION["username"]."' and quiz_id=$quiz_id ";
	$result = mysql_query($query);
	$query = "update quiz_student set started=2 where usn='".$_SESSION["username"]."' and quiz_id=$quiz_id ";
	$result = mysql_query($query);
	
?>
