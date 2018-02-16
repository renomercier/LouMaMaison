<?php
/**
* @file         /Disponibilite.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
    * @class    Disponibilite 
    * @details  Instancie un object de type Disponibilite
    *
    *   1 constructeur  |   getters & setters
    */
	class Disponibilite 
	{
		//attributs prives
		private $id;
		private $dateDebut;
		private $dateFin;
		private $disponibilite;
		private $id_appartement;
		
		//constructeur
		public function __construct($id = "", $dateDebut = "", $dateFin = "", $disponibilite = 1, $idAppartement = "")
		{
			$this->setId($id);
			$this->setDateDebut($dateDebut);
			$this->setDateFin($dateFin);
			$this->setDisponibilite($disponibilite);
			$this->setIdAppartement($idAppartement);
		}
		
		//getters 
		public function getId()
		{
			return $this->id;
		}
		
		public function getDateDebut()
		{
			return $this->dateDebut;
		}
		
		public function getDateFin()
		{
			return $this->dateFin;
		}
		
		public function getDisponibilite()
		{
			return $this->disponibilite;
		}
		
		public function getIdAppartement()
		{
			return $this->idAppartement;
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
		
		public function setDateDebut($dateDebut) //YYYY-MM-DD
		{
			$today = Date("Y-m-d");
			//var_dump($today);
			if($dateDebut < $today) {
				$this->dateDebut = $today;
			}
			else {
				$this->dateDebut = $dateDebut;
			}
		}
		
		public function setDateFin($dateFin) 
		{
			$today = Date("Y-m-d"); 
			$dateFin = strtotime("+1 day", strtotime($today)); //ajouter 1 jour a aujourd'hui si la date fin est aujourd'hui ou avant
			$dateFinNew = Date('Y-m-d', $dateFin);
			if($dateFin <= $today) {
				$this->dateFin = $dateFinNew;
			}
			else {
				$this->dateFin = $dateFin;
			}
		}
		
		public function setDisponibilite($disponibilite)
		{
			if(is_bool($disponibilite)) {
				$this->disponibilite = $disponibilite;
			}
			else {
				return false;
			}
		}
		
		public function setIdAppartement($idAppartement)
		{
			if(is_int($idAppartement)) {
				$this->idAppartement = $idAppartement;
			}
			else {
				return false;
			}
		}

	}
?>