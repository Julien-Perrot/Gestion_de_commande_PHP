<?php

// var_dump($_GET['page']);

require 'connection.php';

// Récupération de la connexion à la base de données
$db = getConnection();

/* TODO
*
* 1. Déterminer le nombre de commandes par page et le numéros de la page actuelle
* 2. Récupérer les commandes de la page actuelle à l'aide de la clause LIMIT... OFFSET (ou LIMIT off, lim)
* 3. OFFSET est déterminé par la formule suivante : nombre de commandes par page * (page actuelle - 1)
* 4. Récupérer le nombre total de commandes avec COUNT puis déterminer le nombre total de pages
* 5. Dans le template pagination.phtml (copié/collé depuis index.phtml) afficher la liste des pages dans une balise nav
* 6. Chaque lien enverra vers pagination.php?page=i (i étant le numéro de la page dans la boucle)
*/


// 1. Déterminer le nombre de commandes par page et le numéros de la page actuelle

$ordersPerPage = 15;

if (isset($_GET['page'])) {
	// On récupère le numéro dans l'url (converti en nombre)
	$currentPage = (int) $_GET['page'];
} else {
	// Si le numéro de la page ne figure pas dans l'url
	// On lui donne la valeur 1 par défaut (page sur laquelle tu arrives la première fois sur le site)
	$currentPage = 1;
}


// 4. Récupérer le nombre total de commandes avec COUNT puis déterminer le nombre total de pages

$query = $db->prepare("SELECT COUNT(*) AS total FROM orders");
$query->execute();

$totalOrders = $query->fetch()['total'];
$totalPages = ceil($totalOrders / $ordersPerPage);


// Avant de faire la requête pour récupérer les commandes
// On vérifie que la page existe
// Si elle n'existe pas, on lui affiche le contenu de la page 404
if ($currentPage <= 0 || $currentPage > $totalPages) {
	// On indique le code HTTP 404 (au lieu du code 200 par défaut)
	header("HTTP/1.0 404 Not Found");
	require '404.php';
	exit();
}

// 3. OFFSET est déterminé par la formule suivante : nombre de commandes par page * (page actuelle - 1)

$offset = $ordersPerPage * ($currentPage - 1);


// 2. Récupérer les commandes de la page actuelle à l'aide de la clause LIMIT... OFFSET (ou LIMIT off, lim)

$query = $db->prepare("
	SELECT o.orderNumber, o.orderDate, o.status, c.customerName
	FROM orders o
	INNER JOIN customers c ON c.customerNumber = o.customerNumber
	ORDER BY orderDate
	LIMIT $ordersPerPage OFFSET $offset
");

$query->execute();

$orders = $query->fetchAll();


// Affichage de toutes les commandes récupérées depuis la base de données
require 'pagination.phtml';