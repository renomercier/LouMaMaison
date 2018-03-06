<?php
/**
* @file         /Appartement.php
* @brief        Projet WEB 2
* @details                              
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018  
*/

    /**
    * @class    Appartement 
    * @details  Instancie un object de type Appartement
    *
    *   1 constructeur  |   getters & setters
    */
    class Appartement {
        
        // Attributs de la classe Appartement
        private $id;
        private $actif;
        private $ville;
        private $options;
        private $titre;
        private $descriptif;
        private $montantParJour;
        private $nbPersonnes;
        private $nbLits;
        private $nbChambres;
        private $photoPrincipale;
        private $noApt;
        private $noCivique;
        private $rue;
        private $codePostal;
        private $id_typeApt;
        private $id_userProprio;
        private $id_nomQuartier;


        /**
        *   constructeur de la classe Appartement
        *       
        *   @param <int>           $id                     l'id de l'appartement  
        *   @param <string>        $options                options de l'appartement   
        *   @param <string>        $titre                  titre de l'annonce (mise en location)  
        *   @param <string>        $descriptif             description de l'appartement   
        *   @param <float>         $montantParJour         montant par jour    
        *   @param <int>           $nbPersonnes            nombre de personnes admises
        *   @param <int>           $nbLits                 nombre de lits
        *   @param <int>           $nbChambres             nombre de chambres 
        *   @param <string>        $photoPrincipale        photo principale de l'appartement     
        *   @param <string>        $noApt                  numero d'appartement 
        *   @param <int>           $noCivique              numero civique
        *   @param <string>        $rue                    nom de rue 
        *   @param <string>        $codePostal             code postal de l'appartement   
        *   @param <string>        $id_typeApt             type d'appartement
        *   @param <string>        $id_userProprio         usager proprietaire de l'appartement    
        *   @param <string>        $id_nomQuartier         nom du quartier ou est situe l'appartement 
        *   @param <bool>          $actif                  si l'appartement est actif 
        *   @param <string>        $ville                  la ville de l'appartement       
        */  
        public function __construct($id = 0, $options = '', $titre = '', $descriptif = '', $montantParJour = 0.00, $nbPersonnes = 0, $nbLits = 0, $nbChambres = 0 , $noApt = '', $noCivique = 0,  $rue = '', $codePostal = '', $id_typeApt = 0, $id_userProprio = '', $id_nomQuartier = 0, $actif = 1, $photoPrincipale = "", $ville = "") {   
            
            $this->setId($id);
            $this->setOptions($options);
            $this->setTitre($titre);
            $this->setDescriptif($descriptif);
            $this->setMontantParJour($montantParJour);
            $this->setNbPersonnes($nbPersonnes);
            $this->setNbLits($nbLits);
            $this->setNbChambres($nbChambres);
            $this->setPhotoPrincipale($photoPrincipale);
            $this->setNoApt($noApt);
            $this->setNoCivique ($noCivique );
            $this->setRue($rue);
            $this->setCodePostal($codePostal);
            $this->setId_typeApt($id_typeApt);
            $this->setId_userProprio($id_userProprio);
            $this->setId_nomQuartier($id_nomQuartier);
            $this->setActif($actif);
            $this->setVille($ville);
        }

        // getters
        public function getId() {
            return $this->id;
        }
        public function getActif() {
            return $this->actif;
        }
        public function getVille() {
            return $this->ville;
        }
        public function getOptions() {
            return $this->options;
        }
        public function getTitre() {
            return $this->titre;
        } 
        public function getDescriptif() {
            return $this->descriptif;
        }
        public function getMontantParJour() {
            return $this->montantParJour;
        }
        public function getNbPersonnes() {
            return $this->nbPersonnes;
        }
        public function getNbLits() {
            return $this->nbLits;
        }
        public function getNbChambres() {
            return $this->nbChambres;
        }
        public function getPhotoPrincipale() {
            return $this->photoPrincipale;
        }
        public function getNoApt() {
            return $this->noApt;
        }
        public function getNoCivique() {
            return $this->noCivique;
        }
        public function getRue() {
            return $this->rue;
        }
        public function getCodePostal() {
            return $this->codePostal;
        }
        public function getId_typeApt() {
            return $this->id_typeApt;
        }
        public function getId_userProprio() {
            return $this->id_userProprio;
        }
        public function getId_nomQuartier() {
            return $this->id_nomQuartier;
        }
        
        // setters
        public function setId($id) {
            if (is_int(intval($id)) && intval($id) != 0) {
                $this->id = $id;
            }
        }
        public function setActif($a) {
            if ($a == 0 || $a == 1) {
                $this->actif = $a;
            }
        }
        public function setVille($v) {
            if (is_string($v) && trim($v)!="") {
                $this->ville = $v;
            }
        }
        public function setOptions($o) {
            if (is_string($o) && trim($o)!="") {
                $this->options = $o;
            }
        }
        public function setTitre($t) {
            if (is_string($t) && trim($t)!="") {
                $this->titre = $t;
            }
        } 
        public function setDescriptif($d) {
            if (is_string($d) && trim($d)!="") {
                $this->descriptif = $d;
            }
        }
        public function setMontantParJour($m) {
            if (is_float(floatval($m)) && floatval($m) != 0)
            $this->montantParJour = $m;
        }
        public function setNbPersonnes($nb) {
            if (is_int(intval($nb)) && intval($nb) != 0) {
                $this->nbPersonnes = $nb;
            }
        }
        public function setNbLits($l) {
            if (is_int(intval($l)) && intval($l) != 0) {
                $this->nbLits = $l;
            }    
        }
        public function setNbChambres($nb) {
            if (is_int(intval($nb)) && intval($nb) != 0) {
                $this->nbChambres = $nb;
            }
        }
        public function setPhotoPrincipale($p) {
            if (is_string($p) && trim($p) != "") {
                $this->photoPrincipale = $p;
            }
        }
        public function setNoApt($no) {
            if (is_string($no) && trim($no) != "") {
                $this->noApt = $no;
            }
        }
        public function setNoCivique($no) {
            if (is_int(intval($no)) && intval($no) != 0) {
                $this->noCivique = $no;
            }
        }
        public function setRue($r) {
            if (is_string($r) && trim($r) != "") {
                $this->rue = $r;
            }
        }
        public function setCodePostal($c) {
            if (is_string($c) && trim($c) != "") {
                $this->codePostal = $c;
            }     
        }
        public function setId_typeApt($t) {
            if (is_int(intval($t)) &&  intval($t) != 0) {
                $this->id_typeApt = $t;
            } 
        }
        public function setId_userProprio($u) {
            if (is_string($u) && trim($u) != "") {
               $this->id_userProprio = $u; 
            }
        }
        public function setId_nomQuartier($n) {
            if (is_int(intval($n)) &&  intval($n) != 0) {
                $this->id_nomQuartier = $n;
            }
        }  
    }

?>             