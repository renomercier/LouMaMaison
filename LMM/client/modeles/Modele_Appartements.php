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
            $sql = "INSERT INTO " . $this->getTableName() . " (options, titre, descriptif, montantParJour, nbPersonnes, nbLits, nbChambres, photoPrincipale, noApt, noCivique, rue, codePostal, id_typeApt, id_userProprio, id_nomQuartier) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
			$data = array($a->getOptions(), $a->getTitre(), $a->getDescriptif(), $a->getMontantParJour(), $a->getNbPersonnes(), $a->getNbLits(), $a->getNbChambres(), $a->getPhotoPrincipale(), $a->getNoApt(), $a->getNoCivique(), $a->getRue(), $a->getCodePostal(), $a->getId_typeApt(), $a->getId_userProprio(), $a->getId_nomQuartier()); 
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
        
        
        public function obtenir_avec_Limit($premiereEntree, $appartParPage, $filtre = array())
        {
            
            $query = "SELECT * FROM disponibilite d JOIN appartement a ON d.id_appartement = a.id 
                        JOIN type_apt t ON a.id_typeApt = t.id 
                        JOIN usager u ON a.id_userProprio = u.username 
                        JOIN quartier q ON a.id_nomQuartier = q.id 
                        LEFT JOIN
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
                      et la somme de toutes les notes d'un appart
		* @return     <entier>
		*/
		public function obtenir_moyenne($id_appart)
		{
			$query = "SELECT AVG(rating) AS moyenne, COUNT(rating) AS nbr_votant FROM evaluation WHERE id_appartement = ? GROUP BY id_appartement";
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

        

    }