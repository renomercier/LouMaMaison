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
        function obtenirIdDispo($dateDebut, $dateFin, $id_apt)
		{
			
			$query = "SELECT id from " . $this->getTableName() . "
			WHERE disponibilite = 1 AND dateDebut <= ? AND dateFin >= ? AND id_appartement = ?";
			$donnees = array($dateDebut, $dateFin, $id_apt);
			$resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Disponibilite'); 
			$lDispo = $resultat->fetch();
			return $lDispo;
		}
	}
?>