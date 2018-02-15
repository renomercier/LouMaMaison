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


<div class="container">
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
				<div class="col-md-12" id="div_info_plus"></div>
				<div class="col-md-12" id="div_info_contact">Moyen de contact : </div>
				<div class="col-md-12" id="div_modif_profil"></div>
            </div>
        </div>
        <div class="col-md-8">
			<div class="row">
				<div class="col-md-6" id="div_messagerie"></div>
				<div class="col-md-6" id="div_action_admin"></div>
			</div>
			<div class="row">			
				<div class="col-md-12" id="div_historique"></div>
				<div class="col-md-12" id="div_reservations"></div>
				<div class="col-md-12" id="div_mes_appts"></div>
			</div>
		</div>
    </div>
</div>

 <!-- Les gens connectes -->           
            <?php                                    
                if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0) 
                {
            ?>
                <span id="info_contact"><?=$data["modeCommunication"][0]->moyenComm;?></span>
                <span id="historique"><button class="btn btn-primary mb-2">Voyages</button></span>
                <span id="messagerie"><button class="btn btn-primary mb-2"><?=$messagerie?></button></span>

                <!-- S'il y a des appartements en cas de proprio -->
                    <?php 
                        if($data["isProprio"]) {
                    ?>
                       <span id="mes_appts" class="btn btn-primary mb-2"><button class="btn btn-primary">Mes Appartements</button></span>
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
                           <p>Username : <?=$data["usager"]->getUsername();?></p> 
                           <p>Adresse : <?=$data["usager"]->getAdresse();?></p> 
                           <p>Téléphone : <?=$data["usager"]->getTelephone();?></p> 
                           <p>Mode de paiement : <?=$data["modePaiement"][0]->modePaiement;?></p> 
                        </span>
                        <?php 
                        if($data["isClient"]) 
                        {
                        ?>  

                        <!-- s'i j'ai des réservations comme client -->
                        <span id="reservations"><button class="btn btn-primary mb-2">Mes réservations</button></span>

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
							<span id="action_admin">
								<a href="index.php?Usagers&action=inversBan&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatBann?></a>
								<a href="index.php?Usagers&action=inversActiv&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatActiv?></a>
								<a href="index.php?Usagers&action=inversAdmin&idUsager=<?=$data["usager"]->getUsername()?>"><?=$etatAdmin?></a>
							</span>
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


 
    