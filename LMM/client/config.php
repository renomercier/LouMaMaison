<?php
	function __autoload($nomClasse)
	{
		$repertoires = array(
				RACINE . "controleurs/", 
				RACINE . "modeles/",
				RACINE . "vues/"
			);

		foreach($repertoires as $rep)
		{
			$nomFichier = $rep . $nomClasse . ".php";
			if(file_exists($nomFichier))
			{
				require_once($nomFichier);
				return;
			}
		}
	}
	
	// déclaration de la racine du projet
	//define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/Projet2/LouMaMaison/LMM/client/");
	//define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/loumamaison-V2\LouMaMaison-1\LMM\client/");
	define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/client/");
	//define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/originLocal/LouMaMaison/LMM/client/");
	//define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/LouMaMaison_v_dim/LouMaMaison/LMM/client/");
	//define("RACINE", $_SERVER["DOCUMENT_ROOT"] . "/LouMaMaison/LouMaMaison/LMM/client/");

	//déclaration des infos de connexion
	define("HOST", "localhost");
    //define("HOST", "127.0.0.1");
	define("DBNAME", "loumamaison");
	define("USERNAME", "root");
	define("PWD", "root");
	//define("PWD", "");
	define("DBTYPE", "mysql");

?>