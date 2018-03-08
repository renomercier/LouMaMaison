<?php
/**
* @file 		/controller/Controleur_Messages.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Controleur_Messages - herite de la classe BaseController
    * @details 	
    *
    */
	class Controleur_Messages extends BaseControleur
	{	
		/**
		* @brief      methode traite - methode abstraite redéfinie par les classes heritant de BaseControleur
		* @details    gere les actions (switch case) ainsi que les parametres envoyes
		* @param      <array>  		$params 	les parametres envoyes
		* @return     <...>  		( tout depend du case )
		*/	
		public function traite(array $params)
		{
            /*
                initialiser les messages à afficher à l'usager
                par rapport à son statut, son état de connexion
                et ses droits sur le site
            */
            $data= $this->initialiseMessages();

			// si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
         
                        // case affichage de la liste des messages reçus par un usager
					case "afficherListeMessages" :
						// chargement du modele et recuperation du data
						$modeleMessages = $this->getDAO("Messages");
						$data['messages'] = $modeleMessages->obtenir_messages_recus($_SESSION['username']);
                        $data['recus'] = true;
                        $this->afficheVue("listeMessages", $data);

                    break;
                        
                        // case affichage de la liste des messages envoyés par un usager
					case "afficheMessagesEnvoyes" :
						// chargement du modele et recuperation du data
						$modeleMessages = $this->getDAO("Messages");
						$data['messages'] = $modeleMessages->obtenir_messages_envoyes($params['idUsager']);
                        $data['recus'] = false;
                        $this->afficheVue("listeMessages", $data);

                    break;
                        
                        // case affichage des details d'un message
					case "detailsMessage" :
						// chargement du modele et recuperation du data
						$modeleMessages = $this->getDAO("Messages");
						$data['message'] = $modeleMessages->obtenir_par_id($params['idMessage']);
                        $modeleMessages->definir_messages_lu($params['idMessage'], $_SESSION['username']);
                        $this->afficheVue("detailsMessage", $data);

                    break;
                                            
                        
                        // case suppression d'un message
					case "supprimerMessage" :
						// chargement du modele et recuperation du data
						$modeleMessages = $this->getDAO("Messages");
						$resultat = $modeleMessages->suppression_logique($params['idMessage'], $_SESSION['username']);
                        $data['messages'] = $modeleMessages->obtenir_messages_recus($_SESSION['username']);
                        $data['recus'] = true;
                        $this->afficheVue("listeMessages", $data);

                    break;
                        
                        // case suppression d'un message
					case "archiverMessage" :
						// chargement du modele et recuperation du data
						$modeleMessages = $this->getDAO("Messages");
						$resultat = $modeleMessages->misAjourChampUnique('archive', 1, $params['idMessage']);
                        $data['messages'] = $modeleMessages->obtenir_messages_envoyes($_SESSION['username']);
                        $data['recus'] = false;
                        $this->afficheVue("listeMessages", $data);

                    break;
                        
                        // case ecrire un message
					case "ecrireMessage" :
						// chargement du modele
                        if(isset($_SESSION['username']) && isset($params['idDestination']) && !empty($params['idDestination']) && isset($params['objet']) && !empty($params['objet']) && isset($params['texte']) && !empty($params['texte']))
                        {
                            $modeleMessages = $this->getDAO("Messages");
                            $message = new Message;
                            $message->setId(0); 
                            $message->setTitre(stripslashes ($params['objet'])); 
                            $message->setSujet(stripslashes ($params['texte'])); 
                            $message->setDateHeure(0); 
                            $message->setId_userEmetteur($_SESSION['username']); 
                            $message->setArchive(0);
                            
                            $dernierID = $modeleMessages->creerMessage($message);
                            $modeleMessages->lier_message_destinatair($dernierID, $params['idDestination']);
                        }

                        // verifier l'existance de nouveaux messages
					case "notification" :
                        $nonLu= $this->nombreMessagesNonLus();
                        echo $nonLu;
                    break;
            
					// case par defaut
					default:
						trigger_error("Action invalide.");				
				} // fin du switch case 				
			}
			else
			{
                // redirection vers la page de appartements
                echo "<script>window.location='./index.php?Appartements'</script>"; 
			}
		}
        
        protected function nombreMessagesNonLus()
        {
            $modeleMessages = $this->getDAO("Messages");
            $resultat = $modeleMessages->obtenir_nombre_messages_nonLus($_SESSION['username']);
            $nbrNonLus = $resultat[0];
            return $nbrNonLus;
        }
	}
?>