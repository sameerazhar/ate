<?php
	session_start();
	require_once '../sql_connect.php';
	if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) )
	{
		header("Location: ../ate.php");
	}

	// Prevent SQL Injection.
	function clean($str) 
    {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) 
        {
			$str = stripslashes($str);
        }
		return mysql_real_escape_string($str);
	}
	$old_pwd = clean($_POST['old_pwd']);
	$new_pwd = clean($_POST['new_pwd']);
	$user_type=trim($_SESSION["usertype"]);
	$user_name=trim($_SESSION["username"]);

	$query="";
	if(strcmp($user_type, "admin")==0)
	{
		$query="SELECT * FROM admin WHERE username='$user_name' AND password='$old_pwd'";
	}
	elseif (strcmp($user_type, "faculty")==0) 
	{
		$query="SELECT  * FROM course WHERE course_code='$user_name' AND password='$old_pwd'";
	}
	elseif(strcmp($user_type, "student")==0)
	{
		$query="SELECT * FROM student WHERE usn='$user_name' AND password='$old_pwd'";
	}

	$result = mysql_query($query);
	if( mysql_num_rows($result) != 0 )
	{
		if(strcmp($user_type, "admin")==0)
		{
			$query="update admin set password='$new_pwd' WHERE username='$user_name' ";
		}
		elseif (strcmp($user_type, "faculty")==0) 
		{
			$query="update course set password='$new_pwd' WHERE course_code='$user_name' ";
		}
		elseif(strcmp($user_type, "student")==0)
		{
			$query="update student set password='$new_pwd' WHERE usn='$user_name' ";
		}
		$result = mysql_query($query);
		echo 'Password changed successfully.';
	}
	else
	{
		echo "Wrong old password.";	
	}

?>