<!--
* @file         /listeAppartement.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste d'appartements (resultat d'une recherche)
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="resultat">
    <h1>Liste des appartements</h1>
    <div class="row">
        <?php
            foreach($data["appartements"] as $appartement)
            {    
        ?>
          <div class="col-md-3">
            <div class="thumbnail">
              <img src="./images/profil.jpg" alt="mon appart">
              <div class="caption">
                <p><?=$appartement->typeApt;?> | <?=$appartement->getNbPersonnes();?> personnes | <?=$appartement->getNbLits();?> lits</p>
                <h5><?=$appartement->getTitre();?></h5>
                <p>$<?=$appartement->getMontantParJour();?> par nuit</p>
                <p>Hôte: <?=$appartement->username;?></p>
                <p>rate 
                    <?php
                        for($i=1; $i<=$appartement->moyenne/2; $i++)
                        {
                        ?>
                            <i class="fas fa-star"></i>
                    <?php
                        }
                        if($appartement->moyenne % 2 != 0)
                        {
                        ?>   
                            <i class="fas fa-star-half"></i>
                     <?php
                        }
                
                    ?>
                  </p> 
                <p><a href="#" class="btn btn-primary" role="button">reserver</a> <a href="#" class="btn btn-default" role="button">noter</a>
                <!-- lientemporaire -->
                <a class="btn btn-primary" href="index.php?Appartements&action=afficherInscriptionApt&id=<?= $appartement->getId(); ?>" role="button">Modifier ce logis</a>
                </p>         
                <p class="adresse" hidden="hidden"><?=$appartement->adresse;?></p>
              </div>
            </div>
          </div>
       <?php  
            }
        ?>
    </div>
</div>
<pre>
       
       </pre>
<div class="row mt-5">
        <ul class="pagination mx-auto">
            <?php 
               // $numPage = isset($params['page'])? $params['page'] : 1;

                    if($data['pageActuelle']-1 > 0)
                    {
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?Appartements&page=<?=$data['pageActuelle']-1?>">precedent</a></li>
                    <?php 
                    }
                        for($i=1; $i<=$data['nbrPage']; $i++) //On fait notre boucle
                    {
                           $active = ($i == $data['pageActuelle'])?  'active' : '';
                    ?>
                        <li class="page-item <?=$active?>"><a class="page-link" href="index.php?Appartements&page=<?=$i?>"><?=$i?></a></li>
                    <?php
                    }
                        if($data['pageActuelle']+1 <= $data['nbrPage'])
                    {
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?Appartements&page=<?=$data['pageActuelle']+1?>">suivant</a></li>
                    <?php
                    }
            ?>
        </ul>
</div>