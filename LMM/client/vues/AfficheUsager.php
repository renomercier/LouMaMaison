<!--
* @file         AfficheUsager.php
* @brief        Projet WEB 2
* @details      Affichage de profil d'usager - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<?php              
    $messagerie = (isset($_SESSION["username"]) && $_SESSION["username"] == $data["usager"]->getUsername()) ? "Messagerie" : "Contacter";
 ?>


<div class="container detail">
    <!-- Tout le monde peut voir -->
    <div class="row">
        <div class="row">
          <div class="col-sm-12">            
             <?= isset($data['succes']) ? $data['succes'] : '' ?>
          </div>
        </div> <!-- fin div row -->
        
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div id="photo"> <img src="<?=$data["usager"]->getPhoto() ?>" class="img img-fluid"> </div>
                </div>
                <div class="col-md-6" id="info_nom">
                    <h3><?=$data["usager"]->getNom() ?> <?=$data["usager"]->getPrenom() ?></h3>
                </div>
				<div id="profilUser" class="col-md-12">
					<form class="form">
						<div class="col-md-12 form-group row" id="div_info_plus"></div>
						<div class="col-md-12 form-group row" id="div_info_contact"></div>
						<div class="col-md-12 form-group row" id="div_modif_profil"></div>
					</form>
				</div>
				
			<!-- Modal -->
			<div class="modal fade" id="myModal<?=$_SESSION["username"]?>" role="dialog">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header bg-primary">
					<h3 class="modal-title">Modifier votre profil</h3>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>
				  <div class="modal-body">
				  <form id="modifierProfil<?=$_SESSION["username"]?>">
					   <table class="table table-hover">
							<tbody>
								<tr>
									<td>Prénom</td><td><input type="text" name="prenom" value="<?= isset($data['prenom']) ? $data['prenom'] : '' ?>"></td>
								</tr>
								<tr>
									<td>Nom</td><td><input type="text" name="nom" value="<?= isset($data['nom']) ? $data['nom'] : '' ?>"></td>
								</tr>
								<tr>
									<td>Adresse</td><td><input type="text" name="adresse" value="<?= isset($data['adresse']) ? $data['adresse'] : '' ?>"></td>
								</tr>
								<tr>
									<td>Téléphone</td><td><input type="text" name="telephone" value="<?= isset($data['telephone']) ? $data['telephone'] : '' ?>"></td>
								</tr>
								<tr>
									<td>
										<label for="moyenComm" class="form-control-label mr-sm-2">Moyen de contact</label>
									</td>
									<td>
										<select name="moyenComm" class="" id="moyenComm">
									   		<?php foreach($data['modeCommunicationGeneral'] AS $c) { 
													if(isset($data['modeCommunication'][0]->id )) { 
													  if($data['modeCommunication'][0]->id  == $c['id']) { ?>
														<option selected value=<?= $c['id'] ?>><?= $c['moyenComm'] ?></option>
											<?php     } 
													  else { ?>
													  <option value=<?= $c['id'] ?>><?= $c['moyenComm'] ?></option>
											<?php     }
													} 
													else { ?>
													  <option value=<?= $c['id'] ?>><?= $c['moyenComm'] ?></option>
											<?php   }
												  } ?>
											</select>
									</td>
								</tr>
								<tr>
									<td>
										<label for="paiement" class="form-control-label mr-sm-2">Type de paiement</label>
									</td>
									<td>
										<select class="" name="paiement" id="modePaiement">
									  <?php 
										foreach($data['modePaiementGeneral'] AS $p) {
											if(isset($data['modePaiement'][0]->id)) {
												if($data['modePaiement'][0]->id == $p['id']) { ?>
												  <option selected value=<?=  $p['id'] ?>><?= $p['modePaiement'] ?></option>
									  <?php     } 
												else { 
										?>
												  <option value=<?= $p['id'] ?>><?= $p['modePaiement'] ?></option>
									  <?php     }
											}
										
											  else { ?>
												<option value=<?= $p['id'] ?>><?= $p['modePaiement'] ?></option>
									  <?php   }
										}
											 ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" name="idUser" value="<?=$_SESSION["username"]?>">
						<button type="button" class="btn btn-success sauvegarder">Save changes</button>
					</form>
				  </div>
				  <div class="modal-footer bg-primary">
                      <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
                    
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
	
            </div>
                             
        </div>
        <div class="col-md-8">
			<div class="row  justify-content-end" >
                
                <ul class="nav menuProfil">
                    <li class="nav-item" id="div_messagerie"></li>
                    <li class="nav-item" id="div_historique"></li>
				    <li class="nav-item" id="div_reservations"></li>
				    <li class="nav-item" id="div_mes_appts"></li>
                
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
                <span id="info_contact"><div  class="form-group row">Moyen de contact : <?=$data["modeCommunication"][0]->moyenComm;?></div></span>
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
                           <div class="form-group row mb-0">Mode de paiement : <?=$data["modePaiement"][0]->modePaiement;?></div> 
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
                         <button type="button" class="btn btn-info mb-2 btn-modifier" data-toggle="modal" data-target="#myModal<?=$_SESSION["username"]?>"  id="ModifierProfil<?=$_SESSION["username"]?>">Modifier le profil</button>
						<?php
                         }

                 }

                        $etatBann = ($data["usager"]->getBanni()=="0") ? 'Bannir' : 'Réhabiliter';
                        $etatActiv = ($data["usager"]->getValideParAdmin()=="0") ? 'Activer' : 'Désactiver';
                        $etatAdmin = ($data["isAdmin"]) ? 'Déchoir' : 'Promouvoir';

                    foreach($data["usager"]->roles as $role)
                    {
                    ?> 
                       <span id="role">Role : <?=$role->nomRole?></span>

                    <?php
                    }
                    if(!$data["isSuperAdmin"])
                    {
                        if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$data["isAdmin"] && !$data["isSuperAdmin"]))
                        {
                        ?>	  
                            <li class="dropdown nav-item col-md-6" id="div_action_admin">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions Admin
                              </button>
                            </li>
                            <div id="action_admin" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                
                                <li><button class="btn btn-default actionAdmin" name="inversBan" id="<?=$data["usager"]->getUsername()?>"><?=$etatBann?></button></li>
                                <li><button class="btn btn-default actionAdmin" name="inversActiv" id="<?=$data["usager"]->getUsername()?>"><?=$etatActiv?></button> </li>
                                <li><button class="btn btn-default actionAdmin" name="inversAdmin" id="<?=$data["usager"]->getUsername()?>"><?=$etatAdmin?></button> </li>

                            </div>
							
                        <?php
                        }    
                    }
                }
            ?>

<script>
   
</script>


 
    