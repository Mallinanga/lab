<?php
session_name('tzLogin');
session_set_cookie_params(2*7*24*60*60);
session_start();
?>
<!DOCTYPE html>
<html>
<body>
<?php
if($_SESSION['id'])
  echo '<h1>Hello, '.$_SESSION['usr'].'! You are registered and logged in!</h1>';
else
  echo '<h1>Please, <a href="demo.php">login</a> and come back later!</h1>';
?>
</body>
</html>
