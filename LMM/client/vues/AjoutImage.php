<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
  <div class="row">
    <div id="message" class="col-sm-12">
       <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
       <?= isset($data['succes']) ? $data['succes'] : '' ?>
    </div>
  </div> <!-- fin div row -->

<!-- ref: https://www.formget.com/ajax-image-upload-php/ -->
<div class="container ajoutImg">
	<hr>
	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
	<div id="image_preview"><img id="previewing" src="" /><small></small></div>
	<hr id="line">

	<div id="selectImage">
		<label></label><br/>
		<div id="ajoutImage">
		<input type="file" name="file[]" id="file" required />
		
		</div>
		<input type="hidden" name="action" value="ajouterPhoto" required />
		<input type="hidden" id="idApt" name="idApt" value="<?= isset($data['idApt']) ? $data['idApt'] : '' ?>" required />

		<button type="button" id="btnAjoutImage">Ajouter une image</button>
		<input type="submit" value="Upload" class="submit" />
		</div>
		</form>
	</div>

	<h4 id='loading' >loading..</h4>