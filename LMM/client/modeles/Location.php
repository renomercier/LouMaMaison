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
	* Classe Location
	*/
	class Location
	{
		//attributs privés
		private $id;
		private $dateDebut;
		private $dateFin;
		private $valideParPrestatire;
		private $validePaiement;
		private $idAppartement;
		private $idUserClient;
		
		//constructeur
		public function __construct($id = "", $dateDebut = "", $dateFin = "", $valideParPrestatire =0, $validePaiement = 0, $idAppartement = "", $idUserClient = "")
		{
			$this->setId($id);
			$this->setDateDebut($dateDebut);
			$this->setDateFin($dateFin);
			$this->setValideParPrestatire($valideParPrestatire);
			$this->setValidePaiement($validePaiement);
			$this->setIdAppartement($idAppartement);
			$this->setIdUserClient($idUserClient);
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
		
		public function getValideParPrestatire()
		{
			return $this->valideParPrestatire;
		}
		
		public function getValidePaiement()
		{
			return $this->validePaiement;
		}
		
		public function getIdAppartement()
		{
			return $this->idAppartement;
		}
		
		public function getIdUserClient()
		{
			return $this->idUserClient;
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
		
		public function setValideParPrestatire($valideParPrestatire)
		{
			if(is_bool($valideParPrestatire)) {
				$this->valideParPrestatire = $valideParPrestatire;
			}
			else {
				return false;
			}
		}
		
		public function setValidePaiement($validePaiement)
		{
			if(is_bool($validePaiement)) {
				$this->validePaiement = $validePaiement;
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
		
		public function setIdUserClient($idUserClient)
		{
			if(is_int($idUserClient)) {
				$this->idUserClient = $idUserClient;
			}
			else
				return false;
		}
	}

?>