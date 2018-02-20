<!--
* @file         /AfficheInscriptionUsager.php
* @brief        Projet WEB 2
* @details      Affichage du formulaire de connexion - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 recherche">

            <form id="formUsager" method="POST" action="index.php?Appartements&action=filtrer">

              <!-- Date arrivée -->
              <div class="form-group">
                  <label for="arrivee" class="form-control-label ">Date d'arrivée</label>
                  <div class="row">
                    <input type="date" name="arrivee" class="col-sm-12 form-control" id="arrivee">
                </div>
              </div> 

              <!-- Date départ -->
              <div class="form-group">
                  <label for="depart" class="form-control-label ">Date de départ</label>
                  <div class="row">
                    <input type="date" name="depart" class="col-sm-12 form-control" id="depart">
                </div>
              </div>

              <!-- nbre de personnes -->
              <div class="form-group">
                  <label for="nbrPersonnes" class="form-control-label ">Nombre de personnes</label>
                  <div class="row">
                    <input type="number" min="0" name="nbrPersonnes" class="col-sm-12 form-control" id="nbrPersonnes">
                </div>
              </div>

              <!-- prix min -->
              <div class="form-group">
                  <label for="prixMin" class="form-control-label ">Minimum</label>
                  <div class="row">
                    <input type="number" min="0" step=".5" name="prixMin" class="col-sm-12 form-control" id="prixMin">
                </div>
              </div>

              <!-- prix max -->
              <div class="form-group">
                  <label for="prixMax" class="form-control-label ">Maximum</label>
                  <div class="row">
                    <input type="number" min="0" step=".5" name="prixMax" class="col-sm-12 form-control" id="prixMax">
                </div>
              </div>

              <!-- Quartier -->
              <div class="form-group">
                <label for="quartier" class="form-control-label my-1 mr-sm-2">Quartier</label>
                <div class="row">
                <select class="col-sm-12 custom-select my-1 mr-sm-2 text-muted" name="quartier" id="quartier">
                    <option value="0">-- Choisir un moyen de communication --</option>
                    <option selected value=""></option>
                    <option value=""></option>
                    <option value=""></option>

                </select>
                <small class="form-text text-muted" id="aideMoyenComm"></small>
                </div>
              </div>

              <!-- Notes -->
                <div class="py-3">
                    <label class="form-control-label ">Note</label>
                    <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="note" id="cinq" value="5" class="form-check-input"><?php for($i=0; $i<5; $i++){echo '<i class="fas fa-star"></i>';} ?>
                    </label>
                    </div>
                    <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="note" id="cinq" value="4" class="form-check-input"><?php for($i=0; $i<4; $i++){echo '<i class="fas fa-star"></i>';} ?>
                    </label>
                    </div>
                    <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="note" id="cinq" value="3" class="form-check-input"><?php for($i=0; $i<3; $i++){echo '<i class="fas fa-star"></i>';} ?>
                    </label>
                    </div>
                    <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="note" id="cinq" value="2" class="form-check-input"><?php for($i=0; $i<2; $i++){echo '<i class="fas fa-star"></i>';} ?>
                    </label>
                    </div>
                    <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" name="note" id="cinq" value="1" class="form-check-input"><i class="fas fa-star"></i>
                    </label>
                    </div>
                      <input type="submit" class="btn btn-primary btn-block btn-lg" id="inputSubmit" value="Sauvegarde">
                </div>						
            </form>
        </div>





