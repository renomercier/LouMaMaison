<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
  <div class="row">
    <div id="message" class="col-sm-12">
       <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
       <?= isset($data['succes']) ? $data['succes'] : '' ?>
    </div>
  </div> <!-- fin div row -->

<!-- ref: https://www.formget.com/ajax-image-upload-php/ -->
<div class="container ajoutImg">
	
	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
		<hr>
			<div id="image_preview" class="text-center"><img id="previewing" src="" /><br><small></small></div>
		<hr>
			<div id="selectImage">
				<div id="ajoutImage">
					<label id="inputFile"><input type="file" name="file[]" id="file" required /></label>
				</div>
				<input type="hidden" name="action" value="ajouterPhoto" required />
				<input type="hidden" id="idApt" name="idApt" value="<?= isset($data['idApt']) ? $data['idApt'] : '' ?>" required />
			</div>
		
		
		<div>
			<?php if(isset($data['idApt'])) { ?>
			<button class="pull-right" type="button" id="btnAjoutImage">Ajouter une image</button>
			<?php } ?>

			<input class="pull-right" type="submit" value="Upload" class="submit" />
		</div>
		
	</form>
	<input id="temp" name="temp" value="" type="hidden"/>
</div>