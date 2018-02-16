<?php
/**
* @file 		/controller/Controleur_Appartement.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Controleur_Appartement - herite de la classe BaseController
    * @details 	
    *
    *   1 methode  |   traite()
    */
	class Controleur_Appartement extends BaseControleur
	{	
		/**
		* @brief      methode traite - methode abstraite redéfinie par les classes heritant de BaseControleur
		* @details    gere les actions (switch case) ainsi que les parametres envoyes
		* @param      <array>  	$params 	les parametres envoyes
		* @return     <...>  	( tout depend du case )
		*/	
		public function traite(array $params)
		{
            /*
                initialiser les messages à afficher à l'usager
                par rapport à son statut, son état de connexion
                et ses droits sur le site
            */
            $message= $this->initialiseMessages();
            //
			//si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					case "machin":
                        $this->afficheVue("header", $message);
						break;

					default:
						trigger_error("Action invalide.");		
				}				
			}
            else{
                $this->afficheVue("header", $message);
                $this->afficheVue("accueil");
            }
            
            // affichage du footer
            $this->afficheVue("footer");
        }
        
        /**
		* @brief 		Affichage de la liste de tous les appartement
		* @param 		Aucun parametre envoye
		* @return		charge la vue avec le tableau de donnees
		*/	
		private function afficheListeAppartements()
		{
            $message= $this->initialiseMessages();
            $this->afficheVue("header",$message);
			$modeleUsagers = $this->getDAO("Usagers");
			$data["usagers"] = $modeleUsagers->obtenir_tous();
			$this->afficheVue("AfficheListeUsagers", $data);
		}
	}
?>