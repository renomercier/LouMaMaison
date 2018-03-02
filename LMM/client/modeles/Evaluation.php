<?php
/**
* @file         /Evaluation.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
    * @class    Evaluation
    * @details  Instancie un object de type Evaluation
    *
    *   1 constructeur  |   getters & setters
    */


	class Evaluation 
	{
		//attributs prives
		private $id;
		private $rating;
		private $commentaire;
		private $dateNotif;		
		private $id_appartement;
		private $id_username;
		
		/**
        *   constructeur de la classe Evaluation
        *       
        *   @param <int>           $id                     l'id de l'evaluation  
        *   @param <int>           $rating                 note d'evaluation     
        *   @param <string>        $commentaire            commentaire sur l'appartement  
        *   @param <date>          $dateNotif              date de l'evaluation  
        *   @param <int>           $id_appartement         l'id de l'appartement   
        *   @param <string>        $id_username            l'id de l'utilisateur    
        */
		public function __construct($rating = "", $commentaire = "", $dateNotif = "", $id_appartement = 1, $id_username = "", $id = "")
		{
			$this->setRating($rating);
			$this->setCommentaire($commentaire);
			$this->setDateNotif($dateNotif);
			$this->setIdAppartement($id_appartement);
			$this->setIdUsername($id_username);
			$this->setId($id);
		}
		
		//getters 
		public function getId() {
			return $this->id;
		}
		public function getRating() {
			return $this->rating;
		}
		public function getCommentaire() {
			return $this->commentaire;
		}
		public function getDateNotif() {
			return $this->dateNotif;
		}
		public function getIdAppartement() {
			return $this->id_appartement;
		}
		public function getIdUsername() {
			return $this->id_username;
		}
		
		//setters
		public function setId($id) {
			if(is_int($id)) {
				$this->id = $id;
			}
			else {
				return false;
			}
		}
		public function setRating($rating) {
			if(is_int(+$rating)) {
				$this->rating = $rating;
			}
			else {
				return false;	
			}
		}
		public function setCommentaire($c) {
			if(is_string($c)) {
				$this->commentaire = $c;
			}
			else {
				return false;	
			}
		}
		public function setDateNotif($dateNotif) {

		//	$this->date = new DateTime();
        //  $this->date = $this->date->format('Y-m-d H:i:s');

			$today = Date("Y-m-d");
			//var_dump($today);
			if($dateNotif < $today) {
				$this->dateNotif = $today;
			}
			else {
				$this->dateNotif = $dateNotif;
			}
		}
		public function setIdAppartement($id) {
			if(is_int(+$id)) {
				$this->id_appartement = $id;
			}
			else
				return false;
		}
		public function setIdUsername($id) {
			if(is_string($id)) {
				$this->id_username = $id;
			}
			else
				return false;
		}

	}

?>