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
	
	class ArrayValue implements JsonSerializable {
		public function __construct(array $array) {
			$this->array = $array;
		}

		public function jsonSerialize() {
			return $this->array;
		}
}

?>