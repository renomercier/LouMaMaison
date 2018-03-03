<?php
/**
* @file 		/Location.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Location 
    * @details  Instancie un object de type Location
    *
    *   1 constructeur  |   getters & setters
    */
	class Location
	{
		//attributs privés
		private $id;
		private $dateDebut;
		private $dateFin;
		private $valideParPrestataire;
		private $validePaiement;
		private $id_appartement;
		private $id_userClient;
		private $nbPersonnes;
		
		//constructeur
		public function __construct($id = 0, $dateDebut = "", $dateFin = "", $valideParPrestataire =0, $validePaiement = 0, $id_appartement = "", $id_userClient = "", $nbPersonnes="")
		{
			$this->setId($id);
			$this->setDateDebut($dateDebut);
			$this->setDateFin($dateFin);
			$this->setValideParPrestataire($valideParPrestataire);
			$this->setValidePaiement($validePaiement);
			$this->setIdAppartement($id_appartement);
			$this->setIdUserClient($id_userClient);
			$this->setNbPersonnes($nbPersonnes);
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
		
		public function getValideParPrestataire()
		{
			return $this->valideParPrestataire;
		}
		
		public function getValidePaiement()
		{
			return $this->validePaiement;
		}
		
		public function getIdAppartement()
		{
			return $this->id_appartement;
		}
		
		public function getIdUserClient()
		{
			return $this->id_userClient;
		}
		
		public function getNbPersonnes()
		{
			return $this->nbPersonnes;
		}
		
		//setters
		public function setId($id)
		{
			if(is_int(intval($id))) {
				$this->id = $id;
			}
			else
				return false;
		}
		
		public function setDateDebut($dateDebut) //YYYY-MM-DD
		{
			$this->dateDebut = $dateDebut;
		}
		
		public function setDateFin($dateFin) 
		{
			$this->dateFin = $dateFin;
		}
		
		public function setValideParPrestataire($valideParPrestataire)
		{
			$this->valideParPrestataire = $valideParPrestataire;
		}
		
		public function setValidePaiement($validePaiement)
		{
			$this->validePaiement = $validePaiement;
		}
		
		public function setIdAppartement($idAppartement)
		{
			$this->id_appartement = $idAppartement;
		}
		
		public function setIdUserClient($id_userClient)
		{
			$this->id_userClient = $id_userClient;
		}
		
		public function setNbPersonnes($nbPersonnes)
		{
			$this->nbPersonnes = $nbPersonnes;
		}	
	}

?>