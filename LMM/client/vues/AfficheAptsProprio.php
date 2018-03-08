<!--
* @file         /AfficheAptsProprio.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste d'appartements du proprio
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
<div class="row">
  <div id="resultatModifApt" class="col-sm-12">     
  </div>
</div> <!-- fin div row -->

<div class="resultat">
    <div class="row">        
        <?php 
		if($data["appartements"]){
			foreach($data["appartements"] as $appartement)
			{ 
		?>
				<div class="col-md-4 appart">

					<?php						
						if ($appartement->getPhotoPrincipale() != "") {
							$photoApt = $appartement->getPhotoPrincipale();
						} else {
							$photoApt = "./images/profil.jpg";
						}
												
					?> 
					<input type="hidden" value="<?=$appartement->username;?>" id="nomHote"/>  
					<!--<img src="./images/profil.jpg" alt="mon appart">-->
					<div class="thumbnail">
						<a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getId() ?>" >
						<img src="<?= $photoApt ?>" class="card-img-top photoAppartement img img-fluid thumbnail" alt="mon appart">
						</a>
				 
                        <div class="card-block">			
                         
                            <p class="card-text">Hôte: <?=$appartement->username;?></p>                        
                            <p class="card-text">                            
                                  <small><?= $appartement->getNbPersonnes(); ?>&nbsp<i class="fa fa-male fa-lg"></i>                        
                                    <?= $appartement->getNbChambres(); ?>&nbsp<i class="fa fa-square-o fa-lg"></i>            
                                    <?= $appartement->getNbLits(); ?>&nbsp<i class="fa fa-bed fa-lg"></i> </small>    
                            </p>
                            <h5 class="card-title"> <?=$appartement->getTitre();?></h5>
                            <p class="card-text">$<?=$appartement->getMontantParJour();?> par nuit</p>
                            <p class="card-text">
                                <?php
                                for($i=1; $i<=$appartement->moyenne/2; $i++)
                                {
                                ?>
                                <i class="fa fa-star"></i>
                                <?php
                                }
                                if($appartement->moyenne % 2 != 0)
                                {
                                ?>   
                                <i class="fa fa-star-half"></i>
                                <?php
                                }
                                ?>
                                <?php
                                if($appartement->moyenne == null) 
                                { 
                                ?>
                                    <i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i>
                                <?php

                                }
                                ?>
                                <small calss="text-muted"><?=$appartement->NbNotes;?></small>
                            </p>
                            <p> <?=$appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();?>
                            </p>
                    </div>
                </div>
				<?php 
					if($appartement->username == $_SESSION['username'])
					{
				?>
						<p class="card-text">
<!-- @ replacer -->         <p><a class="btn btn-primary" href="index.php?Appartements&action=afficherInscriptionApt&id=<?=$appartement->getId()?>" role="button">Modifier ce logis</a></p> 
<!-- @ replacer -->         <p><a value="<?=$appartement->getId()?>" class="btn btn-primary btnSuppressionApt" href="#" role="button">Supprimer ce logis</a></p> 
<!-- @ replacer -->         <p><a class="btn btn-primary" href="index.php?Appartements&action=afficherFormulaireImage&id=<?= $appartement->getId(); ?>" role="button">Ajout de photos</a></p> 

							<form>
								<input type="hidden" value="<?=$appartement->getId_userProprio()?>">
								<input classe="idAptSuppression" type="hidden" value="<?=$appartement->getId()?>">
								<button type="button" data-toggle="modal" data-target="#modal<?=$appartement->getId();?>"  class="btn btn-primary mb-2" >Disponibilite</button>
							</form>
						</p>
						<!-- Modal -->
						<div class="modal fade" id="modal<?=$appartement->getId()?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-animation="false">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header bg-primary">
										<h5 class="modal-title text-white" id="modal<?=$appartement->getId()?>">Disponibilité</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form class="form-inline">
											<label class="mr-sm-2">Date de debut</label><input type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" id="dateDebut<?=$appartement->getId()?>" >
											<label class="mr-sm-2">Date de fin</label><input type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" id="dateFin<?=$appartement->getId()?>">
											<button type="button" id="ajouterDispo<?=$appartement->getId()?>" value = "<?=$appartement->getId()?>" class="btn btn-success btnAjouterDispo">Ajouter</button>
											<table class="table table-hover table_dispo">
												<tbody>
													<tr id="dispoRes<?=$appartement->getId()?>">
														<th>Date de debut</th><th>Date de fin</th>
													</tr>
													<?php
													foreach( $appartement->disponibilite as $dispo) 
													{
													?>
													<tr id="ajoutDispoRes<?=$dispo['id'];?>"> 
														<td id="dateDebut<?=$dispo['id'];?>">
															<?=$dispo['dateDebut'];?>
														</td>
														<td id="dateFin<?=$dispo['id'];?>">
															<?=$dispo['dateFin']?>
														</td>
														<input type="hidden" name="id_apt" value="<?=$appartement->getId()?>">
														<td>
															<button type="button" class="btn btn-warning btnSupprimerDispo" id="btnSupprimerDispo<?=$dispo['id'];?>" value="<?=$dispo['id'];?>">Supprimer</button>
														</td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</form>
									</div>
									<div class="modal-footer bg-primary">
										<div id="erreurDispo<?=$appartement->getId()?>"></div>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			<?php
			}
		}
		?> 
	</div>
</div>