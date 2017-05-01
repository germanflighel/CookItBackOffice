<?php
$hostname ="mysql.hostinger.com.ar";
$database = "u565477680_wecoo";
$username = "u565477680_root";
$password = "wecookhost";
$localhost= mysqli_connect($hostname, $username, $password, $database);
//mysqli_select_db($database, $localhost);

$query_search = "SELECT recetas.nombre, recetas.idRecetas, ROUND( AVG( ratings.rating ), 2)  AS rating
FROM recetas
INNER JOIN ratings ON recetas.idRecetas = ratings.idReceta
GROUP BY recetas.idRecetas
ORDER BY rating DESC
LIMIT 0,5";


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