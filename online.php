<?php
require "connect.php";
require "functions.php";
if(is_bot()) die();
$stringIp = $_SERVER['REMOTE_ADDR'];
$intIp = ip2long($stringIp);
$inDB = mysql_query("SELECT 1 FROM labs_who WHERE ip=".$intIp);
if(!mysql_num_rows($inDB)){
  if($_COOKIE['geoData']){
    list($city,$countryName,$countryAbbrev) = explode('|',mysql_real_escape_string(strip_tags($_COOKIE['geoData'])));
  }else{
    $xml = file_get_contents('http://api.hostip.info/?ip='.$stringIp);
    $city = get_tag('gml:name',$xml);
    $city = $city[1];
    $countryName = get_tag('countryName',$xml);
    $countryName = $countryName[0];
    $countryAbbrev = get_tag('countryAbbrev',$xml);
    $countryAbbrev = $countryAbbrev[0];
    setcookie('geoData',$city.'|'.$countryName.'|'.$countryAbbrev, time()+60*60*24*30,'/');
  }
  $countryName = str_replace('(Unknown Country?)','UNKNOWN',$countryName);
  if (!$countryName){
    $countryName='UNKNOWN';
    $countryAbbrev='XX';
    $city='(Unknown City?)';
  }
  mysql_query("INSERT INTO labs_who (ip,city,country,countrycode) VALUES(".$intIp.",'".$city."','".$countryName."','".$countryAbbrev."')");
}else{
  mysql_query("UPDATE labs_who SET dt=NOW() WHERE ip=".$intIp);
}
mysql_query("DELETE FROM labs_who WHERE dt<SUBTIME(NOW(),'0 0:5:0')");
list($totalOnline) = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM labs_who"));
echo $totalOnline;
?>
