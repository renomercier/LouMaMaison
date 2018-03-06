<?php
	// ouverture de la session
	session_start();

	// Inclusion des fichiers selon le répertoire et déclaration des paramètres de connexion
	require_once("config.php");

	// Déclaration du fuseau horaire et de la date d'aujourd'hui
    date_default_timezone_set("America/New_York"); 
    $now = date("Y-m-d H:i");

	// Redirection au bon controleur
	Routeur::route();
?>