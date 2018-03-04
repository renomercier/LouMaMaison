<?php
/**
* @file 		/controller/Controleur_Evaluation.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Controleur_Accueil - herite de la classe BaseController
    * @details 	
    *
    *   1 methode  |   traite()
    */
	class Controleur_Evaluations extends BaseControleur
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
           
			//si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					case "ajouterEvaluationApt" :
 
						// chargement du modele Appartement
                        $modeleApts = $this->getDAO("Appartements");
                        // Recuperer le detail de l'appartement               
                        $data['appartement'] = $modeleApts->obtenir_par_id($params['id']);
				//		$data['id_appartement'] = $params['id'];
					    $this->afficheVue("header", $message);
           		   		$this->afficheVue("ajoutEvaluation", $data);
						break;

					case "sauvegarderEvaluation" :

                        // on verifie si les champs requis sont remplis
/* @a verifer */           if(isset($params['id_appartement']) && !empty($params['id_appartement']) && isset($params['rating']) && !empty($params['id_appartement']) && $_SESSION['username']) {

                        	// validation des differents parametres
                        	if(filter_var($params['id_appartement'], FILTER_VALIDATE_INT) && filter_var($params['rating'], FILTER_VALIDATE_INT) && ($params['rating'] <= 10) && ($params['rating'] >= 0)) {

                        		// validation du champ commentaire s'il existe
	                        	if(isset($params['commentaire']) && !empty($params['commentaire'])) {
	                        		if(is_string($params['commentaire']) && filter_var($params['commentaire'], FILTER_SANITIZE_STRING)) {
	                        			$commentaire = $params['commentaire'];
	                        		}
	                        	}
	                        	// sinon on met sa valeur par defaut (null)
	                        	else if(trim($params['commentaire'] == "")) {
	                        		$commentaire = null;
	                        	}

				                // validation si l'usager a bien une location de cet appartement
	                        	$modeleLocations = $this->getDAO("Locations");
	                        	$permissionUsager = $modeleLocations->obtenir_par_idApt($_SESSION['username'], 'id_userClient');
	                        	// si oui
	                        	if($permissionUsager) {

	                        		$flag = false;
	                        		// on verifie si l'usager a bien loue cet appartement
	                        		foreach($permissionUsager AS $p) {
	                        			if($p->getIdAppartement() == $params['id_appartement']) {
                        				$flag = true;
                        				}
	                        		}
	                        		// si oui, il peut evaluer ce logament
	                        		if($flag) { 

			                        	// recuperation de la date et de l'heure de l'evaluation
				                        $dateEvaluation = new DateTime;
				                        // chargement du modele Evaluations et instanciation de l'evaluation
				                        $modeleEvaluation = $this->getDAO("Evaluations");
				                        $evaluation = new Evaluation($params['rating'], $commentaire, $dateEvaluation, $params['id_appartement'], $_SESSION['username']);
										// si l'instanciation est un succes
										if($evaluation) {
											$resultat = $modeleEvaluation->sauvegarderEvaluation($evaluation);
/* @temp */									$data['succes'] = 'Votre évaluation a été sauvegardée avec succès';
											echo $data['succes'];
										}
										// sinon message a l'usager
										else {
											$data['erreurs'] = 'Votre évaluation n\'a pu être sauvegardée';
/* @temp *///								affichage du message d'erreurs....?
											echo $data['erreurs'];
										}
									}
									// si l'usager n'a pas loue ce logement
									else {
										$data['erreurs'] = 'Vous n\'avez pas les permissions requises pour évaluer ce logement';
/* @temp *///							affichage du message d'erreurs....?
										echo $data['erreurs'];
									}
								}
								// si l'usager n'a pas loue ce logement
								else {
										$data['erreurs'] = 'Vous n\'avez pas les permissions requises pour évaluer ce logement';
/* @temp *///							affichage du message d'erreurs....?
										echo $data['erreurs'];
								}
                        	}
                        	// si  le champ d'evaluation n'a pas ete rempli
                        	else {
                        		$data['erreurs'] = 'Paramètres d\'évaluation invalides, veuillez vérifier vos informations';
/* @temp *///					affichage du message d'erreurs....?
								echo $data['erreurs'];
                        	}	
                        }
                        // si on n'a pas les champs requis
                        else {
                        	$data['erreurs'] = 'Veuillez vous assurer de remplir les champs requis pour votre évaluation';
/* @temp *///				affichage du message d'erreurs....?
							echo $data['erreurs'];
                        }
						break;

					default:
						trigger_error("Action invalide.");		
				} // fin du switch				
			} 
			// si pas de parametre action
            else{
            	  $this->afficheVue("header", $message);
                  $this->afficheVue("afficheUsager");
                  $this->afficheVue("footer");
            }

        } // fin de la methode traite()

	}

?>