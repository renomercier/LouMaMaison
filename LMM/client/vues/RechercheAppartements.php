<!--
* @file         /AfficheInscriptionUsager.php
* @brief        Projet WEB 2
* @details      Affichage du formulaire de connexion - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="container-fluid">
    <div class="row accueil">
        <div class="col-md-2 col-lg-2 recherche">

            <form id="formFiltrer" method="POST" action="index.php?Appartements&action=filtrer">

              <!-- Date arrivée -->
              <div class="form-group">
                  <label for="arrivee" class="form-control-label ">Date d'arrivée</label>
                  <div class="row inputListeApt">
                    <input type="date" name="arrivee" class="col-sm-12 form-control" id="arrivee">
                </div>
              </div> 

              <!-- Date départ -->
              <div class="form-group">
                  <label for="depart" class="form-control-label ">Date de départ</label>
                  <div class="row inputListeApt">
                    <input type="date" name="depart" class="col-sm-12 form-control" id="depart">
                </div>
              </div>

              <!-- nbre de personnes -->
              <div class="form-group">
                  <label for="nbrPersonnes" class="form-control-label ">Nombre de personnes</label>
                  <div class="row inputListeApt">
                    <input type="number" min="0" name="nbrPersonnes" class="col-sm-12 form-control" id="nbrPersonnes" value="<?= isset($filtre['nbrPers']) ? $filtre['nbrPers'] : '' ?>">
                </div>
              </div>

                <!-- prix min -->
              <div class="form-group">
                  <label for="prixMin" class="form-control-label ">Minimum</label>
                  <div class="row inputListeApt">
                    <input type="number" min="0" step=".5" name="prixMin" class="col-sm-12 form-control" id="prixMin">
                </div>
              </div>

              <!-- prix max -->
              <div class="form-group">
                  <label for="prixMax" class="form-control-label ">Maximum</label>
                  <div class="row inputListeApt">
                    <input type="number" min="0" step=".5" name="prixMax" class="col-sm-12 form-control" id="prixMax">
                </div>
              </div>

            <!-- Type de logis -->
            <div class="form-group" id="divTypeApt">
              <label for="typeApt" class="form-control-label my-1 mr-sm-2">Type de logis</label>
              <div class="row inputListeApt">
              <select class="col-sm-12 custom-select my-1 mr-sm-2 text-muted" name="id_typeApt" id="typeApt" aria-describedby="aideTypeApt">
              <option value="0">-- Choisir un type de logis --</option>
            <?php foreach($data['tab_typeApt'] AS $t) 
                    {
                ?>
                      <option value=<?= $t['id'] ?>><?= $t['typeApt'] ?></option>
            <?php   }
                ?>
              </select>
              <small class="form-text text-muted" id="aideTypeApt"></small>
              </div>
            </div>
                
              <!-- Quartier -->
              <div class="form-group">
                <label for="quartier" class="form-control-label my-1 mr-sm-2">Quartier</label>
                <div class="row inputListeApt">
                <select class="col-sm-12 custom-select my-1 mr-sm-2 text-muted" name="quartier" id="quartier">
                    <option value="0">-- Choisir un quartier --</option>
                    <?php 
                        foreach($data['quartier'] as $quartier)
                        {
                            echo "<option value='".$quartier['id']."'>".$quartier['nomQuartier']."</option>";
                        }
                    ?>
                </select>
                </div>
              </div>
                <input type="hidden" name="note" id="laNote" value="" class="form-check-input">
              <!-- Notes -->
                <div class="py-3">
                    <div class="rateyo-readonly-widg"></div>
                </div>
                <input type="submit" class="btn btn-primary btn-block btn-lg" id="filtrer" value="Chercher">
            </form>
        </div>
<div class="listeApt col-lg-6 col-md-6">