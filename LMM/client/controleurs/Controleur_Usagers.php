<?php
/**
* @file 		/controller/Controleur_Usagers.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Controleur_Usagers - herite de la classe BaseController
    * @details 	
    *
    *   ... methodes  |   traite(), afficheListeUsagers()
    */
	class Controleur_Usagers extends BaseControleur
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
            //
			//si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					case "login":
                        $this->afficheVue("header", $message);
						$this->afficheVue("AfficheLogin");
						break;
						
					case "logout":
						session_destroy();
						header('location:index.php');
						break;
						
					case "authentifier":
						if(isset($params["username"]) && isset($params["password"]))
						{
							//si la session n'existe pas, on authentifier l'usager
							if (!isset($_SESSION["username"]))
							{
								$modeleUsagers = $this->getDAO("Usagers");
								$data = $modeleUsagers->authentification($params["username"], $params["password"]);
								//si l'usager est authentifié
								if($data)
								{
                                    $data = $modeleUsagers->obtenir_par_id($params["username"]);
									//on crée la session
									$_SESSION["username"] = $data->getUsername();
									$_SESSION["nom"] = $data->getNom();
									$_SESSION["prenom"] = $data->getPrenom();
									$_SESSION["isBanned"] = $data->getBanni();
                                    $_SESSION["isActiv"] = $data->getValideParAdmin();

                                    foreach($data->roles as $role)
                                    {
									   $_SESSION["role"][] = $role->id_nomRole;
                                    }
									//on affiche la liste des sujets en respectant les droits d'usager
                                    $this->afficheListeUsagers();
								}
								else
								{
									//si l'usager n'est pas authentifié
									$data="<p class='alert alert-warning'>Username ou password invalide!</p>";
                                    $this->afficheVue("header", $message);
									$this->afficheVue("AfficheLogin", $data);
								}
							}
							else
							{
								//si la session existe déjà
								$data="<p class='alert alert-warning'>Session déjà ouverte!</p>";
                                $this->afficheVue("header", $message);
								$this->afficheVue("AfficheLogin", $data);
							}
						}
						break;

					case "afficheListeUsagers":
						if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"]) || in_array(2,$_SESSION["role"])) && $_SESSION["isBanned"] ==0)
						{
							//affiche tous les usagers
							$this->afficheListeUsagers();
						}
						else
						{
							//affiche page d'erreur
							$this->afficheVue("404");
						}
						break;

					case "affiche":
						if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"]) || in_array(2,$_SESSION["role"])) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0)
						{
							if(isset($params["idUsager"]))
							{
								//affiche details du profil d'usager
								$modeleUsagers = $this->getDAO("Usagers");
								$data = $modeleUsagers->obtenir_par_id($params["idUsager"]);
                                $this->afficheVue("header", $message);
								$this->afficheVue("AfficheUsager", $data);
							}
							else
							{
								trigger_error("Pas d'id spécifié...");
							}
						}
						else
						{
							//affiche page d'erreur
							$this->afficheVue("404");
						}
						break;
					
                        // bannir | réahabiliter un usager
					case "inversBan":
						if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"]) || in_array(2,$_SESSION["role"])) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0)
						{
							if(isset($params["idUsager"]))
							{
								//bannir ou réhabiliter l'usager
								$modeleUsagers = $this->getDAO("Usagers");
                                
                                // changement de l'état de banissement
								$modeleUsagers->misAjourChampUnique('banni', 'NOT banni' , $params["idUsager"]);
                                
                                // insertion du nom de l'administrateur qui à exécuté l'action
                                $modeleUsagers->misAjourChampUnique('id_adminBan', "'".$_SESSION["username"]."'", $params["idUsager"]);
                                $this->afficheListeUsagers();
							}
							else
							{
								trigger_error("Pas d'id spécifié...");
							}
						}
						else
						{
							$this->afficheVue("404");
						}
						break;
					
                        // activer | désactiver un usager
                    case "inversActiv":
						if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"]) || in_array(2,$_SESSION["role"])) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0)
						{
							if(isset($params["idUsager"]))
							{
								//activer ou désactiver un usager
								$modeleUsagers = $this->getDAO("Usagers");
                                
                                // changement de l'état de validation
								$modeleUsagers->misAjourChampUnique('valideParAdmin', 'NOT valideParAdmin' , $params["idUsager"]);
                                
                                // insertion du nom de l'administrateur qui à exécuté l'action
                                $modeleUsagers->misAjourChampUnique('id_adminValid', "'".$_SESSION["username"]."'", $params["idUsager"]);
								$this->afficheListeUsagers();
							}
							else
							{
								trigger_error("Pas d'id spécifié...");
							}
						}
						else
						{
							$this->afficheVue("404");
						}
						break;
                    
                        // Promouvoire | Déchoir un usager
                    case "inversAdmin":
						if(isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]))
						{
							if(isset($params["idUsager"]))
							{
								// Promouvoire | Déchoir un usager
								$modeleUsagers = $this->getDAO("Usagers");
                                
                                // changement de l'état de role Admin dans la table role_usager
								$modeleUsagers->definir_admin($params["idUsager"]);
                                $this->afficheListeUsagers();
							}
							else
							{
								trigger_error("Pas d'id spécifié...");
							}
						}
						else
						{
							$this->afficheVue("404");
						}
						break;

					// case d'affichage du formulaire d'inscription d'un usager (a partir du menu)
					case "afficherInscriptionUsager" :

						$modeleUsagers = $this->getDAO("Usagers");
						$data['paiement'] = $modeleUsagers->getModePaiement();
						$data['communication'] = $modeleUsagers->getModeCommunication();
						if($data) {
                            $this->afficheVue("header", $message);
							$this->afficheVue("afficheInscriptionUsager", $data);
						}
						break;

					// case de sauvegarde d'un usager
					case "sauvegarderUsager" :

