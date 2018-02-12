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
    * @class    Appartement 
    * @details  Instancie un object de type Appartement
    *
    *   1 constructeur  |   getters & setters
    */
    class Appartement {
        
        // Attributs de la classe Appartement
        private $id;
        private $ville;
        //
        private $options;
        private $titre;
        private $descriptif;
        private $montantParJour;
        private $nbPersones;
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
        *   @param <string>        $options                options de l'appartement  
        *   @param <string>        $titre                  titre de l'annonce (mise en location)  
        *   @param <string>        $descriptif             description de l'appartement   
        *   @param <float>         $montantParJour         montant par jour    
        *   @param <int>           $nbPersones             nombre de personnes admises
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
        */  
        public function __construct($options = '', $title = '', $descriptif = '', $montantParJour = 0.00, $nbPersones = 0, $nbLits = 0, $nbChambres = 0 , $photoPrincipale = '', $noApt = '', $noCivique = 0,  $rue = '', $codePostal = '', $id_typeApt = 0, $id_userProprio = '', $id_nomQuartier = 0) {   
 
            $this->setOptions($options);
            $this->setTitre($titre);
            $this->setDescriptif($descriptif);
            $this->setMontantParJour($montantParJour);
            $this->setNbPersones($nbPersones);
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
        }

        // getters
        public function getId() {
            return $this->id;
        }
        public function getVille() {
            return $this->ville;
        }

        public function getOptions() {
            return $this->summary;
        }
        public function getTitle() {
            return $this->title;
        } 
        public function getDescriptif() {
            return $this->descriptif;
        }
        public function getMontantParJour() {
            return $this->montantParJour;
        }
        public function getNbPersones() {
            return $this->nbPersones;
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
        public function setOptions($o) {
            if (is_string($o) && trim($o)!="") {
                $this->options = $o;
            }
        }
        public function setTitle($t) {
            if (is_string($t) && trim($t)!="") {
                $this->title = $t;
            }
        } 
        public function setDescriptif($d) {
            if (is_string($d) && trim($d)!="") {
                $this->descriptif = $d;
            }
        }
        public function setMontantParJour($m) {
            if (is_float($m) && $m != 0)
            $this->montantParJour = $m;
        }
        public function setNbPersones($nb) {
            if (is_int($nb) && $nb != 0) {
                $this->nbPersones = $nb;
            }
        }
        public function setNbLits($l) {
            if (is_int($l) && $l != 0) {
                $this->nbLits = $l;
            }    
        }
        public function setNbChambres($nb) {
            if (is_int($nb) && $nb != 0) {
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
            if (is_int($no) && $no != 0) {
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
            if (is_int($t) &&  $t != 0) {
                $this->id_typeApt = $t;
            } 
        }
        public function setId_userProprio($u) {
/**/        if (is_string($u) && trim($u) != "") {
               $this->id_userProprio = $u; 
            }
        }
        public function setId_nomQuartier($n) {
            if (is_int($n) &&  $n != 0) {
                $this->id_nomQuartier = $n;
            }
        }  
    }

?>


               