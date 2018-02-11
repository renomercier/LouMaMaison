<?php
/**
* @file 		/modeles/DBFactory.php
* @brief 		Projet WEB 2
* @details								
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018 	
*/

	/**
	* @class 	BDFactory
	* @details 	Classe qui gere la connection avec la DB 
	*
	* 1 methode	|	getDB()
	*/
	class DBFactory
	{
		/**
		* @brief      Definit la connexion a la BD selon les parametres suivants:
		* @param      <STRING>  	$typeBD		le type de BD
		* @param      <STRING>  	$dbName 	le nom de la BD
		* @param      <STRING>  	$host 		hostname ou numero
		* @param      <STRING>  	$user 		nom d'utilisateur
		* @param      <STRING>  	$pwd 		mot de passe
		* @return     <type>  		( connexion a la BD )
		*/
		public static function getDB($typeBD, $dbName, $host, $user, $pwd)
		{
			if($typeBD == "mysql")
			{
				$laDB = new PDO("mysql:host=$host;dbname=$dbName", $user, $pwd);
			}
			else if($typeBD == "oracle")
			{
				$laDB = new PDO("oci:host=$host;dbname=$dbName", $user, $pwd);		
			}
			else
				trigger_error("Le type de BD spécifié n'est pas supporté.");
			//else if...
			
			$laDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$laDB->exec("SET NAMES 'utf8'");
			return $laDB;			
		}
	}		
?>

