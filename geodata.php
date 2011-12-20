<?php
require "connect.php";
require "functions.php";
if(is_bot()) die();
$result = mysql_query(" SELECT countryCode,country, COUNT(*) AS total FROM labs_who GROUP BY countryCode ORDER BY total DESC LIMIT 15");
while($row=mysql_fetch_assoc($result)){
  echo '
    <div class="geoRow">
      <div class="flag"><img src="images/countries/'.strtolower($row['countryCode']).'.gif" width="16" height="11" /></div>
      <div class="country" title="'.htmlspecialchars($row['country']).'">'.$row['country'].'</div>
      <div class="people">'.$row['total'].'</div>
    </div>
  ';
}
?>
