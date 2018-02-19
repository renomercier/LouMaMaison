<?php
/**
* @file 		/controller/Router.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Router 
    * @details 	Verification du controleur où envoyer la requete 
    *
    *   1 methode  |   route()
    */
	class Routeur
	{
		/**
		* @brief      	methode route
		* @return     	<type>  		( route vers le bon controleur )
		*/
		public static function route()
		{
			// obtenir le controleur qui devra traiter la requête.
			$chaineRequete = $_SERVER["QUERY_STRING"];
			$posEperluette = strpos($chaineRequete, "&");

			if($posEperluette === FALSE)
				$controleur = $chaineRequete;
			else
				$controleur = substr($chaineRequete, 0, $posEperluette);

			// si aucun controleur n'a été spécifié, mettre un controleur par défaut
			if($controleur == "")
				$controleur = "Appartements";
			// chercher la classe avec le nom du controleur
			$classe = "Controleur_" . $controleur;

			if(class_exists($classe))
			{
				// déclaration du controleur
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