<!--
* @file         /AfficheVoyages.php
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
		if($data["appartement"]){
			foreach($data["appartement"] as $appartement)
			{ 
		?>
				<div class="col-md-4 appart">

					<?php						
						if ($appartement->photoPrincipale != "") {
							$photoApt = $appartement->photoPrincipale;
						} else {
							$photoApt = "./images/profil.jpg";
						}
												
					?> 
					<div class="thumbnail">
						<a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getIdAppartement() ?>" >
						<img src="<?= $photoApt ?>" class="card-img-top photoAppartement img img-fluid thumbnail" alt="mon appart">
						</a>
				 
                        <div class="card-block">			
                         
                            <p class="card-text">Hôte: <?=$appartement->id_userProprio ?></p>                        
                  
                            <h5 class="card-title"> <?=$appartement->titre ?></h5>

                            <p class="card-text">
                              
                            </p>
                            <p> <?=$appartement->noCivique." ".$appartement->rue." ".$appartement->ville ?>
                            </p>
                        </div>
                </div>
				<?php 
					if($appartement->getIdUserClient() == $_SESSION['username'])
					{
				?>
						<p><a class="btn btn-primary" data-toggle="modal" data-target="#myModalEval" href="#" role="button">Evaluer ce logis</a></p>   

                        <!-- div content-modal -->
                        <div class="modal fade" id="myModalEval" >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <!-- div header du modal -->
                                    <div class="modal-header">
                                        <div class="row">
                                            <div class="titreEval">
                                                <button type="button" class="btn pull-right mr-3" data-dismiss="modal" aria-label="Close">
                                                    <small>Fermer&nbsp;</small>
                                                </button>
                                            </div>
                                            <div class="text-center titreEval">
                                                <h5 class="modal-title"><?= isset($appartement) ? $appartement->titre : '' ?></h5>
                                            </div>
                                            <img class="card-img-top photoAppartement img thumbnail imgEval" src="<?= isset($appartement) ? $appartement->photoPrincipale : '' ?>" alt="mon appart">
                                        </div>
                                    </div> <!-- fin modal-header --> 

                                    <!-- div body du modal -->
                                    <div id="evalModalBody" class="modal-body">
                                        <form id="formEvaluation" method="POST" action="index.php?Evaluations&action=sauvegarderEvaluation"> 

                                            <!-- attribution du nb d'etoiles de 0 a 5 -->
                                            <div class="divEvaluation">
                                                <label for="echelleEval" class="form-control-label ">Votre évaluation: &nbsp;&nbsp;<span></span> sur 5</label>
                                                <input type="range" name="rating" min="0" max="10" value="0" class="slider" id="echelleEval">
                                                <div class="divEtoiles">
                                                    <p id="etoilesGrises"></p>
                                                    <p id="etoiles"></p>
                                                </div>
                                            </div>

                                            <!-- descriptif -->
                                            <div class="form-group mt-3">
                                                <label for="commentaireEval" class="form-control-label ">Votre commentaire&nbsp;&nbsp;<small>(facultatif)</small></label>
                                                <div class="form-group">
                                                    <textarea name="commentaire" class="form-control col-sm-12" rows="3" aria-describedby="aideCommentaireEval"><?= isset($data['evaluation']) ? $data['evaluation']->getCommentaire() : '' ?></textarea>
                                                    <small class="form-text text-muted" id="aideCommentaireEval"></small> 
                                                </div>
                                            </div>

                                            <input name="id_appartement" type="hidden" value="<?= isset($appartement) ? $appartement->idApt : '' ?>">
                                        <!--<input name="id_location" type="hidden" value="  isset($data['id_location']) ? $data['id_location'] : ''  "> -->
                                            <input type="submit" class="btn btn-primary btn-block btn-lg" id="submitEvaluation" value="Sauvegarder">            

                                        </form>
                                    </div> <!-- fin modal-body -->

                                    <div id="evalModalFooter" class="modal-footer">
                                    </div> <!-- fin modal-footer -->

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