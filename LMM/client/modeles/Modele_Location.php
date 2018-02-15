<?php

/**
* @file     
* @brief    
* @details  
*                               
* @author   
* @version    
*/
	class Modele_Location extends BaseDAO
	{
		public function getTableName()
		{
			return "location";
		}
		
		/**  
		* @brief     	Créer location d'un appartement
		* @details   	Insérer les dates de début et de fin de location de certain appartement par certain client, ainsi que l'id de cette location 
		* @param   		dateDebut      	date de début de location
		* @param   		dateFin        	date de fin de location
		* @param		idAppartement 	id de l'app
		* @param 		idUser			courriel d'utilisateur
		* @return    	Array :  		'location'
		 */ 
		function creerLocation($dateDebut, $dateFin, $idAppartement, $idUser)
		{
			global $connexion;
			$requete = "INSERT INTO location(dateDebut, dateFin, id_appartement, id_usager) VALUES ('" . filtre($dateDebut) . "', '" . filtre($dateFin) . "','" . filtre($idAppartement) . "','" . filtre($idUser) . "')";		
			$resultat = mysqli_query($connexion, $requete);		
			return $resultat;
		}

	}
?>