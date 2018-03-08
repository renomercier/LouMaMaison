<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
  <div class="row">
    <div id="message" class="col-sm-12">
       <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
       <?= isset($data['succes']) ? $data['succes'] : '' ?>
    </div>
  </div> <!-- fin div row -->

<div id="suppImg" class="container">	

	
<?php 	if(isset($data['photosApt'])) { 
 			foreach($data['photosApt'] AS $p) { ?>
 				<hr>
 				<div class="col">
					<div class="text-center col-6"><img id="" src="<?= $p['photoSupp'] ?>" width="200"/>
					<button class="suppressionImg" type="button" value="<?= $p['id'] ?>">Supprimer cette image</button></div>
					<input type="hidden" name="idApt" value="<?= $p['id_appartement'] ?>"/>
				</div> <!-- div .row -->
				<hr>
<?php 		}
		} ?>	
	
</div> <!-- div .container -->