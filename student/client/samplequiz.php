<?php
	session_start();
	$_SESSION["username"] = "1PI11CS181";
	$_SESSION["usertype"] = "student";
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<form action="/ate/student/client/studentAttemptQuiz.php" method = "POST">
			<input type="text" value = "11CS206" name = "course"/>
			<input type="text" value = "8" name = "quiz_id" />
			<input type="submit" />
		</form>
	</body>
</html>