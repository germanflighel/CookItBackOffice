<?php
$hostname ="mysql.hostinger.com.ar";
$database = "u565477680_wecoo";
$username = "u565477680_root";
$password = "wecookhost";
$localhost= mysqli_connect($hostname, $username, $password, $database);
$query_search = "DELETE FROM recetas_favoritas WHERE idReceta=".$_GET['idReceta']." AND idUser=".$_GET['idUser'];
var_dump($query_search);
$query_exec = mysqli_query($localhost, $query_search);	
mysqli_close($localhost);
?>