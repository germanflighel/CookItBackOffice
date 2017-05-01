<?php
session_start();

define('DB_USER', 'u565477680_root');
define('DB_PASSWORD', 'wecookhost');
define('DB_HOST', 'mysql.hostinger.com.ar');
define('DB_NAME', 'u565477680_wecoo');



function connectDB()
{
	return new PDO(
		'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
		DB_USER,
		DB_PASSWORD,
		[
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]
	);
}
