<!--
* @file         /listeAppartement.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste d'appartements (resultat d'une recherche)
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
    <div class="resultat">
        <div class="row">       
                    <?php
                    if($data["appartements"]){
                        foreach($data["appartements"] as $appartement)
                        {    
                    ?>
                      <div class="col-md-4 appart" id="appart<?=$appartement->id_appartement;?>" name="<?=$appartement->adresse;?>">

                        <div class="thumbnail">
                          <img class="card-img-top" src="./images/profil.jpg" alt="mon appart">
                          <div class="card-block">
                            <p class="card-text"><?=$appartement->typeApt;?> | <?=$appartement->getNbPersonnes();?> personnes | <?=$appartement->getNbLits();?> lits</p>
                            <h5 class="card-title"><?=$appartement->getTitre();?></h5>
                            <p class="card-text">$<?=$appartement->getMontantParJour();?> par nuit</p>
                            <p class="card-text">Hôte: <?=$appartement->username;?></p>
                              <p class="card-text">debut: <?=$appartement->dateDebut;?></p><p>fin: <?=$appartement->dateFin;?></p>
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
                                ?>
                              <small class="text-muted">(<?=$appartement->nbrVotant;?>)</small></p> 
                          </div>
                        </div>
                      </div>
                   <?php 
                        }
                    }else
                    {
                    ?>
        <div class="col-md-6 mx-auto">
            <div class="error-template text-center">
                <h2>Oops!</h2>
                <h3>Aucun résultat our votre recherche</h3>
                <div class="error-details">
                    Éssaiyez avec d'autres critères!
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
       