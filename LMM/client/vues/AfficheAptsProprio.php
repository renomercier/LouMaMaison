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
				<div class="profil-aptProprio d-inline col-sm-4 appart">

					<?php						
						if ($appartement->getPhotoPrincipale() != "") {
							$photoApt = $appartement->getPhotoPrincipale();
						} else {
							$photoApt = "./images/profil.png";
						}
												
					?> 
					<input type="hidden" value="<?=$appartement->username;?>" id="nomHote"/>  
					
                    <!-- Detail d'un appartement -->
					<div class="thumbnail">
						<a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getId() ?>" >
						<img src="<?= $photoApt ?>" class="card-img-top photoAppartement img img-fluid thumbnail" alt="mon appart">
						</a>
				 
                        <div class="card-block">			

                            <h5><?=$appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();?> </h5>

                            <h5 class="card-text">Évalué à 
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
                            </h5>
                            <!--
                            <p>Logis situé au <?=$appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();?> </p>
                            -->
                        </div>
                        
                
				<?php 
					if($appartement->username == $_SESSION['username'])
					{
				?>

                        <br>
                        
                        <!-- Options de gestion d'un appartement -->
                        <div class="profil-aptProprio-opt row justify-content-around">
				            <div class="profilAptIcone d-inline">
                                <p><a class="" href="index.php?Appartements&action=afficherInscriptionApt&id=<?=$appartement->getId()?>"><i class="fa fa-pencil-square-o fa-2x"></i></a></p>
                            </div>
                            <div class="profilAptIcone d-inline">
                                <p><a id="<?=$appartement->getId()?>" class="btnSuppressionApt" href="#"><i class="fa fa-trash-o fa-2x"></i></a></p>
                            </div>
                            <div class="d-inline">                        
                                <div class="profil-aptIcone dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-picture-o fa-2x"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="" href="index.php?Appartements&action=afficherFormulaireImage&id=<?= $appartement->getId(); ?>">Ajouter une photo</a></li>
                                        <li><a class="" href="index.php?Appartements&action=afficheSuppressionPhotos&id=<?= $appartement->getId(); ?>">Retirer une photo</a></li>
                                    </ul>
                                </div>
                                
                            </div>
                            <div class="profilAptIcone d-inline">
                                <p><a value="<?=$appartement->getId()?>" class="" data-toggle="modal" data-target="#modal<?=$appartement->getId();?>" href="#" ><i class="fa fa-calendar fa-2x"></i></a></p>
                            </div>
                        </div>
        
                        <hr>
                        
                    </div>
        
						<!-- Modal Disponibilite -->
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