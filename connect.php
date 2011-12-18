<?php
$db_host='localhost';
$db_user='root';
$db_pass='ourt';
$db_database='paganis';
$link = @mysql_connect($db_host,$db_user,$db_pass) or die('UNABLE TO ESTABLISH A DB CONNECTION');
mysql_set_charset('utf8');
mysql_select_db($db_database,$link);
?>