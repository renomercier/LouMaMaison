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
            $sql = "INSERT INTO " . $this->getTableName() . " (id, options, titre, descriptif, montantParJour, nbPersonnes, nbLits, nbChambres, photoPrincipale, noApt, noCivique, rue, codePostal, id_typeApt, id_userProprio, id_nomQuartier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
			$data = array(0, $a->getOptions(), $a->getTitre(), $a->getDescriptif(), $a->getMontantParJour(), $a->getNbPersonnes(), $a->getNbLits(), $a->getNbChambres(), $a->getPhotoPrincipale(), $a->getNoApt(), $a->getNoCivique(), $a->getRue(), $a->getCodePostal(), $a->getId_typeApt(), $a->getId_userProprio(), $a->getId_nomQuartier()); 
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

        /**
		* @brief      	Selectionne la liste d'appartements selon la page affichee et le nb d'appartements par page
		* @details 		
		* @param      	<int>  		$debut     	L'id du 1er appartement a afficher
		* @param      	<int>  		$fin     	le nb d'appartements par page
		* @return     	<boolean>  		( resultat de la requete ou false )
		*/
      /*  public function obtenir_avec_Limit($debut, $fin)
        {
        	$query = "SELECT * FROM " . $this->getTableName() . " JOIN type_apt ON " . $this->getTableName() . ".id_typeApt = type_apt.id JOIN usager ON " . $this->getTableName() . ".id_userProprio = usager.username LEFT JOIN evaluation ON evaluation.id_appartement = " . $this->getTableName() . ".id GROUP BY " . $this->getTableName() . ".id LIMIT " . $debut .", ". $fin ."";
        //  $query = "SELECT * FROM " . $this->getTableName() . " JOIN type_apt ON " . $this->getTableName() . ".id_typeApt = type_apt.id JOIN usager ON " . $this->getTableName() . ".id_userProprio = usager.username LEFT JOIN evaluation ON evaluation.id_appartement = " . $this->getTableName() . ".id GROUP BY " . $this->getTableName() . ".id LIMIT ?, ?";
		//	$donnees = array($debut, $fin);
			$resultat = $this->requete($query);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
            return $resultat->fetchAll();
        }*/
		
		    public function obtenir_avec_Limit($idProprio=null, $debut, $fin)
        {
        	$query = "SELECT * FROM " . $this->getTableName() . " JOIN type_apt ON " . $this->getTableName() . ".id_typeApt = type_apt.id JOIN usager ON " . $this->getTableName() . ".id_userProprio = usager.username LEFT JOIN evaluation ON evaluation.id_appartement = " . $this->getTableName() . ".id"; 
			if($idProprio) {
				$query .= " WHERE " . $this->getTableName() . ".id_userProprio = ? GROUP BY " . $this->getTableName() . ".id";
			}
			else {
				$query .= " GROUP BY " . $this->getTableName() . ".id LIMIT " . $debut .", ". $fin ."";
			}
		
			$donnees = array($idProprio);
			$resultat = $this->requete($query, $donnees);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement"); 
            return $resultat->fetchAll();
        }
        
		
        
		/**
		* @brief      Selectionner le nombre des notes attribuées a un appart
                      et la somme de toutes les notes d'un appart
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
			/*$donnees = array($id_proprio);
			$resultat = $this->requete($query, $donnees);
            $resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement"); 
           $apts = $resultat->fetchAll();*/
		}
        
        public function obtenir_apt_avec_type($id_apt) {
            $query = "SELECT typeApt FROM type_apt t JOIN " . $this->getTableName() . " a 
            ON t.id = a.id_typeApt WHERE a.id=?";
            $donnees = array($id_apt);
            $resultat = $this->requete($query, $donnees);
            return $resultat->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Appartement");
        }
    }