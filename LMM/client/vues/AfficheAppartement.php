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

<div class="container detailAppartement mt-5">
    
    <!-- affichage des messages a l'usager connecte concernant ses actions -->
    <div class="row">
      <div class="col-sm-12">
         <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
         <?= isset($data['succes']) ? $data['succes'] : '' ?>
      </div>
    </div> <!-- fin div row -->
    
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
    
    <!-- Section de l'affichage des photos de l'appartement -->
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

        <!-- Fin section photo -->    
    </section>
    
    <!-- Section de l'affichage du détail de l'appartement -->
    <section class="sectionAptDetail row">
        
        <!-- portion gauche de l'écran -->
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
                        <p><?= $data['appartement']->getId_userProprio(); ?></p>
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
            
                <?php
                    if( (isset($_SESSION["username"])) && (($_SESSION["username"]) == $data['proprietaire']->getUsername()) )
                  {
                  ?>

                    <div class="d-block">
                       <button type='button' disabled id='btnContactProprio' onclick="formulaireNouveauMessage('afficheInfoProfil')" class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
                    </div>

                <?php
                    } else {
                ?>

                    <div class="d-block">
                        <button type='button' id='btnContactProprio' onclick="formulaireNouveauMessage('afficheInfoProfil')" class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
                    </div>  

                <?php
                    }
                ?>
            
            </div>
                <!-- formulare de redaction d'un message -->
                <div id="profilUser">
                    <input type="hidden" name="idProprio" value="<?= $data['appartement']->getId_userProprio() ?>">
                    <div class="row" id="afficheInfoProfil"></div>
                </div> 
            <hr>
            
            <!-- affichage des equipements de l'appartememnt -->
            <div class="aptEquipements d-block">
                <h5 class="row">Équipements et fonctionnalités</h5>
                <div class="row">
                    
                    <?php
                        foreach($data["tab_options"] as $option) {
                            if  ($option['id'] > 4) {
                    ?>
                            
                            <div class="d-inline col-sm-6">
                                <div class="">
                                    <img src="<?= $option['icone']; ?>" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                    <p class="d-inline"><?= $option['option']; ?></p>
                                </div>
                                <br>
                            </div>
                                         
                <?php                    
                            }
                        }
                    reset($data["tab_options"]);
                ?>   

                </div>
            </div>
            
            <hr>
            
            <!-- affichage des reglements de l'appartememnt -->
            <div class="aptReglement d-block">
                <h5 class="row">Règlement intérieur</h5>
                
                <div class="row">
                    
                    <?php
                        foreach($data["tab_options"] as $option) {
                            
                            if  ($option['id'] == 4) {
                    ?>
                            
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="<?= $option['icone']; ?>" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline"><?= $option['option']; ?></p>
                                    </div>
                                    <br>
                                </div>
                                         
                    <?php
                                }
                        }
                        reset($data["tab_options"]);
                    ?>
                </div>
                
                <div class="">
                    <p>C'est selon...</p>
                    <p>Bacon ipsum dolor amet spare ribs pork loin ribeye shank kevin beef chicken strip steak burgdoggen leberkas. Venison t-bone short ribs buffalo spare ribs, pork chop brisket boudin chicken jerky shankle drumstick hamburger ground round turkey. Beef ribeye rump doner fatback. Cow filet mignon tongue, capicola ball tip cupim shankle meatball bacon pancetta andouille pork loin swine jowl bresaola.</p>
                </div>
            </div>
            
            <hr>
            
            <!-- affichage de la politique d'annulation de la réservation de l'appartememnt -->
            <div class="aptAnnulation d-block">
                <h5 class="row">Annulation</h5>
                <div class="">
                    <p>Strictes.</p>
                    <p>Vestibulum nec dignissim sem, quis cursus sapien. Nam ac orci a nulla finibus laoreet hendrerit id ligula. Nunc at augue vel ligula tristique scelerisque a id urna. Nulla eget nunc et orci vehicula tempor at non augue. Quisque leo erat, semper ac vehicula sed, vulputate vitae quam. Curabitur sed mauris id tellus ultrices euismod. Cras pharetra eros a massa faucibus malesuada. Proin hendrerit ultricies enim, et vulputate ligula sodales luctus. Nunc a urna accumsan, tempus felis at, efficitur magna.</p>
                </div>
            </div>
            
            <hr>
            
            <!-- affichage des accès à l'appartememnt -->
            <div class="aptAcces d-block">
                <h5  class="row">Accèssibilité</h5>
                <div class="row">
                    
                    <?php
                        foreach($data["tab_options"] as $option) {
                            
                            if  ($option['id'] <= 3) {
                    ?>
                            
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="<?= $option['icone']; ?>" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline"><?= $option['option']; ?></p>
                                    </div>
                                    <br>
                                </div>
                                         
                    <?php
                                }
                        }
                        reset($data["tab_options"]);
                    ?>
                </div>
            </div>
            
            <hr>
            
            <!-- affichage des commentaires de l'appartememnt -->
            <div class="aptCommentaires d-block">
                <h3 class="row"><?= $data['moyenneApt']['nbr_votant'] ;?> commentaire(s) &nbsp&nbsp<i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i></h3>
                
                <?php
                    foreach($data["tab_evals"] as $eval) {
                ?>
                        <hr>

                        <div class="row">
                            <div class="">
                                <img src="<?= $eval['photo']; ?>" class="aptPhotoComment rounded-circle img-fluid" alt="PhotoComment">
                            </div>
                            <div class="text-center">
                                <h5><?= $eval['username']; ?></h5>                          
                                <p><?= date('M Y',strtotime($eval['dateNotif']));; ?></p>
                            </div>
                            <div class="col-sm-12">
                                <p><?= $eval['commentaire']; ?></p>
                            </div>                           
                        </div>
                                         
                <?php
                    }
                ?>
                
            </div>
            
            <hr>
            
            <!-- affichage de l'hôte de l'appartememnt -->
            <div class="aptHote d-block">      
                <div class="row col-sm-12 justify-content-between">
                    <div class="d-inline">
                        <h3 class="row">Votre hôte : <?= $data['appartement']->getId_userProprio(); ?></h3>
                        <p>Membre autorisé LouMaMaison.</p>
                    </div>
                    <div class="d-inline">
                        <div class="text-center align-middle">
                            <img src="<?= $data['proprietaire']->getPhoto(); ?>" class="aptPhotoProprio rounded-circle img-fluid" alt="PhotoProprio">
                        </div>
                    </div>
                </div> 
                
                <div class="row align-middle">
                    <div class="d-inline col-sm-12 text-left">
                        <?php
                            if( (isset($_SESSION["username"])) && (($_SESSION["username"]) == $data['proprietaire']->getUsername()) )
                        {
                        ?>
                                <div class="d-block">
                                    <button type='button' disabled id='btnContactProprio' onclick="formulaireNouveauMessage('afficheInfoProfil2')" class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
                                </div>
                        <?php
                            } else {
                        ?>
                                <div class="d-block">
                                    <button type='button' id='btnContactProprio' onclick="formulaireNouveauMessage('afficheInfoProfil2')" class='btnContactProprio btn btn-primary btn-lg'>Contacter l'hôte</button>
                                </div>  
                        <?php
                            }
                        ?>
                    </div>
                    <!-- formulare de redaction d'un message -->                     
                </div>
                    <div>
                        <input type="hidden" name="idProprio" value="<?= $data['appartement']->getId_userProprio() ?>">
                        <div class="row" id="afficheInfoProfil2"></div>
                    </div> 
                </div> 
            <hr>
            
            <!-- affichage des politique de communication de l'appartememnt -->
            <div class="aptCommunication d-block">      
                <h5 class="row">Communiquez toujours via LouMaMaison</h5>
                <div class="">
                    <p>Il circule des centaines de versions différentes du Lorem ipsum, mais ce texte aurait originellement été tiré de l'ouvrage de Cicéron, De Finibus Bonorum et Malorum (Liber Primus, 32), texte populaire à cette époque, dont l'une des premières phrases est : « Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit... » (« Il n'existe personne qui aime la souffrance pour elle-même, ni qui la recherche ni qui la veuille pour ce qu'elle est... »).</p>
                </div>                              
            </div>
            
            <!-- affichage du quartier de l'appartememnt -->
            <div class="aptQuartier d-block">                 
                <h5 class="row">Le Quartier</h5>
                <div class="">
                    <p>Le logis de <?= $data['proprietaire']->getUsername(); ?> est situé à <strong><em><?= $data['appartement']->getVille(); ?></em></strong> dans le quartier <strong><em><?= $data['quartier'][0]['nomQuartier']; ?></em></strong></p>
                </div>
                            
                <div id="accordion" role="tablist" aria-multiselectable="true">
                  
                  <!-- affichage des informations sur le quartier de l'appartement -->
                  <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                      <h6 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Connaître le quartier
                        </a>
                      </h6>
                    </div>
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="card-block">
                          <p>Montréal est la plus grande ville de la province de Québec au Canada. Située sur une île du fleuve Saint-Laurent, elle doit son nom au mont Royal, la colline à trois sommets qui domine la ville. Ses arrondissements, dont la plupart étaient autrefois des villes indépendantes, comprennent des quartiers allant du Vieux-Montréal colonial français, avec la basilique Notre-Dame de style néogothique au centre, au très bohème Plateau-Mont-Royal.</p>
                          
                          <!-- affichage des moyens de transports disponibles -->
                          <div>
                            <h5>Transports disponibles</h5>
                            <div class="">
                              <div class="row">
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/taxi.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Taxi</p>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/metro.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Metro/autobus</p>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/bicycle.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Bixi</p>
                                    </div>
                                    <br>
                                </div> 
                              </div>
                            </div>
                          </div>
                          
                          <!-- affichage des services de proximité disponibles -->
                          <div>
                            <h5>Services disponibles à proximité</h5>
                            <div class="">
                              <div class="row">
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/groceries-1.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Marché</p>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/food-2.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Traiteur</p>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/pub.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Bistro/café</p>
                                    </div>
                                    <br>
                                </div>
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/shop.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Boutiques</p>
                                    </div>
                                    <br>
                                </div> 
                              </div>
                            </div>
                          </div>
                          
                          <!-- affichage des autres attraits disponibles -->
                          <div>
                            <h5>Autres</h5>
                            <div class="">
                              <div class="row">
                                <div class="d-inline col-sm-6">
                                    <div class="">
                                        <img src="./icones/bench.svg" class="aptIconesOptions d-inline img-fluid" alt="OptionAppartement">
                                        <p class="d-inline">Parc</p>
                                    </div>
                                    <br>
                                </div> 
                              </div>
                            </div>
                          </div>                     
                          
                      </div>
                    </div>
                  </div>
                  
                  <!-- affichage des activités disponibles dans la ville -->
                  <div class="card">
                    <div class="card-header" role="tab" id="headingTwo">
                      <h6 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Que faire à Montréal
                        </a>
                      </h6>
                    </div>
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="card-block">
                          <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                          
                          <!-- affichage des liens utiles dans la ville -->
                          <div>
                            <h5>Liens utiles</h5>
                            <ul>
                                <li><a href="https://www.mtl.org/fr" target="_blank" title="Découvrez Montreal">Tourisme Montréal</a></li>
                                <li><a href="http://ville.montreal.qc.ca/culture/mieux-connaitre-montreal" target="_blank" title="Mieux connaitre Montreal">Mieux connaître Montréal</a></li>
                                <li><a href="http://montreal-guidetouristique.com/" target="_blank" title="Guide touristique de Montreal">Guide touristique de Montréal</a></li>
                                <li><a href="http://museesmontreal.org/fr/musees" target="_blank" title="Guide des musees de Montreal">Guide des musées de Montréal</a></li>
                               <li><a href="https://www.uneparisienneamontreal.com/guide-bonnes-adresses/" target="_blank" title="Suggestion de restaurants">Suggestion de restaurants</a></li>
                            </ul>
                          </div>
                      </div>
                    </div>
                  </div>

                </div>
                
                <!-- affichage du quartier de l'appartememnt -->
                <div id="carteQuartier" class="col-sm-8">
                
                </div>
                
                <br>

            </div>
            
        </div>
        
        <!-- portion droite de l'écran -->
        <div class="sectionAptDetail-d col-md-4 flex-first flex-md-unordered">
            <br>
            
            <!-- Si l'usager est le proprio de l'appartement : affichage des boutons de gestion -->
            <?php
                if( (isset($_SESSION["username"])) && (($_SESSION["username"]) == $data['proprietaire']->getUsername()) )
                {
            ?>
            
                <div class="aptModification col-sm-12">
            
                    <div class="">                     
                        <p><a class="btn btn-block btn-primary btn-lg" href="index.php?Appartements&action=afficherInscriptionApt&id=<?= $data['appartement']->getId(); ?>" role="button">Modifier l'appartement</a></p> 
                    </div>
                    <hr>
                    <div class="">
                        <button type="button" data-toggle="modal" data-target="#modal<?= $data['appartement']->getId() ;?>"  class="btn btn-block btn-primary btn-lg" >Gérer les disponibilités</button>
                    </div>
                    
                </div>
            
            <?php
                } else {
            ?>
                <!-- Et sinon : affichage d'une demande de réservation -->
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
               
                    <div class="demandeReservation">
                        <form id="formReserveApt" method="POST" action="">
                            <!-- Date d'arrivée -->
                            <div class="form-group">
                                <div class="row">
                                    <label for="dateArrivee">Date arrivée &nbsp | &nbsp Date départ</label>
                                    <input type="date" name="dateDebut" id="dateDebut" size="8" class="col-sm-12 form-control text-muted" aria-describedby="aideDateArrivee">
                                    <small class="form-text text-muted" id="aideDateArrivee"></small>
                                </div>
                            </div>
                            <!-- Date de départ -->
                          
                            <div class="form-group">
                                <div class="row">
                                    <label for="dateDepart">Date de départ</label>
                                    <input type="date" name="dateFin" id="dateFin" size="8" class="col-sm-12 form-control text-muted" aria-describedby="aideDateDepart">
                                    <small class="form-text text-muted" id="aideDateDepart"></small>
                                </div>
                            </div>
                            
                            <!-- Nombre de personnes -->
                            <div class="form-group">
                                <div class="row">
                                    <label for="nbPersonnes">Nombre de personnes</label>
                                    <select class="col-sm-12 form-control text-muted" name="nbPersonnes" id="nbPersonnes" aria-describedby="aideNbPersonnes">
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
                            <input type="hidden" value="<?=$data['appartement']->getId();?>" name="id_appart">
						    <input type="hidden" value="<?=(isset($_SESSION['username'])) ? $_SESSION['username'] : "" ?>" name="id_userClient">
                            <button type="button" class="col-sm-12 btn btn-primary btn-block btn-lg" id="demandeReservation">Réserver</button>
                        </form>
                        <div id="erreurReservation"></div>
                    </div>
                    <hr>
                    <br>
                </div>
                        
            <?php
                }
            ?>           
            
        </div>
        
        <!-- Fin section detail -->     
    </section>
    
    <!-- Fin container -->
</div> 