/* ajouter !empty */	
                        if((isset($params['client']) || isset($params['prestataire'])) && isset($params['username']) && isset($params['nom']) && isset($params['prenom']) && isset($params['adresse']) && isset($params['telephone']) && isset($params['pwd0']) && isset($params['pwd1']) && isset($params['modePaiement']) && isset($params['moyenComm'])) {
							
							if(isset($params['photo'])) {
							// ajout d'insertion d'une photo (src) à faire... + upload de l'image
							} else {
								$photo = "profil.jpg";
							}

							// validation des champs input du formulaire d'inscription d'un usager
							$params['erreurs'] = $this->validerUsager([ 'Le nom d\'utilisateur'=>$params['username'], 'Le nom'=>$params["nom"], 'Le prénom'=>$params["prenom"], 'L\'adresse'=>$params['adresse'], 'Le téléphone'=>$params['telephone'], 'Le mot de passe'=>$params['pwd0'], 'La validation du mot de passe'=>$params['pwd1'], 'Le mode de paiement'=>$params['modePaiement'], 'Le moyen de communication'=>$params['moyenComm'] ]);
							// si pas d'erreurs, on instancie l'usager et on l'insère dans la BD
							if(!$params['erreurs']) {
								// on instancie un nouvel Usager
								$usager = new Usager($params['username'], $params["nom"], $params["prenom"], $photo, $params['adresse'], $params['telephone'], $params['pwd0'], $params['moyenComm'], $params['modePaiement']);
								// appel du modele_Usagers et insertion dans la BD
								$modeleUsagers = $this->getDAO("Usagers");
								$resultat = $modeleUsagers->sauvegarder($usager);
								// si la sauvegarde a fonctionné, message à l'usager 
								if($resultat) {
									// message à l'usager - success de l'insertion dans la BD
									$data['succes'] = "<p class='alert alert-success'>Votre inscription a été effectuée avec succès. Nous communiquerons avec vous par messagerie LMM dès que vos informations auront été vérifiées</p>";
/* affichage vue profil */			$this->afficheVue("afficheInscriptionUsager", $data);
									
								}
								else {
									// message à l'usager - s'il la requete echoue
									$params['erreurs'] = "<p class='alert alert-warning'>Votre compte n'a pu être créé, veuillez contacter l'administration ou recommencer</p>";
									$this->afficheFormInscription($params);
								}
							}
							// si on a des erreurs
							else {
								// message à l'usager - erreurs dans la validation des inputs du formulaire d'inscription
								$this->afficheFormInscription($params);
							}
						}
						else {
							// message à l'usager - s'il manque des params requis
							$params['erreurs'] = "<p class='alert alert-warning'>Veuillez vous assurer de remplir tous les champs requis</p>";
							$this->afficheFormInscription($params);						
						}
						break;

					default:
						trigger_error("Action invalide.");		
				}				
			}
			else
			{
                // redirection temporaire
               $this->afficheListeUsagers(); 
 /*               
                
               //action par défaut - afficher la liste des sujets/usagers
				if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"]) || in_array(2,$_SESSION["role"])) && $_SESSION["isBanned"] ==0)
				{
					$this->afficheListeUsagers();
				}
				else
				{
					//afficher la page d'erreur
					$this->afficheVue("404");
				}
*/
			}
            
