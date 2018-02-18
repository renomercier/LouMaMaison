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
					case "page_suivante":
                            $numPage = isset($params['page'])? $params['page'] : 1;
                            $this->afficheListeAppartements($numPage);
						break;

					default:
						trigger_error("Action invalide.");		
				}				
			}
            else{  
                $numPage = isset($params['page'])? $params['page'] : 1;
                $this->afficheListeAppartements($numPage);
                
            }
            
            // affichage du footer
            $this->afficheVue("footer");
        }
        
        /**
		* @brief 		Affichage d'un nombre d'appartements selon une limite définie
		* @param 		$page numero de la page sur laquelle on se trouve
		* @return		charge la vue avec le tableau de donnees
		*/	
		private function afficheListeAppartements($page)
		{
			$modeleAppartement= $this->getDAO("Appartements");
			$appart = $modeleAppartement->obtenir_tous();
            
            $appartParPage = 4;
            $nbrAppart = count($appart);
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
            
            $data["appartements"] = $modeleAppartement->obtenir_avec_Limit($premiereEntree, $appartParPage);
            
            foreach($data["appartements"] as $appartement)
            { 
                $evaluation = $modeleAppartement->nombre_notes($appartement->getId());
                if($evaluation[0][1] !=0)
                {
                    $moyenne = ($evaluation[0][0] / $evaluation[0][1]);
                    $appartement->moyenne = round($moyenne, 1);;
                }
                else
                {
                    $appartement->moyenne = "";
                }                
            }
            
			$this->afficheVue("Accueil", $data);
		}
	}
?>