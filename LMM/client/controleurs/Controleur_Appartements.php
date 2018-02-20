<?php
/**
* @file 		/controller/Controleur_Appartements.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Controleur_Appartements - herite de la classe BaseController
    * @details 	
    *
    *   ... methodes  |   traite(), afficheListeAppartements
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

                    // case d'affichage du formulaire d'inscription d'un appartement 
                    case "afficherInscriptionApt" :

                        if(isset($_SESSION['username'])) {
                            $params['erreurs'] = $this->validerPermissionApt($_SESSION['username']);
                            $this->afficheFormAppartement($params);
                        }
                        else {
                            $params['erreurs'] = "Vous devez être connecté pour ajouter un appartement<br>";
                            $this->afficheFormAppartement($params);
                        }
                        
                        break;

                    // case de sauvegarde (creation ou modification) d'un appartement
                    case "sauvegarderApt" :
                       
                            if( isset($_SESSION['username']) && !empty($_SESSION['username']) && isset($params['titre']) && !empty($params['titre']) && isset($params['descriptif']) && !empty($params['descriptif']) && isset($params['id_typeApt']) && !empty($params['id_typeApt']) && 
                            isset($params['noCivique']) && !empty($params['noCivique']) && isset($params['rue']) && !empty($params['rue']) && isset($params['montantParJour']) && !empty($params['montantParJour']) && isset($params['noApt']) && !empty($params['noApt']) && 
                            isset($params['codePostal']) && !empty($params['codePostal']) && isset($params['id_nomQuartier']) && !empty($params['id_nomQuartier']) && isset($params['nbPersonnes']) && !empty($params['nbPersonnes']) && isset($params['nbChambres']) && 
                            !empty($params['nbChambres']) && isset($params['nbLits']) && !empty($params['nbLits'])) {
                        
                            // ajout d'insertion d'une photo (src) à faire... + upload de l'image + images supp.

                            // validation des champs input du formulaire d'inscription d'un appartement
                            $params['erreurs'] = $this->validerAppartement([ 'Le titre de l\'annonce'=>$params["titre"], 'Le descriptif de l\'appartement'=>$params["descriptif"], 'Le nom de rue'=>$params['rue'], 'Le numéro d\'appartement'=>$params['noApt'], 'Le code postal'=>$params['codePostal'] ], [ 'Le numéro civique'=>$params['noCivique'], 'Le montant du logement'=>$params['montantParJour'], 'Le nombre de personnes'=>$params['nbPersonnes'], 'Le nombre de chambres'=>$params['nbChambres'], 'Le nombre de lits'=>$params['nbLits'], 'Le type d\'appartement'=>$params['id_typeApt'], 'Le quartier'=>$params['id_nomQuartier'] ], [ 'Les options'=>isset($params['options']) ? $params['options'] : "" ] );                            
                            // si pas d'erreurs, on instancie l'appartement et on l'insère dans la BD
                            if(!$params['erreurs']) {
/* @temp */                     $photo = "photo.jpg";
                                // nouvel objet appartement
                                $appartement = new Appartement($params['options'], $params['titre'], $params['descriptif'], $params['montantParJour'], $params['nbPersonnes'], $params['nbLits'], $params['nbChambres'], $photo, $params['noApt'], $params['noCivique'], $params['rue'], $params['codePostal'], $params['id_typeApt'], $_SESSION['username'], $params['id_nomQuartier']);
                                // chargement du modele Appartement
                                $modeleApts = $this->getDAO("Appartements");
                                $resultat = $modeleApts->sauvegarderAppartement($appartement);
                                if($resultat) {
                                    $data['succes'] = "<p class='alert alert-success'>Votre appartement a été sauvegardé avec succès! Vous pouvez maintenant associer des disponibilités à cet appartement";
/* affichage @temp */               $this->afficheFormAppartement($data);
                                }
                                else {
                                    $params['erreurs'] = "Votre appartement n'a pu être sauvegardée, veuillez recommencer ou communiquer avec l'administration si le problème persiste";
                                    $this->afficheFormAppartement($params);
                                }
                            }
                            // si on a des erreurs
                            else {
                                // affichage du formulaire avec data de l'usager et messages d'erreurs a afficher
                                $this->afficheFormAppartement($params);
                            }
                        }
                        // si on n'a pas tous les parametres requis
                       else {
                            $params['erreurs'] = "Veuillez vous assurer de bien remplir tous les champs requis du formulaire";
                            $this->afficheFormAppartement($params);
                        }   
                        break;

					default :
						trigger_error("Action invalide.");		
				} // fin du switch 				
			}
            // si aucune action, affichage de la page d'accueil par defaut
            else{            
                $this->afficheListeAppartements($params['page']);
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
            $data= $this->initialiseMessages();
            $this->afficheVue("header",$data);
			$modeleAppartement= $this->getDAO("Appartements");
			$appart = $modeleAppartement->obtenir_tous();
            $appartParPage = 1;
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
            
			$this->afficheVue("Accueil", $data);
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
            // formatage du message d'erreurs à afficher
            if(isset($data['erreurs'])) {
                $data['erreurs'] = "<p class='alert alert-warning'>" . $data['erreurs'] . "</p>";
            }
            // chargement du modele Appartement
            $modeleApts = $this->getDAO("Appartements");
            // chargement des differents types d'appartement et quartiers de Mtl
            $data['tab_typeApt'] = $modeleApts->getTypesApt();
            $data['tab_quartier'] = $modeleApts->getQuartier();
            // si le tableau data est charge
            if($data) {

                $this->afficheVue("header");
                // affichage du formulaire d'inscription d'un appartement avec tableau de data rempli
                $this->afficheVue("afficheInscriptionApt", $data);
            }
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
	}
?>