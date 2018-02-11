<?php
	class Routeur
	{
		public static function route()
		{
			//obtenir le controleur qui devra traiter la requête.
			$chaineRequete = $_SERVER["QUERY_STRING"];
			$posEperluette = strpos($chaineRequete, "&");

			if($posEperluette === FALSE)
				$controleur = $chaineRequete;
			else
				$controleur = substr($chaineRequete, 0, $posEperluette);

			//si aucun controleur n'a été spécifié, mettre un controleur par défaut
			if($controleur == "")
				$controleur = "Usagers";
			//chercher la classe avec le nom du controleur
			$classe = "Controleur_" . $controleur;

			if(class_exists($classe))
			{
				//déclaration du controleur
				$objetControleur = new $classe;
				if($objetControleur instanceof BaseControleur)
					$objetControleur->traite($_REQUEST);
				else
					trigger_error("Controleur invalide.");
			}
			else
			{
				trigger_error("Erreur 404! Le controleur $classe n'existe pas.");
			}
		}
	}
?>