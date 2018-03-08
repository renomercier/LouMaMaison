<?php
/**
* @file         /Modele_Evaluations.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
	* @class 	Modele_Evaluations - herite de BaseDao
	* @details  
	*
	* 	... 7 methodes	|	getTableName(), obtenir_par_id(), obtenir_tous(), supprimerEvaluation(), 
	*						supprimerEvaluation(), supprimeEvaluationParApt(), sauvegarderEvaluation()
	*/
	class Modele_Evaluations extends BaseDAO
	{	

		/**  
		* @brief     	Renvoie le nom de la table evaluation
		* @details   	Retourne le nom de la table contenant les moyens de communication pour la BD 
		* @param   		Aucun
		* @return    	Le nom de la table communication
		 */
		public function getTableName() {
			return "evaluation";
		}
				
		/**  
		* @brief     	Lecture d'une evaluation inscrite a la BD
		* @details   	Exécute la lecture d'un evaluation de la BD à l'aide de son identifiant 
		* @param   		$id 		Identifiant evaluation
		* @return    	Résultat de la requête SQL
		 */
		public function obtenir_par_id($id) {

			$query = $this->lire($id);
			$query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Evaluation'); 
			$resultat = $query->fetch();
			return $resultat;
		}
				
		/**  
		* @brief     	Lecture des evaluations inscrites a la BD
		* @details   	Exécute la lecture de toutes les evaluations de la BD 
		* @param   		Aucun parametre envoye
		* @return    	Résultat de la requête SQL
		 */
		public function obtenir_tous() {

			$query = $this->lireTous();
			$resultat = $query->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Evaluation');
			return $resultat;
		}
        
        /**  
		* @brief     	Lecture des commentaires aux evaluations d'un appartement inscrites a la BD
		* @details   	Exécute la lecture de tous les commentaires liés  à une evaluations d'un appartement de la BD 
		* @param   		$id 		Identifiant de l'appartement
		* @return    	Résultat de la requête SQL
		 */
		public function obtenir_tous_non_null($id) {
            $query = "SELECT * FROM evaluation e
                      JOIN usager u ON e.id_username = u.username 
                      WHERE commentaire is not null and e.id_appartement = ?";
			$donnees = array($id);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll();
		}

		/**
		* @brief      	Supprime une evaluation
		* @details 		Fait appel a la fonction delete de BaseDAO
		* @param      	<varchar>  		$id     	Identifiant de l'evaluation OU autre colonne dans la table evaluation
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
      	public function supprimerEvaluation($id) {
      		
            return $this->supprimer($id);
        }

        /**  
		* @brief     	Supprimer les evaluations d'un appartement
		* @param   		<int>   	$id  	Identifiant de l'appartement
		* @return    	<boolean>   ( resultat de la requete ou false )
		*/
        public function supprimeEvaluationParApt($idApt) {

            $query = "DELETE FROM " . $this->getTableName() . " WHERE id_appartement = ?";
			$donnees = array($idApt);
			return $this->requete($query, $donnees);
        }

		/**
		* @brief      Sauvegarde une Evaluation dans la BD (insertion)
		* @param      <object>  		l'Eppartement
		* @return     <boolean>  		( resultat de la requete )
		*/
		public function sauvegarderEvaluation(Evaluation $e) {
	
            $sql = "INSERT INTO " . $this->getTableName() . " (rating, commentaire, dateNotif, id_appartement, id_username) VALUES (?, ?, ?, ?, ?)"; 
			$data = array($e->getRating(), $e->getCommentaire(), $e->getDateNotif(), $e->getIdAppartement(), $e->getIdUsername()); 
			$resultat = $this->requete($sql, $data);	
	        return $resultat;
		}
				
	}
	
?>