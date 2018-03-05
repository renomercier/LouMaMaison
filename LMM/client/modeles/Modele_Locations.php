<?php
/**
* @file         /Modele_Locations.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
	* @class 	Modele_Locations - herite de BaseDao
	* @details  Classe qui lie les requetes d'objects Location a la BD
	*					- definit les requetes specifiques a la classe
	*
***	* 	... 5 methodes	|	getTableName(), creerLocation(), afficheLocation(), misAjourChampUnique(), 
	*						obtenir_par_idApt()
	*/
	class Modele_Locations extends BaseDAO
	{

		/**  
		* @brief     	Renvoie le nom de la table location
		* @param   		Aucun
		* @return    	Le nom de la table location
		*/
		public function getTableName()
		{
			return "location";
		}

		/**  
		* @brief     	Créer location d'un appartement
		* @details   	Inscrire la création d'une location à la BD
		* @param   		<object>      	Location
		* @return    	Résultat de la requête SQL
		 */ 
		public function creerLocation(Location $Location)

		{
			$query = "INSERT INTO " . $this->getTableName() . " (dateDebut, dateFin, id_appartement, id_userClient,  nbPersonnes) VALUES (?, ?, ?, ?, ?)";
			$data = array($Location->getDateDebut(), $Location->getDateFin(), $Location->getIdAppartement(), $Location->getIdUserClient(),  $Location->getNbPersonnes());
			return $this->requete($query, $data);
		}
				
		/**  
		* @brief     	Afficher des locations du proprio avec status différents
		* @param   		<int>   $idProprio : 
		* @param   		<int>   $dateNow : date d'aujourd'hui
		* @return    	<...> 	Résultat de la requête SQL
		*/
        public function afficheLocation($dateNow, $idProprio) 
        {
            $query = "SELECT * FROM " . $this->getTableName() . " l 
					JOIN 
					(SELECT (id) as idApt, photoPrincipale, titre, id_userProprio FROM appartement) a ON l.id_appartement = a.idApt
					JOIN usager u ON l.id_userClient = u.username
					WHERE dateDebut >= ? AND id_userProprio = ?";
            $donnees = array($dateNow, $idProprio);
            $resultat = $this->requete($query, $donnees);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Location');
			return $resultat->fetchAll();
        }
		
		/**  
		* @brief     	Afficher des locations du client avec status différents
		* @param   		<int>   $idClient : 
		* @param   		<int>   $dateNow : date d'aujourd'hui
		* @return    	<...> 	Résultat de la requête SQL
		*/
        public function afficheLocationClient($dateNow, $idClient) 
        {
            $query = "SELECT * FROM " . $this->getTableName() . " l 
					JOIN 
					(SELECT (id) as idApt, photoPrincipale, titre, id_userProprio FROM appartement) a ON l.id_appartement = a.idApt
					JOIN usager u ON l.id_userClient = u.username
					WHERE dateDebut >= ? AND id_userClient=?";
            $donnees = array($dateNow, $idClient);
            $resultat = $this->requete($query, $donnees);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Location');
			return $resultat->fetchAll();
        }
		
		/**  
		* @brief     	Afficher des locations par son ID
		* @param   		<int>   $idLocation : 
		* @param   		<int>   $dateNow : date d'aujourd'hui
		* @return    	<...> 	Résultat de la requête SQL
		*/
        public function obtenir_location_par_id($dateNow, $idLocation) 
        {
            $query = "SELECT * FROM " . $this->getTableName() . " l 
					JOIN 
					(SELECT (id) as idApt, photoPrincipale, titre, id_userProprio FROM appartement) a ON l.id_appartement = a.idApt
					JOIN usager u ON l.id_userClient = u.username
					WHERE dateDebut >= ? AND id = ?";
            $donnees = array($dateNow, $idLocation);
            $resultat = $this->requete($query, $donnees);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Location');
			$lLocation = $resultat->fetch();
			return $lLocation;
        }
		 
        /**
		* @brief		Fonction pour changer le status de validation
		* @details		Permet de changer le statut des champs: validePaiement et 	valideParPrestataire
		* @param 		<VAR>		$leChamp		Le champ à modifier (validePaiement / valideParPrestataire)
		* @param 		<VAR>		$laValeur		La nouvelle valeur de ce champ
		* @param 		<VAR>		$id 			id de location dans la base de données
		* @return    	<bool>		résultat de la requete
		*/
		public function misAjourChampUnique($leChamp, $laValeur, $id)
		{
			return $this->miseAjourChamp($leChamp, $laValeur, $id);	 
		}

		/**  
		* @brief     	Fonction de recherche d'une location par appartement
		* @details   	Recherche une ou plusieurs location(s) associee(s) a un appartement
		* @param   		<int>		$idApt			Identifiant d'appartement
		* @param   		<int>		$colonneIdApt	Le nom de la colonne id_appartement
		* @return    	Résultat de la requête SQL
		*/
		public function obtenir_par_idApt($idApt, $colonneIdApt) {

			$query = "SELECT * from " . $this->getTableName() . " WHERE " . $colonneIdApt ."= ?"; 
			$donnees = array($idApt);
			$resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Location');
			return $resultat->fetchAll();
		}
	}

?>