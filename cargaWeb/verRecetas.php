<?php
require_once('functions/generics.php');
require_once('html.php');
require_once('functions/users.php');
require_once('functions/recetas.php');


if(!isLoggedIn())
{
	header('location: login.php');
	exit;
}

?>
<?php echo htmlHeader('Recetas', 'Mira y administra todas tus recetas') ?>
<?php echo navBar('CookIt'); ?>

<?php
$db = connectDB();
if(!checkAdmin())
{
$stmt = $db->prepare("SELECT recetas.* FROM recetas WHERE idUsuario = :idre");
$stmt-> bindValue(':idre',$_SESSION['user']['Id'], PDO::	PARAM_STR);
$stmt->execute();
$recetas =$stmt->fetchAll(PDO::FETCH_ASSOC);
}
else
{
	$stmt = $db->prepare("SELECT * FROM recetas");
	$stmt->execute();
	$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<table class="table">
<th>Receta</th>
<th></th>
<th></th>
<?php
foreach($recetas as $receta) {
    ?><tr>

		<td>
			<?php echo $receta['nombre'];?>
		</td>

    <td>
      <a href="unaReceta.php?id=<?php echo $receta['idRecetas'] ?>" role="button" class="btn">Ver</a>
    </td>

		<td>
			<a href="eliminarReceta.php?id=<?php echo $receta['idRecetas'] ?>" role="button" class="btn">Eliminar</a>
		</td>
	</tr>
	<?php
}
?>
</table>

	<table>
		<tr>
			<td>

			</td>
		</tr>
	</table>
