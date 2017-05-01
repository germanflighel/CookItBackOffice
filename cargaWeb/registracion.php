<?php
require_once('functions/generics.php');
require_once('functions/validations.php');
require_once('functions/users.php');
require_once('html.php');
echo htmlHeader('Carga tu receta!', 'Carga de recetas web cookit');
echo navBar('CookIt');

$errores = [];

$nombre = '';
$apellido = '';
$username = '';
$email = '';
$emailConfirm = '';
$genero = 1;
$dia = 1;
$mes = 1;
$anio = date('Y');
$descripcion = '';
$selectedCategorias = [];
$terminos = false;

if($_POST)
{
	$nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$emailConfirm = $_POST['email_confirm'];
	$genero = $_POST['genero'];
	$dia = $_POST['fnac_dia'];
	$mes = $_POST['fnac_mes'];
	$anio = $_POST['fnac_anio'];


	$terminos = isset($_POST['terminos']);

	$errores = validarRegistro();
	if(empty($errores))
	{
		try
		{
			registrarUsuario();

			header('location: login.php');
			exit;
		}
		catch(Exception $e)
		{
			$errores[] = $e->getMessage();
		}
	}
}


?>

<div class="container">
	<div class="row">
		<?php if(!empty($errores)) {?>
			<div class="alert alert-danger" role="alert">
				<ul>
					<?php foreach($errores as $error) { ?>
						<li><?php echo $error ?></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		<form role="form" action="" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="nombre">Nombre</label>
					<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre ?>" placeholder="Ingrese Nombre">
				</div>
				<div class="form-group col-sm-6">
					<label for="apellido">Apellido</label>
					<input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido ?>" placeholder="Ingrese Apellido">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="username">Nombre de Usuario</label>
					<input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" placeholder="Ingrese Nombre de Usuario">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="email">Email</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>" placeholder="Ingrese Email">
				</div>
				<div class="form-group col-sm-6">
					<label for="email-confirm">Confirmar Email</label>
					<input type="text" class="form-control" id="email-confirm" name="email_confirm" value="<?php echo $emailConfirm ?>" placeholder="Ingrese Confirmación Email">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-6">
					<label for="contrasena">Contraseña</label>
					<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese Contraseña">
				</div>
				<div class="form-group col-sm-6">
					<label for="contrasena-confirm">Confirmar Contraseña</label>
					<input type="password" class="form-control" id="contrasena-confirm" name="contrasena_confirm" placeholder="Ingrese Confirmación Contraseña">
				</div>
			</div>
			<div class="form-group">
				<label>Avatar</label>
				<div>
					<input type="file" name="avatar" />
				</div>
			</div>
			<div class="form-group">
				<label>Sexo</label>
				<div>
					<label class="radio-inline">
					  <input type="radio" name="genero" id="genero_masculino" value="0" <?php echo(($genero == 0) ? 'checked="checked"' : '');?>> Masculino
					</label>
					<label class="radio-inline">
					  <input type="radio" name="genero" id="genero_femenino" value="1" <?php echo(($genero == 1) ? 'checked="checked"' : '');?>> Femenino
					</label>
				</div>
			</div>
			<div class="form-group">
				<label> Fecha de Nacimiento</label>
				<div class="row">
					<div class="col-sm-4">
						<select class="form-control" name="fnac_dia">
						<?php
							for($i = 1; $i <= 31; $i++)
							{
								if($i == $dia)
								{
									echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
								}
								else
								{
									echo '<option value="' . $i . '">' . $i . '</option>';
								}
							}
						?>
						</select>
					</div>
					<div class="col-sm-4">
						<select class="form-control" name="fnac_mes">
						<?php
							for($i = 1; $i <= 12; $i++)
							{
								if($i == $mes)
								{
									echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
								}
								else
								{
									echo '<option value="' . $i . '">' . $i . '</option>';
								}
							}
						?>
						</select>
					</div>
					<div class="col-sm-4">
						<select class="form-control" name="fnac_anio">
						<?php
							for($i = date('Y'); $i > (date('Y') - 100); $i--)
							{
								if($i == $anio)
								{
									echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
								}
								else
								{
									echo '<option value="' . $i . '">' . $i . '</option>';
								}
							}
						?>
						</select>
					</div>
				</div>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" id="chk-terminos" name="terminos" <?php echo($terminos ? 'checked="checked"' : '');?>> Acepto los términos y condiciones
				</label>
			</div>
			<input type="submit" name="btn_submit" class="btn btn-info" value="Registrarme" />
		</form>
	</div>
</div>
<?php echo htmlFooter();?>
