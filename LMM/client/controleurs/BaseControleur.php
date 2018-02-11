<?php
	abstract class BaseControleur
	{		
		//la méthode qui sera appelée par le routeur
		public abstract function traite(array $params);

		protected function afficheVue($nomVue, $data = null)
		{  
			$cheminVue = RACINE . "vues/" . $nomVue . ".php";

			if(file_exists($cheminVue))
			{
				include($cheminVue);
			}
			else
			{
				trigger_error("Erreur 404! La vue $cheminVue n'existe pas.");
			}
		}

		protected function getDAO($nomModele)
		{
			$classe = "Modele_" . $nomModele;

			if(class_exists($classe))
			{
				//on fait une connexion à la base de données
				$laDB = DBFactory::getDB(DBTYPE, DBNAME, HOST, USERNAME, PWD);

				//on crée une instance de la classe Modele_$classe
				
				$objetModele = new $classe($laDB);
				if($objetModele instanceof BaseDAO)
				{
					return $objetModele;
				}
				else
				{
					trigger_error("Le modèle n'est pas conforme.");
				}
			}
		}
        //
        // initialiser les messages a retourner à l'utilisateur
        protected function initialiseMessages()
        {
            $data['message'] = (isset($_SESSION["username"])) ? "<p class='alert alert-success'>Bienvenue ".$_SESSION['prenom']. " " .$_SESSION['nom'] ."</p>" : "<p class='alert alert-warning'>Vous n'êtes pas connecté. Vos privilèges seront limités!</p>";
            //
            $data['banni'] = (isset($_SESSION["username"]) && $_SESSION["isBanned"]==1) ? "<p class='alert alert-danger'>Vous êtes banni ! prenez contact avec l'administrateur</p>" : "";
            //
            $data['log'] = (isset($_SESSION["username"])) ? "logout" : "login";
            
            return $data;
        }

	}
?>