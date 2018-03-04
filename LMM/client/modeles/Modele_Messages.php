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
		* @details   	Insérer un message et le relier avec un expediteur 
		* @param   		$titre      	titre du message
		* @param   		$sujet        	le contenu du message
		* @param		$dateHeure 	    la date et l'heure de la création du message
		* @param 		$id_userEmetteur	id de l'emetteur du message
		* @return    	Array :  		'message'
		 */ 
 
		public function creerMessage(Message $leMessage) {
				// Sauvegarde de l'ajout du message
				$query = "INSERT INTO " . $this->getTableName() . "(id, titre, sujet, dateHeure, id_userEmetteur, archive) VALUES (?, ?, ?, ?, ?, ?)";
				$donnees = array($leMessage->getId(), $leMessage->getTitre(), $leMessage->getSujet(), $leMessage->getDateHeure(), $leMessage->getId_userEmetteur(), $leMessage->getArchive());
                $this->requete($query, $donnees);
                return $this->db->lastInsertId();
		}
        
        /**  
		* @brief     	Créer une liaison entre un message et le ou les utilsateurs déstinataires
		* @details   	Insérer un message et le relier avec un ou plusieurs recepteurs
		* @param   		$titre      	titre du message
		* @param   		$sujet        	le contenu du message
		* @param		$dateHeure 	    la date et l'heure de la création du message
		* @param 		$id_userEmetteur	id de l'emetteur du message
		* @return    	Array :  		'message'
		 */ 
 
		public function lier_message_destinatair($idMessage, $idDestinataire) {
				// Sauvegarde de l'ajout de la liaison
				$query = "INSERT INTO message_user (id_message, id_username) VALUES (?, ?)";
				$donnees = array($idMessage, $idDestinataire);
				return $this->requete($query, $donnees);
		}
        

		/**  
		* @brief     	Supprimer la relation entre un usager et un message de la BD
		* @details   	Exécute la suppression d'une relation usager-message de la BD 
		* @param   		<int>		$id_message 		Identifiant du message
        * @param   		<string>	$idUsager 		Identifiant du message
		* @return    	<bool>		résultat de la requete SQL
		*/
		public function suppression_logique($id_message, $idUsager) {
            $query = "UPDATE message_user SET supprime = 1 WHERE id_message =? AND id_username =?";
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
		* @brief     	Lecture des messages reçus par un usager
		* @details   	Exécute la lecture de tous les messages reçus par un usager 
		* @param   		<string> 	$id_usager 		Identifiant de l'usager
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_messages_recus($id_usager) {
            $query = "select * from message_user mu join message m on mu.id_message = m.id where mu.supprime = 0 AND mu.id_username = ?";
            $donnees = array($id_usager);
            $resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Message");
			return $resultat->fetchAll();
		} 
        
        /**  
		* @brief     	Lecture des messages envoyés par un  usager
		* @details   	Exécute la lecture de tous les messages envoyés par un usager 
		* @param   		<string> 	$id_usager 		Identifiant de l'usager
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_messages_envoyes($id_usager) {
            $query = "select * from message m left JOIN message_user mu on m.id = mu.id_message where m.archive = 0 AND id_userEmetteur = ?";
            $donnees = array($id_usager);
            $resultat = $this->requete($query, $donnees);
			$resultat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Message");
			return $resultat->fetchAll();
		}
        
        
        /**  
		* @brief     	Definir un message comme etant Déja lu
		* @param   		<int>		$id_message 		Identifiant du message
        * @param   		<string>	$idUsager 		Identifiant du message
		* @return    	<bool> 	Résultat de la requête SQL
		*/
        public function definir_messages_lu($id_message, $idUsager) {
			$query = "UPDATE message_user SET statut = 1 WHERE id_message =? AND id_username =?";
			$donnees = array($id_message, $idUsager);
			return $this->requete($query, $donnees);
		}
        
        /**
		* @brief		Fonction pour changer le statut d'un message pour l'archivage
		* @param 		<VAR>		$leChamp		Le champ à modifier (isBanned / isAdmin)
		* @param 		<VAR>		$laValeur		La nouvelle valeur de ce champ
		* @param 		<VAR>		$id 			id d'usager dans la base de données
		* @return    	<bool>		résultat de la requete
		*/
		public function misAjourChampUnique($leChamp, $laValeur, $id)
		{
			return $this->miseAjourChamp($leChamp, $laValeur, $id);	 
		}
        
        /**  
		* @brief     	nombre de messages non lus
		* @details   	Exécute la lecture du nombre de messages reçus et pas encore consultés 
		* @param   		<string> 	$id_usager 		Identifiant de l'usager
		* @return    	<objet> 	Résultat de la requête SQL
		*/
        public function obtenir_nombre_messages_nonLus($id_usager) {
            $query = "select COUNT(id_message) as nonLus from  message_user mu  where mu.supprime = 0 AND mu.statut = 0 AND mu.id_username = ?";
            $donnees = array($id_usager);
            $resultat = $this->requete($query, $donnees);
			return $resultat->fetch();
		}
	}
?>