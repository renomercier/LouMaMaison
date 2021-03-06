<!--
* @file         /listeAppartement.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste d'appartements (resultat d'une recherche)
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="resultat col-md-12 pl-3 pr-3">
    <div class="row resultatListeApt">       
        <?php
        if($data["appartements"]){
            foreach($data["appartements"] as $appartement)
            { 
                if ($appartement->getPhotoPrincipale() != "") {
                    $photoApt = $appartement->getPhotoPrincipale();
                } else {
                    $photoApt = "./images/profil.png";
                }
            ?>
            <div class="col-12 col-lg-6 appart mb-3" id="appart<?=$appartement->id_appartement;?>" name="<?=$appartement->adresse;?>">

                <div class="thumbnail">
                    <a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->id_appartement;?>">
                        <img class="card-img-top photoAppartement img img-fluid thumbnail" src="<?= $photoApt ?>" alt="mon appart">
                    </a>
                    <div class="card-block">
                    <p class="card-text"><?=$appartement->typeApt;?> | <?=$appartement->getNbPersonnes();?> personne<?= ($appartement->getNbPersonnes() > 1) ? 's' : '' ?> | <?=$appartement->getNbLits();?> lits</p>
                    <h5 class="card-title"><?=$appartement->getTitre();?></h5>
                    <p class="card-text">$<?=$appartement->getMontantParJour();?> par nuit</p>
                    <p class="card-text">Hôte: 
                <?php 
                    if(isset($_SESSION['username']))
                    { 
                        if($appartement->username != $_SESSION['username'])
                        {
                    ?>
                        <a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->username;?>"> <?=$appartement->username;?></a>
                    <?php
                        }
                        else if($appartement->username == $_SESSION['username'])
                        {
                            echo $appartement->username; 
                        }
                    }
                    else
                    {
                    ?>
                        <a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->username;?>"> <?=$appartement->username;?></a>
                    <?php
                    }
                ?>
    				</p>
                    <p class="card-text">rate                                
                <?php
                    for($i=1; $i<=$appartement->moyenne/2; $i++)
                    {
                    ?>
                        <i class="fa fa-star"></i>
                    <?php
                        }
                        if($appartement->moyenne % 2 != 0)
                        {
                         ?>   
                            <i class="fa fa-star-half"></i>
                     <?php
                        }
                        if($appartement->moyenne == null) 
    					{ 
    					?>
    						<i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i><i class="fa fa-star fa_custom"></i>
    					<?php
    					}
    					?>
                        <small class="text-muted">(<?=$appartement->nbr_votant;?>) évaluation<?= ($appartement->nbr_votant > 1) ? 's' : '' ?></small></p> 
                    </div> <!-- div .card-block -->
              </div> <!-- div .thumbnail -->
        </div> <!-- div .appart -->
                       <?php 
                            } // fin du for
                        } else

                        {
                        ?>
        <div class="col-md-6 mx-auto">
            <div class="error-template text-center">
                <h2>Oops!</h2>
                <h3>Aucun résultat pour votre recherche</h3>
                <div class="error-details">
                    Essayez avec d'autres critères!
                </div>
            </div>
        </div>
                        <?php  
                        } // fin du foreach 
                        ?>
    </div>
    <div class="row mt-5">
        <ul class="pagination mx-auto">
            <?php 
            if($data['nbrPage']>1)
            {
               // $numPage = isset($params['page'])? $params['page'] : 1;
                if($data['pageActuelle']-1 > 0)
                {
                ?>
                    <li class="page-item" value=""><a class="page-link" onclick="naviguer(<?=$data['appartParPage']?>,<?=$data['pageActuelle']-1?>)">precedent</a></li>
                <?php 
                }
                    for($i=1; $i<=$data['nbrPage']; $i++) //On fait notre boucle
                {
                       $active = ($i == $data['pageActuelle'])?  'active' : '';
                ?>
                    <li class="page-item <?=$active?>"><a class="page-link" onclick="naviguer(<?=$data['appartParPage']?>,<?=$i?>)"><?=$i?></a></li>
                <?php
                }
                    if($data['pageActuelle']+1 <= $data['nbrPage'])
                {
                ?>
                    <li class="page-item"><a class="page-link" onclick="naviguer(<?=$data['appartParPage']?>,<?=$data['pageActuelle']+1?>)">suivant</a></li>
                <?php
                }
            }
            ?>
        </ul>
    </div>
</div>