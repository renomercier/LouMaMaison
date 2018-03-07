<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
  <div class="row">
    <div id="message" class="col-sm-12">
       <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
       <?= isset($data['succes']) ? $data['succes'] : '' ?>
    </div>
    <div id="photo" value="false"></div>
  </div> <!-- fin div row -->

<!-- ref: https://www.formget.com/ajax-image-upload-php/ -->
<div class="container ajoutImg">	
	<form <?= (isset($data['idApt'])) ? 'id="uploadimage"' : 'id="uploadimageProfil"' ?> action="" method="post" enctype="multipart/form-data">
<?php	if(isset($data['idApt'])) { ?>
		<div class="form-check">
		    <label class="form-check-label">
		        <input type="radio" class="form-check-input" name="modifPP" id="modifPP" checked/>Ajout/Modification de la photo principale ET ajout de photos supplémentaires
		    </label>
		</div>
		<div class="form-check">
		    <label class="form-check-label">
		        <input type="radio" class="form-check-input" name="modifPP" value="">Ajout de photos supplémentaires seulement
		    </label>
		</div>
<?php   } 
		else { ?>
			<a href="index.php?Usagers&action=afficheUsager&idUsager=<?= $data['idPhotoUsager'] ?>&message=nouvelUsager"><button class="pull-right" type="button" id="btnSansImg">Plus tard</button></a>
<?php	} ?>
		<h5 class="titrePhotoPrincipale text-center"><?= (isset($data['idApt'])) ? 'Photo principale de l\'appartement' : 'Photo du profil' ?></h5>
		<hr>
		<div id="image_preview" class="text-center"><img id="previewing" src="" /><br><small></small></div>
		<hr>
		
		<div id="selectImage">
			<div id="ajoutImage">
				<label id="inputFile"><input type="file" name="file[]" id="file" required /></label>
			</div>
			<input type="hidden" name="action" value="ajouterPhoto" required />
			<input type="hidden" id="idApt" name="idApt" value="<?= isset($data['idApt']) ? $data['idApt'] : '' ?>"/>
			<input type="hidden" name="idPhotoUsager" value="<?= isset($data['idPhotoUsager']) ? $data['idPhotoUsager'] : '' ?>"/>
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