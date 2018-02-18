<?php
/**
* @file     
* @brief    
* @details  
*                               
* @author   
* @version    
*/

	/**
    * @class    Appartement 
    * @details  lie les requetes d'objects Appartement a la BD
    *                   - definit les requetes specifiques a la classe
    *
*** *   ... methodes  |   getTableName(), getAllAuditorium(), saveAuditorium(), deleteAuditorium()
    */
    class Modele_Appartements extends BaseDAO {

    	/**
		* @brief      Retourne le nom de la table dans la BD
		* @return     <string>  	( le nom de la table )
		*/
		public function getTableName() {
			return "appartement";
		}

        /**  
		* @brief     	Lecture d'un appartement de la BD
		* @details   	Exécute la lecture d'un appartement de la BD à l'aide de son identifiant 
		* @param   		<string> 	$idAppart 		Identifiant de l'appartement
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_par_id($idAppart) {
			$resultat = $this->lire($idAppart);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Appartement'); 
			$lAppart = $resultat->fetch();
			return $lAppart;
		}
        
		/**
		* @brief      Selectionne tous les Appartements
		* @details    Fait appel a la fonction loadAll() de BaseDAO
		* @return     <object>  	( tous les Appartements )
		*/
		public function obtenir_tous() {

			$result = $this->lireTous();	
			$result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
			return $result->fetchAll();
    	}

    	/**
		* @brief      Sauvegarde un Appartement dans la BD (insertion ou modification)
		* @param      <object>  		l'Appartement
		* @return     <boolean>  		( resultat de la requete )
		*/
		public function sauvegarderAppartement(Appartement $a) {
				
			// insertion
            $sql = "INSERT INTO " . $this->getTableName() . " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
			$data = array($a->getOptions(), $a->getTitle(), $a->getDescriptif(), $s->getMontantParJour(), $s->getNbPersones(), $s->getNbLits(), $s->getNbChambres(), $s->getPhotoPrincipale(), $s->getNoApt(), $s->getNoCivique(), $s->getRue(), $s->getCodePostal());
		
			// modification a ajouter
			
           	return $this->requete($sql, $data);
		}
       
       	/**
		* @brief      	Supprime un Appartement
		* @details 		Fait appel a la fonction delete de BaseDAO
		* @param      	<varchar>  		$id     	L'id de l'Appartement
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
      	public function supprimerAppartement($id) {
      		
            return $this->supprimer($id);
        }
        
        public function obtenir_avec_Limit($debut, $fin)
        {
            $query = "SELECT * FROM " . $this->getTableName() . " ORDER BY id DESC LIMIT " . $debut .", ".$fin."";
			$resultat = $this->requete($query);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
            return $resultat->fetchAll();
        }

    }