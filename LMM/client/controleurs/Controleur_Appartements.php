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
    *   7 methodes  |   traite(), afficheFormAppartement(), validerPermissionApt(), validerAppartement(),
    *                   prepareTabOptions(), prepareTabOptionsPourAffichage(), afficheListeAppartements()
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
                    // case de gestion des filtres pour affichage des appartements
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

                        if(isset($params['id_appart']) && filter_var($params['id_appart'], FILTER_VALIDATE_INT)) {   

                            // si params message, message a l'usager concernant des actions sur son appartement
                            if(isset($params['message'])) {
                                $data['succes'] = "<p class='alert alert-success'>". $params['message'] . "</p>";
                            }
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
                        }
                        break;
					
                    // case d'affichage d'un appartement par proprio
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
                            $this->afficheVue("AfficheAptsProprio", $data); 
                            }
					break;
					
                    // case de suppression d'un appartement
                    case "supprimerAppartement" :

                        if(isset($params['id']) && !empty($params['id']) && $_SESSION['username']) {

                            // chargement des modeles requis
                            $modeleLocation = $this->getDAO("Locations");
                            $modeleEvaluation = $this->getDAO("Evaluations");
                            $modeleDispo = $this->getDAO("Disponibilites");
                            $modeleApt = $this->getDAO("Appartements");
                            $modeleUsager = $this->getDAO("Usagers");

                            // validation si l'appartement correrspond au username et s'il a les droits requis
                            $permissionSuppression = $modeleApt->obtenir_par_id($params['id']);
                            $permissionUsager = $modeleUsager->obtenir_par_id($_SESSION['username']);

                            if(($permissionSuppression->getId_userProprio() == $_SESSION['username']) && ($permissionUsager->getValideParAdmin() == 1) &&
                                ($permissionUsager->getBanni() == 0)) {

                                // validation si l'appartement est libre de location presente ou future
                                $aptLocation = $modeleLocation->obtenir_par_idApt($params['id'], 'id_appartement');
                                // declaration du bool aucune location presente ou future a true par defaut
                                $flag = true;
                                // on recupere la date d'aujourd'hui
                                $dateNOW = new DateTime;
                                $dateNOW = $dateNOW->format('Y-m-d');
                                // pour chacune des locations, on verifie si la date de fin de location est passee
                                foreach($aptLocation AS $a) {
                                    // comparaison de la date de fin avec aujourd'hui
                                    if($a->getDateFin() >= $dateNOW) {
                                        // si locaton en cours ou future, flag a false
                                        $flag = false;
                                    }
                                }
                                // si le logement est libre de location, on procede a la suppression
                                if($flag) {
                                    // suppression des dependances (evaluations - dispo - photosSupp)
                                    $suppressionEvaluationApt = $modeleEvaluation->supprimeEvaluationParApt($params['id']);
                                    $suppressionDispoApt = $modeleDispo->supprimeDispoParApt($params['id']);
/**/                                $suppressionPhotosApt = $modeleApt->supprimePhotosParApt($params['id']);
                                    // lorsque toutes les dependances sont supprimees
                                    if($suppressionEvaluationApt && $suppressionDispoApt && $suppressionPhotosApt) {
                                        // suppression de l'appartement du profil utilisateur
/**/                                    $supressionApt = $modeleApt->supprimerAppartement($params['id']);
                                        // si l'appartement est supprime, message succes a l'usager
                                        if($supressionApt) {
                                            $data['succes'] = 'La supression de l\'appartement a été effectuée avec succès';
                                            echo "<p class='alert alert-success'>". $data['succes'] . "</p>";
                                        }
                                        // sinon message d'erreur
                                        else {
                                            $data['erreurs'] = 'La supression de l\'appartement a échoué, veuillez communiquer avec l\'administration';
                                            echo "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                                        }
                                    }
                                    // si les supressions d'evaluation, de dispo et de photos ont echoue
                                    else {
                                        $data['erreurs'] = 'La supression de l\'appartement a échoué, veuillez vérifier si des locations sont en cours ou à venir';
                                        echo "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                                    }
                                }
                                // s'il y a location en cours
                                else {
                                    $data['erreurs'] = 'La supression de l\'appartement a échoué, veuillez vérifier si des locations sont en cours ou à venir';
                                    echo "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                                }
                            }
                            // si l'usager n'a pas les permissions requises pour supprimer un appartement
                            else {
                                $data['erreurs'] = 'Vous n\'avez pas les permissions pour supprimer cet appartement';
                                echo "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                            }
                        } 
                        break;   

                    // case de suppression d'une disponibilite (d'un appartement)
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
                    
                    // case d'ajout d'une disponibilite pour un appartement                        
                   case "ajouteDisponibilite" :
						$message_dispo="";
						$obj = json_decode($_REQUEST['dataJson'],true); 
                        if(isset($params['id_apt']) && isset($params['dateDebut']) && isset($params['dateFin']) && !empty($params['id_apt']) && !empty($params['dateDebut']) && !empty($params['dateFin'])) {
                            $modeleDispo = $this->getDAO("Disponibilites");
							//verification de dates
							$today = Date("Y-m-d");
	
							if($obj['dateDebut'] >= $today && $obj['dateFin']>= $obj['dateDebut'])
							{	
								$datesAnciens = $modeleDispo->afficheDisponibilite($obj['id_apt']);
								if($datesAnciens)
								{
									foreach($datesAnciens as $dateOld) {
										$dateDebutOld = $dateOld['dateDebut'];
										$dateFinOld = $dateOld['dateFin'];
									}
										if(($obj['dateDebut'] > $dateFinOld && $obj['dateFin']>=$obj['dateDebut']) || ($obj['dateDebut'] < $dateDebutOld && $obj['dateFin'] < $dateDebutOld && $obj['dateFin'] >= $obj['dateDebut']))
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
								$message_dispo = json_encode(array("messageErreur"=>"Veuillez vous vérifier vos dates"));
								echo $message_dispo;     
							}   
						}
						else
						{
							$message_dispo = json_encode(array("messageErreur"=>"Veuillez vous assurer de remplir tous les champs requis!"));//creer une message d'échec
							echo $message_dispo;		
                        }
                        break;
					
					//case de creation de location
					case "creerLocation" :
						$message_reservation="";
						$today = Date("Y-m-d");
						if(isset($params['id_appart']) && isset($params['dateDebut']) && isset($params['dateFin']) && isset($params['nbPersonnes']) && !empty($params['id_appart']) && !empty($params['dateDebut']) && !empty($params['dateFin']) && !empty($params['nbPersonnes']) && is_numeric($params['nbPersonnes']))
						{
							if(isset($params['id_userClient']) && !empty($params['id_userClient'])) {
								if($_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0) {
									if($params['dateFin']>=$params['dateDebut'] && $params['dateDebut']>=$today) {
										$modeleDisponibilites = $this->getDAO("Disponibilites");
										$data['idDispo'] = $modeleDisponibilites->obtenirIdDispo($params['dateDebut'],$params['dateFin'],$params['id_appart']);
										if($data['idDispo']) {
											$idDispo = $data['idDispo']->getId();								
											$dateDebutAncien=$data['idDispo']->getDateDebut();
											$dateFinAncien=$data['idDispo']->getDateFin();	

											$dateBeginNew = $modeleDisponibilites->newDateBegin($params['dateFin']);
											$dateFinNew = $modeleDisponibilites->newDateEnd($params['dateDebut']);

											if($dateDebutAncien<=$dateFinNew)
											{	
												$modeleDisponibilites->ajouteDisponibilite($dateDebutAncien, $dateFinNew, $params['id_appart']);			
											}
											if($dateBeginNew<=$dateFinAncien)
											{	
												$modeleDisponibilites->ajouteDisponibilite($dateBeginNew, $dateFinAncien, $params['id_appart']);					
											}
											
											//réserver un apt à cette date
											$modeleDisponibilites->misAjourChampUnique('disponibilite', 0, $idDispo);
											//creer un objet location
											$location = new Location(0, $params['dateDebut'],  $params['dateFin'], 0, 0, $params['id_appart'], $params['id_userClient'], $params['nbPersonnes']);
											//chargement du modele Location 
											$modeleLocation = $this->getDAO("Locations");
											//creation de location
											$resultat = $modeleLocation->creerLocation($location);
											if($resultat) {
												$message_reservation = json_encode(array("messageSucces"=>"Vous avez faites une demande de réservation! Veuillez vous attendre une confirmation de propriètaire."));//creer une message de success 
												echo $message_reservation;
											}
										}
										else if ($data['idDispo']==false){
											$message_reservation = json_encode(array("messageErreur"=>"L'appartement n'est pas disponible. Veuillez vous choisir d'autres dates!"));
											echo $message_reservation;
										}
									}
									else {
										$message_reservation = json_encode(array("messageErreur"=>"Veuillez vous vérifier les dates!"));
										echo $message_reservation;
									}
								}
								else {
									$message_reservation = json_encode(array("messageErreur"=>"Vous devez être validé par l'admin et n'est pas banni pour faire la demande de réservation"));
									echo $message_reservation;
								}
							}
							else {
								$message_reservation = json_encode(array("messageErreur"=>"Vous devez être connecté pour faire la demande de réservation"));
								echo $message_reservation;
							}

						}
						else {
							$message_reservation = json_encode(array("messageErreur"=>"Veuillez vous assurer de remplir tous les champs requis!"));//creer une message d'échec
							echo $message_reservation;	
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

                        if( isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($params['titre']) && !empty($params['titre']) && isset($params['descriptif']) && !empty($params['descriptif']) && isset($params['id_typeApt']) && !empty($params['id_typeApt']) && 
                            isset($params['noCivique']) && !empty($params['noCivique']) && isset($params['rue']) && !empty($params['rue']) && isset($params['montantParJour']) && !empty($params['montantParJour']) && isset($params['codePostal']) && !empty($params['codePostal']) && 
                            isset($params['id_nomQuartier']) && !empty($params['id_nomQuartier']) && isset($params['nbPersonnes']) && !empty($params['nbPersonnes']) && isset($params['nbChambres']) && !empty($params['nbChambres']) && isset($params['nbLits']) && !empty($params['nbLits'])) {
                        
                            // validation ses permissions de l'usager d'abord  
                            $params['erreurs'] = $this->validerPermissionApt($_SESSION['username']);
                            // validation des champs input du formulaire d'inscription d'un appartement
                            $params['erreurs'] .= $this->validerAppartement([ 'Le titre de l\'annonce'=>$params["titre"], 'Le descriptif de l\'appartement'=>$params["descriptif"], 'Le nom de rue'=>$params['rue'], 'Le numéro d\'appartement'=>$params['noApt'], 'Le code postal'=>$params['codePostal'] ], [ 'Le numéro civique'=>$params['noCivique'], 'Le montant du logement'=>$params['montantParJour'], 'Le nombre de personnes'=>$params['nbPersonnes'], 'Le nombre de chambres'=>$params['nbChambres'], 'Le nombre de lits'=>$params['nbLits'], 'Le type d\'appartement'=>$params['id_typeApt'], 'Le quartier'=>$params['id_nomQuartier'] ], [ 'Les options'=>isset($params['options']) ? $params['options'] : "" ] );                            
                            
                            // si pas d'erreurs, on instancie l'appartement et on l'insère dans la BD
                            if(!$params['erreurs']) {
                                
                                // nouvel objet appartement
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
                                else if(isset($modifApt)) {
                                    $data['succes'] = "<p class='alert alert-success'>Votre appartement a été modifié avec succès!</p>";
                                    $this->afficheVue("header");
                                    // redirection vers la page du profil usager
                                    echo "<script>window.location='./index.php?Appartements&action=afficherAppartement&id_appart=" . $params['idApt'] . "&message=Votre appartement a été modifié avec succès!'</script>";
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

                        if(isset($params['id']) && !empty($params['id']) && isset($_SESSION['username'])) {
                            $data['idApt'] = $params['id'];
                            $this->afficheVue("header");
                            $this->afficheVue("AjoutImage", $data); 
                        }
                        break;

                    // case de sauvegarde d'une ou plusieurs photos pour un appartement, ou pour profil usager
                    case "ajouterPhoto" :

                        // declaration du bool pour differencier une telechargement de photo usager ou appartement
                        $photoApt = (isset($params['idApt']) && !empty($params['idApt'])) ? true : false;
                        // recuperation de l'id usager
                        $idUsager = (isset($_SESSION['username'])) ? $_SESSION['username'] : $params['id_usager'];
                        $modifPhotoPrincipale = (isset($params['modifPP']) && ($params['modifPP'] == 'true')) ? true : false;
                        
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
                                    // si l'image est de type invalide
                                    if ($_FILES["file"]["error"][$i] > 0) {
                                        $data['erreurs'] .= "Code de l'erreur: " . $_FILES["file"]["error"][$i] . " pour l'image " . $_FILES["file"]["name"][$i] . "<br/>";
                                    } 
                                    // sinon on verifie si l'image existe dans le fichier images
                                    else {
                                        // si elle existe, message à l'usager
                                        if (file_exists("images/" . $idUsager . "_" . $_FILES["file"]["name"][$i])) {
                                            $data['erreurs'] .= "La photo nommée " . $_FILES["file"]["name"][$i] . " existe déjà<br/>";
                                        }
                                        // si l'image n'existe pas, on procede a la sauvegarde et au telechargement
                                        else { 
                                        /*    
                                            if($photoApt) {
                                                $derniererPhoto = $modeleApts->obtenir_dernierePhotoParIdApt($params['idApt']);
                                                if($derniererPhoto) {  
                                                    $nomPhoto = $derniererPhoto['photoSupp'];
                                                    $numFichierPhoto = $this->prepareNomPhoto($nomPhoto);
                                                    $fileName = $idUsager . "_" . $numFichierPhoto;
                                                }
                                                else {
                                                    $fileName = $idUsager . "_" . $i;
                                                }

                                            }
                                            else {

                                            }
                                        */    

                                            $fileName = $idUsager . "_" . $i . "_" . $_FILES['file']['name'][$i];
                                            // chargement de la src dans une variable temporaire
                                            $sourcePath = $_FILES['file']['tmp_name'][$i]; 
                                            // adresse de l'image
                                            $targetPath = "images/" . $fileName; 
                                            // on charge la photo dans le dossier images
                                            move_uploaded_file($sourcePath, $targetPath) ; 
                                            // on renomme correctement l'image avant insertion dans la BD
                                            $fileName = "./images/" . $fileName;
                                            
                                            // chargement des modeles Appartements et Usagers
                                            $modeleApts = $this->getDAO("Appartements");
                                            $modeleUsagers = $this->getDAO("Usagers");

                                            // bool pour differencier photo profil de photo apt
                                            $flag = false;
                                            // si la photo est une photo principale
                                            if($i == 0 && $modifPhotoPrincipale) {
                                                // si on a un id d'apt, on modifie le champ photoPrincipale de l'appartement
                                                if($photoApt) {
                                                    // misa a jour du champ photo principale                                               
                                                    $resultat = $modeleApts->editerChampUnique("photoPrincipale", $fileName, $params['idApt']);
                                                }
                                                // sinon on modifie le champ photo du profil usager
                                                else {
                                                    // mise a jour du champ photo 
                                                    $resultat = $modeleUsagers->editerChampProfil("photo", $fileName, $idUsager);
                                                    $modeleUsagers = $this->getDAO("Usagers");
                                                    $usager = $modeleUsagers->obtenir_par_id($idUsager);
                                                    $photoProfil = $usager->getPhoto();
                                                    $flag = true;
                                                }  
                                            } 
                                            // si la photo est une photo supplementaire
                                            else {
                                                // insertion des differentes photos supplementaires ds la table photo                                                
                                                $resultat = $modeleApts->sauvegarderPhoto($fileName, $params['idApt']);
                                            }
                                            // si l'insertion de la photo ne fonctionne pas, message a l'usager 
                                            if(!$resultat) {
                                                if($flag) {
                                                    echo '<div id="photo">L\'image "' . $_FILES['file']['name'][$i] . ' n\'a pu être sauvegardée</div><br/>';
                                                }
                                                else { 
                                                    $data['erreurs'] .= "L\'image " . $_FILES['file']['name'][$i] . " n\'a pu être sauvegardée<br/>";
                                                }
                                            } 
                                            // sinon, messages success a l'usager
                                            else {
                                                
                                                if($flag) {
                                                    if(isset($_SESSION['username'])) {
                                                        header('Content-type: application/json');
                                                        $data['img'] = '<div id="photo"><img src="' . $photoProfil . '" class="img img-fluid" width="100px"> </div>';
                                                        $reponse = ([ 'img' => $data['img'] ]);
                                                        echo json_encode($reponse);
                                                    }
                                                    else {
                                                        $data['succes'] = "L'image " . $_FILES['file']['name'][$i] . " a été sauvegardée avec succès. Votre profil est maintenant complet. Vous pourrez consulter votre profil et utiliser le site dès votre confirmation par l'administration";
                                                        //echo "<script>window.location='./index.php?Usagers&action=afficheUsager&idUsager=" . $idUsager . "&message=" . $data['succes'] . "'</script>";
                                                        
                                                        header('Content-type: application/json'); 
                                                        $data['idUsager'] = $idUsager;
                                                        $reponse = ([ 'message' => $data['succes'], 'idUsager' => $data['idUsager'] ]);
                                                        echo json_encode($reponse);
                                                        
                                                    }
                                                }
                                                // photo
                                                else {
                                                    $data['succes'] .= "L\'image " . $_FILES['file']['name'][$i] . " a été sauvegardée avec succès<br/>";
                                                }
                                            }
                                        }
                                    }
                                }
                                // si le type ou la taille du fichier genere une erreur, message a l'usager
                                else {
                                    $data['erreurs'] .= "L\'image " . $_FILES['file']['name'][$i] . " est de format ou taille invalide <small> (Maximum de 100 mega octets)</small><br/>"; 
                                //    echo "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                                }
                            } // fin de la boucle 'for' sur toutes les images a inserer
                            // si on a des erreurs, affichage des messages a l'usager
                            if($data['erreurs']) {
                                echo "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
                            }
                            // sinon, affichage du message succes
                            else {
                                if($photoApt) {
                                //    echo "<p class='alert alert-success'>" . $data['succes'] . "</p>";
                                //    echo "<script>window.location='./index.php?Appartements&action=afficherAppartement&id_appart=" . $params['idApt'] . "&message=" . $data['succes'] . "'</script>";
                                    echo "<script>window.location='./index.php?Appartements&action=afficherAppartement&id_appart=" . $params['idApt'] . "&message=Les photos ont été sauvegardées avec succès!'</script>";
                                }
                            //  $data['succes'] = "<p class='alert alert-success'>" . $data['succes'] . "</p>";
                            }
                        }
                        break;

                    // affichage de photos pour suppression
                    case "afficheSuppressionPhotos" :
                        // verificationsi id d'apt et si l'usager est connecte
                        if(isset($params['id']) && filter_var($params['id'], FILTER_VALIDATE_INT) && isset($_SESSION['username'])) {

                            // chargement des modeles Appartements et Usagers
                            $modeleApts = $this->getDAO("Appartements");
                            $apt = $modeleApts->obtenir_par_id($params['id']);
                            $photosApt = $modeleApts->getPhotos_par_id($params['id']);
                            // on s'assure que l'usager est bien proprietaire de l'appartement duquel supprimer des photos
                            if($_SESSION['username'] == $apt->getId_userProprio()) {
                                // chargement du data photos supplementaires
                                $data['photosApt'] = $photosApt;
                                // affichage
                                $this->afficheVue("header", $data);
                                $this->afficheVue("SuppressionImage", $data);
                                $this->afficheVue("footer");
                            }
                        }
                        break;

                    // case de suppression d'une photo
                    case "supprimerPhoto" :
                        // verificationsi id d'apt et si l'usager est connecte
                        if(isset($params['id']) && filter_var($params['id'], FILTER_VALIDATE_INT) && isset($_SESSION['username'])
                            && isset($params['idApt']) && filter_var($params['idApt'], FILTER_VALIDATE_INT)) {
                            // chargement du modele appartements
                            $modeleApts = $this->getDAO("Appartements");
                            $suppressionPhoto = $modeleApts->supprimePhotoParId($params['id']);
                            if($suppressionPhoto) {
                                $this->affichePhotos($params['idApt']);
                            }
                            else {
                                echo "<p class='alert alert-warning'>Un problème est survenu, la photo n'a pu être supprimée</p>"; 
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
            $data['tab_quartier'] = $modeleApts->getQuartiers();
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
                    /*  if(preg_match(',', $valeur)) {
                            $valeur = preg_replace(',', '.', $valeur);
                            var_dump($valeur);
                            die;
                        }   */
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
        public function prepareTabOptionsPourAffichage($optionsSerialisees) {

            // on recupere le fichier json
            $jsonOptions = file_get_contents("./json/optionsApt.json");
            $options = (json_decode($jsonOptions, true));

            // declaration des tableau d'options et d'objet d'options
            $tabObjets = array();
            $tabOptions = array();

            // separation de la 'string' d'options d'un appartement
            $tabTemp = explode('&', $optionsSerialisees);
            
            // on boucle dans le tableau des options d'un appartement
            for($i=0; $i<count($tabTemp); $i++) {
                
                // pour chaque option, on soustrait le nom
                $delimiter = strpos($tabTemp[$i], "=");
                $option = substr($tabTemp[$i], 0, $delimiter);

                // ajout de l'option preparee dans le tableau pour affichage
                $tabOptions[] = $option;
                
                // on compare les options de l'appartement avec toutes les options
                foreach($options AS $o) { 
                    // recuperation des options de l'appartement seulement
                    for($j=0; $j<count($o); $j++) {   
                        if($o[$j]['id'] == $tabOptions[$i]) {
                            // on popule le tableau des options
                            $tabObjets[]= $o[$j];
                        }
                    } 
                }  
            }
            return $tabObjets;
        }

        /**
         * @brief      fonction de preparation du nom de photo a inserer dans la table
         * @details    
         * @params     <string>     $nomPhoto           nom de la derniere photo
         * @return     <number>     le nom (numero) pour la nouvelle photo
         */
/*      public function prepareNomPhoto($nomPhoto) {
            
            $nom = preg_replace('/\.\/images\//', '', $nomPhoto);  
            $nom = explode('.', $nom);
            array_splice($nom, -1);
            $nom = explode('_', implode($nom));
            $numPhoto = $nom[count($nom) -1];           
            return +$numPhoto + 1;
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
            
            $data['quartier'] = $modeleAppartement->getQuartiers();
            $data['tab_typeApt'] = $modeleAppartement->getTypesApt();
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
                $appartement->adresse = $appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();
            }
            return $data;
        }

        /**
         * @brief      fonction d'affichage de photos
         * @details    rafraîchie l'affichage des photos lors de suppression
         * @params     <int>        $idApt           id de l'appartement
         * @return     echo de la vue a afficher
         */
        public function affichePhotos($idApt) {

            // chargement du modele 
            $modeleApts = $this->getDAO("Appartements");
            $photosApt = $modeleApts->getPhotos_par_id($idApt);
            // declaration de la string d'affichage
            $result = "";
            // on boucle dans chaque photo pour les afficher                
            foreach($photosApt AS $p) { 

                $result .=   '<hr>';
                $result .=  '<div class="col">';
                $result .=      '<div class="text-center col-6"><img id="" src="' . $p['photoSupp'] . '" width="200"/>';
                $result .=      '<button class="suppressionImg" type="button" value="' . $p['id'] . '">Supprimer cette image</button></div>';
                $result .=      '<input type="hidden" name="idApt" value="' . $p['id_appartement'] . '"/>';
                $result .=  '</div>';
                $result .=  '<hr>';
            }
            echo $result;
        }
    }
?>