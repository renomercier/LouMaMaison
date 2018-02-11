<?php
	abstract class BaseDao
	{
		protected $db;

		public function __construct(PDO $dbPDO)
		{			
			$this->db = $dbPDO;
		}
			

		/**
		 * Delete a row from a table
		 * @param      <STRING>  $clePrimaire     The primary key
		 * @return     <type>  ( description_of_the_return_value )
		 */
		protected function supprimer($clePrimaire)
		{
			$query = "DELETE FROM " . $this->getTableName() . " WHERE " . $this->getClePrimaire() ."=?";
			$donnees = array($clePrimaire);
			return $this->requete($query, $donnees);
		}

		/**
		 * reads the content from a table
		 *
		 * @param      VAR             $valeurCherchee  The cle primaire from the
		 *                                              table you'll want to read
		 * @param      boolean|string  $clePrimaire   The other column
		 *
		 * @return     <type>          ( description_of_the_return_value )
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
		 * { read all the rows from a table }
		 * @return     <type>  ( description_of_the_return_value )
		 */
		protected function lireTous()
		{
			$query = "SELECT * from " . $this->getTableName();
			return $this->requete($query);
		}

		/**
		 * mise a jour d'un champ particulier d'une table
		 * @param      STRING  $leChamp  le champ a mettre a jour
		 * @param      array   $laValeur   la nouvelle valeur du champ
		 * @param      array   $id   valeur de la clé primaire de la rangée sur laquelle on intervient
		 * @return     <type>  ( description_of_the_return_value )
		 */
		 
		protected function miseAjourChamp($leChamp, $laValeur, $id)
		{
			$query = "UPDATE " . $this->getTableName() . " SET ".$leChamp." = ".$laValeur." WHERE " . $this->getClePrimaire() ."=?";
			$donnees = array($id);
			return $this->requete($query, $donnees);
		}


		/**
		 * Makes a query to a table with the parameters you'll send
		 * @param      STRING  $query  The query
		 * @param      array   $data   The values to insert into the query
		 * @return     <type>  ( description_of_the_return_value )
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
		 * Gets the table name.
		 */
		abstract function getTableName();	
		
		/**
		* filtrer les donnees avant de les inserer dans BD
		*/
		protected function filtre($data)
		{
			$data = stripslashes($data);
			$data = strip_tags($data);
			return $data;
		}
	}
?>