<?php
$hostname ="mysql.hostinger.com.ar";
$database = "u565477680_wecoo";
$username = "u565477680_root";
$password = "wecookhost";
$localhost= mysqli_connect($hostname, $username, $password, $database);
//mysqli_select_db($database, $localhost);
$acumuladoringredientes= "";
foreach($_GET as $ingrediente){
	$acumuladoringredientes .= $ingrediente . ',';                  
}

$acumuladoringredientes=trim($acumuladoringredientes,',');

$query_search = "SELECT idRecetas FROM inger_paso WHERE idIngredientes IN (".$acumuladoringredientes . ")";


$query_exec = mysqli_query($localhost, $query_search);
$json = Array();
    $i=0;
	if(mysqli_num_rows($query_exec)){
		while($row=mysqli_fetch_assoc($query_exec)){
			$json[$i] = $row;
			$i++;
		}
	}
$acumuladorrecetas="";	

foreach($json as $receta){
$acumuladorrecetas .= $receta['idRecetas'] . ',';
}
$acumuladorrecetas=trim($acumuladorrecetas,',');

$query_search = "SELECT recetas.idRecetas, recetas.rutaMedia, recetas.nombre, recetas.duracion, ROUND( AVG( ratings.rating ), 2)  AS rating
FROM recetas
INNER JOIN ratings ON recetas.idRecetas = ratings.idReceta
WHERE recetas.idRecetas IN (".$acumuladorrecetas . ")
GROUP BY recetas.idRecetas";


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