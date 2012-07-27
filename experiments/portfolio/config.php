<?
ob_start("gzip_handler");
ob_start();
$host = "localhost";
$db_username = "olivelai_dba";
$db_password = "fula-zuju-my-peh";
$database = "olivelai_paganis";
$prefix = '';
mysql_connect($host, $db_username, $db_password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error());
?>
