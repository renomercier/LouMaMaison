<?php
/**
* @file 		/controller/BaseControleur.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    BaseController - classe abstraite
    * @details  Gere les chargements de vues et modeles, traite les actions et paramêtres
    *
    *   4 methodes  |   traite(), afficheVue(), getDAO(), initialiseMessages()
    */
	abstract class BaseControleur
	{		
		/**
        * @brief       la méthode qui sera appelée par le routeur
        * @param       <array>       $params         Les parametres a traiter
        * @details     methode abstraite redefinie par chaque controleur qui herite de BaseControleur    
        */
		public abstract function traite(array $params);

		/**
        * @brief       la méthode qui charge la vue a afficher
        * @param       <string>      $nomVue        La vue a traiter          
        * @param       <array>       $data         	Le tableau de donnees a traiter          
        */
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

		/**
        * @brief       la méthode qui charge le modele requis
        * @param       <string>       $nomModele         Le nom du modele          
        */
		protected function getDAO($nomModele)
		{
			$classe = "Modele_" . $nomModele;

			if(class_exists($classe))
			{
				// on fait une connexion à la base de données
				$laDB = DBFactory::getDB(DBTYPE, DBNAME, HOST, USERNAME, PWD);

				// on crée une instance de la classe Modele_$classe
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
            else {
                trigger_error("Erreur de nom de modele");
                
            }
		}

        /**
        * @brief       la méthode qui initialise les messages a retourner à l'utilisateur
        * @return      <array>       $data       Tableau de messages à l'usager          
        */
        protected function initialiseMessages()
        {
            $data['message'] = (isset($_SESSION["username"])) ? "<p class='alert alert-success'>Bienvenue ".$_SESSION['prenom']. " " .$_SESSION['nom'] ."</p>" : "<p class='alert alert-warning'>Vous n'êtes pas connecté. Vos privilèges seront limités!</p>";
            //
            $data['banni'] = (isset($_SESSION["username"]) && $_SESSION["isBanned"]==1) ? "<p class='alert alert-danger'>Vous êtes banni ! prenez contact avec l'administrateur</p>" : "";
            //
            $data['log'] = (isset($_SESSION["username"])) ? "logout" : "login";
            
            return $data;
        }
        
		        /**
		* @brief 		Affichage d'un nombre d'appartements du PROPRIO selon une *					limite définie
		* @param 		$page numero de la page sur laquelle on se trouve
		* @return		charge la vue avec le tableau de donnees
		*/	
		public function afficheListeAppartementsProprio($page, $idProprio)
		{
			$modeleAppartement= $this->getDAO("Appartements");
			$apparts = $modeleAppartement->obtenirAptProprio($idProprio);  
            $data = $this->obtenir_liste_partielle($idProprio, $apparts, $page); 	
		}
		
		
		
        /**
		* @brief 		Affichage d'un nombre d'appartements selon une limite définie
		* @param 		$page numero de la page sur laquelle on se trouve
		* @return		charge la vue avec le tableau de donnees
		*/	
		public function afficheListeAppartements($page)
		{
			$modeleAppartement= $this->getDAO("Appartements");
			$apparts = $modeleAppartement->obtenir_tous();
            $data = $this->obtenir_liste_partielle($idProprio=null, $apparts, $page);
		}
        
        /**
		* @brief 		Affichage d'un nombre d'appartements selon une limite définie
		* @param 		$page numero de la page sur laquelle on se trouve
		* @return		charge la vue avec le tableau de donnees
		*/
        public function obtenir_liste_partielle($idProprio=null, $apparts, $page)
        {
            $appartParPage = 4;
            $nbrAppart = count($apparts);
            $data['nbrPage'] = ceil($nbrAppart/$appartParPage);
            
            if(isset($page))
            {
                if($page<=0){ $page = 1;}
                if($page>$data['nbrPage']){ $page = $data['nbrPage'];}
                
                 $data['pageActuelle']=intval($page);

                 if($data['pageActuelle'] > $data['nbrPage']) 
                 {
                      $data['pageActuelle'] = $data['nbrPage'];
                 }
            }
            else // Sinon
            {
                 $data['pageActuelle']=1; // La page actuelle est la n°1    
            }
            
            $premiereEntree=($data['pageActuelle']-1) * $appartParPage; // On calcul la première entrée à lire
            
            $modeleAppartement= $this->getDAO("Appartements");
            $data["appartements"] = $modeleAppartement->obtenir_avec_Limit($idProprio, $premiereEntree, $appartParPage);
            
            foreach($data["appartements"] as $appartement)
            { 
                $adresse=[];
                $evaluation = $modeleAppartement->nombre_notes($appartement->getId());
                if($evaluation[0][1] !=0)
                {
                    $moyenne = ($evaluation[0][0] / $evaluation[0][1]);
                    $appartement->moyenne = floatval(round($moyenne, 1));
                }
                else
                {
                    $appartement->moyenne = 0;
                }
                $appartement->adresse = $appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();

            }
            
			$this->afficheVue("listeAppartements", $data);
            $this->afficheVue("carteGeographique", $data);
            return $data;
        }
	}
?>