<!-- Liste des commandes

## Instructions

1. Créer un nouveau dossier pour l'exercice
2. Créer un fichier *index.php* et son template (*index.phtml*)
3. Se connecter à la base de données classicmodels à l'aide de PDO
4. Récupérer la liste des commandes (orderNumber, orderDate, status, customerName)
5. Afficher dans un tableau html la liste des commandes récupérée -->

<?php

// 7. Importer ce fichier et utiliser la fonction dans le code
require 'connection.php';

$db = getConnection();

// Connexion à une base de données
// 1er paramètre : DSN (Data Source Name)
// 2ème paramètre : nom d'utilisateur
// 3ème paramètre : mot de passe
// 4ème paramètre (facultatif) : les options


// 3. Se connecter à la base de données classicmodels à l'aide de PDO
//  $db = new PDO('mysql:host=localhost;dbname=exercice_PHP_MYSQL;charset=UTF8', 'root', 'root', [
//	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
// ]);


// 4. Récupérer la liste des commandes (orderNumber, orderDate, status, customerName)
$query = $db->prepare('
	SELECT o.orderNumber, o.orderDate, o.status, c.customerName
	FROM orders o
	INNER JOIN customers c ON c.customerNumber = o.customerNumber
	ORDER BY orderDate
');

// 5. Afficher dans un tableau html la liste des commandes récupérée
$query->execute();

$orders = $query->fetchAll();

require 'index.phtml';