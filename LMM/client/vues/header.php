<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
	<title>Loue ma maison</title>	
    <meta name="description" content="TP architecture MVC">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>				
</head>
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
	    </ul>
	  </div>
	</nav>
	<?=$data['message']?>
	<?=$data['banni']?>
