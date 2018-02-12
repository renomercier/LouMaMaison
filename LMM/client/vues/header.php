<!--
* @file       	/header.php
* @brief 		Projet WEB 2
* @details 		
* @author     	Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version    	v.1 | fevrier 2018
-->

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Projet WEB 2 - Loue ma maison</title>	
	<!-- meta tags requis -->
	<meta charset="UTF-8">
    <meta name="description" content="ProjetWEB2">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap - CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<!-- src script js -->
   	<script type= "text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   	<script src="https://use.fontawesome.com/e58c171d55.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>			
</head>

<headder>
</header>

<body class="container">
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
		   <a class="navbar-brand" href="index.php">LE LOGO</a>
	    </div>
	    <ul class="nav navbar-nav">
      		<?php
			if(isset($_SESSION["username"]) && (in_array(1,$_SESSION["role"])||in_array(2,$_SESSION["role"])) && $_SESSION["isActiv"] ==1)			
			{
			?>
			 	<li><a href="index.php?Usagers">Usagers</a></li>
			<?php
			}
			?>
	      <li><a href="index.php?Usagers&action=<?=$data['log']?>"><?=$data['log']?></a></li>
	      <li><a href="index.php?Usagers&action=afficherInscriptionUsager">S'inscrire</a></li>
	    </ul>
	  </div>
	</nav>
	<?=$data['message']?>
	<?=$data['banni']?>
