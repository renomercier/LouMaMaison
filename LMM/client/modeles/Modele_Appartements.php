<?php
/**
* @file         /Modele_Appartements.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
    * @class    Modele_Appartements 
    * @details  lie les requetes d'objets Appartement a la BD
    *                   - definit les requetes specifiques a la classe
    *
*** *   ...19 methodes  |   getTableName(), obtenir_par_id(), obtenir_tous(), sauvegarderAppartement(), editerChampUnique(), 
	* 						supprimerAppartement(), supprimePhotosParApt(), obtenir_avec_Limit(), obtenir_moyenne(), getTypesApt(), 
	* 						getTypeApt_par_id(), getQuartier(), getQuartier_par_id(), getPhotos_par_id(),
	* 						obtenirAptProprio(), obtenir_apt_avec_type(), obtenir_apt_avec_nb_notes(), sauvegarderPhoto()
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
        public function obtenir_par_id($id_appart) {
			$resultat = $this->lire($id_appart);
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
			
			$query = "UPDATE " . $this->getTableName() . " SET " . $champ . " = ? WHERE " . $this->getClePrimaire() . " = ?";			
			$donnees = array($val, $id);
			return $this->requete($query, $donnees);
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
		* @brief     	Supprimer les photos supplementaires d'un appartement
		* @param   		<int>   	$id  	Identifiant de l'appartement 
		* @return    	<boolean>   ( resultat de la requete ou false )
		*/
        public function supprimePhotosParApt($idApt) 
        {
            $query = "DELETE FROM photo WHERE id_appartement = ?";
			$donnees = array($idApt);
			return $this->requete($query, $donnees);
        }
        
        /**
		* @brief      	Selectionne la liste d'appartements selon la page affichee et le nb d'appartements par page
		* @details 		
		* @param      	<int>  		$premiereEntree     	L'id du 1er appartement a afficher
		* @param      	<int>  		$appartParPage     		le nb d'appartements par page
		* @param      	<array>  	$filtre     			filtres de recherche
		* @return     	<boolean>  		( resultat de la requete ou false ) ...
		*/
        public function obtenir_avec_Limit($premiereEntree, $appartParPage, $filtre = array())
        {  
            $query = "SELECT * FROM disponibilite d JOIN appartement a ON d.id_appartement = a.id 
                        JOIN type_apt t ON a.id_typeApt = t.id 
                        JOIN usager u ON a.id_userProprio = u.username 
                        JOIN quartier q ON a.id_nomQuartier = q.id 
                        LEFT JOIN
                            (SELECT (id_appartement) as Apparteval, AVG(rating) AS moyenne FROM evaluation e 
                                JOIN appartement a2 ON e.id_appartement = a2.id group by a2.id) note 
                                ON note.Apparteval = a.id
                    	WHERE d.disponibilite = 1 AND d.dateFin > NOW()";

            if(!empty($filtre['priMin']))
            {
                $query.= " AND a.montantParJour >= " . $filtre['priMin'] ."";
            }
            if(!empty($filtre['prixMax']))
            {
                $query.= " AND a.montantParJour <= " . $filtre['prixMax'] ."";
            }
            if(!empty($filtre['quartier']))
            {
                $query.= " AND a.id_nomQuartier = " . $filtre['quartier'] ."";
            }
            if(!empty($filtre['nbrPers']))
            {
                $query.= " AND a.nbPersonnes = " . $filtre['nbrPers'] ."";
            }
            if(!empty($filtre['dateDepart']))
            {
                $query.= " AND d.dateFin >= '" . $filtre['dateDepart'] ."'";
            }
            if(!empty($filtre['dateArrive']))
            {
                $query.= " AND '" . $filtre['dateArrive'] ."' BETWEEN  NOW() AND d.dateFin";
            }
            if(!empty($filtre['note']))
            {
                $query.= " AND moyenne BETWEEN " . $filtre['note'] ."-1 AND ". $filtre['note'] ."+1";
            }
            $query.= " GROUP BY d.id_appartement LIMIT " . $premiereEntree .", ".$appartParPage."";

			$resultat = $this->requete($query);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
   
            return $resultat->fetchAll();
        }
		

		/**
		* @brief      Selectionner le nombre des notes attribuées a un appart
        *             ainsi que la somme de toutes les notes d'un appart
        * @param 	  <int> 		$id_appart 		l'id de l'appartement
		* @return     <entier> 		resultat de la requete
		*/
		public function obtenir_moyenne($id_appart)
		{
			$query = "SELECT AVG(rating) AS moyenne, COUNT(rating) AS nbr_votant FROM evaluation WHERE id_appartement = ? GROUP BY id_appartement";
            $donnees = array($id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetch();
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
		* @brief		Lecture du nom d'un quartier de la BD
		* @details		Permet de recuperer le nom d'un quartier dans la table photo
		* @param      	<varchar>  		$id     	L'identifiant du type d'appartement
		* @return    	<type> 		le type d'appartement concerne de la table type_apt ou false 
		*/
		public function getTypeApt_par_id($id_appart) {

			$query = "SELECT * FROM type_apt WHERE id = ?";
            $donnees = array($id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll();  
        }

        /**
		* @brief		Lecture de tous les quartiers de Montreal de la BD
		* @details		Permet de recuperer tous les quartiers dans la table quartier
		* @param 		Aucun parametre envoyé
		* @return    	<type> 		toutes les rangées de la table quartier ou false 
		*/
		public function getQuartiers() {

			$query = "SELECT id, nomQuartier from quartier";
			$resultat = $this->requete($query);
            return $this->requete($query);   
        }	
		
        /**
		* @brief		Lecture du nom d'un quartier de la BD
		* @details		Permet de recuperer le nom d'un quartier dans la table photo
		* @param      	<varchar>  		$id     	L'identifiant du quartier
		* @return    	<type> 		le nom du quartier concerne de la table quartier ou false 
		*/
		public function getQuartier_par_id($id_appart) {
			$query = "SELECT * FROM quartier WHERE id = ?";
            $donnees = array($id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll();  
        }
		
        /**
		* @brief		Lecture de toutes les photos d'un appartement de la BD
		* @details		Permet de recuperer toutes les photos d'un appartement dans la table photo
		* @param      	<varchar>  		$id     	L'identifiant de l'appartement
		* @return    	<type> 		toutes les rangées concernees de la table photo ou false 
		*/
		public function getPhotos_par_id($id_appart) {

			$query = "SELECT * FROM photo WHERE id_appartement = ?";
            $donnees = array($id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll();  
        }

        /**
		* @brief		Selectionner les appartements du proprio
		* @details		Permet d'afficher les appartements qui appartiennent à proprio
		* @param 		<int> 		$id_proprio id du proprio
		* @return    	<objet> 	Résultat de la requête SQL
		*/
		public function obtenirAptProprio($id_proprio) {
		   // $query = "SELECT * FROM appartement a JOIN usager ON a.id_userProprio = usager.username LEFT JOIN (SELECT id_appartement, AVG(rating) AS moyenne FROM evaluation e JOIN appartement a2 ON e.id_appartement = a2.id GROUP BY a2.id) note ON a.id = note.id_appartement WHERE a.id_userProprio = 'nat' GROUP BY a.id";
            
            $query = "SELECT * FROM " . $this->getTableName() . " a
                JOIN usager ON a.id_userProprio = usager.username 
                LEFT JOIN (SELECT id_appartement, AVG(rating) AS moyenne FROM evaluation e JOIN appartement a2 ON e.id_appartement = a2.id GROUP BY a2.id) note ON a.id = note.id_appartement
                WHERE a.id_userProprio = ? 
                GROUP BY a.id";
            $donnees = array($id_proprio);
            $resultat = $this->requete($query, $donnees);
            $lesApts = $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
            return $lesApts;
		}
        
		/**
		* @brief		Obtenir le type d'un appartement
		* @details		
		* @param 		<int> 		$id_apt id d'appartement
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_apt_avec_type($id_apt) {
            $query = "SELECT typeApt FROM type_apt t JOIN " . $this->getTableName() . " a 
            ON t.id = a.id_typeApt WHERE a.id=?";
            $donnees = array($id_apt);
            $resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
        }
		
		/**
		* @brief		Obtenir le nombre de notes d'un appartement
		* @details		
		* @param 		<int> 		$id_apt id d'appartement
		* @return    	<objet> 	Résultat de la requête SQL
		*/
		public function obtenir_apt_avec_nb_notes($id_apt) {
			$query = "SELECT COUNT(rating) as NbNotes FROM evaluation WHERE id_appartement = ?";
			$donnees = array($id_apt);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetch();
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

        /**
		* @brief      Chercher tous les quartiers sauvegardés dans la bd
		* @return     tableau de quartier
		*/
/*		public function obtenir_quartiers()
		{
			$query = "SELECT * FROM quartier";
			$resultat = $this->requete($query);
            return $resultat->fetchAll();
		}	*/

    }
?>