<!--
* @file         AfficheUsager.php
* @brief        Projet WEB 2
* @details      Affichage de profil d'usager - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<h1>Profil d'usager</h1>
<div class="container">
    <!-- Tout le monde peut voir -->
    <div id="photo"> <img src="<?=$data["usager"]->getPhoto() ?>"> </div>
    <div id="info_nom">
        <h3><?=$data["usager"]->getNom() ?> <?=$data["usager"]->getPrenom() ?></h3>
    </div>
    
    <!-- Les gens connectes -->
<?php 
    if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0) 
    {
?>
    <div id="info_contact">Moyen de contact : <?=$data["usager"]->getIdMoyenComm() ?></div>
    <div id="historique"><button class="btn btn-primary">Voyages</button></div>
    <div id="message"><button class="btn btn-primary">Envoyer un message</button></div>
    
    <!-- S'il y a des appartements en cas de proprio -->
        <?php 
            if($data["isProprio"]) {
        ?>
           <div id="mesappts" class="btn btn-primary"><button class="btn btn-primary">Appartements</button></div>
       <?php      
        }
        ?>
        
    <!-- Si c'est mon profil -->  
    <?php
        if($_SESSION["username"] == $_REQUEST["idUsager"]) {
    ?>
            <div id="info_plus">
                
               <p>Username : <?=$data["usager"]->getUsername();?></p> 
               <p>Adresse : <?=$data["usager"]->getAdresse();?></p> 
               <p>Téléphone : <?=$data["usager"]->getTelephone();?></p> 
               <p>Mode de paiement : <?=$data["usager"]->getIdModePaiement();?></p> 
  
            </div>
            <?php 
            if($data["isClient"]) 
            {
            ?>  
                
                <!-- s'i j'ai des réservations comme client -->
                <div id="reservations"><button class="btn btn-primary">Mes réservations</button></div>
               
            <?php 
            }
            ?>
                <button class="btn btn-info" id="<?=$_SESSION["username"]?>">Modifier le profil</button>
            <?php 
        }
    }
?>
</div>


 
    