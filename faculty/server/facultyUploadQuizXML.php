<?php
	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: ../../index.php");
	}

    $xml = simplexml_load_file($_FILES['quiz']['tmp_name']) or die ('Error loading file');

    require_once "../../sql_connect.php";

	extract($_POST);

    foreach($xml->children() as $question)
    {
    	
    	$correct_answer = trim($question->correctAnswer);
    	$question_statement = trim($question->questionStatement);
    	$topic=trim($question->topic);
    	$difficulty=trim($question->difficulty);

    	$query = sprintf("insert into quiz_qstn_repository(course_code,qstn_summary,question,correct_answer,difficulty) values ('$course_code','%s', '%s','$correct_answer', $difficulty )", mysql_real_escape_string($topic), mysql_real_escape_string($question_statement));
		$result = mysql_query($query);

		$query = "SELECT max(qstn_id) qstn_id from quiz_qstn_repository";
		$result = mysql_query($query);
		$row_result = mysql_fetch_assoc($result,MYSQL_ASSOC);						
		$question_id = $row_result["qstn_id"];
	
		$option_no = 1;
		foreach ($question->option as $option) 
		{
			$query = sprintf("insert into question_option(qstn_id,option_no,ques_option) values ( $question_id , $option_no ,'%s' )", mysql_real_escape_string(trim($option)));
			$result = mysql_query($query);
			
			$option_no++;
		}
    }

	echo "Quiz uploaded successfully!!";
?>
