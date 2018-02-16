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
		private $dateNotif;		
		private $id_appartement;
		private $id_username;
		
		//constructeur
		public function __construct($id = "", $rating = "", $dateNotif = "", $id_appartement = 1, $id_username = "")
		{
			$this->setId($id);
			$this->setRating($rating);
			$this->setDateNotif($dateNotif);
			$this->setIdAppartement($id_appartement);
			$this->setIdUsername($id_username);
		}
		
		//getters 
		public function getId()
		{
			return $this->id;
		}
		
		public function getRating()
		{
			return $this->rating;
		}
		
		public function getDateNotif()
		{
			return $this->dateNotif;
		}
		
		public function getIdAppartement()
		{
			return $this->id_appartement;
		}
		
		public function getIdUsername()
		{
			return $this->id_username;
		}
		
		//setters
		public function setId($id)
		{
			if(is_int($id)) {
				$this->id = $id;
			}
			else
				return false;
		}
		
		public function setRating($rating) //is_float() || is_int() ?
		{
			if(is_numeric($rating)) {
				$this->rating = $rating;
			}
			else
				return false;	
		}
		
		public function setDateNotif($dateNotif) //YYYY-MM-DD
		{
			$today = Date("Y-m-d");
			//var_dump($today);
			if($dateNotif < $today) {
				$this->dateNotif = $today;
			}
			else {
				$this->dateNotif = $dateNotif;
			}
		}
		
		public function setIdAppartement($id)
		{
			if(is_int($id)) {
				$this->id_appartement = $id;
			}
			else
				return false;
		}
		
		public function setIdUsername($id)
		{
			if(is_int($id)) {
				$this->id_username = $id;
			}
			else
				return false;
		}
		
	}