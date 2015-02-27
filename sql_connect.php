<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "mysql";
$mysql_database = "ate";
$db = mysql_connect ($mysql_hostname, $mysql_user, $mysql_password) or die ("Could not connect to database");
mysql_set_charset('utf8', $db);
mysql_select_db ($mysql_database, $db) or die ("Could not select the database");
?>
