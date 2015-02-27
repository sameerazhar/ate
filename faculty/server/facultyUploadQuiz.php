<?php
	require_once './Classes/PHPExcel.php';
	require_once './Classes/PHPExcel/IOFactory.php';

	session_start();
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
	{
		header("Location: /ate/index.php");
	}
	//  Read your Excel workbook
	try 
	{
    	$inputFileType = PHPExcel_IOFactory::identify($_FILES['quiz']['tmp_name']);
    	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
    	$objPHPExcel = $objReader->load($_FILES['quiz']['tmp_name']);
	} 
	catch(Exception $e) 
	{
    	die('Error loading file');
	}

	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	$question="";
	$correct_answer="";
	$summary="";

	require_once "../../sql_connect.php";

	extract($_POST);
	
	/*$qstn_sequence=array();
	for ($i=1; $i <= $highestRow; $i++) 
	{ 
		array_push($qstn_sequence, $i);
	}
	shuffle($qstn_sequence);*/
	//$query = "insert into quiz ( course_code, quiz_name, enable, time_period )values ('". $course_code . "','". $quiz_name . "', 0 , NULL )";
	//mysql_query($query);
	//	$query= "SELECT max(quiz_id) quiz_id from quiz";
	//	$result = mysql_query($query);
	//	$row = mysql_fetch_assoc($result,MYSQL_ASSOC);						
	//	$quiz_id=$row["quiz_id"];

		//  Loop through each row of the worksheet in turn
	for ($i = 1; $i <= $highestRow; $i++)
	{ 
		//$row = array_pop($qstn_sequence);
		$question=$sheet->getCellByColumnAndRow(0, $i)->getValue();
		$correct_answer=$sheet->getCellByColumnAndRow(1, $i)->getValue();
		$difficulty=$sheet->getCellByColumnAndRow(2, $i)->getValue();
		$summary=$sheet->getCellByColumnAndRow(3, $i)->getValue();
		$query = sprintf("insert into quiz_qstn_repository(course_code,qstn_summary,question,correct_answer,difficulty) values ('$course_code','%s', '%s','$correct_answer', $difficulty )", mysql_real_escape_string($summary), mysql_real_escape_string($question));

		
		$result = mysql_query($query);
		$query= "SELECT max(qstn_id) qstn_id from quiz_qstn_repository";
		$result = mysql_query($query);
		$row_result = mysql_fetch_assoc($result,MYSQL_ASSOC);						
		$question_id=$row_result["qstn_id"];
		for ($col = 4; $col <= $highestColumnIndex; $col++)
		{
			$option = $sheet->getCellByColumnAndRow($col, $i)->getValue();
 			if($option)
 			{
 				$cr_opt=$col-3;
 				$query = sprintf("insert into question_option(qstn_id,option_no,ques_option) values ( $question_id , $cr_opt,'%s' )", mysql_real_escape_string($option));
				$result = mysql_query($query);
 			}
 		}
 	}

	echo "Quiz uploaded successfully!!";

?>