////////////// l'affichage du footer et du header pourraient se faire ds baseControleur, ce qui eviterait de les appeler a chaque controleur, mais ca @bug avec des variables du login
            $this->afficheVue("footer");
		}

		/**
		* @brief 		Affichage de la liste de tous les usagers
		* @param 		Aucun parametre envoye
		* @return		charge la vue avec le tableau de donnees
		*/	
		private function afficheListeUsagers()
		{
            $message= $this->initialiseMessages();
            $this->afficheVue("header",$message);
			$modeleUsagers = $this->getDAO("Usagers");
			$data["usagers"] = $modeleUsagers->obtenir_tous();
			$this->afficheVue("AfficheListeUsagers", $data);
		}

		/**
		* @brief 		Affichage du formulaire d'inscription d'un usager
		* @details 		Recupere des donnees en parametre pour affichage des choix de l'usager et des erreurs à afficher
		*				Ajoute ensuite le data paiment et communication pour populer les selects
		* @param 		<array>		$data 		tableau Usager et erreurs
		* @return		charge la vue avec le tableau de donnees
		*/	
		private function afficheFormInscription($data)
		{
			// formatage du message d'erreurs à afficher
			$data['erreurs'] = "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
			// recuperation des donnees pour populer les select
			$modeleUsagers = $this->getDAO("Usagers");
			$data['paiement'] = $modeleUsagers->getModePaiement();
			$data['communication'] = $modeleUsagers->getModeCommunication();

			if($data) {
                $message= $this->initialiseMessages();
                $this->afficheVue("header", $message);
				$this->afficheVue("afficheInscriptionUsager", $data);
			}
		}

		/**
		* @brief		Fonction de validation des parametres du formulaire d'inscription d'un usager
		* @details		Validation des différents inputs avant l'instanciation et l'insertion dans la BD
		* @param 		<array> 	$tabUsager 		tableau des parametres de l'usager	
		* @return    	<string> 	Les messages d'erreur à afficher à l'usager 
		*/
        private function validerUsager(array $tabUsager) {

        	// declaration de la 'string' d'erreurs
			$erreurs = "";

			// verification si le champ est rempli et pret à l'insertion 
			foreach($tabUsager AS $t => $valeur) {
				
				$resultat = htmlspecialchars(stripslashes(trim($valeur)));
				$erreurs .= ($resultat == "") ? "Le champ " . $t . " est requis<br>" : "";

				if($t == "Le nom d'utilisateur" || $t == "Le mot de passe" || $t == "La validation du mot de passe") {
					$erreurs .= (strlen($valeur) < 8 || strlen($valeur) > 50) ? $t . " doit contenir entre 8 et 50 caractères.<br>" : "";
				}
				if($t == "Le téléphone") {
					$erreurs .= (strlen($valeur) < 10 || strlen($valeur) > 20) ? $t . " doit contenir entre 10 et 20 caractères.<br>" : "";
				}
				if($t == "Le mode de paiement" || $t == "Le moyen de communication") {
					$erreurs .= (intval($valeur) == 0) ? $t . " est requis<br>" : "";
				}
			}

			// verification par specificite de champ
			if ($tabUsager['Le mot de passe'] !== $tabUsager['La validation du mot de passe']) {
			  	$erreurs .= "Les mots de passe entrés doivent être identiques.<br>";
			}
			return $erreurs;
		
		}
	}
?>