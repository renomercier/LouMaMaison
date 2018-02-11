<?php
/**
* @file 		/modeles/Usager.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
    * @class    Usager 
    * @details  Instancie un object de type Usager
    *
    *   1 constructeur  |   getters & setters
    */
	class Usager 	{
		
		// Attributs de la classe Usager
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
		
		/**
        *   constructeur de la classe Usager
        *       
        *   @param <string>        $username               nom d'utilisateur  
        *   @param <string>        $nom                    nom   
        *   @param <string>        $prenom             	   prenom  
        *   @param <string>        $photo         	       photo profil utilisateur  
        *   @param <string>        $adresse                adresse de l'utilisateur
        *   @param <string>        $telephone              no de telephone de l'utilisateur
        *   @param <string>        $motDePasse             mot de passe de l'utilisateur
        *   @param <int>           $id_moyenComm           id du moyen de communication de l'utilisateur     
        *   @param <int>           $id_modePaiement        id du mode de paiement de l'utilisateur       
        */
		public function __construct($u = "", $n = "", $p = "", $ph = "", $a = "", $t = "", $mP = "", $iMC = 0, $iMP = 0) {			
			$this->setUsername($u);
			$this->setNom($n);
			$this->setPrenom($p);
			$this->setPhoto($ph);
			$this->setAdresse($a);
			$this->setTelephone($t);
			$this->setMotDePasse($mP);
			$this->valideParAdmin = false;
			$this->banni = false;
			$this->setIdMoyenComm($iMC);
			$this->setIdModePaiement($iMP);
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


		/*****   Setters   *****/

		//
		public function setUsername ($u) {
			if (is_string($u) && trim($u)!="") {
				$this->username = $u;
			}
		}
		//
		public function setNom ($n) {
			if (is_string($n) && trim($n)!="") {
				$this->nom = $n;
			}		
		}
		//
		public function setPrenom ($p) {
			if (is_string($p) && trim($p)!="") {
				$this->prenom = $p;
			}	
		}
		//
		public function setPhoto ($ph) {
			if (is_string($ph) && trim($ph)!="") {
				$this->photo = $ph;
			}
		}
		//
		public function setAdresse ($a) {
			if (is_string($a) && trim($a)!="") {
				$this->adresse = $a;
			}
		}
		//
		public function setTelephone ($t) {
			if (is_string($t) && trim($t)!="") {
				$this->telephone = $t;
			}
		}
		//
		public function setMotDePasse ($mP) {
			if (is_string($t) && trim($t)!="") {
				$this->motDePasse = $mP;
			}
		}
		//
		public function setValideParAdmin ($vA) {
			// validation
			$this->valideParAdmin = $vA;
		}
		//
		public function setBanni ($b) {
			// validation
			$this->banni = $b;
		}
		//
		public function setIdMoyenComm ($iMC) {
			if (is_int($iMC) &&  $iMC != 0) {
				$this->id_moyenComm = $iMC;
			}
		}
		//
		public function setIdModePaiement ($iMP) {
			if (is_int($iMP) &&  $iMP != 0) {
				$this->id_modePaiement = $iMP;
			}
		}

	}

?>