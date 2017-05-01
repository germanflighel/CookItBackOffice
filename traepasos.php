<?php
header('content-type: application/json; charset=utf-8');
$hostname ="mysql.hostinger.com.ar";
$database = "u565477680_wecoo";
$username = "u565477680_root";
$password = "wecookhost";


$localhost= mysqli_connect($hostname, $username, $password, $database);
$query_search = "SELECT Descripcion, timer, media FROM pasos WHERE idRecetas = " . $_GET["id"];

$query_exec = mysqli_query($localhost, $query_search);


$json = Array();

    $i=0;
	if(mysqli_num_rows($query_exec)){
		while($row=mysqli_fetch_assoc($query_exec)){
			$json[$i] = $row;
			$i++;
		}
	}

mysqli_close($localhost);

echo json_encode($json);

?>