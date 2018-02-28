<?php
/**
* @file         /Modele_Messages.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
	* @class 	Modele_Messages - herite de BaseDao
	* @details  Classe qui lie les requetes d'objects Message a la BD
	*					- definit les requetes specifiques a la classe
	*
***	* 	... 2 methodes	|	getTableName(), creerMessage()
	*/
	class Modele_Messages extends BaseDAO
	{

		/**  
		* @brief     	Renvoie le nom de la table message
		* @param   		Aucun
		* @return    	Le nom de la table message
		*/
		public function getTableName()
		{
			return "message";
		}
	
		/**  
		* @brief     	Créer un message
		* @details   	Insérer un message et le relier avec un expediteur et un recepteur 
		* @param   		$titre      	titre du message
		* @param   		$sujet        	le contenu du message
		* @param		$dateHeure 	    la date et l'heure de la création du message
		* @param 		$id_userEmetteur	id de l'emetteur du message
		* @return    	Array :  		'message'
		 */ 
 
		public function creerMessage(Message $leMessage) {
				// Sauvegarde de l'ajout du message
				$query = "INSERT INTO " . $this->getTableName() . "(id, titre, sujet, dateHeure, id_userEmetteur) VALUES (?, ?, ?, ?, ?)";
				$donnees = array($leMessage->getId(), $leMessage->getTitre(), $leMessage->getSujet(), $leMessage->getDateHeure(), $leMessage->getId_userEmetteur());
				return $this->requete($query, $donnees);
		}

		/**  
		* @brief     	Supprimer la relation entre un usager et un message de la BD
		* @details   	Exécute la suppression d'une relation usager-message de la BD 
		* @param   		<int>		$id_message 		Identifiant du message
        * @param   		<string>	$idUsager 		Identifiant du message
		* @return    	<bool>		résultat de la requete SQL
		*/
		public function retirer($id_message, $idUsager) {
            $query = "DELETE FROM message_user WHERE id_message=? AND id_username=?";
			$donnees = array($id_message, $idUsager);
			$resultat = $this->requete($query, $donnees);
            return $resultat;

		}

        /**  
		* @brief     	Lecture d'un message de la BD
		* @details   	Exécute la lecture d'un message de la BD à l'aide de son identifiant 
		* @param   		<int> 	$id_message 		Identifiant du message
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_par_id($id_message) {
			$resultat = $this->lire($id_message);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Message'); 
			$leMessage = $resultat->fetch();
			return $leMessage;
		}
        
        /**  
		* @brief     	Lecture des message d'un usager
		* @details   	Exécute la lecture de tous les messages reçus par un usager 
		* @param   		<string> 	$id_usager 		Identifiant de l'usager
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_messages_recus($id_usager) {
            $query = "select * from message_user mu join message m on mu.id_message = m.id join usager u on m.id_userEmetteur = u.username where mu.id_username = ?";
            $donnees = array($id_usager);
            $resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Message");
			return $resultat->fetchAll();
		}
        
	}
?>