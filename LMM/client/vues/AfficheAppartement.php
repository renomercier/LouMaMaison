<!--
* @file         AfficheAppartement.php
* @brief        Projet WEB 2
* @details      Affichage de profil d'usager - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<?php              
    //$messagerie = (isset($_SESSION["username"]) && $_SESSION["username"] == $data["usager"]->getUsername()) ? "Messagerie" : "Contacter";
 ?>


<div class="container detailAppartement">

    <div class="row">
        
		<!-- Affichage des messages a l'usager -->
        <div class="col-sm-12 succes_erreur">            
        </div>
        
		<!-- Affichage des photos de l'appartement -->
        <div class="col-sm-12 photo_principale">
		
			<h1>Affichage d'un appartement</h1>
		
			<!-- Affichage de la photo principale -->
			<div>
                <div id="photoPrincipale"> <img src="<?= $data["appartement"]->getPhotoPrincipale() ?>" class="img img-fluid"> </div>
            </div>

			<!-- Affichage des photos supplementaires -->
			<div class = "d-inline">
				<div style="width: 10%; height: 10%">
				
				<?php
					foreach($data["tab_photos"] as $photo) {
				?>
						<div class="col-xs-2">
						  <img src="<?= $photo['photoSupp'] ?>" class="img-thumbnail img-fluid" alt="Photo Supplementaire">
						</div> 
				<?php
					}
				?>
				
				</div>
			</div>
			
        </div>
		
		
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div id="photo"> <img src="<?=$data["usager"]->getPhoto() ?>" class="img img-fluid"> </div>
                </div>
                <div class="col-md-6" id="div_info_nom">
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
									<td>Prénom</td><td><input type="text" name="prenom" id="prenom" value="<?= isset($data['prenom']) ? $data['prenom'] : '' ?>"><small class="form-text text-muted" id="aidePrenom"></small></td>
								</tr>
								
								<tr>
									<td>Nom</td><td><input type="text" name="nom" id="nom" value="<?= isset($data['nom']) ? $data['nom'] : '' ?>"><small class="form-text text-muted" id="aideNom"></small></td>			
								</tr>
								
								<tr>
									<td>Adresse</td><td><input type="text" name="adresse" id="adresse" value="<?= isset($data['adresse']) ? $data['adresse'] : '' ?>"><small class="form-text text-muted" id="aideAdresse"></small></td>
								</tr>
								
								<tr>
									<td>Téléphone</td><td><input type="text" name="telephone" id="telephone" value="<?= isset($data['telephone']) ? $data['telephone'] : '' ?>"><small class="form-text text-muted" id="aideTel"></small></td>
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
                                        <small class="form-text text-muted" id="aideModePaiement"></small>
									</td>
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
                                        <small class="form-text text-muted" id="aideMoyenComm"></small>
									</td>
                                </tr>
								
                                <tr>
                                    <td>Mot de passe</td><td><input type="password" name="pwd0" id="pwd0"><small class="form-text text-muted" id="aidePwd0"></small></td>
                                </tr>
								
                                <tr>
                                    <td>Confirmer le mot de passe</td><td><input type="password" name="pwd1" id="pwd1"><small class="form-text text-muted" id="aidePwd1"></small></td>
                                </tr>
								
                                <tr>								
							</tbody>
						</table>
						<input type="hidden" name="idUser" value="<?=$_SESSION["username"]?>">
						<button type="button" id="submit_form<?=$_SESSION["username"]?>" class="btn btn-success sauvegarderForm">Save changes</button>
					</form>
				  </div>
				  <div class="modal-footer bg-primary">
                      <div class="erreurModif"></div>
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

 