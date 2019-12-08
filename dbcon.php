<?php
$db_username        = "root"; //MySql database username
$db_password        = ""; //MySql database password
$db_name            = "db_doberman2"; //MySql database name
$db_host            = "localhost"; //MySql hostname or IP

 $con = new mysqli($db_host,$db_username,$db_password,$db_name);

 if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}

 ?>
