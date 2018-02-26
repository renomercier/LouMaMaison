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
*** *   ...11 methodes  |   getTableName(), obtenir_par_id(), obtenir_tous(), sauvegarderAppartement(), editerChampUnique(), 
	* 						supprimerAppartement(), obtenir_avec_Limit(), obtenir_moyenne(), getTypesApt(), getQuartier(),
	* 						sauvegarderPhoto()
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
		* @param      	<int>  		$premiereEntree     	L'id du 1er appartement a afficher
		* @param      	<int>  		$appartParPage     		le nb d'appartements par page
		* @param      	<array>  	$filtre     			...
		* @return     	<boolean>  		( resultat de la requete ou false ) ...
		*/
        public function obtenir_avec_Limit($premiereEntree, $appartParPage, $filtre = array())
        {  
            $query = "SELECT * FROM disponibilite d JOIN appartement a ON d.id_appartement = a.id 
                        JOIN type_apt t ON a.id_typeApt = t.id 
                        JOIN usager u ON a.id_userProprio = u.username 
                        JOIN quartier q ON a.id_nomQuartier = q.id 
                        JOIN
                            (SELECT id_appartement, AVG(rating) AS moyenne FROM evaluation e 
                                JOIN appartement a2 ON e.id_appartement = a2.id group by a2.id) note 
                                ON note.id_appartement = a.id
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
                $query.= " AND q.id = " . $filtre['quartier'] ."";
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
                $query.= " AND d.dateFin >= '" . $filtre['dateArrive'] ."'";
            }
            if(!empty($filtre['note']))
            {
                $query.= " AND moyenne BETWEEN " . $filtre['note'] ."-1 AND ". $filtre['note'] ."+1";
            }
            $query.= " GROUP BY d.id_appartement LIMIT " . $premiereEntree .", ".$appartParPage."";
           /* if(!empty( $filtre['premiereEntree']))
            {
                $query.= "LIMIT " . $filtre['premiereEntree'] .", ".$filtre['appartParPage']."";
            }*/
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
			$query = "SELECT AVG(rating) AS moyenne FROM evaluation WHERE id_appartement = ? GROUP BY id_appartement";
            $donnees = array($id_appart);
			$resultat = $this->requete($query, $donnees);
            return $resultat->fetch();
		}
        
        /**
		* @brief      Chercher tous les quartiers sauvegardés dans la bd
		* @return     tableau de quartier
		*/
		public function obtenir_quartiers()
		{
			$query = "SELECT * FROM quartier";
			$resultat = $this->requete($query);
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