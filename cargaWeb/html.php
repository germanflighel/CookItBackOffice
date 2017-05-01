<?php

function htmlHeader($pageTitle = null, $pageDescription = null)
{
	return '
		<!DOCTYPE html>
		<html lang="en">
		  <head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>' . $pageTitle . '</title>
			<meta name="description" content="' . $pageDescription . '">

			<!-- Bootstrap -->
			<link href="assets/libs/bootstrap-3/css/bootstrap.min.css" rel="stylesheet">

			<!--[if lt IE 9]>
			  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
		  </head>
		  <body>
	';
}

function htmlFooter()
{
	return '

			<script src="assets/libs/jquery/jquery-1.11.1.min.js"></script>
			<script src="assets/libs/bootstrap-3/js/bootstrap.min.js"></script>
		  </body>
		</html>
	';
}

function navBar($title)
{
	$html = '
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-links">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php">' . $title . '</a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-links">
			  <ul class="nav navbar-nav">
				
				<li><a href="index.php">Cargar receta</a></li>
				<li><a href="verRecetas.php">Ver mis recetas</a></li>';

	$html .= '
		</ul>
		<ul class="nav navbar-nav navbar-right">';

		if(!isLoggedIn())
		{
			$html .= '<li><a href="login.php">Login</a></li>';
		}
		else
		{
			$html .= '<li>' . $_SESSION['user']['Nombre'] . '</li>';
			$html .= '<li><a href="logout.php">Logout</a></li>';
		}

		$html .= '
					</ul>
				</div>
				</div>
			</nav>
		';

	return $html;
}
