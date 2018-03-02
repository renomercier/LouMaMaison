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
    
	<!-- Modal disponibilite -->
    <div class="modal fade" id="modal<?= $data['appartement']->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-animation="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
				<div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modal<?= $data['appartement']->getId(); ?>">Disponibilité</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				        <span aria-hidden="true">&times;</span>
					</button>
				</div>
                
				<div class="modal-body">
				    <form class="form-inline">
				        <label class="mr-sm-2">Date de debut</label><input type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" id="dateDebut<?= $data['appartement']->getId(); ?>" >
				        <label class="mr-sm-2">Date de fin</label><input type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" id="dateFin<?= $data['appartement']->getId(); ?>">
				        <button type="button" id="ajouterDispo<?= $data['appartement']->getId(); ?>" value = "<?= $data['appartement']->getId(); ?>" class="btn btn-success btnAjouterDispo">Ajouter</button>
				        <table class="table table-hover table_dispo">
				            <tbody>
								<tr id="dispoRes<?= $data['appartement']->getId(); ?>">
								    <th>Date de debut</th>
                                    <th>Date de fin</th>
								</tr>
								<?php
								    foreach( $data["tab_dispos"] as $dispo) 
								    {
								?>
								<tr id="ajoutDispoRes<?=$dispo['id'];?>"> 
									<td id="dateDebut<?=$dispo['id'];?>"> <?=$dispo['dateDebut'];?> </td>
								    <td id="dateFin<?=$dispo['id'];?>">  <?=$dispo['dateFin']?> </td>
								    <input type="hidden" name="id_apt" value="<?= $data['appartement']->getId(); ?>">
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
				    <div id="erreurDispo<?= $data['appartement']->getId(); ?>"></div>
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
				</div>
                
            </div>
        </div>
    </div>
    
    
    
    
    <!-- Modal du carousel de photos -->
    <div class="modal fade" id="modalGaleriePhoto" tabindex="-1" role="dialog" aria-labelledby="modalPhotoSupp" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <div class="pull-left">Galerie de photos</div>
            <h4 class="modal-title" id="myModalLabel"><?= $data['appartement']->getTitre() ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          
          <div class="modal-body">
             
            <!--begin carousel-->
            <div id="maGalerie" class="carousel slide" data-ride="false">
                
                <ol class="carousel-indicators">                   
                <?php
                    $nbrP = 0;
					foreach($data["tab_photos"] as $photo) {
                                
                        if($nbrP==0) {
				?>                  
                        <li data-target="#maGalerie" data-slide-to="0" class="active"></li>                    
                    <?php
                        } else {
				    ?>                      
                        <li data-target="#maGalerie" data-slide-to="<?= $nbrP ?>"></li>
				<?php
                        }
                        $nbrP++;
                    }
                    reset($data["tab_photos"]);
				?>                  
                </ol>
              
              <div class="carousel-inner" role="listbox">

                <?php
                    $nbrP = 0;
					foreach($data["tab_photos"] as $photo) {
                                
                        if($nbrP==0) {
				?>
                  
                        <div class="carousel-item active"> 
                            <img src="<?= $photo['photoSupp'] ?>" class="aptPhotoModal d-block img img-fluid" alt="photoGalerie<?= $nbrP ?>">
                            <!--
                            <div class="carousel-caption">
                                <h3>Heading 3</h3>
                                <p>Photo numéro <?= $nbrP ?></p>
                            </div>
                            -->
                        </div>
                  
                    <?php
                        } else {
				    ?>    
                  
                        <div class="carousel-item"> 
                            <img src="<?= $photo['photoSupp'] ?>" class="aptPhotoModal d-block img img-fluid" alt="photoGalerie<?= $nbrP ?>">
                            <!--
                            <div class="carousel-caption">
                                <h3>Heading 3</h3>
                                <p>Photo numéro <?= $nbrP ?></p>
                            </div>
                            -->
                        </div>

				<?php
                        }
                        $nbrP++;
                    }
                    reset($data["tab_photos"]);
				?>  
                            
                <!--end carousel-inner-->
              </div>
                
              <!--Begin Previous and Next buttons-->
              <a class="carousel-control-prev" href="#maGalerie" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </a> 
              <a class="carousel-control-next" href="#maGalerie" role="button" data-slide="next"> 
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </a>
            
            <!--end carousel-->
            </div>              

          
          <!-- end modal-body -->
          </div>
          
          <div class="modal-footer">
            <div class="pull-left"><small>Photographies par le propriétaire</small></div>
            <button type="button" class="btn-sm btn-default" data-dismiss="modal">Fermer</button>
          </div>
            
        <!-- end modal-content -->
        </div>
    
      <!-- end modal-dialog -->
      </div>
    
    <!--end modal -->
    </div>
    

    <section class="row sectionAptPhoto">
        
		<!-- Affichage des messages a l'usager -->
        <div class="col-sm-12 succes_erreur">            
        </div>
        
		<!-- Affichage des photos de l'appartement -->
        <div class="col-sm-12 photo_principale">
		
			<h1>Affichage d'un appartement</h1>
		
			<!-- Affichage de la photo principale -->
			<div>
                <div id="photoPrincipale">
                    <img src="<?= $data['appartement']->getPhotoPrincipale() ?>" class="aptPhotoPrincipale img img-fluid">
                </div>
            </div>

			<!-- Affichage des photos supplementaires -->
			<div class = "row">
				<div class="text-center col-xs-2 col-md-12">
				
				<?php
                    $nbrP = 0;
					foreach($data["tab_photos"] as $photo) {
				?>
						<div class="d-inline" data-toggle="modal" data-target="#modalGaleriePhoto">
                            <a href="#maGalerie" data-slide-to="<?= $nbrP ?>">
                                <img src="<?= $photo['photoSupp'] ?>" class="aptPhotoSupp img-thumbnail img-fluid" alt="Photo-<?= $nbrP ?>">
                            </a>
						</div>
				<?php
                    $nbrP++;
					}
				?>
				
				</div>

			</div>
			
        </div>

        <!-- Fin row -->    
    </section>
    
    
    <section class="sectionAptDetail d-flex">    
        <div class="sectionAptDetail-g col-sm-8">
            <br>
            <div class="row justify-content-between">
                <div class="d-inline">
                    <h6><?= $data['typeApt'][0]['typeApt']; ?></h6>
                    <h2><?= $data['appartement']->getTitre(); ?></h2>
                    <h4><?= $data['quartier'][0]['nomQuartier']; ?></h4>
                    <p><?= $data['appartement']->getVille(); ?></p>
                </div>
                <div class="">
                    <div class="text-center align-middle">
                        <img src="<?= $data['proprietaire']->getPhoto(); ?>" class="aptPhotoProprio rounded-circle img-fluid" alt="PhotoProprio">

                        <!--<img src="/images/profil.jpg" class="aptProprio rounded-circle img-fluid" alt="PhotoProprio">-->

                        <p><?= $data['appartement']->getId_userProprio() ?></p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="iconeAptDescription">
                    <p><i class="fa fa-male fa-lg"></i>&nbsp<?= $data['appartement']->getNbPersonnes(); ?> personnes</p>
                </div>
                <div class="iconeAptDescription">
                    <p><i class="fa fa-square-o fa-lg"></i>&nbsp<?= $data['appartement']->getNbChambres(); ?> chambres</p>
                </div>
                <div class="iconeAptDescription">
                    <p><i class="fa fa-bed fa-lg"></i>&nbsp<?= $data['appartement']->getNbLits(); ?> lits</p>
                </div>
            </div>
            
            <hr>
            
            <div class="d-block">
                <div class="d-inline">
                    <p><?= $data['appartement']->getDescriptif(); ?></p>
                </div>
            </div>
            
   		  <?php

	        if( (isset($_SESSION["username"])) && (($_SESSION["username"]) == $data['proprietaire']->getUsername()) )
          {
          ?>
            
            <div class="d-block">
                <button type='button' disabled id='btnContactProprio' onclick='???' class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
            </div>
            
        <?php
            } else {
        ?>
                
            <div class="d-block">
                <button type='button' id='btnContactProprio' onclick='???' class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
            </div>  
      
        <?php
            }
        ?>
            
            <hr>
            
            <div class="aptEquipements d-block">
                <h5 class="row">Équipements / fonctionnalités</h5>
                <div class="row">
                    <div class="d-inline col-sm-6">
                        <img src="./icones/griller.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">blablablablabla...</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/griller.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">blablablablabla...</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/griller.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">blablablablabla...</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/griller.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">blablablablabla...</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/griller.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">blablablablabla...</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/griller.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">blablablablabla...</p>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="aptReglement d-block">
                <h5 class="row">Règlement intérieur</h5>
                <div class="row">
                    <div class="d-inline col-sm-6">
                        <img src="./icones/no-smoking.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">Non fumeur</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/043-dog.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">Animaux permis</p>
                    </div>
                </div>
                <div class="">
                    <p>C'est selon...</p>
                    <p>Bacon ipsum dolor amet spare ribs pork loin ribeye shank kevin beef chicken strip steak burgdoggen leberkas. Venison t-bone short ribs buffalo spare ribs, pork chop brisket boudin chicken jerky shankle drumstick hamburger ground round turkey. Beef ribeye rump doner fatback. Cow filet mignon tongue, capicola ball tip cupim shankle meatball bacon pancetta andouille pork loin swine jowl bresaola.</p>
                </div>
            </div>
            
            <hr>
            
            <div class="aptAnnulation d-block">
                <h5 class="row">Annulation</h5>
                <div class="">
                    <p>Strictes.</p>
                    <p>Vestibulum nec dignissim sem, quis cursus sapien. Nam ac orci a nulla finibus laoreet hendrerit id ligula. Nunc at augue vel ligula tristique scelerisque a id urna. Nulla eget nunc et orci vehicula tempor at non augue. Quisque leo erat, semper ac vehicula sed, vulputate vitae quam. Curabitur sed mauris id tellus ultrices euismod. Cras pharetra eros a massa faucibus malesuada. Proin hendrerit ultricies enim, et vulputate ligula sodales luctus. Nunc a urna accumsan, tempus felis at, efficitur magna.</p>
                </div>
            </div>
            
            <hr>
            
            <div class="d-block">
                <h5  class="row">Accèssibilité</h5>
                <div class="row">
                    <div class="d-inline col-sm-6">
                        <img src="./icones/elevator.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">Ascenseur</p>
                    </div>
                    <div class="d-inline col-sm-6">
                        <img src="./icones/013-sign-1.svg" class="aptIcones img-fluid" alt="Icone">
                        <p class="d-inline">Handicap</p>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <h5>Commentaires</h5>
            </div>
            
        </div>
        
        <div class="sectionAptDetail-d col-sm-4 sticky">
            <br>

             <?php
                if( (isset($_SESSION["username"])) && (($_SESSION["username"]) == $data['proprietaire']->getUsername()) )
                {
             ?>
            
                <div class="aptModification col-sm-12">
            
                    <div class="">                     
                        <p><a class="btn btn-block btn-primary btn-lg" href="index.php?Appartements&action=afficherInscriptionApt&id=<?= $data['appartement']->getId(); ?>" role="button">Modifier cet appartement</a></p> 
                    </div>
                    <hr>
                    <div class="">
                        <button type="button" data-toggle="modal" data-target="#modal<?= $data['appartement']->getId() ;?>"  class="btn btn-block btn-primary btn-lg" >Gérer les disponibilités</button>
                    </div>
                    
                </div>
            
            <?php
                } else {
            ?>
                <div class="aptReservation col-sm-12">
                    <h4>$<?= $data['appartement']->getMontantParJour(); ?> CAD <small>par nuit</small></h4>
                    <h6>Ratings
                        <?php
                            for($i=1; $i<=$data['moyenneApt']['moyenne']/2; $i++)
                            {
                        ?>
                                <i class="fa fa-star"></i>
                        <?php
                            }
                            if($data['moyenneApt']['moyenne'] % 2 != 0)
                            {
                                         ?>   
                                <i class="fa fa-star-half"></i>
                        <?php
                            }
                        ?>
                        <?php
							if($data['moyenneApt']['moyenne'] == null) 
							{ 
						?>
								<i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i>
						<?php
							}
				        ?>
                        <?= $data['moyenneApt']['nbr_votant'] ;?>
                    </h6>
                    <hr>
                    <!--
                    <div class="aptDisponibilites">
                        <h4 class="text-center">Disponibilités</h4>

                        <?php
                            $nbrD = 0;
                            foreach($data["tab_dispos"] as $dispo) {
                                $nbrD++;
                        ?>
                                <p><?= $nbrD; ?>. Du: <?= $dispo['dateDebut'] ?>  Au: <?= $dispo['dateFin'] ?></p>
                        <?php
                           }
                        ?>
                    </div>
                    <hr>
                    -->                
                    <div class="demandeReservation">
                        <form id="formApt" method="POST" action="index.php?Appartements&action=sauvegarderApt">
                            <!-- Date d'arrivée -->
                            <div class="form-group">
                                <div class="row">
                                    <label for="dateArrivee">Date d'arrivée</label>
                                    <input type="date" name="dateArrivee" id="dateArrivee" size="8" class="form-control text-muted" aria-describedby="aideDateArrivee">
                                    <small class="form-text text-muted" id="aideDateArrivee"></small>
                                </div>
                            </div>
                            <!-- Date de départ -->
                            <div class="form-group">
                                <div class="row">
                                    <label for="dateDepart">Date de départ</label>
                                    <input type="date" name="dateDepart" id="dateDepart" size="8" class="form-control text-muted" aria-describedby="aideDateDepart">
                                    <small class="form-text text-muted" id="aideDateDepart"></small>
                                </div>
                            </div>
                            <!-- Nombre de personnes -->
                            <div class="form-group">
                                <div class="row">
                                    <label for="nbPersonnes">Nombre de personnes</label>
                                    <select class="form-control text-muted" name="nbPersonnes" id="nbPersonnes" aria-describedby="aideNbPersonnes">
                                        <option selected>Sélectionnez</option>
                                        <?php
                                            for ($i = 1; $i <= $data['appartement']->getNbPersonnes(); $i++) {
                                                echo $i;
                                                echo "<option value=" . $i . ">" . $i . "</option>";
                                            }
                                        ?>         
                                    </select>
                                    <small class="form-text text-muted" id="aideNbPersonnes"></small>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary btn-block btn-lg" id="inputSubmit" value="Demande de réservation">						
                        </form>
                    </div>
                    <p class="text-center"><small>Vous ne serez débité que si vous confirmez</small></p>
                    <hr>
                </div>
            
            <?php
                }
            ?>   
            
        </div>
        

    
        <!-- Fin d-flex -->    
    </section>
    
    <!-- Fin container -->
</div> 