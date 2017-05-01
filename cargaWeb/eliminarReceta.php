<?php
require_once('functions/generics.php');
require_once('functions/validations.php');
require_once('functions/users.php');
require_once('html.php');
echo htmlHeader('Eliminar receta', 'Estas a punto de eliminar una receta');
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

?>
<?php
if($_POST && (isset($_POST['seguroEliminar']))){
  $sql = "DELETE FROM recetas WHERE idRecetas =  :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $idReceta, PDO::PARAM_INT);
  $stmt->execute();

  $sql = "DELETE FROM inger_paso WHERE idRecetas =  :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $idReceta, PDO::PARAM_INT);
  $stmt->execute();

  $sql = "DELETE FROM ratings WHERE idReceta =  :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $idReceta, PDO::PARAM_INT);
  $stmt->execute();

  header("Location: verRecetas.php");
}
 ?>

<form role="form" action="" method="post">
  <div class="row">
<?php echo '¿Estas seguro que queres eliminar' . $receta[0]['nombre'] . '?'; ?>
      <div class="checkbox">
        <label>
          <input type="checkbox" name="seguroEliminar" <?php echo($rememberme ? 'checked="checked"' : '');?>> Sí
        </label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-4 col-sm-offset-4">
      <input type="submit" name="btn_submit" class="btn btn-info" value="Eliminar" />
    </div>
  </div>
</form>
</div>
</div>
