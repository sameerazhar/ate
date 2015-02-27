<?php

	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: /ate/index.php");
	}
	extract($_GET);
	require_once "../../sql_connect.php";

	$query= "SELECT question_order FROM quiz WHERE quiz_id='" . $quiz_id . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);
	$qstn_order = $row["question_order"];
	$qstns = explode(",",$qstn_order);

	$num = sizeof($qstns);
	for( $i = 0; $i < $num; $i++ )
	{
		$qstn = $qstns[$i];
		$query= "SELECT question, correct_answer FROM quiz_qstn_repository WHERE qstn_id='" . $qstn . "'";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result,MYSQL_ASSOC);						
		$question_string = $row["question"];
		$correct_answer=$row["correct_answer"];
		echo "<p>Question_". ($i+1) . " : " . $question_string. "</p>" ;
		$query= "SELECT option_no,ques_option from question_option where qstn_id= $qstn order by option_no";
		$result = mysql_query($query);
		while($row = mysql_fetch_assoc($result,MYSQL_ASSOC))
		{
			echo "&nbsp&nbsp&nbsp( ". $row["option_no"]. " )&nbsp ". $row["ques_option"] . "<br>";
		}
		echo "<br>&nbsp&nbspCorrect answers: ". $correct_answer, "<br><br>";
	}
?>