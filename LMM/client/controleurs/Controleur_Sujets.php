<?php
	class Controleur_Sujets extends BaseControleur
	{		
		public function traite(array $params)
		{
			//si le paramètre action existe
			if(isset($params["action"]))
			{
				//switch en fonction de l'action qui nous est envoyée
				//ce switch détermine la vue et obtient le modèle
				switch($params["action"])
				{
					case "afficheListeSujets":
						$this->afficheListeSujets();

						break;
					
					default:
						trigger_error("Action invalide.");		
				}				
			}
			else
			{
				//action par défaut - afficher la liste des sujets
				$this->afficheListeSujets();
			}
		}
		
        private function afficheListeSujets()
		{  
			$this->afficheVue("header");
			$this->afficheVue("AfficheListeSujets", $data);
			$this->afficheVue("footer");
		}
        
		/**
		* fonction de validation du formulaire d'ajout de sujet
		*/
		
		private function valideFormSujet($titre, $reponse)
		{
			$erreurs = "";
			$titre = trim($titre);
			$reponse = trim($reponse);
			if($titre == "")
				$erreurs .= "Le titre ne peut être vide.<br>";
			if(strlen($titre) > 100)
				$erreurs .= "Le titre ne doit pas avoir plus de 100 caracters.<br>";
			if(isset($reponse))
			{
				if($reponse== "")
				{
					$erreurs .= "Le texte ne peut être vide.<br>";
				}
				if(strlen($reponse) > 100)
				$erreurs .= "Le texte ne doit pas avoir plus de 1000 caracters.<br>";
			}
			return $erreurs;
		}
	}
?>