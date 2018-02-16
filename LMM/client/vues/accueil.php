<!--
* @file         /accueil.php
* @brief        Projet WEB 2
* @details      Affichage du formulaire de connexion - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div class="row">
    <div class="col-sm-4 offset-sm-4">
        <h1>alalicorne</h1>
        <p> La page d'accueil vient d'être codée !</p>
    </div>
</div> <!-- fin div row -->
<div class="row">
    <div class="col-sm-4 offset-sm-4">
    </div>
</div> <!-- fin div row -->

<!--
* @file         /AfficheListeUsagers.php
* @brief        Projet WEB 2
* @details      Affichage de tous les usagers - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<h1>Liste des appartements</h1>
<div class="container">          

        <?php
            foreach($data["appartements"] as $appartement)
            {    
        ?>
        <div>
            <p><?=$appartement->getOptions();?></p>
            <p><?=$appartement->getTitre();?></p>
            <p><?=$appartement->getDescriptif();?></p>
            <p><?=$appartement->getMontantParJour();?></p>
            <p><?=$appartement->getNbPersones();?></p>
            <p><?=$appartement->getNbLits();?></p>
            <p><?=$appartement->getNbChambres();?></p>
            <p><?=$appartement->getPhotoPrincipale();?></p>
            <p><?=$appartement->getNoApt();?></p>
            <p><?=$appartement->getNoCivique ();?></p>
            <p><?=$appartement->getRue();?></p>
            <p><?=$appartement->getCodePostal();?></p>
            <p><?=$appartement->getId_typeApt();?></p>
            <p><?=$appartement->getId_userProprio();?></p>
            <p><?=$appartement->getId_nomQuartier();?></p>
        </div>
       <?php     
            }
        ?>

</div>

<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="./images/profil.jpg" alt="mon appart">
      <div class="caption">
        <h3>nom</h3>
        <p>tout le text ici</p>
        <p><a href="#" class="btn btn-primary" role="button">reserver</a> <a href="#" class="btn btn-default" role="button">noter</a></p>
      </div>
    </div>
  </div>
</div>


<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="..." alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Cras justo odio</li>
    <li class="list-group-item">Dapibus ac facilisis in</li>
    <li class="list-group-item">Vestibulum at eros</li>
  </ul>
  <div class="card-body">
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
</div>

