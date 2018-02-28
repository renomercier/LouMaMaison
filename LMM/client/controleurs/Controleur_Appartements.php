<?php
/**
* @file         /controller/Controleur_Appartement.php
* @brief        Projet WEB 2
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
        * @param      <array>   $params     les parametres envoyes
        * @return     <...>     ( tout depend du case )
        */  
        public function traite(array $params)
        {
            /*
                initialiser les messages à afficher à l'usager
                par rapport à son statut, son état de connexion
                et ses droits sur le site
            */
            $data= $this->initialiseMessages();
            //si le paramètre action existe
            if(isset($params["action"]))
            {
                //switch en fonction de l'action qui nous est envoyée
                //ce switch détermine la vue et obtient le modèle
                switch($params["action"])
                {

                    case "filtrer":
                    
                        // numero de la page actuelle
                        $numPage = isset($params['page']) && is_numeric($params['page'])? $params['page'] : 1;
                    
                        // nombre d'appartements à afficher par page
                        $data['appartParPage'] = isset($params['appartParPage']) && is_numeric($params['appartParPage']) ? $params['appartParPage'] : 4;
                   
                        // nombre de personnes
                        $filtre['nbrPers'] = isset($params['nbrPersonnes']) && is_numeric($params['nbrPersonnes'])? $params['nbrPersonnes'] : 0;
                    
                        // prix minimum
                        $filtre['priMin'] = isset($params['prixMin']) && is_numeric($params['prixMin']) ? $params['prixMin'] : 0;
                    
                        // prix maximum
                        $filtre['prixMax'] = isset($params['prixMax']) && is_numeric($params['prixMax']) ? $params['prixMax'] : 0;
                    
                        // nombre d'etoiles
                        $filtre['note'] = isset($params['note'])? $params['note'] : 0;
                    
                        // quartier
                        $filtre['quartier'] = isset($params['quartier'])? $params['quartier'] : 0;
                    
                        // date d'arrivée
                        $filtre['dateArrive'] = isset($params['arrivee'])? $params['arrivee'] : 0;
                    
                        // date de départ
                        $filtre['dateDepart'] = isset($params['depart'])? $params['depart'] : 0;

                        $data = $this->afficheListeAppartements($numPage, $data['appartParPage'],$filtre);
                        $this->afficheVue("listeAppartements", $data);
						break;

                            
                    // Case d'affichage du detail d'un appartement
                    case "afficherAppartement" :    
                        // chargement du modele Appartement
                        $modeleApts = $this->getDAO("Appartements");
                        // Recuperer le detail de l'appartement               
                        $data['appartement'] = $modeleApts->obtenir_par_id($params['id_appart']);
                        // Recuperer les photos de l'appartement
                        $data['tab_photos'] = $modeleApts->getPhotos_par_id($params['id_appart']);
                        // Recuperer le quartier de l'appartement
                        $data['quartier'] = $modeleApts->getQuartier_par_id($data['appartement']->getId_nomQuartier());
                        // Recuperer le type de l'appartement
                        $data['typeApt'] = $modeleApts->getTypeApt_par_id($data['appartement']->getId_typeApt());
                        // Recuperer la moyenne de l'appartement
                        $data['moyenneApt'] = $modeleApts->obtenir_moyenne($data['appartement']->getId_typeApt());
                        // Recuperer les disponibilites de l'appartement
                        $modeleDisponibilites = $this->getDAO("Disponibilites");
                        $data['tab_dispos'] = $modeleDisponibilites->afficheDisponibilite($params['id_appart']);
                        // Recuperer le proprietaire de l'appartement
                        $modeleUsagers = $this->getDAO("Usagers");
                        $data['proprietaire'] = $modeleUsagers->obtenir_par_id($data['appartement']->getId_userProprio());
                        
                        // Affichage du detail d'un appartement
						$this->afficheVue("header",$data);
                        $this->afficheVue("AfficheAppartement", $data);
						$this->afficheVue("footer");
                        break;
					
					case "afficheAptsProprio" :
						
						if(isset($_SESSION["username"]) && isset($params["idProprio"])) {
                            $modeleApt = $this->getDAO("Appartements");
                            $data['appartements'] = $modeleApt->obtenirAptProprio($params["idProprio"]);
							$modeleDispo = $this->getDAO("Disponibilites");
                            
                                foreach($data['appartements'] as $apt)
                                {
                                    $apt->disponibilite = $modeleDispo->afficheDisponibilite($apt->getId());
                                    $apt->typeApt = $modeleApt->obtenir_apt_avec_type($apt->getId())[0]->typeApt;
									$apt->NbNotes = $modeleApt->obtenir_apt_avec_nb_notes($apt->getId())[0];									
                                }
							$this->afficheVue("header",$data);
                            $this->afficheVue("AfficheAptsProprio", $data); 
							$this->afficheVue("footer");
                            }
					break;
					
					case "supprimeDisponibilite":
						if(isset($params['id_dispo']) && !empty($params['id_dispo'])) 
						{
							$modeleDispo = $this->getDAO("Disponibilites");
							$modeleDispo->supprimeDisponibilite($params['id_dispo']);
							$reponse = json_encode(array("messageSucces"=>"Vous avez supprimé une disponibilité!"));//creer une message de success
							echo $reponse;					
						}
						else
						{
							$reponse = json_encode(array("messageErreur"=>"Choisissez une disponibilité!"));//creer une message d'échec
							echo $reponse;		
						}
					break;
                                            
                    case "ajouteDisponibilite" :
						$message_dispo="";
						$obj = json_decode($_REQUEST['dataJson'],true); 
                        if(isset($params['id_apt']) && isset($params['dateDebut']) && isset($params['dateFin']) && !empty($params['id_apt']) && !empty($params['dateDebut']) && !empty($params['dateFin'])) {
                            $modeleDispo = $this->getDAO("Disponibilites");
							//verification de dates
							$today = Date("Y-m-d");
	
							if($obj['dateDebut'] >= $today && $obj['dateFin']> $obj['dateDebut'])
							{	
								$datesAnciens = $modeleDispo->afficheDisponibilite($obj['id_apt']);
								if($datesAnciens)
								{
									foreach($datesAnciens as $dateOld) {
										$dateDebutOld = $dateOld['dateDebut'];
										$dateFinOld = $dateOld['dateFin'];
									}
										if(($obj['dateDebut'] > $dateFinOld && $obj['dateFin']>$obj['dateDebut']) || ($obj['dateDebut'] < $dateDebutOld && $obj['dateFin'] < $dateDebutOld && $obj['dateFin'] > $obj['dateDebut']))
										{
											$data['disponibilite'] = $modeleDispo->ajouteDisponibilite($obj['dateDebut'], $obj['dateFin'],$obj['id_apt']);
											if($data['disponibilite']) 
											{								
												header('Content-type: application/json'); 
												$dispoNew = $modeleDispo->afficheDisponibilite($obj['id_apt']); 
												$reponse = array($dispoNew);
												$reponse1 = array("messageSucces"=>"Vous avez ajouté une disponibilité!");//creer une message de success 
												$tempData = [];
												$tempData = ([$reponse, $reponse1]);//joindre 2 objets dans une array                     //renvoyer une seule reponse avec 2 array dedans!                                
												echo json_encode($tempData);
											}
											else 
											{
												// message à l'usager - s'il la requete echoue
												$message_dispo = json_encode(array("messageErreur"=>"La requete echoue"));
												echo $message_dispo;                                        
											}
										}
									
										else
										{
											$message_dispo = json_encode(array("messageErreur"=>"Vous avez deja cette disponibilite"));
											echo $message_dispo; 
										}
									
								}
								else if (!$datesAnciens)
								{
									$data['disponibilite'] = $modeleDispo->ajouteDisponibilite($obj['dateDebut'], $obj['dateFin'],$obj['id_apt']);
									if($data['disponibilite']) 
									{								
										header('Content-type: application/json'); 
										$dispoNew = $modeleDispo->afficheDisponibilite($obj['id_apt']); 
										$reponse = array($dispoNew);
										$reponse1 = array("messageSucces"=>"Vous avez ajouté une disponibilité!");//creer une message de success 
										$tempData = [];
										$tempData = ([$reponse, $reponse1]);//joindre 2 objets dans une array                     //renvoyer une seule reponse avec 2 array dedans!                                
										echo json_encode($tempData);
									}
									else 
									{
										// message à l'usager - s'il la requete echoue
										$message_dispo = json_encode(array("messageErreur"=>"La requete echoue"));
										echo $message_dispo;                                        
									}
								}
							}
							else
							{
								$message_dispo = json_encode(array("messageErreur"=>"Veuillez vérifier vos dates"));
								echo $message_dispo;     
							}   
						}
						else
						{
							$message_dispo = json_encode(array("messageErreur"=>"Veuillez vous assurer de remplir tous les champs requis!"));//creer une message d'échec
							echo $message_dispo;		
                        }
                    break;                

                    // case d'affichage du formulaire d'inscription d'un appartement 
                    case "afficherInscriptionApt" :
                        
                        // si l'usager est connete, on valide ses droits et acces
                        if(isset($_SESSION['username'])) {
                            $params['erreurs'] = "";
                            $params['erreurs'] .= $this->validerPermissionApt($_SESSION['username']);
                            // si on a un id d'appartement (ds le cas d'une modification)
                            if(isset($params['id'])) {
                                // validation du params['id']
                                $id = filter_var($params['id'], FILTER_VALIDATE_INT);
                                // si l'id est invalide, message d'erreur a l'usager
                                if(!$id) {
                                    $params['id'] = false;
                                    $params['erreurs'] .= "L'id de l'appartement n'est pas spécifié";
                                }  
                            }
                            // affichage des vues header et formAppartement
                            $this->afficheVue("header",$data);
                            $this->afficheFormAppartement($params);
                            $this->afficheVue("footer");
                        }
                        // sinon, message d'erreur a l'usager
                        else {
                            $params['erreurs'] = "Vous devez être connecté pour ajouter un appartement<br>";
                            $this->afficheVue("header", $data);
                            $this->afficheFormAppartement($params);
                            $this->afficheVue("footer");
                        }
                        break;

                    // case de sauvegarde (creation ou modification) d'un appartement
                    case "sauvegarderApt" :

/* valider les permissions d'abord */ 

                            if( isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($params['titre']) && !empty($params['titre']) && isset($params['descriptif']) && !empty($params['descriptif']) && isset($params['id_typeApt']) && !empty($params['id_typeApt']) && 
                            isset($params['noCivique']) && !empty($params['noCivique']) && isset($params['rue']) && !empty($params['rue']) && isset($params['montantParJour']) && !empty($params['montantParJour']) && isset($params['codePostal']) && !empty($params['codePostal']) && 
                            isset($params['id_nomQuartier']) && !empty($params['id_nomQuartier']) && isset($params['nbPersonnes']) && !empty($params['nbPersonnes']) && isset($params['nbChambres']) && !empty($params['nbChambres']) && isset($params['nbLits']) && !empty($params['nbLits'])) {
                        
                            // validation des champs input du formulaire d'inscription d'un appartement
                            $params['erreurs'] = $this->validerAppartement([ 'Le titre de l\'annonce'=>$params["titre"], 'Le descriptif de l\'appartement'=>$params["descriptif"], 'Le nom de rue'=>$params['rue'], 'Le numéro d\'appartement'=>$params['noApt'], 'Le code postal'=>$params['codePostal'] ], [ 'Le numéro civique'=>$params['noCivique'], 'Le montant du logement'=>$params['montantParJour'], 'Le nombre de personnes'=>$params['nbPersonnes'], 'Le nombre de chambres'=>$params['nbChambres'], 'Le nombre de lits'=>$params['nbLits'], 'Le type d\'appartement'=>$params['id_typeApt'], 'Le quartier'=>$params['id_nomQuartier'] ], [ 'Les options'=>isset($params['options']) ? $params['options'] : "" ] );                            
                            // si pas d'erreurs, on instancie l'appartement et on l'insère dans la BD
                            if(!$params['erreurs']) {
                                
/* @temp */                     // nouvel objet appartement
                                $appartement = new Appartement((isset($params['idApt']) ? $params['idApt'] : 0), (isset($params['options']) ? $params['options'] : ""), $params['titre'], $params['descriptif'], $params['montantParJour'], $params['nbPersonnes'], $params['nbLits'], $params['nbChambres'], $params['noApt'], $params['noCivique'], $params['rue'], $params['codePostal'], $params['id_typeApt'], $_SESSION['username'], $params['id_nomQuartier']);

                                // chargement du modele Appartement
                                $modeleApts = $this->getDAO("Appartements");
                                // si idApt et si valide, on modifie
                                if(isset($params['idApt']) && filter_var($params['idApt'], FILTER_VALIDATE_INT)) {
                                    $modifApt = $modeleApts->sauvegarderAppartement($appartement);
                                }
                                // sinon on insere un nouvel appartement
                                else {
                                    $dernier_idApt = $modeleApts->sauvegarderAppartement($appartement);
                                }

                                // si insertion reussie, affichage du formulaire d'ajout d'images
                                if(isset($dernier_idApt)) {
                                    $data['succes'] = "<p class='alert alert-success'>Votre appartement a été sauvegardé avec succès! Vous pouvez maintenant ajouter des photos à cet appartement";
                                    $data['idApt'] = $dernier_idApt;
                                    $this->afficheVue("header");
                                    $this->afficheVue("AjoutImage", $data);
                                }
                                // si modification reussie
/**/                            else if(isset($modifApt)) {
                                    $data['succes'] = "<p class='alert alert-success'>Votre appartement a été modifié avec succès!";
                                    $this->afficheVue("header");
/* redir @temp */                   $this->afficheFormAppartement($data);
                                }
                                // si la sauvegarde a echoue
                                else {
                                    $params['erreurs'] = "Votre appartement n'a pu être sauvegardée, veuillez recommencer ou communiquer avec l'administration si le problème persiste";
                                    $this->afficheFormAppartement($params);
									$this->afficheVue("footer");
                                }
                            }
                            // si on a des erreurs de validation de params
                            else {
                                // affichage du formulaire avec data de l'usager et messages d'erreurs a afficher
								$this->afficheVue("header",$data);
                                $this->afficheFormAppartement($params);
								$this->afficheVue("footer");
                            }
                        }
                        // si on n'a pas tous les parametres requis
                       else {
							$this->afficheVue("header",$data);
                            $params['erreurs'] = "Veuillez vous assurer de bien remplir tous les champs requis du formulaire";
                            $this->afficheFormAppartement($params);
                            $this->afficheVue("footer");
                            }
                            	
                        break;

                    // case pour remplir les options selectionnees d'un appartement (en vue de modification)
                    case "getOptionsApt" :
                        // entetes importantes pour envoi json
                        header('Content-type: application/json');
                        // chargement du modele Appartement
                        $modeleApts = $this->getDAO("Appartements");
                        $data['apt'] = $modeleApts->obtenir_par_id($params['id']);
                        // appel de la fonction qui prepare le tableau d'options a afficher
                        $data['options'] = $this->prepareTabOptions($data['apt']->getOptions());
                        // preparation du tableau d'options, avec ajout d'une cle pour manipulation js
                        $tabOptions = (['o'=>$data['options']]);
                        echo json_encode($tabOptions);
                        break;
                        
                    // affichage du  formulaire d'ajout d'images pour un appartement
                    case "afficherFormulaireImage" :

                        $this->afficheVue("header");
                        $this->afficheVue("AjoutImage");
                        break;

                    // case de sauvegarde d'une ou plusieurs photos pour un appartement
                    case "ajouterPhoto" :

                    //    var_dump($_FILES);
                    //    var_dump($_SESSION);
                    //    var_dump($params);
                       
                        // ref: https://www.formget.com/ajax-image-upload-php/
                        if(isset($_FILES["file"]["type"]))
                        {
                            // declaration des 'strings' d'erreurs et de succes
                            $data['erreurs'] = "";
                            $data['succes'] = "";
                            // on boucle dans le tableau de fichiers
                            for($i=0; $i<count($_FILES["file"]['name']); $i++) {
                           
                                // validation si l'image est d'un type valide
                                $validextensions = array("jpeg", "jpg", "png");
                                $temporary = explode(".", $_FILES["file"]["name"][$i]);
                                $file_extension = end($temporary);
                                // Approx. 100kb peuvent etre telecharges
                                if ((($_FILES["file"]["type"][$i] == "image/png") || ($_FILES["file"]["type"][$i] == "image/jpg") || ($_FILES["file"]["type"][$i] == "image/jpeg")) && ($_FILES["file"]["size"][$i] < 100000) && in_array($file_extension, $validextensions)) {
                                    // si l'image estde type invalide
                                    if ($_FILES["file"]["error"][$i] > 0) {
                                        $data['erreurs'] .= "Code de l'erreur: " . $_FILES["file"]["error"][$i] . " pour l'image " . $_FILES["file"]["name"][$i] . "<br/>";
                                    } 
                                    else {
                                        if (file_exists("images/" . $_SESSION['username'] . "_" . $_FILES["file"]["name"][$i])) {
                                            $data['erreurs'] .= "La photo nommée " . $_FILES["file"]["name"][$i] . " existe déjà<br/>";
                                        }
                                        else {   
                                            $fileName = $i . "_" . $_SESSION['username'] . "_" . $_FILES['file']['name'][$i];
                                            // chargement de la src dans une variable temporaire
                                            $sourcePath = $_FILES['file']['tmp_name'][$i]; 
                                            // adresse de l'image
                                            $targetPath = "images/" . $fileName; 
                                            // on charge la photo dans le dossier images
                                            move_uploaded_file($sourcePath, $targetPath) ; 

                                            // chargement du modele Appartement
                                            $modeleApts = $this->getDAO("Appartements");
                                            if($i == 0) {
                                                // misa a jour du champ photo principale
                                                $resultat = $modeleApts->editerChampUnique("photoPrincipale", "./images/" . $fileName, $params['idApt']);
                                            } 
                                            else {
                                                // ensuite, insertion des differents photos supplementaires ds la table photo
                                                $resultat = $modeleApts->sauvegarderPhoto($fileName, $params['idApt']);
                                            }
                                            // si l'insertion de la photo ne fonctionne pas, message a l'usager 
                                            if(!$resultat) {
                                                $data['erreurs'] .= "L'image " . $_FILES['file']['name'][$i] . " n'a pu être sauvegardée<br/>";
                                            } 
                                            // sinon, message success a l'usager
                                            else {
                                                $data['succes'] .= "L'image " . $_FILES['file']['name'][$i] . " a été sauvegardée avec succès<br/>";
                                            }
                                        }
                                    }
                                }
                                // si le type ou la taille du fichier genere une erreur, message a l'usager
                                else {
                                    $data['erreurs'] .= "Format ou taille de l'image invalide<br/>"; 
                                }
                            } // fin de la boucle 'for' sur toutes les images a inserer
                            // si on a des erreurs, affichage des messages a l'usager
                            if($data['erreurs']) {
                                $data['erreurs'] = "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                                echo $data['erreurs'];
                            }
                            // sinon, affichage du message succes
                            else {
/* redir page dispo */          echo "<p class='alert alert-success'>" . $data['succes'] . "</p>";
                            }
                        }
                        break;

					default :
						trigger_error("Action invalide.");		
				} // fin du switch 				
			}
            // si aucune action, affichage de la page d'accueil par defaut

            else{ 
                $data= $this->initialiseMessages();
                $this->afficheVue("header",$data);
                $numPage = isset($params['page'])? $params['page'] : 1;
                // nombre d'appartements à afficher par page
                $data['appartParPage'] = isset($params['appartParPage']) && is_numeric($params['appartParPage']) ? $params['appartParPage'] : 4;
                $data = $this->afficheListeAppartements($numPage, $data['appartParPage']);
                $this->afficheVue("RechercheAppartements", $data);
                $this->afficheVue("listeAppartements", $data);
                $this->afficheVue("carteGeographique", $data);
                // affichage du footer
                $this->afficheVue("footer");
            }            

        }
        
        /**
        * @brief        Affichage du formulaire d'inscription d'un appartement
        * @details      Recupere des donnees en parametre pour affichage des choix de l'usager et des erreurs à afficher
        *               Ajoute ensuite le data typeApt et quartier pour populer les selects
        * @param        <array>     $data       tableau d'erreurs s'il y a lieu
        * @return       charge la vue avec le tableau de donnees
        */  
        private function afficheFormAppartement($data = "")
        {
            // chargement du modele Appartement
            $modeleApts = $this->getDAO("Appartements");

            // formatage du message d'erreurs à afficher
            if(isset($data['erreurs']) && !empty($data['erreurs'])) {
                $data['erreurs'] = "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
            }
            // verification si on a un id d'appartement (pour modification)
            if(isset($data['id']) && !empty($data['id'])) {
                // si oui, on recupere les donnees de l'appartement
                $data['apt'] = $modeleApts->obtenir_par_id($data['id']);
            }
            // chargement des differents quartiers de Mtl
            $data['tab_quartier'] = $modeleApts->getQuartier();
            $data['tab_typeApt'] = $modeleApts->getTypesApt();
            // affichage du formulaire d'inscription d'un appartement avec tableau de data rempli
/**/        $this->afficheVue("afficheInscriptionApt", $data);
        }

        /**
        * @brief        Fonction de validation si l'usager est connecte et a les permissions nécessaires pour ajouter un appartement
        * @details      Validation de la variable avant affichage du formulaire
        * @param        <string>    $usager      l'id  de l'usager  
        * @return       <string>    Les messages d'erreur à afficher à l'usager, si tel est le cas
        */
        private function validerPermissionApt($usager) {

            // declaration de la 'string' d'erreurs
            $erreurs = "";
            // 'nettoyage' de la variable et verification si le champ est vide
            $resultat = htmlspecialchars(stripslashes(trim($usager)));
            $erreurs .= ($resultat == "" || !is_string($resultat)) ? "Usager invalide" : "";
            // si aucune erreur
            if(!$erreurs) {
                // on verifie ensuite si l'usager a la permission d'ajouter un appartement
                $modeleUsagers = $this->getDAO("Usagers");
                $permission = $modeleUsagers->obtenir_par_id($usager);
                // si l'usager est valide par un admin ET s'il n'est pas banni
                if($permission->getValideParAdmin() == true && $permission->getBanni() == false) {
                    // declaration du bool role valide a false par defaut
                    $flag = false;
                    // Ensuite on verifie s'il a un des roles requis
                    foreach($permission->roles AS $role) {
                        // si on trouve un des roles requis, flag = true
                        if($role->id_nomRole >= 1 && $role->id_nomRole <= 3) {
                            $flag = true;
                        }
                    }
                    $erreurs .= (!$flag) ? "Vous n'avez pas les droits nécessaires pour inscrire un appartement. Vous devez vous inscrire à titre de prestataire<br>" : "";
                } 
                // sinon, message a l'usager
                else {
                    $erreurs .= "Vous n'avez pas les permissions pour utiliser les services de ce site. Veuillez communiquer avec l'administration<br>";
                } 
            }      
            return $erreurs;
        }

        /**
        * @brief        Fonction de validation des parametres du formulaire d'inscription d'un appartement
        * @details      Validation des différents inputs avant l'instanciation et l'insertion dans la BD
        * @param        <array>     $tabUsager      tableau des parametres de l'usager  
        * @return       <string>    Les messages d'erreur à afficher à l'usager 
        */
        private function validerAppartement(array $tabString, array $tabNumber, array $options = null) {

            // declaration de la 'string' d'erreurs
            $erreurs = "";

            // verification si un champ de type string est rempli et valide
            foreach($tabString AS $s => $valeur) {
                // 'nettoyage' des donnees et verification si le champ est vide
                $resultat = htmlspecialchars(stripslashes(trim($valeur)));
                if($s != 'Le numéro d\'appartement') {
                    $erreurs .= ($resultat == "") ? $s . " est requis<br>" : "";
                }
                // si le resultat n'est pas vide, verifications supplementaires
                if($resultat != "") {
                    $erreurs .= (!is_string($valeur)) ? $s . " doit être de type texte<br>" : "";
                    if($s == 'Le titre de l\'annonce') {
                        $erreurs .= (strlen($valeur) > 250) ? $s . " doit contenir au maximum 250 caractères.<br>" : "";
                    }
                    if($s == 'Le descriptif de l\'appartement') {
                        $erreurs .= (strlen($valeur) > 2000) ? $s . " doit contenir au maximum 2000 caractères.<br>" : "";
                    }
                    if($s == 'Le code postal') {
                        $regEx = '/^[a-z][\d][a-z]\s?[\d][a-z][\d]$/i';                        
                        $erreurs .= (!preg_match($regEx, $valeur)) ? $s . " est invalide<br>" : "";
                    }
                }
            }
            // verification si un champ de type number est rempli et valide
            foreach($tabNumber AS $n => $valeur) {
                // 'nettoyage' des donnees et verification si le champ est vide
                $resultat = htmlspecialchars(stripslashes(trim($valeur)));
                $erreurs .= ($resultat == "") ? $n . " est requis<br>" : "";
                // si le resultat n'est pas vide, verifications supplementaires 
                if($resultat != "") {
                    if($n == 'Le montant du logement') {
                        $erreurs .= (!is_float(floatval($valeur))) ? $n . " est invalide<br>" : "";
                    }
                    else { 
                        $erreurs .= (!ctype_digit($valeur)) ? $n . " est invalide<br>" : "";
                    }     
                }
                if($n == 'Le type d\'appartement' || $n == 'Le quartier') {
                    $erreurs .= (intval($valeur) == 0) ? $n . " est requis<br>" : "";
                }
            }
            // verification si le champ d'options est valide
            if($options != "") {
                foreach($options AS $o => $valeur) {
                    $erreurs .= (!is_string($valeur)) ? $o . " sont de format invalide<br>" : "";
                }
            }
            return $erreurs;
        }

        /**
         * @brief      fonction de preparation des options a l'affichage
         * @details    separe la chaine par option et soustrait le nom de chaque option
         * @params     <string>     $optionsSerialisees     les options serialisees en js
         * @return     <array>      $tabOptions             tableau des differents options associees a un appartement
         */
        public function prepareTabOptions($optionsSerialisees) {
            // declaration du tableau d'options
            $tabOptions = array();
            // separation de la 'string' d'options
            $tabTemp = explode('&', $optionsSerialisees);
            for($i=0; $i<count($tabTemp); $i++) {
                // pour chaque option, on soustrait le nom
                $delimiter = strpos($tabTemp[$i], "=");
                $option = substr($tabTemp[$i], 0, $delimiter);
                // ajout de l'option preparee dans le tableau pour affichage
                $tabOptions[] .= $option;
            }
            return $tabOptions;
        }

        /**
         * @brief      fonction de preparation des options a l'affichage
         * @details    separe la chaine par option et soustrait le nom de chaque option
         * @params     <string>     $optionsSerialisees     les options serialisees en js
         * @return     <array>      $tabOptions             tableau des differents options associees a un appartement
         */
