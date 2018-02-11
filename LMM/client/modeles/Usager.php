<?php
/**
* @file       Usager.php
* @author     Renaud Mercier - Gr. 15612
* @version    1.0 
* @date       Février 2018 
* @brief      la classe Usager 
* @license    GNU General Public License version 3 (GPLv3)
* @copyright  Copyright (C) 2018 College de Maisonneuve
*/

	class Usager 	{
		
		// Attributs
		private $username;
		private $nom;
		private $prenom;
		private $photo;
		private $adresse;
		private $telephone;
		private $motDePasse;
		private $valideParAdmin;
		private $banni;
		private $id_moyenComm;
		private $id_modePaiement;
        private $id_adminBan;
        private $id_adminValid;
		
		// Constructeur
		public function __construct($u = "", $n = "", $p = "", $ph = "", $a = "", $t = "", $mP = "", $iMC = "", $iMP = "", $iAB = "", $iAV = "") {			
			$this->username = $u;
			$this->nom = $n;
			$this->prenom = $p;
			$this->photo = $ph;
			$this->adresse = $a;
			$this->telephone = $t;
			$this->motDePasse = $mP;
			$this->valideParAdmin = false;
			$this->banni = false;
			$this->id_moyennComm = $iMC;
			$this->id_modePaiement = $iMP;
            $this->id_adminBan = $iAB;
			$this->id_adminValid = $iAV;
		}


		/*****   Getters   *****/

		//
		public function getUsername () {
			return $this->username;
		}

		//
		public function getNom () {
			return $this->nom;
		}

		//
		public function getPrenom () {
			return $this->prenom;
		}

		//
		public function getPhoto () {
			return $this->photo;
		}

		//
		public function getAdresse () {
			return $this->adresse;
		}

		//
		public function getTelephone () {
			return $this->telephone;
		}

		//
		public function getMotDePasse () {
			return $this->motDePasse;
		}

		//
		public function getValideParAdmin () {
			return $this->valideParAdmin;
		}	

		//
		public function getBanni () {
			return $this->banni;
		}	

		//
		public function getIdMoyenComm () {
			return $this->id_moyenComm;
		}	

		//
		public function getIdModePaiement () {
			return $this->id_modePaiement;
		}
        
		//
		public function getAdminBan () {
			return $this->$id_adminBan;
		}	

		//
		public function getAdminValid () {
			return $this->$id_adminValid;
		}

		/*****   Setters   *****/

		//
		public function setUsername ($u) {
			$this->username = $u;
		}

		//
		public function setNom ($n) {
			$this->nom = $n;
		}

		//
		public function setPrenom ($p) {
			$this->prenom = $p;
		}

		//
		public function setPhoto ($ph) {
			$this->photo = $ph;
		}

		//
		public function setAdresse ($a) {
			$this->adresse = $a;
		}

		//
		public function setTelephone ($t) {
			$this->telephone = $t;
		}

		//
		public function setMotDePasse ($mP) {
			$this->motDePasse = $mP;
		}

		//
		public function setValideParAdmin ($vA) {
			$this->valideParAdmin = $vA;
		}

		//
		public function setBanni ($b) {
			$this->banni = $b;
		}

		//
		public function setIdMoyenComm ($iMC) {
			$this->id_moyenComm = $iMC;
		}

		//
		public function setIdModePaiement ($iMP) {
			$this->id_modePaiement = $iMP;
		}
        
		//
		public function setAdminBan ($iAB) {
			$this->$id_adminBan = $iAB;
		}	

		//
		public function setAdminValid ($iAV) {
			$this->$id_adminValid = $iAV;
		}

	}

?>