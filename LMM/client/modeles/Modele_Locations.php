<?php
/**
* @file         /Modele_Location.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
	* @class 	Modele_Location - herite de BaseDao
	* @details  Classe qui lie les requetes d'objects Location a la BD
	*					- definit les requetes specifiques a la classe
	*
***	* 	... 2 methodes	|	getTableName(), creerLocation()
	*/
	class Modele_Location extends BaseDAO
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
	
	/////////////////////////////////// - mettre les ? ? ? ? au lieu des variables	
	/////////////////////////////////// - la fonction doit prendre en parametre un objet absolument
	/////////////////////////////////// - je propose sauvegarderLocation puisque la fonction servira à créer ou modifier une location
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