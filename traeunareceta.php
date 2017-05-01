<?php
require_once('users/generics.php');
	

	
	$receta = traeReceta();
    $ingredientes = traeIngredientes();

	$newArray=array_merge($receta,$ingredientes);

	
	echo(json_encode($newArray));
	
	

function traeIngredientes(){
	$db = connectDB();

	$stmt = $db->prepare('SELECT ingredientes.*, inger_paso.Unidad, inger_paso.Cantidad 
FROM ingredientes 
INNER JOIN inger_paso ON inger_paso.idIngredientes = ingredientes.idIngredientes 
WHERE idRecetas = :id');
	$stmt->bindValue(':id', $_GET['idReceta'], PDO::PARAM_INT);
	$stmt->execute();

	$ingredientes= $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $ingredientes;
}	
function traeReceta(){
	

	$db = connectDB();

	$stmt = $db->prepare('SELECT * FROM recetas WHERE idRecetas = :id');
	$stmt->bindValue(':id', $_GET['idReceta'], PDO::PARAM_INT);
	$stmt->execute();

	$receta= $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $receta;
}						