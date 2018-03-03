<?php
/**
* @file         /Message.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

	/**
    * @class    Message 
    * @details  Instancie un object de type Message
    *
    *   1 constructeur  |   getters & setters
    */
	class Message 
	{
		//attributs prives
		private $id;
		private $titre;
		private $sujet;
		private $dateHeure;
		private $id_userEmetteur;
        private $archive;
		
		//constructeur
		public function __construct($id = "", $titre = "", $sujet = "", $dateHeure = "", $id_userEmetteur = "", $archive=0)
		{
			$this->setId($id);
			$this->setTitre($titre);
			$this->setSujet($sujet);
			$this->setDateHeure($dateHeure);
			$this->setId_userEmetteur($id_userEmetteur);
            $this->setArchive($archive);
		}
		
		//getters 
		public function getId()
		{
			return $this->id;
		}
		
		public function getTitre()
		{
			return $this->titre;
		}
		
		public function getSujet()
		{
			return $this->sujet;
		}
		
		public function getDateHeure()
		{
			return $this->dateHeure;
		}
		
		public function getId_userEmetteur()
		{
			return $this->id_userEmetteur;
		}
        
        public function getArchive()
		{
			return $this->archive;
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
		
		public function setTitre($titre)
		{

			$this->titre = $titre;
		}
		
		public function setSujet($sujet) 
		{
            $this->sujet = $sujet;
		}
		
		public function setDateHeure($dateHeure)
		{
			$this->dateHeure = date("Y-m-d H:i:s");
		}
		
		public function setId_userEmetteur($id_userEmetteur)
		{
            $this->id_userEmetteur = $id_userEmetteur;
		}
        
        public function setArchive($archive)
		{
			 $this->archive = $archive;
		}

	}
?>