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
***	* 	... 6 methodes	|	getTableName(), obtenir_par_id(), obtenir_tous(), supprimerEvaluation(), 
	*						supprimeEvaluationParApt(), sauvegarderEvaluation()
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
		* @brief      Sauvegarde un Appartement dans la BD (insertion ou modification)
		* @param      <object>  		l'Appartement
		* @return     <boolean>  		( resultat de la requete )
		*/
		public function sauvegarderEvaluation(Evaluation $e) {
	
			// si on a un id d'appartement, modification
			if($e->getId() && $this->lire($e->getId())->fetch()) {
				/*
				$query = "UPDATE " . $this->getTableName() . " SET options=?, titre=?, descriptif=?, montantParJour=?, nbPersonnes=?, nbLits=?, nbChambres=?, noApt=?, noCivique=?, rue=?, codePostal=?, id_typeApt=?, id_nomQuartier=? WHERE " . $this->getClePrimaire() . "=?";
				$data = array($a->getOptions(), $a->getTitre(), $a->getDescriptif(), $a->getMontantParJour(), $a->getNbPersonnes(), $a->getNbLits(), $a->getNbChambres(), $a->getNoApt(), $a->getNoCivique(), $a->getRue(), $a->getCodePostal(), $a->getId_typeApt(), $a->getId_nomQuartier(), $a->getId()); 
				return $this->requete($query, $data);	*/
			}
			// sinon insertion
			else {
	            $sql = "INSERT INTO " . $this->getTableName() . " (rating, commentaire, dateNotif, id_appartement, id_username) VALUES (?, ?, ?, ?, ?)"; 
				$data = array($e->getRating(), $e->getCommentaire(), $e->getDateNotif(), $e->getIdAppartement(), $e->getIdUsername()); 
				$resultat = $this->requete($sql, $data);	
	        }
	        return $resultat;
		}
				
	}
	
?>