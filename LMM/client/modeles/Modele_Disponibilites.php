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
	* 	... 9 methodes	|	getTableName(), afficheDisponibilite(), supprimeDisponibilite(), supprimeDispoParApt(), ajouteDisponibilite(),
	*						obtenirIdDispo(), newDateBegin(), newDateEnd(), misAjourChampUnique()
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
            $query = "SELECT * FROM " . $this->getTableName() . " WHERE disponibilite = 1 AND dateDebut>= DATE(NOW()) AND id_appartement = ?";
            $donnees = array($id_apt);
            $resultat= $this->requete($query, $donnees);
            return $resultat->fetchAll();
        }
        
        /**  
		* @brief     	Supprimer une disponibilite d'un appartement par id de disponibilite
		* @param   		<int>   	$id_dispo  		Identifiant de la table disponibilite 
		* @return    	<boolean>   ( resultat de la requete ou false )
		*/
        public function supprimeDisponibilite($id_dispo) 
        {
            return $this->supprimer($id_dispo);
        }

        /**  
		* @brief     	Supprimer les disponibilites d'un appartement par id d'appartement
		* @param   		<int>   	$id  	Identifiant de l'appartement
		* @return    	<boolean>   ( resultat de la requete ou false )
		*/
        public function supprimeDispoParApt($idApt) 
        {
            $query = "DELETE FROM " . $this->getTableName() . " WHERE id_appartement = ?";
			$donnees = array($idApt);
			return $this->requete($query, $donnees);
        }
        
        /**  
		* @brief     	Ajouter une disponibilite a un appartement
		* @param   		<date>   	$dateDebut 	Date de debut de la disponobilite
		* @param   		<date>   	$dateFin 	Date de fin de la disponibilite
		* @param   		<int>   	$id_apt 	Identifiant d'un appartement
		* @return    	<boolean>  	( resultat de la requete ou false )
		*/
        public function ajouteDisponibilite($dateDebut, $dateFin, $id_apt) 
        {
            $query = "INSERT INTO " . $this->getTableName() . " (dateDebut, dateFin, id_appartement) VALUES (?, ?, ?)";
            $donnees = array($dateDebut, $dateFin, $id_apt);
            return $this->requete($query, $donnees);                
        }      
		 
        /**
		* @brief		Recupere la disponibilite associee a un apparteement selon un filtre de dates 			
		* @param   		<date>   	$dateDebut 	Date de debut recherche
		* @param   		<date>   	$dateFin 	Date de fin recherche
		* @param   		<int>   	$id_apt 	Identifiant d'un appartement		
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
		* @brief      	Calcule la date de début de la nouvelle location
		* @details    	Dans le cas d'une location qui est au milieu d'une disponibilité, 
		* 				on crée la date de début de la nouvelle location 
		* @param    	<date>		$dateEnd   		date de fin de location recherchée par un client 
		* @return	  	la date de début de la nouvelle location   
		*/ 	
		public function newDateBegin($dateEnd)
		{
			// + 1 day from date
			$newDateRef = strtotime("+1 day", strtotime($dateEnd));
			$newDateBegin = Date('Y-m-d', $newDateRef);
			return $newDateBegin;		
		}
		
		/**  
		* @brief      	Calcule la date de fin de la nouvelle location
		* @details    	Dans le cas d'une location qu'est au mileu de disponibilité, 
		* 				on crée la date de fin de la nouvelle location 
		* @param    	<date>		$dateBegin  		date de début de location recherchée par un client 
		* @return	  	la date de fin de la nouvelle location   
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