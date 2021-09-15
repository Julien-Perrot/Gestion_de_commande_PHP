<?php

// var_dump($_GET['orderId']);

/*
*	1. Récupérer le numéros de la commande dans l'url
*	2. Récupérer les informations du client qui a passé la commande
*	3. Récupérer les détails de la commande
*	4. Récupérer le montant total de la commande (HT, TVA et TTC)
*	5. Créer une fonction getConnection() dans un fichier connection.php
*	6. Cette fonction renvoie la connexion à notre base de données (notre variable $db)
*	7. Importer ce fichier et utiliser la fonction dans le code
*/


// 7. Dans la page *detail.php* on récupérera le numéro de commande depuis l'url pour récupérer les différentes informations :
//   * Récupérer le nom du client qui a passé la commande, ainsi que son adresse complète (adresse, ville, code postal, pays)
//   * Récupérer la liste des articles commandés (article commandé, prix unitaire, quantité commandée, total pour cet article)
//   * Récupérer le total de la commande (dont le numéro se trouve dans l'url)


// 7. Importer ce fichier et utiliser la fonction dans le code
require 'connection.php';

$db = getConnection();


// $db = new PDO('mysql:host=localhost;dbname=exercice_PHP_MYSQL;charset=UTF8', 'root', 'root', [
// 		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// 		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
// ]);


// Création d'une requête SQL et : 
	//   * Récupérer le nom du client qui a passé la commande, ainsi que son adresse complète (adresse, ville, code postal, pays)
	// 2. Récupérer les informations du client qui a passé la commande

$query = $db->prepare("
	SELECT c.customerName, c.contactFirstName, c.contactLastName, c.addressLine1, c.city, c.postalCode, c.country
	FROM orders o
	INNER JOIN customers c ON c.customerNumber = o.customerNumber
	WHERE o.orderNumber = ?
");

$query->execute([
	$_GET['orderId']
]);

// Je ne récupère que la première ligne car je n'ai TOUJOURS qu'un seul client
$customer = $query->fetch();


//   * Récupérer la liste des articles commandés (article commandé, prix unitaire, quantité commandée, total pour cet article)
//	3. Récupérer les détails de la commande

$query = $db->prepare("
	SELECT od.quantityOrdered, od.priceEach, p.productName, (od.quantityOrdered * od.priceEach) AS total
	FROM orderdetails od
	INNER JOIN products p ON p.productCode = od.productCode
	WHERE od.orderNumber = ?
	ORDER BY od.orderLineNumber
");

$query->execute([
	$_GET['orderId']
]);

$orderdetails = $query->fetchAll();


//   * Récupérer le total de la commande (dont le numéro se trouve dans l'url)
//	 4. Récupérer le montant total de la commande (HT, TVA et TTC

$query = $db->prepare("
	SELECT SUM(quantityOrdered * priceEach) AS totalHT, SUM(quantityOrdered * priceEach) * 0.2 AS totalTVA, SUM(quantityOrdered * priceEach) * 1.2 AS totalTTC
	FROM orderdetails
	WHERE orderNumber = ?
");

$query->execute([
	$_GET['orderId']
]);

$total = $query->fetch();

// var_dump($total);

require 'detail.phtml';