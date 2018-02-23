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
    
    <!-- Modal du carousel de photos -->
    <div class="modal fade" id="modalGaleriePhoto" tabindex="-1" role="dialog" aria-labelledby="modalPhotoSupp" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <div class="pull-left">Galerie de photos</div>
            <h4 class="modal-title" id="myModalLabel"><?= $data['appartement']->getTitre() ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          
          <div class="modal-body">
             
            <!--begin carousel-->
            <div id="maGalerie" class="carousel slide" data-ride="carousel">
                
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
                            <img src="<?= $photo['photoSupp'] ?>" class="d-block img img-fluid" alt="photoGalerie<?= $nbrP ?>">
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
                            <img src="<?= $photo['photoSupp'] ?>" class="d-block img img-fluid" alt="photoGalerie<?= $nbrP ?>">
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
                    <img src="<?= $data['appartement']->getPhotoPrincipale() ?>" class="photoPrincipale img img-fluid">
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
                                <img src="<?= $photo['photoSupp'] ?>" style="width: 100px; height: 75px" class="photoSupplementaire img-thumbnail img-fluid" alt="Photo-<?= $nbrP ?>">
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
    
    
    <section class="sectionAptDetail">
        
        <br>
        <h5>BlaBlaBla</h5><br>
        <h5>BleBleBle</h5><br>
        <h5>BliBliBli</h5><br>
        <h5>BloBloBlo</h5><br>
        <h5>BluBluBlu</h5><br>
        <h5>BlyBlyBly</h5><br>
    
            <!-- Fin row -->    
    </section>
    
    <!-- Fin container -->
</div>

 