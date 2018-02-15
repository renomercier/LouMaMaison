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
<meta charset="UTF-8">
	<title>Projet WEB 2 - Loue ma maison</title>	

	<!-- meta tags requis -->
	<meta charset="UTF-8">
    <meta name="description" content="ProjetWEB2">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap - CSS -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<!-- src script js -->
   	<script src="https://use.fontawesome.com/e58c171d55.js"></script>

</head>
<header>
</header>

<body class="container">
    <nav class="navbar sticky-top navbar-toggleable-md navbar-light bg-faded">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="index.php">LE LOGO</a>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
            </li>
      		<?php

			if(isset($_SESSION["username"])) 
            {
                if((in_array(1,$_SESSION["role"])||in_array(2,$_SESSION["role"])) && $_SESSION["isActiv"] ==1)
                {
			?>
			 	<li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=afficheListeUsagers">Usagers</a></li>
			<?php
                }
                ?>
            <li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=afficheUsager&idUsager=<?=$_SESSION['username']?>">Profil</a></li>
			<?php
            }
            else{
                ?>
                <li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=afficherInscriptionUsager">S'inscrire</a></li>
            <?php
            }
			?>
        
                <li class="nav-item"><a class="nav-link" href="index.php?Usagers&action=<?=$data['log']?>"><?=$data['log']?></a></li>

            


	    </ul>
          
      </div>
</nav>
	<?=$data['message']?>
	<?=$data['banni']?>