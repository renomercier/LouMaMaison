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
            $data = $this->initialiseMessages();
            //
            // afficher le header
            $this->afficheVue("header", $data);
            //
			//si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					case "login":
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
/*                                    
?>
<pre>
<?php var_dump($data->roles); ?>
</pre>
<?php*/
                                    foreach($data->roles as $role)
                                    {
									   $_SESSION["role"][] = $role->id_nomRole;
                                    }
									//on affiche la liste des sujets en respectant les droits d'usager
                                    header('location:index.php');
								}
								else
								{
									//si l'usager n'est pas authentifié
									$data="<p class='alert alert-warning'>Username ou password invalide!</p>";
									$this->afficheVue("AfficheLogin", $data);
								}
							}
							else
							{
								//si la session existe déjà
								$data="<p class='alert alert-warning'>Session déjà ouverte!</p>";
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
								header('location:index.php?Usagers');
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
								header('location:index.php?Usagers');
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

								header('location:index.php?Usagers');
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
            //
            // afficher le footer
            $this->afficheVue("footer");
		}

		/**
		* @brief 		Affichage de la liste de tous les usagers
		* @return		la vue
		*/	
		private function afficheListeUsagers()
		{
			$modeleUsagers = $this->getDAO("Usagers");
			$data["usagers"] = $modeleUsagers->obtenir_tous();
			$this->afficheVue("AfficheListeUsagers", $data);
		}
	}
?>