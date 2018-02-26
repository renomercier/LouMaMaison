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
    * @class    Modele_Appartements 
    * @details  lie les requetes d'objets Appartement a la BD
    *                   - definit les requetes specifiques a la classe
    *
*** *   ...9 methodes  |   	getTableName(), obtenir_par_id(), obtenir_tous(), sauvegarderAppartement(), supprimerAppartement(),
	*						obtenir_avec_Limit(), nombre_notes(), getTypesApt(), getQuartier()
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
			
			// si on a un id d'appartement, modification
			if($a->getId() && $this->lire($a->getId())->fetch()) {
				
				$query = "UPDATE " . $this->getTableName() . " SET options=?, titre=?, descriptif=?, montantParJour=?, nbPersonnes=?, nbLits=?, nbChambres=?, noApt=?, noCivique=?, rue=?, codePostal=?, id_typeApt=?, id_nomQuartier=? WHERE " . $this->getClePrimaire() . "=?";
				$data = array($a->getOptions(), $a->getTitre(), $a->getDescriptif(), $a->getMontantParJour(), $a->getNbPersonnes(), $a->getNbLits(), $a->getNbChambres(), $a->getNoApt(), $a->getNoCivique(), $a->getRue(), $a->getCodePostal(), $a->getId_typeApt(), $a->getId_nomQuartier(), $a->getId()); 
				return $this->requete($query, $data);
			}
			// sinon insertion
			else {
	            $sql = "INSERT INTO " . $this->getTableName() . " (options, titre, descriptif, montantParJour, nbPersonnes, nbLits, nbChambres, noApt, noCivique, rue, codePostal, id_typeApt, id_userProprio, id_nomQuartier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
				$data = array($a->getOptions(), $a->getTitre(), $a->getDescriptif(), $a->getMontantParJour(), $a->getNbPersonnes(), $a->getNbLits(), $a->getNbChambres(), $a->getNoApt(), $a->getNoCivique(), $a->getRue(), $a->getCodePostal(), $a->getId_typeApt(), $a->getId_userProprio(), $a->getId_nomQuartier()); 
				$resultat = $this->requete($sql, $data);
				$lastId = $this->db->lastInsertId();
		        return ($resultat) ? $lastId : false;	
	        }
		}

		/**
		* @brief      	Met a jour la valeur d'une colonne specifique dans une table 
		* @details 		Fait appel a la fonction miseAjourChamp() de BaseDAO qui met a jour 
		*				la valeur d'une colonne specifique dans une table 
		* @param      	<varchar>  		$champ     	Titre du champ
		* @param      	<varchar>  		$val     	Valeur du champ 
		* @param      	<varchar>  		$id     	L'id de l'Appartement
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
		public function editerChampUnique($champ, $val, $id) {
			
			return $this->miseAjourChamp($champ, $val, $id);
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

        /**
		* @brief      	Selectionne la liste d'appartements selon la page affichee et le nb d'appartements par page
		* @details 		
		* @param      	<int>  		$debut     	L'id du 1er appartement a afficher
		* @param      	<int>  		$fin     	le nb d'appartements par page
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
        public function obtenir_avec_Limit($debut, $fin)
        {
        	$query = "SELECT * FROM " . $this->getTableName() . " JOIN type_apt ON " . $this->getTableName() . ".id_typeApt = type_apt.id JOIN usager ON " . $this->getTableName() . ".id_userProprio = usager.username LEFT JOIN evaluation ON evaluation.id_appartement = " . $this->getTableName() . ".id GROUP BY " . $this->getTableName() . ".id LIMIT " . $debut .", ". $fin ."";
        //  $query = "SELECT * FROM " . $this->getTableName() . " JOIN type_apt ON " . $this->getTableName() . ".id_typeApt = type_apt.id JOIN usager ON " . $this->getTableName() . ".id_userProprio = usager.username LEFT JOIN evaluation ON evaluation.id_appartement = " . $this->getTableName() . ".id GROUP BY " . $this->getTableName() . ".id LIMIT ?, ?";
		//	$donnees = array($debut, $fin);
			$resultat = $this->requete($query);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
            return $resultat->fetchAll();
        }
        
		/**
		* @brief      Selectionner le nombre des notes attribuées a un appart
        *             ainsi que la somme de toutes les notes d'un appart
		* @return     <entier>
		*/
		public function nombre_notes($id_appart)
		{
			$query = "SELECT SUM(rating) AS Total_des_notes, COUNT(rating) AS nombre_note FROM evaluation WHERE id_appartement = ?";
            $donnees = array($id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll();
		}

        /**
		* @brief		Lecture des types d'appartements de la BD
		* @details		Permet de recuperer tous les types d'appartements dans la table type_apt
		* @param 		Aucun parametre envoyé
		* @return    	<type> 		toutes les rangées de la table type_Apt ou false 
		*/
		public function getTypesApt() {

			$query = "SELECT id, typeApt from type_apt";
			$resultat = $this->requete($query);
            return $this->requete($query);   
        }

        /**
		* @brief		Lecture de tous les quartiers de Montreal de la BD
		* @details		Permet de recuperer tous les quartiers dans la table quartier
		* @param 		Aucun parametre envoyé
		* @return    	<type> 		toutes les rangées de la table quartier ou false 
		*/
		public function getQuartier() {

			$query = "SELECT id, nomQuartier from quartier";
			$resultat = $this->requete($query);
            return $this->requete($query);   
        }

        /**
		* @brief		Insertion de photos supplementaires pour un appartement dans la table photo
		* @details		Permet de recuperer tous les quartiers dans la table quartier
		* @param 		<string> 	$urlPhoto  		adresse photo
		* @param 		<int> 		$id_appart  	l'id de l'appartement
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
		public function sauvegarderPhoto($urlPhoto, $id_appart) {

			$query = "INSERT INTO photo (photoSupp, id_appartement) VALUES (?, ?)";
			$donnees = array($urlPhoto, $id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat;   
        }

    }