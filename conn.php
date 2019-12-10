<?php
// $host = "localhost";
// $db_user = "root";
// $db_pass = "";
// $dbname = "db_doberman2";

$host = "35.240.223.49:3306";
$db_user = "dobermandb";
$db_pass = "wKue77tk0ovftrik";
$dbname = "db_doberman";

$connect = new PDO("mysql:host=$host; dbname=$dbname", $db_user, $db_pass);
?>
