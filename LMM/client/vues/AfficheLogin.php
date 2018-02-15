<!--
* @file         /AfficheLogin.php
* @brief        Projet WEB 2
* @details      Affichage du formulaire de connexion - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div class="row">
    <div class="col-sm-4 offset-sm-4">
        <form id="formLogin" method="POST" action="index.php?Usagers&action=authentifier">

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 form-control-label sr-only">Username</label>
              <div class="col-sm-12">
                <input type="text" name="username"  class="form-control" id="inputEmail3" placeholder="Username">
              </div>
            </div>

            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 form-control-label sr-only">Mot de passe</label>
              <div class="col-sm-12">
                <input type="password" name="password"  class="form-control" id="inputPassword3" placeholder="Mot de passe">
              </div>
            </div>          	
                <input type="submit" name="login" class="btn btn-primary btn-block btn-lg" value="Connexion">						
        </form>
    </div>
</div> <!-- fin div row -->
<div class="row">
    <div class="col-sm-4 offset-sm-4">
        <?= $data?>
    </div>
</div> <!-- fin div row -->

