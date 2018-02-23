<!--
* @file         /AfficheAptsProprio.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste d'appartements du proprio
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="resultat">
    <div class="row">        
        <?php 
        foreach($data["appartements"] as $appartement)
        { 
        ?>
        <div class="col-md-6">
            <div class="thumbnail">
              <img src="./images/profil.jpg" alt="mon appart">
              <div class="caption">

                <p> <?=$appartement->typeApt;?> | <?=$appartement->getNbPersonnes();?> personnes |<?=$appartement->getNbLits();?> lits</p>
                <h5><?=$appartement->getTitre();?></h5>
                <p>$<?=$appartement->getMontantParJour();?> par nuit</p>
                <p>rate 
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
                  </p> 
                  <p> <?=$appartement->getNoCivique()." ".$appartement->getRue()." ".$appartement->getVille();?></p>                
                  <div>
                    <form>
                    <input type="hidden" value="<?=$appartement->getId_userProprio()?>">
                      <button type="button" data-toggle="modal" data-target="#modal<?=$appartement->getId();?>" id="<?=$appartement->getId()?>" class="btn btn-info " >Disponibilite</button>
                     </form>
                  </div>
                        <!-- Modal -->
                        <div class="modal fade" id="modal<?=$appartement->getId()?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-info">
                                <h5 class="modal-title text-white" id="modal<?=$appartement->getId()?>">Disponibilite</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                  <form class="form-inline">
                                    <label class="mr-sm-2">Date de debut</label><input type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" >
                                    <label class="mr-sm-2">Date de fin</label><input type="date" class="form-control mb-2 mr-sm-2 mb-sm-0" >
                                    <button type="button" id="ajouterDispo<?=$appartement->getId()?>" class="btn btn-success btnAjouterDispo">Ajouter</button>
                                     <table class="table table-hover">
                                         <tbody>
                                             <tr class="trDispo"><th>Date de debut</th><th>Date de fin</th></tr>
                                             <tr>

                                                <?php
                                                 foreach( $appartement->disponibilite as $dispo) 
                                                 {
                                                  ?>   
                                                <td><?=$dispo['dateDebut'];?></td>
                                                 <td><?=$dispo['dateFin']?></td>
                                                 <td><button type="button" class="btn btn-warning btnSupprimerDispo" id="dispo<?=$dispo['id'];?>">Supprimer</button></td>
                                                 <?php
                                                 }
                                                    ?>
                                             </tr>
                                         </tbody>
                                      </table>
                                  </form>
                              </div>
                              <div class="modal-footer bg-info">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>

                              </div>
                            </div>
                          </div>
                        </div>
                   </div>
                </div>
            </div>
            <?php
            }
            ?> 
    </div>
</div>


<!--
<div class="row mt-5">
        <ul class="pagination mx-auto">
   
			 <?php /*
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
			*/
            ?>
        </ul>
</div>
-->