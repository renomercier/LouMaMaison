<!--
* @file         /AfficheLogin.php
* @brief        Projet WEB 2
* @details      Affichage du formulaire de connexion - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div id="image-entete" class="carousel slide " data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="./images/entete.jpg" alt="Montreal">
      <div class="carousel-caption">
        <p class="slogan"></p>

        <div class="row mb-5">
            <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3">
                <form id="formLogin" method="POST" action="index.php?Usagers&action=authentifier">

                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 form-control-label sr-only">Username</label>
                      <div class="col-sm-12">
                        <input type="text" name="username"  class="form-control" id="inputEmail3" placeholder="Nom d'utilisateur">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-2 form-control-label sr-only">Mot de passe</label>
                      <div class="col-sm-12">
                        <input type="password" name="password"  class="form-control" id="inputPassword3" placeholder="Mot de passe" value="">
                      </div>
                    </div>          	
                        <input type="submit" name="login" class="btn btn-primary btn-block" value="Connexion">						
                </form>
            </div>
        </div> <!-- fin div row -->

        <p></p>
      </div>   
    </div>
  </div>
</div>

<div class="row">
    <div class="col-sm-4 offset-sm-4">
        <?= $data ?>
    </div>
</div> <!-- fin div row -->