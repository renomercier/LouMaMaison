<?php
/**
* @file 		/modeles/BaseDAO.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
	* @class 	model BaseDao - classe abstraite
	* @details 	Classe BaseDao qui gere et prepare les requetes a la BD
	*					- Cette classe est protegee et n'est accedee que pas les modeles qui en herite
	*
	* 	8 methodes	|	supprimer(), lire(), lireTous(), miseAjourChamp(), requete(), getClePrimaire(), getTableName(), filtre()
	*/
	abstract class BaseDao
	{
		// attribut de la classe BaseDao
		protected $db;

		/**
        *   constructeur de la classe BaseDao   
        *   @param BD   	$dbPDO      la base de donnee        
        */
		public function __construct(PDO $dbPDO)
		{			
			$this->db = $dbPDO;
		}
			
		/**
		* @brief      Supprime une rangee dans une table
		* @param      <STRING>  	$clePrimaire     La cle primaire
		* @return     <boolean>  	( resultat de la requete )
		*/
		protected function supprimer($clePrimaire)
		{
			$query = "DELETE FROM " . $this->getTableName() . " WHERE " . $this->getClePrimaire() ."=?";
			$donnees = array($clePrimaire);
			return $this->requete($query, $donnees);
		}

		/**
		* @brief      Selectionne le contenu d'une table
		* @param      VAR             	$valeurCherchee  	La valeur de recherche - clause WHERE
		* @param      boolean|string  	$clePrimaire   		La colonne de recherche - clause WHERE
		* @return     <object>          ( la/les rangee(s) selectionnee(s) )
		*/
		protected function lire($valeurCherchee, $clePrimaire = NULL)
		{
			if(!isset($clePrimaire)){
				$query = "SELECT * from " . $this->getTableName() . " WHERE " . $this->getClePrimaire() ."=?";
			}
			else{
				$query = "SELECT * from " . $this->getTableName() . " WHERE " . $clePrimaire ."=?";
			}
			$donnees = array($valeurCherchee);
			return $this->requete($query, $donnees);
		}

		/**
		* @brief      Selectionne toutes les rangees d'une table
		* @return     <object>  ( toutes les rangees d'une table )
		*/
		protected function lireTous()
		{
			$query = "SELECT * from " . $this->getTableName();
			return $this->requete($query);
		}

		/**
		* @brief  		mise a jour d'un champ particulier d'une table
		* @param      	<STRING>  	$leChamp  	le champ a mettre a jour
		* @param      	<array>   	$laValeur   la nouvelle valeur du champ
		* @param      	<array>  	$id   		valeur de la clé primaire de la rangée sur laquelle on intervient
		* @return     	<boolean>  ( resultat de la requete )
		*/	 
		protected function miseAjourChamp($leChamp, $laValeur, $id)
		{
			$query = "UPDATE " . $this->getTableName() . " SET ".$leChamp." = ".$laValeur." WHERE " . $this->getClePrimaire() ."=?";
			$donnees = array($id);
			return $this->requete($query, $donnees);
		}

		/**
		* @brief      Prepare et execute les requetes envoyees
		* @param      <STRING>   $query  	La requete
		* @param      <array>    $data   	Les valeurs a inserer dans la requete
		* @return     <type>     ( $stmt )
		*/
		final protected function requete($query, $data = array())
		{
			try
			{
				$stmt = $this->db->prepare($query);
				$stmt->execute($data);
			}
			catch(PDOException $e)
			{
				trigger_error("<p>La requête suivante a donné une erreur : $query</p><p>Exception : " . $e->getMessage() . "</p>");
			}
			return $stmt;
		}

		/**
		* @brief      Selectionne la cle primaire d'une table
		* @return     <VAR>  ( valeur de la cle primaire )
		*/
		final protected function getClePrimaire()
		{
			//copyright salim
			$query = "Show columns FROM " . $this->getTableName();
			$resultat = $this->requete($query);
			foreach ($resultat as $rangee)
			{
				if($rangee["Key"]=="PRI")
				{
					return $rangee["Field"];
				}
			}
		}

		/**
		* @brief    	Fournit le nom d'une table
		*/
		abstract function getTableName();	
		
		/**
		* @brief 	filtre les donnees avant de les inserer dans BD
		* @return 	<type> 		la donnée nettoyée
		*/
		protected function filtre($data)
		{
			$data = stripslashes($data);
			$data = strip_tags($data);
			return $data;
		}
	}
?>