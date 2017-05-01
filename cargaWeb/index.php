<?php
require_once('html.php');
require_once('functions/generics.php');
require_once('functions/validations.php');
require_once('functions/users.php');
$db = new PDO('mysql:host=mysql.hostinger.com.ar;dbname=u565477680_wecoo;charset=utf8mb4', 'u565477680_root', 'wecookhost');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
?>
<?php
if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

 ?>


<!-- FORMULARIO HTML -------------------------------------------------------------->
<?php echo htmlHeader('Carga tu receta!', 'Carga de recetas web cookit') ?>
<?php echo navBar('CookIt'); ?>
<body>
<div class="container">
<form action="" method="POST" enctype="multipart/form-data">
<div class="tituloReceta">
<label class="titulo"> Titulo receta: </label></br>
<input type ="text" name ="titulo" class="textbox"> </br>
<label class="titulo"> Duracion receta (hh:mm): </label></br>
<input type="time"  name="duracionreceta" class="timebox" > </br>
</div>
<div class="imagenReceta">
<label class="titulo"> Imagen: </label></br>
<input type="file" name="foto" value=""/> <br>
</div>
<div class="ingredientes">
<label class="titulo"> Ingredientes:</label> <br>
<div class="input_fields_wrap_2">
    <button class="add_field_button_2 btn btn-default btn-sm btn btn-warning" style="margin-bottom: 5px;">Agregar ingrediente</button>
    <div><input type="text" name="mying[]" class="textbox" placeholder="Cebolla" ><input type="text" name="cantidad[]" class="unicant" placeholder="5" style="width: 30px" ><input type="text" name="unidad[]" class="unicant" placeholder="Kg" style="width: 30px"> </div>
</div>
</div>
<div class="pasos">
<label class="titulo"> Pasos: </label> <br>
<div class="input_fields_wrap">
    <button class="add_field_button btn btn-warning">Agregar paso</button>
    <div class="pasowrap">Paso: </br><textarea rows="4" cols="50" name="mytext[]" class="textbox"/></textarea></br> Timer: <input type="time"  name="time[]" class="timebox"> <input name="mediapaso[]" type="file"/></div>
</div>
</div>
<input type="submit" value="Cargar" name="Aceptar" class="btn btn-primary btn-lg cargar"/>
</form>
</div>
</body>
<!-- FIN FORMULARIO HTML ---------------------------------------------------------------------------------------->

<!-- AGREGADOR DE PASOS ----------------------------------------------------------------------------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="pasowrap"><a href="#" class="remove_field" style="float: right; margin: 3px 3px 3px 3px"><img src="delete.png" width="15" height="15"></a>Paso: </br><textarea rows="4" cols="50" name="mytext[]" class="textbox"/></textarea></br> Timer: <input type="time"  name="time[]" class="timebox" > <input name="mediapaso[]" type="file"/></div>'); //add input box
        }

    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;

    })
});
</script>
<!-- FIN AGREGADOR DE PASOS ---------------------------------------------------------------------------------------->

<!-- AGREGADOR DE INGREDIENTES ------------------------------------------------------------------------------------->
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap_2"); //Fields wrapper
    var add_button      = $(".add_field_button_2"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="mying[]" class="textbox" placeholder="Cebolla"/><input type="text" name="cantidad[]" class="unicant" placeholder="5" style="width: 30px" ><input type="text" name="unidad[]" class="unicant" placeholder="Kg" style="width: 30px"><a href="#" class="remove_field_2"><img src="delete.png" width="15" height="15"></a></div>'); //add input box
        }

    });

    $(wrapper).on("click",".remove_field_2", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;

    })
});
</script>
<!-- FIN AGREGADOR DE INGREDIENTES ---------------------------------------------------------------------------------->


<?php
function checkIng($ingredient){

	$db = new PDO('mysql:host=mysql.hostinger.com.ar;dbname=u565477680_wecoo;charset=utf8mb4', 'u565477680_root', 'wecookhost');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$ingrediente =strtolower($ingredient);
	$stmt = $db->prepare("SELECT ingredientes.* FROM ingredientes WHERE Nombre = :ingredient");
	$stmt-> bindValue(':ingredient',$ingrediente, PDO::	PARAM_STR);
	$stmt->execute();

	$result =$stmt->fetchAll(PDO::FETCH_ASSOC);

	if(empty($result))
	{
		return false;
	}
	else{
		return true;
	}
}
function getIngredientId($ingrediente){

$db = new PDO('mysql:host=mysql.hostinger.com.ar;dbname=u565477680_wecoo;charset=utf8mb4', 'u565477680_root', 'wecookhost');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$stmt =$db->prepare("SELECT ingredientes.idIngredientes FROM ingredientes WHERE Nombre = :ingredient");
	$stmt->bindValue(':ingredient',$ingrediente, PDO::PARAM_STR);
	$stmt->execute();
	$result= $stmt->fetch(PDO::FETCH_ASSOC);
	return $result['idIngredientes'];
}



