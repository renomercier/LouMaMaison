  <!--<p class='alert alert-warning'>Veuillez noter que ce site affiche exclusivement des logements situés à Montréal</p>-->

  <!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
  <div class="row">
    <div class="col-sm-12">
       <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
       <?= isset($data['succes']) ? $data['succes'] : '' ?>
    </div>
  </div> <!-- fin div row -->
      
  <!-- div content-modal -->
  <!--
  <div class="modal fade" id="myModalApt">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
          <small>Fermer&nbsp;</small><i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
          </button>
        </div> 

        <div id="bodyApt" class="modal-body">  
        </div> 

        <div id="modalFooter" class="modal-footer">
        </div> 

      </div>
    </div>
  </div> -->
<!-- fin modal-header -->  
<!-- fin modal-body -->
<!-- fin modal-footer -->

<div class="container" id="divAjoutApt">
  <!-- on verifie si l'usager est connecte et a les droits d'ajout d'un apartement -->
  <?php if(isset($_SESSION['username']) && (isset($_SESSION["isBanned"]) && $_SESSION["isBanned"] == 0) && (isset($_SESSION["isActiv"]) && $_SESSION["isActiv"] == 1) && ( in_array(1 ,$_SESSION["role"]) || in_array(2 ,$_SESSION["role"]) || in_array(3 ,$_SESSION["role"])) ) { ?> 

    <form id="formApt" method="POST" action="index.php?Appartements&action=sauvegarderApt"> 

    <!-- Titre -->
    <div class="form-group">
        <label for="titreApt" class="form-control-label ">Titre de votre annonce d'appartement</label>
        <div class="row">
          <input type="text" name="titre" class="col-sm-12 form-control" id="titreApt" value="<?= isset($data['apt']) ? $data['apt']->getTitre() : '' ?>" placeholder="Le titre de l'annonce d'appartement" aria-describedby="aideTitreApt">
          <small class="form-text text-muted" id="aideTitreApt"></small> 
      </div>
    </div>

    <!-- descriptif -->
    <div class="form-group">
        <label for="descriptifApt" class="form-control-label ">Descriptif de votre appartement</label>
        <div class="row">
          <input type="text" name="descriptif" class="col-sm-12 form-control" id="descriptifApt" value="<?= isset($data['apt']) ? $data['apt']->getDescriptif() : '' ?>" placeholder="Descriptif de votre appartement" aria-describedby="aideDescriptifApt">
          <small class="form-text text-muted" id="aideDescriptifApt"></small> 
      </div>
    </div>

    <!-- Type de logis -->
    <div class="form-group" id="divTypeApt">
      <label for="typeApt" class="form-control-label my-1 mr-sm-2">Type de logis</label>
      <div class="row">
      <select class="col-sm-12 custom-select my-1 mr-sm-2 text-muted" name="id_typeApt" id="typeApt" aria-describedby="aideTypeApt">
      <?= (isset($data['apt'])) ? '<option value="0">-- Choisir un type de logis --</option>' : '<option value="0" selected>-- Choisir un type de logis --</option>' ?>
    <?php foreach($data['tab_typeApt'] AS $t) {
            if(isset($data['apt'])) { 
              if($data['apt']->getId_typeApt() == $t['id']) { ?>
                <option selected value=<?= $t['id'] ?>><?= $t['typeApt'] ?></option>
    <?php     } 
              else { ?>
                <option value=<?= $t['id'] ?>><?= $t['typeApt'] ?></option>
    <?php     }
            } 
            else { ?>
              <option value=<?= $t['id'] ?>><?= $t['typeApt'] ?></option>
    <?php   }
          } ?>
      </select>
      <small class="form-text text-muted" id="aideTypeApt"></small>
      </div>
    </div>

    <!-- Adresse -->
    <!-- No civique -->
    <div class="form-group">
      <label class="form-control-label ">L'Adresse de l'appartement</label>
      <div class="row">
          <label for="noCivique" class="col-sm-5 form-control-label">Numéro civique</label>
          <input type="text" name="noCivique" class="col-sm-7 form-control" id="noCivique" value="<?= isset($data['apt']) ? $data['apt']->getNoCivique() : '' ?>" placeholder="Entrer le numéro civique" aria-describedby="aideNoCivique">
          <small class="form-text text-muted" id="aideNoCivique"></small> 
      </div>
    </div>

    <!-- Nom de la rue -->
    <div class="form-group">
      <div class="row">
          <label for="nomRue" class="col-sm-5 form-control-label">Nom de la rue</label>
          <input type="text" name="rue" class="col-sm-7 form-control" id="nomRue" value="<?= isset($data['apt']) ? $data['apt']->getRue() : '' ?>" placeholder="Entrer le nom de rue" aria-describedby="aideNomRue">
          <small class="form-text text-muted" id="aideNomRue"></small> 
      </div>
    </div>

    <!-- No appartememnt -->
    <div class="form-group">
      <div class="row">
          <label for="noApt" class="col-sm-5 form-control-label">No d'appartement</label>
          <input type="text" name="noApt" class="col-sm-7 form-control" id="noApt" value="<?= isset($data['apt']) ? $data['apt']->getNoApt() : '' ?>" placeholder="Entrer le numéro d'appartement" aria-describedby="aideNoApt">
          <small class="form-text text-muted" id="aideNoApt"></small> 
      </div>
    </div>

    <!-- Code postal -->
    <div class="form-group">
      <div class="row">
          <label for="codePostal" class="col-sm-5 form-control-label">Code postal</label>
          <input type="text" name="codePostal" class="col-sm-7 form-control" id="codePostal" value="<?= isset($data['apt']) ? $data['apt']->getCodePostal() : '' ?>" placeholder="Entrer le code postal" aria-describedby="aideCP">
          <small class="form-text text-muted" id="aideCP"></small> 
      </div>
    </div>

    <!-- Quartier ou se situe le logis -->
    <div class="form-group" id="divQuartier">
      <label for="quartier" class="form-control-label my-1 mr-sm-2">Quartier où se situe votre logis</label>
      <div class="row">
      <select class="col-sm-12 custom-select my-1 mr-sm-2 text-muted" name="id_nomQuartier" id="quartier" aria-describedby="aideQuartier">
      <?= (isset($data['apt'])) ? '<option value="0">-- Choisir un quartier --</option>' : '<option value="0" selected>-- Choisir un quartier --</option>' ?>
    <?php foreach($data['tab_quartier'] AS $q) {
            if(isset($data['apt'])) { 

              if($data['apt']->getId_nomQuartier() == $q['id']) { ?>
                <option selected value=<?= $q['id'] ?>><?= $q['nomQuartier'] ?></option>
    <?php     } 
              else { ?>
                <option value=<?= $q['id'] ?>><?= $q['nomQuartier'] ?></option>
    <?php     }
            } 
            else { ?>
              <option value=<?= $q['id'] ?>><?= $q['nomQuartier'] ?></option>
    <?php   }
          } ?>
      </select>
      <small class="form-text text-muted" id="aideQuartier"></small>
      </div>
    </div>

    <!-- nb de personnes admises -->
    <div class="form-group">
      <label for="nbPersonnes" class="form-control-label ">Nombre maximum de personnes admises</label>
      <div class="row">
        <input type="text" name="nbPersonnes" class="col-sm-12 form-control" id="nbPersonnes" value="<?= isset($data['apt']) ? $data['apt']->getNbPersonnes() : '' ?>" placeholder="Entrer le nombre maximum de personnes admises" aria-describedby="aideNbPersonnes">
        <small class="form-text text-muted" id="aideNbPersonnes"></small> 
      </div>
    </div>

    <!-- nb de chambres -->
    <div class="form-group">
      <label for="nbChambres" class="form-control-label ">Nombre de chambres dans votre logis</label>
      <div class="row">
        <input type="text" name="nbChambres" class="col-sm-12 form-control" id="nbChambres" value="<?= isset($data['apt']) ? $data['apt']->getNbChambres() : '' ?>" placeholder="Entrer le nombre de chambres de votre logis" aria-describedby="aideNbChambres">
        <small class="form-text text-muted" id="aideNbChambres"></small> 
      </div>
    </div>

    <!-- nb de lits -->
    <div class="form-group">
      <label for="nbLits" class="form-control-label ">Nombre de lits dans votre logis</label>
      <div class="row">
        <input type="text" name="nbLits" class="col-sm-12 form-control" id="nbLits" value="<?= isset($data['apt']) ? $data['apt']->getNbLits() : '' ?>" placeholder="Entrer le nombre de lits disponibles" aria-describedby="aideNbLits">
        <small class="form-text text-muted" id="aideNbLits"></small> 
      </div>
    </div>

    <!-- montant par jour -->
    <div class="form-group">
      <label for="montantParJour" class="form-control-label ">Montant demandé par jour</label>
      <div class="row">
        <input type="text" name="montantParJour" class="col-sm-12 form-control" id="montantParJour" value="<?= isset($data['apt']) ? $data['apt']->getMontantParJour() : '' ?>" placeholder="Entrer le montant demandé par jour" aria-describedby="aideMontant">
        <small class="form-text text-muted" id="aideMontant"></small> 
      </div>
    </div>

    <!-- Options de l'appartement -->
    <div>
      <div id="option" class="py-3">
        <label class="form-control-label ">Options liées à l'appartement</label>
      </div><small class="form-text text-muted pl-0" id="checkbox"></small> 
    </div> <!-- fin div options -->
    
    <input id="optionsSerialises" type="hidden" name="options" value="" />
    <input id="idApt" name="idApt" type="hidden" value="<?= isset($data['apt']) ? $data['apt']->getId() : '' ?>">

    <input type="submit" class="btn btn-primary btn-block btn-lg" id="submitApt" value="Sauvegarder">            
  </form>
<?php } ?>
</div> <!-- fin div .container -->