<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "my_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
  $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
}
catch(mysqli_sql_exception $e){
  die("Database connection failed.");
}