if($_POST)
{
// CARGA A BD DATOS RECETA
	$stmt = $db->prepare("INSERT INTO recetas(nombre, rutaMedia, duracion, idUsuario) VALUES(:nom, :media, :dur, :usu)");

  $uploads_dir_R = '/home/u565477680/public_html/images';
  $tmp_name_R = $_FILES["foto"]["tmp_name"];
  $namefile_R = basename($_FILES["foto"]["name"]);
  $ext_R = pathinfo($namefile_R, PATHINFO_EXTENSION);
  $name_R = sha1(time()) . sha1($namefile_R) . '.' . $ext_R;
  move_uploaded_file($tmp_name_R, "$uploads_dir_R/$name_R");

	$stmt->execute([':nom' => $_POST['titulo'], ':media' => $name_R, ':dur' => $_POST['duracionreceta'], ':usu'=>$_SESSION['user']['Id']]);
  $insertId = $db->lastInsertId();


// FIN CARGA DATOS RECETA

// CARGA A DB LOS PASOS
if(isset($_POST["mytext"])){

  $i = 0;
    foreach($_POST["mytext"] as $key => $text_field){

  		$stmt = $db->prepare("INSERT INTO pasos(Descripcion, posicionPaso, idRecetas) VALUES(:desc,:pos,:rec)");
  		$eachin = $stmt->execute([':desc' => $text_field, ':pos' => $key+1,':rec'=>$insertId]);
      echo "filas afectadas: " . $eachin . ' ';
      $insertIdpaso = $db->lastInsertId();
      $timerConcatenado = $_POST['time'][$i] . ':00';
      if($timerConcatenado != ":00"){
      $stmt = $db->prepare("UPDATE pasos SET timer = :timer WHERE idPasos=:idAModi");
      $stmt->execute([':timer' => $timerConcatenado, ':idAModi' => $insertIdpaso]);
    }

      if(isset($_FILES['mediapaso'])){
        $uploads_dir = '/home/u565477680/public_html/images';
        $tmp_name = $_FILES["mediapaso"]["tmp_name"][$i];
        $namefile = basename($_FILES["mediapaso"]["name"][$i]);
        $ext = pathinfo($namefile, PATHINFO_EXTENSION);
        $name = sha1(time()) . sha1($namefile) . '.' . $ext;
        move_uploaded_file($tmp_name, "$uploads_dir/$name");

      $stmt = $db->prepare("UPDATE pasos SET media = :media WHERE idPasos=:idAModi");
      $stmt->execute([':media' => $name, ':idAModi' => $insertIdpaso]);

      }
      $i++;

    }
}
// FIN CARGA PASOS

//CARGA A DB INGREDIENTES
if(isset($_POST["mying"])){
    $u=0;
    foreach($_POST["mying"] as $key => $text_field_ing){

		if(!checkIng(strtolower($text_field_ing))){
			$stmt = $db->prepare("INSERT INTO ingredientes(Nombre) VALUES(:nombre)");
			$stmt->execute([':nombre' => $text_field_ing]);
			$insertIding = $db->lastInsertId();
			$stmt = $db->prepare("INSERT INTO inger_paso(idRecetas,idIngredientes) VALUES(:rec,:ing)");
			$stmt->execute([':rec' => $insertId, ':ing' => $insertIding]);
		}
		else{
			$idob = getIngredientId($text_field_ing);
			$stmt = $db->prepare("INSERT INTO inger_paso(idRecetas,idIngredientes) VALUES(:rec,:ing)");
			$stmt->execute([':rec' => $insertId, ':ing' => $idob]);
      $insertIding = $idob;
		}
    if(($_POST['cantidad'][$u]) != ""){
    $stmt = $db->prepare("UPDATE inger_paso SET Cantidad = :cantidad WHERE idIngredientes=:idAModing");
    $stmt->execute([':cantidad' => $_POST['cantidad'][$u], ':idAModing' => $insertIding]);
    }
    if(($_POST['unidad'][$u]) != ""){
    $stmt = $db->prepare("UPDATE inger_paso SET Unidad = :unidad WHERE idIngredientes=:idAModing");
    $stmt->execute([':unidad' => $_POST['unidad'][$u], ':idAModing' => $insertIding]);
    }
    $u++;
    }
}
// FIN DE CARGA DE INGREDIENTES



//CARGA IMAGENES DE RECETA
/*
if(isset($_FILES['foto']))
{
$uploads_dir_R = '/home/u565477680/public_html/images';
$tmp_name_R = $_FILES["foto"]["tmp_name"];
$namefile_R = basename($_FILES["foto"]["name"]);
$ext_R = pathinfo($namefile_R, PATHINFO_EXTENSION);
$name_R = sha1(time()) . sha1($namefile_R) . '.' . $ext_R;
move_uploaded_file($tmp_name_R, "$uploads_dir/$name");

$stmt = $db->prepare("UPDATE recetas SET rutaMedia = :media WHERE idRecetas=:idAModi");
$insertIdre = $db->lastInsertId();
$stmt->execute([':media' => $name_R, ':idAModi' => $insertIdre]);
}
*/
}

echo htmlFooter();
?>



</html>
