<?php


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
			$resultat = $query->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Communication');
			return $resultat;
		}
				
	}
?>