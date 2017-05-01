<?php

function validarRegistro()
{
	$errores = array();

	if(trim($_POST['nombre']) == '')
	{
		$errores[] = 'Debe ingresar un nombre';
	}

	if(trim($_POST['apellido']) == '')
	{
		$errores[] = 'Debe ingresar un apellido';
	}

	if(trim($_POST['username']) == '')
	{
		$errores[] = 'Debe ingresar un nombre de usuarios';
	}

	$email = trim($_POST['email']);
	if($email == '')
	{
		$errores[] = 'Debe ingresar un email';
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$errores[] = 'Debe ingresar un email v&aacute;lido';
	}
	elseif($email != trim($_POST['email_confirm']))
	{
		$errores[] = 'El email y su confirmaci&oacute;n deben coincidir';
	}

	if(trim($_POST['contrasena']) == '')
	{
		$errores[] = 'Debe ingresar una contrase&ntilde;a';
	}
	elseif(strlen($_POST['contrasena']) < 6)
	{
		$errores[] = 'La contrase&ntilde;a debe tener al menos 6 caracteres';
	}
	elseif($_POST['contrasena'] != trim($_POST['contrasena_confirm']))
	{
		$errores[] = 'La contraseña y su confirmaci&oacute;n deben coincidir';
	}

	if(!$_FILES || !file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name']))
	{
        $errores[] = 'Debe elegir un avatar';
    }

	if(!isset($_POST['genero']))
	{
		$errores[] = 'Debe seleccionar una opci&oacute;n de sexo';
	}

	if(!checkdate($_POST['fnac_mes'], $_POST['fnac_dia'], $_POST['fnac_anio']))
	{
		$errores[] = 'La fecha de nacimiento debe ser uan fecha v&aacute;lida';
	}	

	if(!isset($_POST['terminos']))
	{
		$errores[] = 'Debe aceptar los t&eacute;rminos y condiciones';
	}

	return $errores;
}

function validarLogin($email, $password)
{
	$errores = array();

	if($email == '')
	{
		$errores[] = 'Debe ingresar un email';
	}
	elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$errores[] = 'Debe ingresar un email v&aacute;lido';
	}

	if($password == '')
	{
		$errores[] = 'Debe ingresar una contrase&ntilde;a';
	}

	return $errores;
}



function validarPregunta(){
	$errores = array();

	if(trim($_POST['pregunta']) == '')
	{
		$errores[] = 'Debe ingresar una pregunta';
	}

	if(trim($_POST['respuesta1']) == '')
	{
		$errores[] = 'Debe ingresar la respuesta';
	}

	if(trim($_POST['respuesta2']) == '')
	{
		$errores[] = 'Debe ingresar la respuesta';
	}
	if(trim($_POST['respuesta4']) == '')
	{
		$errores[] = 'Debe ingresar la respuesta';
	}


	$email = trim($_POST['respuesta3']);
	if($email == '')
	{
		$errores[] = 'Debe ingresar la respuesta';
	}
	
	if(!isset($_POST['respuestacorrecta']))
	{
		$errores[] = 'Debe seleccionar una respuesta correcta';
	}
	
	return $errores;
}
