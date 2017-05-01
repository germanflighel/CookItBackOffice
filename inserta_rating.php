<?php
$hostname ="mysql.hostinger.com.ar";
$database = "u565477680_wecoo";
$username = "u565477680_root";
$password = "wecookhost";
$localhost= mysqli_connect($hostname, $username, $password, $database);
//mysqli_select_db($database_localhost, $localhost);
var_dump($_GET);
$query_search = "INSERT INTO ratings (rating, idReceta) VALUES  (".$_GET['rating'].",".$_GET['idreceta'].")";
$query_exec = mysqli_query($localhost, $query_search);


	
mysqli_close($localhost);



?>