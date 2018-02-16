<!--
* @file         AfficheUsager.php
* @brief        Projet WEB 2
* @details      Affichage de profil d'usager - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

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
 ?>


<div class="container detail">
    <!-- Tout le monde peut voir -->
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div id="photo"> <img src="<?=$data["usager"]->getPhoto() ?>" style="width:80%"> </div>
                </div>
                <div class="col-md-6" id="info_nom">
                    <h3><?=$data["usager"]->getNom() ?> <?=$data["usager"]->getPrenom() ?></h3>
                </div>
                <form class="form">
                    <div class="col-md-12 form-group row" id="div_info_plus"></div>
                    <div class="col-md-12 form-group row" id="div_info_contact"></div>
                    <div class="col-md-12 form-group row" id="div_modif_profil"></div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
			<div class="row  justify-content-end" >
                
                <ul class="nav">
                    <li class="nav-item" id="div_messagerie"></li>
                    <li class="nav-item" id="div_historique"></li>
				    <li class="nav-item" id="div_reservations"></li>
				    <li class="nav-item" id="div_mes_appts"></li>
                    <li class="dropdown nav-item col-md-6" id="div_action_admin">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions Admin
                      </button>
                    </li>
                </ul>
			</div>
			<div class="row">
				<div></div>
			</div>
		</div>
    </div>
</div>

 <!-- Les gens connectes -->           
            <?php                                    
                if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0) 
                {
            ?>
                <div id="info_contact">Moyen de contact : <?=$data["modeCommunication"][0]->moyenComm;?></div>
                <a class="nav-link" href="#" id="historique">Voyages</a>
                <a class="nav-link" href="#" id="messagerie" ><?=$messagerie?></a>

                <!-- S'il y a des appartements en cas de proprio -->
                    <?php 
                        if($data["isProprio"]) {
                    ?>
                       <a class="nav-link" href="#" id="mes_appts">Appartements</a>
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
                        <span id="info_plus" class="">
                           <div class="form-group row">Username : <?=$data["usager"]->getUsername();?></div> 
                           <div class="form-group row">Adresse : <?=$data["usager"]->getAdresse();?></div> 
                           <div class="form-group row">Téléphone : <?=$data["usager"]->getTelephone();?></div> 
                           <div class="form-group row">Mode de paiement : <?=$data["modePaiement"][0]->modePaiement;?></div> 
                        </span>
                        <?php 
                        if($data["isClient"]) 
                        {
                        ?>  

                        <!-- s'i j'ai des réservations comme client -->
                        <a class="nav-link" href="#" id="reservations">Réservations</a>

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
                       <span id="role">Role : <?=$role->nomRole?></span>

                    <?php
                    }

                    if(!$isSuperAdmin)
                    {
                        if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$isAdmin && !$isSuperAdmin))
                        {
                        ?>	
							<div id="action_admin" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="index.php?Usagers&action=inversBan&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatBann?></a>
								<a class="dropdown-item" href="index.php?Usagers&action=inversActiv&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatActiv?></a>
								<a class="dropdown-item" href="index.php?Usagers&action=inversAdmin&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatAdmin?></a>
							</div>
                        <?php
                        }    
                    }

                }
            ?>

<script>
    $(document).ready(function() {
		$("#div_info_plus").append($("#info_plus"));
		
		$("#div_info_contact").append($("#info_contact"));
        
		$("#div_modif_profil").append($(".btn-modifier"));
		
		$("#div_messagerie").append($("#messagerie"));
		
		$("#div_action_admin").append($("#action_admin"));
		
		$("#div_historique").append($("#historique"));
		
		$("#div_reservations").append($("#reservations"));
		
		$("#div_mes_appts").append($("#mes_appts"));
        
    });
</script>


 
    