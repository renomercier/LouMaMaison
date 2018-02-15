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
    
    $isAdmin = false;
    $isSuperAdmin = false;

    foreach($data["usager"]->roles as $role)
    {
        if($role->id_nomRole == 1)
        {
            $isSuperAdmin = true;
        }
        if($role->id_nomRole == 2)
        {
            $isAdmin = true;
        }
    }

                          
    $messagerie = (isset($_SESSION["username"]) && $_SESSION["username"] == $data["usager"]->getUsername()) ? "Messagerie" : "Contacter";
    if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0) 
    {
?>
    <div id="info_contact">Moyen de contact : <?=$data["modeCommunication"][0]->moyenComm;?></div>
    <div id="historique"><button class="btn btn-primary mb-2">Voyages</button></div>
    <div id="message"><button class="btn btn-primary mb-2"><?=$messagerie?></button></div>
    
    <!-- S'il y a des appartements en cas de proprio -->
        <?php 
            if($data["isProprio"]) {
        ?>
           <div id="mesappts" class="btn btn-primary mb-2"><button class="btn btn-primary">Appartements</button></div>
       <?php      
        }
        ?>
        
    <!-- Si c'est mon profil je peux le voir avec toute l'info et Admin et SuperAdmin aussi-->  
    <?php
     
     if(isset($_SESSION["username"])) 
     {
        
        if((in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 || in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0) || ($_SESSION["username"] == $_REQUEST["idUsager"]) )  
        {
        ?>
            <div id="info_plus">
               <p>Username : <?=$data["usager"]->getUsername();?></p> 
               <p>Adresse : <?=$data["usager"]->getAdresse();?></p> 
               <p>Téléphone : <?=$data["usager"]->getTelephone();?></p> 
               <p>Mode de paiement : <?=$data["modePaiement"][0]->modePaiement;?></p> 
            </div>
            <?php 
            if($data["isClient"]) 
            {
            ?>  

            <!-- s'i j'ai des réservations comme client -->
            <div id="reservations"><button class="btn btn-primary mb-2">Mes réservations</button></div>
            
            <?php 
            }
        }
             if($_SESSION["username"] == $_REQUEST["idUsager"]) 
            {
            ?>
             <button class="btn btn-info mb-2 btn-modifier" id="ModifierProfil<?=$_SESSION["username"]?>">Modifier le profil</button>
            <?php
             }
         
     }
     
            $etatBann = ($data["usager"]->getBanni()=="0") ? 'Bannir' : 'Réhabiliter';
            $etatActiv = ($data["usager"]->getValideParAdmin()=="0") ? 'Activer' : 'Désactiver';
            $etatAdmin = ($isAdmin) ? 'Déchoir' : 'Promouvoir';

        foreach($data["usager"]->roles as $role)
        {
        ?> 
            <div><span>Role : <?=$role->nomRole?></span><span>  </span></div>

        <?php
        }

        if(!$isSuperAdmin)
        {
            if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$isAdmin && !$isSuperAdmin))
            {
            ?>
                <a href="index.php?Usagers&action=inversBan&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatBann?></a>
                <a href="index.php?Usagers&action=inversActiv&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatActiv?></a>
                <a href="index.php?Usagers&action=inversAdmin&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatAdmin?></a>
            <?php
            }    
        }
            
    }
?>


</div>


 
    