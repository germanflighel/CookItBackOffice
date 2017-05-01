<?php
require_once('functions/generics.php');
require_once('functions/validations.php');
require_once('functions/users.php');
require_once('html.php');
echo navBar('CookIt');

if(!isLoggedIn())
{
	header('location: login.php');
	exit;
}


$idReceta = $_GET['id'];
$db = connectDB();
$stmt = $db->prepare("SELECT recetas.* FROM recetas WHERE idRecetas = :idre");
$stmt-> bindValue(':idre',$idReceta, PDO::	PARAM_STR);
$stmt->execute();
$receta =$stmt->fetchAll(PDO::FETCH_ASSOC);
echo htmlHeader($receta[0]['nombre'], 'La informacion detallada sobre tu receta');

$stmt = $db->prepare("SELECT pasos.* FROM pasos WHERE idRecetas = :idre");
$stmt-> bindValue(':idre',$idReceta, PDO::	PARAM_STR);
$stmt->execute();
$pasos =$stmt->fetchAll(PDO::FETCH_ASSOC);

$recetaSeleccionada = $receta[0];?>
<a href="http://wecook.hol.es/cargaWeb/verRecetas.php" type="button" class="btn btn-default">Volver</a></br>
<img src = "http://wecook.hol.es/images/<?php echo $recetaSeleccionada['rutaMedia'];?>"  style="  max-width:400px; max-height:150px; width: auto; height: auto;"/>
<?php
echo '<h3>' . $recetaSeleccionada['nombre'] . '</h3>';
echo 'Duracion: ' . $recetaSeleccionada['duracion'];
?>

</br>
<?php

$pasos = array_reverse($pasos);
foreach ($pasos as $paso) {
  echo '<div id=muestrapaso>';
  ?>
  <?php
  if($paso['media'] != 'nohay')
  {
    ?>
    <img src = "http://wecook.hol.es/images/<?php echo $paso['media'];?>"  style="  max-width:400px; max-height:150px; width: auto; height: auto;"/>
<?php  }

  echo $paso['Descripcion'] . '</br>';
  echo '</div>';
}

echo htmlFooter();
