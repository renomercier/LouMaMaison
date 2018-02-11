<?php
/**
* @file 		/modeles/Usagers.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
	* @class 	Modele_Usagers - herite de BaseDao
	* @details  Classe qui lie les requetes d'objects Usagers a la BD
	*					- definit les requetes specifiques a la classe
	*
	* 	6 methodes	|	getTableName(), obtenir_par_id(), obtenir_tous(), sauvegarder(), retirer(), authentification(), banirRehabiliter(), 
	*/
	class Modele_Usagers extends BaseDAO
	{	

		/**  
		* @brief     	Renvoie le nom de la table usager
		* @details   	Retourne le nom de la table contenant les usagers pour la BD 
		* @param   			Aucun
		* @return    	Le nom de la table usager
		*/
		public function getTableName()
		{
			return "usager";
		}
				
		/**  
		* @brief     	Lecture d'un usager de la BD
		* @details   	Exécute la lecture d'un usager de la BD à l'aide de son identifiant 
		* @param   		<string> 	$username 		Identifiant de l'usager
		* @return    	<objet> 	Résultat de la requête SQL
		*/
		public function obtenir_par_id($username) {
			$resultat = $this->lire($username);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Usager'); 
			$lUsager = $resultat->fetch();
            $this->jointure_Tables($lUsager);
			return $lUsager;
		}
				
		/**  
		* @brief     	Lecture des usagers de la BD
		* @details   	Exécute la lecture de tous les usagers de la BD 
		* @param   		Aucun
		* @return    	<objet> 	Résultat de la requête SQL
		*/
		public function obtenir_tous() {
            $resultat = $this->lireTous();
			$lesUsagers = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
            foreach($lesUsagers as $usager)
            {
                $this->jointure_Tables($usager);
            }

			return $lesUsagers;
		}
	
		/**  
		* @brief     	Sauvegarder la modification ou l'ajout d'un usager à la BD
		* @details   	Inscrire la modification ou la création d'un usager à la BD
		* @param   			Usager 		Objet Usager
		* @return    	Résultat de la requête SQL
		*/ 
		public function sauvegarder(Usager $lUsager) {
			if($lUsager->username && $this->lire($lUsager->username)->fetch())
			{
				// Sauvegarde de la modification de l'usager
				$query = "UPDATE " . $this->getTableName() . " SET nom=?, prenom=?, photo=?, adresse=?, telephone=?, motDePasse=?, valideParAdmin=?,  banni=?, id_moyenComm=?, id_modePaiement=? WHERE " . $this->getClePrimaire() . "=?";
				$donnees = array($lUsager->nom, $lUsager->prenom, $lUsager->photo, $lUsager->adresse, $lUsger->telephone, $lUsager->motDePasse, $lUsager->valideParAdmin, $lUsager->banni, $lUsager->id_moyenComm, $lUsager->id_modePaiement, $lUsager->username);
				return $this->requete($query, $donnees);
			}
			else
			{
				// Sauvegarde de l'ajout de l'usager
				$query = "INSERT INTO " . $this->getTableName() . "(username, nom, prenom, photo, adresse, telephone, motDePasse, valideParAdmin, banni, id_moyenComm, id_modePaiement ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$donnees = array($lUsager->username, $lUsager->nom, $lUsager->prenom, $lUsager->photo, $lUsager->adresse, $lUsager->telephone, $lUsager->motDePasse, $lUsager->valideParAdmin, $lUsager->banni, $lUsager->id_moyenComm, $lUsager->id_modePaiement);
				return $this->requete($query, $donnees);
			}
		}

		/**  
		* @brief     	Supprimer un usager de la BD
		* @details   	Exécute la suppression d'un usager de la BD 
		* @param   		<string>		$username 		Identifiant de l'usager
		* @return    	<bool>			résultat de la requete SQL
		*/
		public function retirer($username) {
		  	$resultat = $this->supprimer($username);
			return $resultat;
		}
        
        /**
		* @brief		Fonction pour authentifier l'usager 
		* @details		Permet de trouver l'usager qui a le username et le mot de passe entrés en paramètres;
		*				si cet usager existe, authentifie l'usager
		* @param 		<string>		$username			nom d'utilisateur
		* @param 		<string>		$password			mot de passe
		* @return    	<bool>			résultat de la requete
		*/       
		public function authentification($username, $password)
		{
			$query = "SELECT * from " . $this->getTableName() . " WHERE username = ? AND motDePasse = ?";
			$donnees = array($username, $password);
			$resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Usager'); 
			if($leUsager = $resultat->fetch())
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
        
        /**
		* @brief		Fonction pour changer le statut d'un usager
		* @details		Permet de changer le statut : Banni / non banni ou Admin / non admin
		* @param 		<VAR>		$leChamp		Le champ à modifier (isBanned / isAdmin)
		* @param 		<VAR>		$laValeur		La nouvelle valeur de ce champ
		* @param 		<VAR>		$id 			id d'usager dans la base de données
		* @return    	<bool>		résultat de la requete
		*/
		public function misAjourChampUnique($leChamp, $laValeur, $id)
		{
			return $this->miseAjourChamp($leChamp, $laValeur, $id);	 
		}
        
        /**
		* @brief		Fonction pour effectuer une jointure entre l'usager et son role, son mode de paiement et son moyen de comminication ...
		* @details		Permet de recuperer toutes les informations relative à un usager
		* @param 		<string>		$usager		
		* @return    	<...> 		les rangées correspondant à un usager donné
		*/
        
        ////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        // fonction incomplete, à completer les jointures a mesure que le projet avance
        
		private function jointure_Tables($usager)
        {
            $query = "SELECT * from role_user JOIN role ON id_nomRole = id WHERE id_username =?";
            $donnees = array($usager->getUsername());
            $resultat = $this->requete($query, $donnees);
            $usager->roles = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Usager");
        }
	}
?>