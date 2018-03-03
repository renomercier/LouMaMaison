<?php
/**
* @file         /Modele_Disponibilites.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
	* @class 	Modele_Disponibilites - herite de BaseDao
	* @details  
	*
	* @methodes		getTableName(), afficheDisponibilite(), supprimeDisponibilite(), ajouteDisponibilite()
	*/
	class Modele_Disponibilites extends BaseDAO
	{

		/**  
		* @brief     	Renvoie le nom de la table disponibilite
		* @param   		Aucun
		* @return    	Le nom de la table disponibilite
		*/
		public function getTableName()
		{
			return "disponibilite";
		}
        
        /**  
		* @brief     	Afficher des disponibilites d'un appartement
		* @param   		<int>   $id_apt Identifiant d'un appartement
		* @return    	<...> 	les rangées correspondant à un appartement donné 
		*/
        public function afficheDisponibilite($id_apt) 
        {
            $query = "SELECT * FROM " . $this->getTableName() . " WHERE disponibilite = 1 AND id_appartement = ?";
            $donnees = array($id_apt);
            $resultat= $this->requete($query, $donnees);
            return $resultat->fetchAll();
        }
        
        /**  
		* @brief     	Supprimer une disponibilite d'un appartement
		* @param   		<int>   $id_dispo Identifiant de disponibilite
		* @return    	<boolean>  		( resultat de la requete ou false )
		*/
	       
        public function supprimeDisponibilite($id_dispo) 
        {
            return $this->supprimer($id_dispo);
        }
        
         /**  
		* @brief     	Ajouter une disponibilite d'un appartement
		* @param   		<int>   $id_apt Identifiant d'un appartement
		* @param   		<int>   $dateDebut Date de debut
		* @param   		<int>   $dateFin Identifiant d'un appartement
		* @return    	<boolean>  		( resultat de la requete ou false )
		*/
	       
        public function ajouteDisponibilite($dateDebut, $dateFin, $id_apt) 
        {
            $query = "INSERT INTO " . $this->getTableName() . " (dateDebut, dateFin, id_appartement) VALUES (?, ?, ?)";
            $donnees = array($dateDebut, $dateFin, $id_apt);
            return $this->requete($query, $donnees);                
        }
        
		 
        /**
		* @brief		
		* @details		
		* @param 		
		* @return    	
		*/
        public function obtenirIdDispo($dateDebut, $dateFin, $id_apt)
		{
			$query = "SELECT * from " . $this->getTableName() . "
			WHERE disponibilite = 1 AND dateDebut <= ? AND dateFin >= ? AND id_appartement = ?";
			$donnees = array($dateDebut, $dateFin, $id_apt);
			$resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Disponibilite'); 
			$lDispo = $resultat->fetch();
			return $lDispo;
		}
		
		/**  
		* @brief      Calculer la date de début de la nouvelle location
		* @details    Dans le cas de location qu'est au mileu de disponibilité, 
		* on créer la date de début de la nouvelle location 
		* @param    dateEnd   date de fin de location cherchée par un client 
		* @return	  la date de début de la nouvelle location   
		*/ 	
		public function newDateBegin($dateEnd)
		{
			// + 1 day from date
			$newDateRef = strtotime("+1 day", strtotime($dateEnd));
			$newDateBegin = Date('Y-m-d', $newDateRef);
			return $newDateBegin;		
		}
		
		/**  
		* @brief      Calculer la date de fin de la nouvelle location
		* @details    Dans le cas de location qu'est au mileu de disponibilité, 
		* on créer la date de fin de la nouvelle location 
		* @param    dateBegin  date de début de location cherchée par un client 
		* @return	  la date de fin de la nouvelle location   
		*/ 		
		public function newDateEnd($dateBegin)
		{
			// - 1 day to date
			$newDateRef=strtotime("-1 day", strtotime($dateBegin));
			$newDateEnd=Date('Y-m-d', $newDateRef);
			return $newDateEnd;		
		}
		
		 /**
		* @brief		Fonction pour réserver un appartement
		* @details		Permet de changer le statut de champ: disponibilité
		* @param 		<VAR>		$leChamp		Le champ à modifier (disponibilite)
		* @param 		<VAR>		$laValeur		La nouvelle valeur de ce champ
		* @param 		<VAR>		$id 			id de disponibilité dans la base de données
		* @return    	<bool>		résultat de la requete
		*/
		public function misAjourChampUnique($leChamp, $laValeur, $id)
		{
			return $this->miseAjourChamp($leChamp, $laValeur, $id);	 
		}
		
	}
?>