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
	class Controleur_Appartements extends BaseControleur
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
            $data= $this->initialiseMessages();
            $this->afficheVue("header",$data);
            //
			//si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					case "filtrer":
                        $this->afficheVue("RechercheAppartements", $data);
						break;

					default:
						trigger_error("Action invalide.");		
				}				
			}
            else{ 
                $numPage = isset($params['page'])? $params['page'] : 1;
               
                $this->afficheVue("RechercheAppartements", $data);
                $this->afficheListeAppartements($numPage);            
            }
            
            $this->afficheVue("footer");
        }
        
	}
?>