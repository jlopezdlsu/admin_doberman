<?php
$db_username        = "root"; //MySql database username
$db_password        = ""; //MySql database password
$db_name            = "db_doberman2"; //MySql database name
$db_host            = "localhost"; //MySql hostname or IP
//
// $db_username        = "dobermandb";
// $db_password        = "wKue77tk0ovftrik";
// $db_name            = "db_doberman";
// $db_host            = "35.240.223.49:3306";
 $con = new mysqli($db_host,$db_username,$db_password,$db_name);

 if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}

 ?>
