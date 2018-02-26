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
    *   5 methodes  |   traite(), afficheListeUsagers(), afficheFormInscription(), validerUsager(), attribution_role()
    */
	class Controleur_Usagers extends BaseControleur
	{	
		/**
		* @brief      methode traite - methode abstraite redéfinie par les classes heritant de BaseControleur
		* @details    gere les actions (switch case) ainsi que les parametres envoyes
		* @param      <array>  		$params 	les parametres envoyes
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

			// si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					// case de connexion d'un usager
					case "login":
                        $this->afficheVue("header", $data);
						$this->afficheVue("AfficheLogin");
						break;

					// case de deconnexion d'un usager	
					case "logout":
                        session_destroy();
                        // redirection vers la page d'accueil
                        echo "<script>window.location='./index.php?Appartements'</script>";
                        
                     /*   session_destroy();
                        $data= $this->initialiseMessages();
                        $this->afficheVue("header",$data);
                        $numPage = isset($params['page'])? $params['page'] : 1;
                        $this->afficheListeAppartements($numPage,4);*/
						break;

					// case d'authetification d'un usager	
					case "authentifier":
                        if(isset($params["login"]))
						{

                            if(isset($params["username"]) && isset($params["password"]) && !empty($params["username"]) && !empty($params["password"]))
                            {
                                //si la session n'existe pas, on authentifier l'usager
                                if (!isset($_SESSION["username"]))
                                {
                                    $modeleUsagers = $this->getDAO("Usagers");
                                    $valide = $modeleUsagers->authentification($params["username"], $params["password"]);
                                    //si l'usager est authentifié
                                    if($valide)
                                    {
                                        $data['user'] = $modeleUsagers->obtenir_par_id($params["username"]);
                                        // on crée la session
                                        $_SESSION["username"] = $data['user']->getUsername();
                                        $_SESSION["nom"] = $data['user']->getNom();
                                        $_SESSION["prenom"] = $data['user']->getPrenom();
                                        $_SESSION["isBanned"] = $data['user']->getBanni();
                                        $_SESSION["isActiv"] = $data['user']->getValideParAdmin();

                                        foreach($data['user']->roles as $role)
                                        {
                                           $_SESSION["role"][] = $role->id_nomRole;
                                        }

                                        // redirection vers la page d'accueil
                                        echo "<script>window.location='./index.php?Appartements'</script>";
                                    }
                                    else
                                    {
                                        // si l'usager n'est pas authentifié
                                        $this->afficheVue("header", $data);
                                        $data="<p class='alert alert-warning'>Username ou password invalide!</p>";
                                        $this->afficheVue("AfficheLogin", $data);
                                    }
                                }
                                else
                                {
                                    // si la session existe déjà
                                    $this->afficheVue("header",$data);
                                    $data="<p class='alert alert-warning'>Session déjà ouverte!</p>";
                                    // redirection temporaire
                                    $this->afficheVue("accueil", $data); 
                                }
                            }else{
                                $this->afficheVue("header",$data);
                                $data="<p class='alert alert-warning'>Username et password obligatoires!</p>";
                                $this->afficheVue("AfficheLogin", $data);
                            }
                        }

						break;
					// case d'affichage de la liste de tous les usagers
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

                    // case d'affichage le profil du client 
                    case "afficheUsager" :
                        if(isset($params["idUsager"]) && !empty($params["idUsager"]))
                        {       
                            $this->afficheProfil($params["idUsager"], $data);
                        }
                        else
                        {
                            trigger_error("Pas d'id spécifié");
                        }
                    	break;
					
					// case de modification d'un profil usager	
					case "modifierProfil":
						$message_profil="";
						$obj = json_decode($_REQUEST['dataJson'],true); 
						if(isset($params["idUser"]) && isset($params["prenom"]) && isset($params["nom"]) && isset($params["adresse"]) && isset($params["telephone"]) && isset($params["moyenComm"]) &&  isset($params["paiement"]) && isset($params["pwd0"])) 
						{
							if(!empty($params["idUser"]) && !empty($params["prenom"]) && !empty($params["nom"])&& !empty($params["adresse"]) && !empty($params["telephone"]) && !empty($params["moyenComm"]) && !empty($params["paiement"]) && !empty($params["pwd0"])) 
							{
								if(!isset($params['idUser']) || $params['idUser'] == '')
								{
									$idUser = 0; //on cree usager
								}
								else
								{
									$idUser = $params['idUser']; //sinon, on modifie l'existante
                                               
									$modeleUsagers = $this->getDAO("Usagers");
									$data["usager"] = $modeleUsagers->obtenir_par_id($idUser);
									//a changer
									if(isset($_REQUEST['photo'])) {
										// ajout d'insertion d'une photo (src) à faire... + upload de l'image
									} else {
										$photo =$data["usager"]->getPhoto();
									}
                                    
                                      $coor_moyenComm = $data["usager"]->getCoorMoyenComm();
								}
								$modeleUsagers = $this->getDAO("Usagers");
								$usager = new Usager($idUser, $obj["nom"], $obj["prenom"], $photo, $obj['adresse'], $obj['telephone'], $obj['motdepasse'], $obj['moyenComm'], $coor_moyenComm,  $obj["paiement"]);
								// appel du modele_Usagers et insertion dans la BD
								$resultat = $modeleUsagers->sauvegarder($usager);
									if($resultat) {								
                                        header('Content-type: application/json'); //absolument mettre ce header pour json
                                        $user = $modeleUsagers->obtenir_avec_paiement_communication($params['idUser']); 
                                        //convertir les objets en array pour les mettre dans un seul tableau pour les encoder ensuite en renvoyer vers client
                                        $reponse = array($user); 
                                        $reponse1 = (array("messageSucces"=>"Votre profil a ete modifie avec succes!"));//creer une message de success

                                        $tempData = [];
                                        $tempData = ([$reponse, $reponse1]);//joindre 2 objets dans une array                     //renvoyer une seule reponse avec 2 array dedans!                                
                                        echo json_encode($tempData); 
                                    }
                                    else 
                                    {
                                        // message à l'usager - s'il la requete echoue
										$message_profil = json_encode(array("messageErreur"=>"La requete echoue"));
										echo $message_profil;                                        
                                    }
							}
							else 
							{
								$message_profil = json_encode(array("messageErreur"=>"Veuillez vous assurer de remplir tous les champs requis"));
								echo $message_profil;				
							}
						}
						else
						{
							$message_profil = json_encode(array("messageErreur"=>"Non-non-non...!"));
							echo $message_profil;
						}
					break;
					
                    // case pour bannir | réahabiliter un usager
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
					
                    // case pour activer | désactiver un usager
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
                    
                    // case pour promouvoir | Déchoir un usager
                    case "inversAdmin":
						if(isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]))
						{
							if(isset($params["idUsager"]))
							{
								// Promouvoire | Déchoir un usager
								$modeleUsagers = $this->getDAO("Usagers");
                                
                                // changement de l'état de role Admin dans la table role_usager
								$modeleUsagers->definir_admin($params["idUsager"]);
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
						// chargement du modele et recuperation du data
						$modeleUsagers = $this->getDAO("Usagers");
						$data['paiement'] = $modeleUsagers->getModePaiement();
						$data['communication'] = $modeleUsagers->getModeCommunication();
						if($data) {
                            $this->afficheVue("header", $data);
							$this->afficheVue("afficheInscriptionUsager", $data);
						}
						break;

					// case de sauvegarde d'un usager
					case "sauvegarderUsager" :

						if((isset($params['client']) || isset($params['prestataire'])) && isset($params['username']) && !empty($params['username']) && isset($params['nom']) && !empty($params['nom']) && isset($params['prenom']) && !empty($params['prenom']) && isset($params['adresse']) && !empty($params['adresse']) && 
						isset($params['telephone']) && !empty($params['telephone']) && isset($params['pwd0']) && !empty($params['pwd0']) && isset($params['pwd1']) && !empty($params['pwd1']) && isset($params['modePaiement']) && isset($params['moyenComm']) && !empty($params['moyenComm']) 
						&& isset($params['coor_moyenComm']) && !empty($params['coor_moyenComm'])) {

							if(isset($params['photo'])) {
							// ajout d'insertion d'une photo (src) à faire... + upload de l'image
							} else {
								$photo = "profil.jpg";
							}

							// validation des champs input du formulaire d'inscription d'un usager
							$params['erreurs'] = $this->validerUsager([ 'Le nom d\'utilisateur'=>$params['username'], 'Le nom'=>$params["nom"], 'Le prénom'=>$params["prenom"], 'L\'adresse'=>$params['adresse'], 'Le téléphone'=>$params['telephone'], 'Le mot de passe'=>$params['pwd0'], 'La validation du mot de passe'=>$params['pwd1'], 'Le mode de paiement'=>$params['modePaiement'], 'Le moyen de communication'=>$params['moyenComm'], 'Les coordonnées du moyen de communication'=>$params['coor_moyenComm'] ], [ 'client'=>isset($params['client']), 'prestataire'=>isset($params['prestataire']) ]);
							// si pas d'erreurs, on instancie l'usager et on l'insère dans la BD
							if(!$params['erreurs']) {
								// on instancie un nouvel Usager
								$usager = new Usager($params['username'], $params["nom"], $params["prenom"], $photo, $params['adresse'], $params['telephone'], $params['pwd0'], $params['moyenComm'], $params['coor_moyenComm'], (isset($params['modePaiement']) ? $params['modePaiement'] : 0));
								// appel du modele_Usagers et insertion dans la BD
								$modeleUsagers = $this->getDAO("Usagers");
								$resultat = $modeleUsagers->sauvegarder($usager);
								// si la sauvegarde a fonctionné, message à l'usager 
								if($resultat) {
									// attribution du ou des roles choisis par l'usager
									$roles = (isset($params['client']) && isset($params['prestataire'])) ? [ $params['client'], $params['prestataire'] ] : (isset($params['prestataire']) ? [ $params['prestataire'] ] : [ $params['client'] ]);
/* verif si role avant success*/	$nouveauxRoles = $this->attribution_role($usager->getUsername(), $roles);
									// message à l'usager - success de l'insertion dans la BD
									$data['succes'] = "<p class='alert alert-success'>Votre inscription a été effectuée avec succès. Nous communiquerons avec vous par messagerie LMM dès que vos informations auront été vérifiées";
                					$this->afficheVue("header", $data);
/* affichage @temps */				$this->afficheVue("afficheInscriptionUsager", $data);									
								}
								else {
									// message à l'usager - s'il la requete echoue
									$params['erreurs'] = "Votre compte n'a pu être créé, veuillez contacter l'administration ou recommencer</p>";
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
							$params['erreurs'] = "Veuillez vous assurer de remplir tous les champs requis";
							$this->afficheFormInscription($params);						
						}	
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
			// affichage du footer
            //$this->afficheVue('footer');
			
		}

		/**
		* @brief 		Affichage de la page d'accueil
		* @param 		Aucun parametre envoye
		* @return		charge la vue avec le tableau de donnees
		*/
        private function afficheAccueil()
        {
            $data= $this->initialiseMessages();
            $this->afficheVue("header",$data);
            $modeleAppartement= $this->getDAO("Appartements");
            $data["appartements"] = $modeleAppartement->obtenir_tous();
            $this->afficheVue("listeAppartements", $data); 
        }

		/**
		* @brief 		Affichage de la liste de tous les usagers
		* @param 		Aucun parametre envoye
		* @return		charge la vue avec le tableau de donnees
		*/	
		private function afficheListeUsagers()
		{
            $data= $this->initialiseMessages();
            $this->afficheVue("header",$data);
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
				// affichage du formulaire d'inscription avec tout le data
				$this->afficheVue("header", $data);	
				$this->afficheVue("afficheInscriptionUsager", $data);		
			}
		}

		/**
		* @brief		Fonction d'attribution des differents roles d'un usager
		* @details		L'usager peut choisir les roles client et/ou prestataire
		* @param 		<string> 	$usager 		id de l'usager	
		* @param 		<array> 	$tabRoles 		tableau des roles de l'usager	
		* @return    	<bool> 	
		*/
		public function attribution_role($usager, $tabRoles) {

			$flag = true;
			// chargement du modele usager
			$modeleUsagers = $this->getDAO("Usagers");
			// on boucle dans les differents roles pour les integrer dans la BD
			foreach($tabRoles AS $r) {
				$resultat = $modeleUsagers->definir_role_usager($usager, $r);
				if(!$resultat) {
					$flag = false;
					return $flag;
				}
			}
			return $flag;
		}
        
        /**
		* @brief		Fonction d'affichage d'un profil usager 
		* @details		Preparation des donnees propres a un usager
		* @param 		<string> 	$id 		id de l'usager	
		* @param 		<array> 	$data 		tableau de parametres associes a l'usager	
		* @return    	<vue> 		
		*/
        private function afficheProfil($id, $data)
        { 
            // formatage du message d'erreurs à afficher
		    $data['erreur'] = "";
            $modeleUsagers = $this->getDAO("Usagers");
            $data["usager"] = $modeleUsagers->obtenir_par_id($id);
            $data["isProprio"] = false;
            $data["isClient"] = false;
            $data["isAdmin"] = false;
            $data["isSuperAdmin"] = false;
            $data["modePaiement"] = $modeleUsagers->getModePaiement($id);
            $data["modePaiementGeneral"] = $modeleUsagers->getModePaiement();
            $data["modeCommunication"] = $modeleUsagers->getModeCommunication($id);
            $data["modeCommunicationGeneral"] = $modeleUsagers->getModeCommunication();
            $data['prenom'] = $data["usager"]->getPrenom();
            $data['nom'] = $data["usager"]->getNom();
            $data['adresse'] = $data["usager"]->getAdresse();
            $data['telephone'] = $data["usager"]->getTelephone();
            $data['motdepasse'] = $data["usager"]-> getMotDePasse();	
            foreach($data["usager"]->roles as $role)
            {
                if($role->id_nomRole == 3)
                {
                    $data["isProprio"] = true;
                }
                if($role->id_nomRole == 4)
                {
                    $data["isClient"] = true;
                }
                if($role->id_nomRole == 2)
                {
                    $data["isAdmin"] = true;
                }
                if($role->id_nomRole == 1)
                {
                    $data["isSuperAdmin"] = true;
                }
            }

            $this->afficheVue("header",$data);
            $this->afficheVue("AfficheUsager", $data); 
        }
        
		/**
		* @brief		Fonction de validation des parametres du formulaire d'inscription d'un usager
		* @details		Validation des différents inputs avant l'instanciation et l'insertion dans la BD
		* @param 		<array> 	$tabUsager 		tableau des parametres de l'usager	
		* @param 		<array> 	$tabRoles 		tableau des differents roles de l'usager	
		* @return    	<string> 	Les messages d'erreur à afficher à l'usager 
		*/
        private function validerUsager(array $tabUsager, array $tabRoles=null) {

        	// declaration de la 'string' d'erreurs
			$erreurs = "";

			// on s'assure qu'un des deux roles usager est a true (on reverifie, même si )
			if($tabRoles['client'] == false && $tabRoles['prestataire'] == false) {
				$erreurs .= 'Vous devez choisir au moins un role usager';
			}
			// on s'assure que les roles sont de type boolean
			$erreurs .= is_bool($tabRoles['client']) ? "" : "Role invalide<br>";
			$erreurs .= is_bool($tabRoles['prestataire']) ? "" : "Role invalide<br>";
			// verification si le mode de paiement est valide si l'usager est un client
			if($tabRoles['client'] == true) {
				$erreurs .= ($tabUsager['Le mode de paiement'] == 0) ? "Le mode de paiement est requis" : "" ;
			}
			// verification si le champ est rempli et pret à l'insertion 
			foreach($tabUsager AS $t => $valeur) {
				// 'nettoyage' des donnees et verification si le champ est vide
				$resultat = htmlspecialchars(stripslashes(trim($valeur)));
				$erreurs .= ($resultat == "") ? "Le champ " . $t . " est requis<br>" : "";
				// si le cahmp n'est pa vide, verifications supplementaires
				if(!$erreurs) {
					if($t == 'Les coordonnées du moyen de communication' || $t == 'Le nom' || $t == 'Le prénom' || $t == 'L\'adresse' || $t == 'Le nom d\'utilisateur') {
					$erreurs .= (!is_string($valeur)) ? $t . " est invalide<br>" : "";
					}
					if($t == "Le nom d'utilisateur" || $t == "Le mot de passe" || $t == "La validation du mot de passe") {
						$erreurs .= (strlen($valeur) < 8 || strlen($valeur) > 50) ? $t . " doit contenir entre 8 et 50 caractères.<br>" : "";
					}
					if($t == "Le téléphone") {
						$erreurs .= (strlen($valeur) < 10 || strlen($valeur) > 20) ? $t . " doit contenir entre 10 et 20 caractères.<br>" : "";
					}
					if($t == "Le moyen de communication") {
						$erreurs .= (intval($valeur) == 0) ? $t . " est requis<br>" : "";
					}
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