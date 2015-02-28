<?php
	session_start();
	require_once '../sql_connect.php';
	
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
	
	$usr = clean($_POST['user_id']);
	$pwd = clean($_POST['user_pwd']);
	$type= clean($_POST['user_type']);
	
	if( strcasecmp ( $type, "admin" ) == 0 )
	{
		$query="SELECT * FROM admin WHERE username='$usr' AND password='$pwd'";
		
	}
	elseif( strcasecmp ( $type, "faculty" ) == 0 )
	{
		$usr = strtoupper($usr);
		$query="SELECT * FROM faculty WHERE username='$usr' AND password='$pwd'";
	}
	elseif( strcasecmp ( $type, "student" ) == 0 )
	{
		$usr = strtoupper($usr);
		$query="SELECT * FROM student WHERE usn='$usr' AND password='$pwd'";
	}
	
	// Setting up a session variable.
	
	$result = mysql_query($query);
	if( mysql_num_rows($result) != 0 )
	{
		$_SESSION['username'] = $usr;
		$_SESSION['usertype'] = $type;
		echo 'valid';
	}
	else
	{
		echo "invalid ".$usr." ".$pwd." ".$type;	
	}

?>

