<?php
$hostname ="mysql.hostinger.com.ar";
$database = "u565477680_wecoo";
$username = "u565477680_root";
$password = "wecookhost";
$localhost= mysqli_connect($hostname, $username, $password, $database);
$query_search = "INSERT INTO recetas_favoritas (idReceta, idUser) VALUES  (".$_GET['idReceta'].",".$_GET['idUser'].")";
$query_exec = mysqli_query($localhost, $query_search);


	
mysqli_close($localhost);



?>