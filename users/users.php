<?php
require_once('generics.php');
require_once('validations.php');

function registrarUsuario()
{
	$email = $_POST['email'];

	if(!getUserByEmail($email))
	{
		$fechaNacimiento[] = $_POST['fnac_anio'];
		$fechaNacimiento[] = $_POST['fnac_mes'];
		$fechaNacimiento[] = $_POST['fnac_dia'];

		$data = [
			'first_name' => $_POST['nombre'],
			'last_name' => $_POST['apellido'],
			'username' => $_POST['username'],
			'email' => $email,
			'password' => password_hash($_POST['contrasena'], PASSWORD_DEFAULT),
			'gender' => $_POST['genero'],
			'birth_date' => implode('-', $fechaNacimiento),

		];

		$db = connectDB();
		$db->beginTransaction();
		try
		{
		    $id = saveUser($data);

			$uploads_dir_R = '/home/u565477680/public_html/images';
			$tmp_name_R = $_FILES["avatar"]["tmp_name"];
			$namefile_R = basename($_FILES["foto"]["name"]);
			$ext_R = pathinfo($namefile_R, PATHINFO_EXTENSION);
			$name_R = sha1(time()) . sha1($namefile_R) . '.' . $ext_R;
			move_uploaded_file($tmp_name_R, "$uploads_dir/$name");

		    $db->commit();
		}
		catch(\Exception $e)
		{
		    $db->rollBack();

		    throw $e;
		}
	}
	else
	{
		throw new Exception('El email ingresado ya existe en nuestra base de datos');
	}

	return true;
}


function getUserByEmail($email)
{
	$db = connectDB();

	$stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
	$stmt->bindValue(':email', $email, PDO::PARAM_STR);
	$stmt->execute();

	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserById($id)
{
	$db = connectDB();

	$stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function saveUser(array $data)
{
	$db = connectDB();

	$stmt = $db->prepare("
		INSERT INTO users
			(first_name, last_name, username, email, password, gender)
		VALUES
			(:first_name, :last_name, :username, :email, :password, :gender,)
	");

	$stmt->bindValue(':first_name', $data['first_name'], PDO::PARAM_STR);
	$stmt->bindValue(':last_name', $data['last_name'], PDO::PARAM_STR);
	$stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
	$stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
	$stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
	$stmt->bindValue(':gender', $data['gender'], PDO::PARAM_BOOL);


	$stmt->execute();

	$userId = $db->lastInsertId();



	return $userId;
}




function login()
{
	$email = trim($_POST['email']);
	$password = trim($_POST['contrasena']);
	$rememberme = isset($_POST['rememberme']);

	$errores = validarLogin($email, $password);

	if(empty($errores))
	{
		$usuario = getUserByEmail($email);

		if($usuario)
		{
			if(password_verify($password, $usuario['password']))
			{
				fillUser($usuario);

				if($rememberme)
				{
					setcookie(REMEMBER_COOKIE_NAME, $usuario['id'], time() + (60*60*24*365*5)); //5 años
				}
				return true;
			}
			else
			{
				$errores[] = 'No hay usuarios con las credenciales ingresadas';
			}
		}
		else
		{
			$errores[] = 'No hay usuarios con las credenciales ingresadas';
		}
	}

	return $errores;
}

function loginGET()
{
	$email = trim($_GET['usuario']);
	$password = trim($_GET['password']);



	$errores = validarLogin($email, $password);

	if(empty($errores))
	{
		$usuario = getUserByEmail($email);

var_dump($usuario);
		if($usuario)
		{

			if(sha1($password)==$usuario['password'])
			{
				fillUser($usuario);
        return true;
			}
			else
			{
				$errores[] = 'No hay usuarios con las credenciales ingresadas';
				return false;
			}
		}
		else
		{
			$errores[] = 'No hay usuarios con las credenciales ingresadas';
			return false;
		}
	}
	return false;


}

function fillUser($usuario)
{



	$user = [
		'Id' => $usuario['id'],
		'Nombre' => $usuario['first_name'],
		'Apellido' => $usuario['last_name'],
		'Email' => $usuario['email'],
		'Username' => $usuario['username'],

	];

	$_SESSION['user'] = $user;
}

function isLoggedIn()
{
	return isset($_SESSION['user']);
}
