<?php
require_once('generics.php');
require_once('validations.php');
require_once('users.php');
require_once('html.php');

$errores = array();

$email = '';
$password = '';

if($_POST)
{
	$email = $_POST['email'];
	$rememberme = isset($_POST['rememberme']);

	$errores = login();
	if(empty($errores))
	{
		header('location: index.php');
		exit;
	}
}
if($_GET){


		if(loginGET()){
		header('location: oklogin.php');
		exit;
		}
		else {
			header('location:errorlogin.php');
		}

}
?>
<?php echo htmlHeader('Login - Preguntados 6IC', 'Preguntados Login');?>
<?php echo navBar('Preguntados 6IC'); ?>
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
		<form role="form" action="" method="post">
			<div class="row">
				<div class="form-group col-sm-4 col-sm-offset-4">
					<label for="email">Email</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>" placeholder="Ingrese Email">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4 col-sm-offset-4">
					<label for="contrasena">Contraseña</label>
					<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese Contraseña">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4 col-sm-offset-4">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="rememberme" <?php echo($rememberme ? 'checked="checked"' : '');?>> Recordarme
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-4 col-sm-offset-4">
					<input type="submit" name="btn_submit" class="btn btn-info" value="Login" />
					<a href="registracion.php">Registrarme</a>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo htmlFooter();?>
