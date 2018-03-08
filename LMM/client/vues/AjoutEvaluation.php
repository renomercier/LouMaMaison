<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
<div class="row">
	<div class="col-sm-12">
	   <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
	   <?= isset($data['succes']) ? $data['succes'] : '' ?>
	</div>
</div> <!-- fin div row -->

<p><a class="btn btn-primary" data-toggle="modal" data-target="#myModalEval" href="#" role="button">Evaluer ce logis</a></p>   

<!-- div content-modal -->
<div class="modal fade" id="myModalEval">
	<div class="modal-dialog" role="document">
	  	<div class="modal-content">

	  		<!-- div header du modal -->
		    <div class="modal-header">
		    	<div class="row col-12 modalEval">
		    		<div class="titreEval">
		    			<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
					</div>
		    		<div class="text-center titreEval">
						<h5 class="modal-title"><?= isset($data['appartement']) ? $data['appartement']->getTitre() : '' ?></h5>
					</div>
					<img class="card-img-top photoAppartement img thumbnail imgEval" src="<?= isset($data['appartement']) ? $data['appartement']->getPhotoPrincipale() : '' ?>" alt="mon appart">
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
				    <div class="form-group">
				        <label for="commentaireEval" class="form-control-label ">Votre commentaire&nbsp;&nbsp;<small>(facultatif)</small></label>
				        <div class="form-group">
				        	<textarea name="commentaire" class="form-control col-sm-12" rows="3" aria-describedby="aideCommentaireEval"><?= isset($data['evaluation']) ? $data['evaluation']->getCommentaire() : '' ?></textarea>
							<small class="form-text text-muted" id="aideCommentaireEval"></small> 
				      	</div>
				    </div>

				    <input name="id_appartement" type="hidden" value="<?= isset($data['appartement']) ? $data['appartement']->getId() : '' ?>">
				<!--<input name="id_location" type="hidden" value="  isset($data['id_location']) ? $data['id_location'] : ''  "> -->
				    <input type="submit" class="btn btn-primary btn-block btn-lg" id="submitEvaluation" value="Sauvegarder">            
  				
  				</form>
		    </div> <!-- fin modal-body -->

		    <div id="evalModalFooter" class="modal-footer">
		    </div> <!-- fin modal-footer -->

	  	</div>
	</div>
</div> 