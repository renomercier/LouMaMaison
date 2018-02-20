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

<!-- affichage message succes d'inscription à l'usager - à ajouter quand tu seras prêt -->
<!--  isset($data['succes']) ? $data['succes'] : ''  -->                  

<h1>Liste des appartements</h1>
         
    <div class="row">
        <?php
            foreach($data["appartements"] as $appartement)
            {    
        ?>
        
          <div class="col-md-4">
            <div class="thumbnail">
              <img src="./images/profil.jpg" alt="mon appart">
              <div class="caption">
                <p><?=$appartement->getId_typeApt();?> <?=$appartement->getNbPersones();?> personnes - <?=$appartement->getNbLits();?> lits</p>
                <h5><?=$appartement->getTitre();?></h5>
                <p>$<?=$appartement->getMontantParJour();?> par nuit</p>
                <p>note</p>
                <p><a href="#" class="btn btn-primary" role="button">reserver</a> <a href="#" class="btn btn-default" role="button">noter</a></p>
              </div>
            </div>
          </div>
        
       <?php     
            }
        ?>
    </div>
    <div class="row mt-5">
            <ul class="pagination mx-auto">
                <?php 
                    if($_GET['page']-1 > 0)
                {
                ?>
                    <li class="page-item"><a class="page-link" href="index.php?Appartements&page=<?=$_GET['page']-1?>">precedent</a></li>
                <?php 
                }
                    for($i=1; $i<=$data['nbrPage']; $i++) //On fait notre boucle
                {
                       $active = ($i == $data['pageActuelle'])?  'active' : '';
                ?>
                    <li class="page-item <?=$active?>"><a class="page-link" href="index.php?Appartements&page=<?=$i?>"><?=$i?></a></li>
                <?php
                }
                    if($_GET['page']+1 <= $data['nbrPage'])
                {
                ?>
                    <li class="page-item"><a class="page-link" href="index.php?Appartements&page=<?=$_GET['page']+1?>">suivant</a></li>
                <?php
                }
                ?>
            </ul>
    </div>