/*      public function prepareTabOptionsPHP($optionsSerialisees) {

            // on recupere le fichier json
            $jsonOptions = file_get_contents("./json/optionsApt.json");
            $options = (json_decode($jsonOptions));

            // declaration du tableau d'options
            $tabObjets = array();
            // separation de la 'string' d'options
            $tabTemp = explode('&', $optionsSerialisees);
            for($i=0; $i<count($tabTemp); $i++) {
                // pour chaque option, on soustrait le nom
                $delimiter = strpos($tabTemp[$i], "=");
                $option = substr($tabTemp[$i], 0, $delimiter);
                // on compare les options de l'appartement et ajout de l'option complete (objet) dans le tableau pour affichage
                foreach($options AS $o) { 
                    for($i=0; $i<count($o); $i++) {
                        if($o[$i]->id == $option) {
                            
                        //    $tabObjets .= remplir tableau d'objets avec $o[$i]...
                        }
                    }
                } 
            }
            return $tabObjets;
        }
*/

        /**
        * @brief        Affichage d'un nombre d'appartements selon une limite définie
        * @param        <int>       $page               numero de la page sur laquelle on se trouve
        * @param        <int>       $appartParPage      le nombre d'appart à afficher par page
        * @param        <array>     $filtre             ...
        * @return       charge la vue avec le tableau de donnees
        */  
        private function afficheListeAppartements($page, $appartParPage, $filtre=[])
        {
            $modeleAppartement= $this->getDAO("Appartements");
            
            // le nombre d'appart resultant de la requete
            $nbrAppart = count($modeleAppartement->obtenir_avec_Limit(0, PHP_INT_MAX, $filtre));
                        
            // definir le nombre d'appart à afficher par page
            $data['appartParPage']=$appartParPage;
            
            $data['quartier'] = $modeleAppartement->obtenir_quartiers();
            // calculer le nombre de pages necessaires pour afficher tous les resultats
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
            
            $premiereEntree = ($data['pageActuelle']-1) * $appartParPage >=0 ?($data['pageActuelle']-1) * $appartParPage : 0; // On calcul la première entrée à lire
            // chercher tous les appartements remplissant les criteres de recherche
            $data["appartements"] = $modeleAppartement->obtenir_avec_Limit($premiereEntree, $appartParPage, $filtre);
            
            // pour chaque apart, trouver le total des evaluation et calculer la moyenne
            foreach($data["appartements"] as $appartement)
            { 
                $adresse=[];
               // $moyenne = $modeleAppartement->obtenir_moyenne($appartement->getId());
                //$appartement->moyenne = $moyenne['moyenne'];
              //  $appartement->nbrVotant = $moyenne['nbr_votant'];
                // reconstituer l'adresse pour la localisation sur la carte google
                $appartement->adresse = $appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();
				//pour afficher nb notes
				//$appartement->NbNotes = $modeleAppartement->obtenir_apt_avec_nb_notes($appartement->getId())[0];
            }
            return $data;
        }
    }

?>