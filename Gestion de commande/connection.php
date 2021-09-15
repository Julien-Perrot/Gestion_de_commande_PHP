<?php

// 5. Créer une fonction getConnection() dans un fichier connection.php 

function getConnection(): PDO
{
	// 6. Cette fonction renvoie la connexion à notre base de données (notre variable $db)
	return new PDO('mysql:host=localhost;dbname=exercice_PHP_MYSQL;charset=UTF8', 'root', 'root', [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
}

// AUTRE POSSIBILITER : 
	
	// *	5. Créer une fonction getConnection() dans un fichier connection.php
	// *	6. Cette fonction renvoie la connexion à notre base de données (notre variable $db)
	// *	7. Importer ce fichier et utiliser la fonction dans le code


/*
*	<?php
*	
*	function getConnection(): PDO
* {
	$host = 'localhost';
	$dbname = 'exercice_PHP_MYSQL';
	$user = 'root';
	$passeword = 'root';

	return new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $user, $passeword, [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
}
*
*/