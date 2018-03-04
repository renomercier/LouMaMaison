<!--
* @file         AfficheUsager.php
* @brief        Projet WEB 2
* @details      Affichage de profil d'usager - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<!-- affichage des messages d'erreur a l'usager (temporaire) - concernant ses actions -->
<div class="row">
<div id="message" class="col-sm-12">
   <?= isset($data['erreurs']) ? $data['erreurs'] : '' ?>
   <?= isset($data['succes']) ? $data['succes'] : '' ?>
</div>
</div> <!-- fin div row -->
  
<?php              
    $messagerie = (isset($_SESSION["username"]) && $_SESSION["username"] == $data["usager"]->getUsername()) ? "Messagerie" : "Contacter";
?>

<div class="container-fluid detail">
    <!-- Tout le monde peut voir -->
    <div class="row">
     
        <div class="col-sm-12 succes_erreur">	
        </div>
        
        <div class="col-md-4">
            <div class="row">
                <div id="photoProfilUsager" class="col-md-5">
                    <div id="photo"> <img src="<?=$data["usager"]->getPhoto() ?>" class="img img-fluid" width="100px"> </div>
                </div>
				<!--On affiche nom d'usager pour les gens pas connectés ou bannis ou non activés, ainsi que
					pour les connectés; 
					on affiche nom complet juste pour le proprio du profil qu'est active et pas banni ET pour le superadmin
					ET pour les admins actives et non bannis
				-->
                <div class="col-md-5" id="div_info_nom">
					<?php
					if(isset($_SESSION["username"])) {
						if((in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 || in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0) || ($_SESSION["username"] == $_REQUEST["idUsager"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0)  
						{
						?>
							<h3><?=$data["usager"]->getNom() ?> <?=$data["usager"]->getPrenom() ?></h3>
						<?php
						}
					}
					?>
					<h3 id="userNom">		
						<?=$data["usager"]->getUsername();?>
					</h3>
                </div>
            </div>
			<!-- Juste le proprio du profil qu'est connecte, active et pas banni peut changer sa photo			
			-->
			<?php 
			if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0 && $_SESSION["username"] == $_REQUEST["idUsager"]) 
			{
			?>
            <div class="mb-3">
                <div class="mb-3">                   
                   <button id="btn-profil" type="button" data-toggle="collapse" data-target="#collapsePhoto" aria-expanded="false" aria-controls="collapsePhoto">
                  Changer la photo
                   </button>
                </div>
                <div class="collapse" id="collapsePhoto">

                    <!-- ref: https://www.formget.com/ajax-image-upload-php/ -->
                    <div class="container ajoutImg">    
                        <form id="uploadimageProfil" action="" method="post" enctype="multipart/form-data">
                            <hr>
                                <div id="image_preview" class="text-center"><img id="previewing" src="" /><br><small></small></div>
                            <hr>
                                <div id="selectImage">
                                    <div id="ajoutImage">
                                        <label id="inputFile"><input type="file" name="file[]" id="file" required /></label>
                                    </div>
                                    <input type="hidden" name="action" value="ajouterPhoto" required />
                                </div>
                            
                            <div>
                                <input class="pull-right" type="submit" value="Upload" class="submit" />
                            </div>
                        </form>
                    </div>

                </div>
            </div>
			<?php
			}
			/* if(isset($_SESSION["username"])) 
            {
                if((in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 || in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0) || ($_SESSION["username"] == $_REQUEST["idUsager"]) )  
            {*/
			?>
            <div class="mb-3">
                <div class="mb-3">
                    <button id="btn-profil" type="button" data-toggle="collapse" data-target="#collapseProfil" aria-expanded="false" aria-controls="collapseProfil">
                   Profil
                    </button>
                </div>
                <div class="collapse" id="collapseProfil">
                    <div id="profilUser" class="">
                        <form class="form">
							<div class="panel">
								<div class="panel-header">Profil</div>
								<div class="panel-body pb-0">					
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-5 text-right">
                                            <small><label>Nom d'usager</label></small>
                                        </div>
                                        <div class="col-sm-8 col-md-7" id="div_user_nom"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-5 text-right">
                                            <small><label>Adresse</label></small>
                                        </div>
                                        <div class="col-sm-8 col-md-7" id="div_adresse">
                                        </div>    
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-5 text-right">
                                            <small><label>Téléphone</label></small>
                                        </div>
                                        <div class="col-sm-8 col-md-7" id="div_telephone">
                                        </div>    
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-5 text-right">
                                            <small><label>Mode de paiement</label></small>
                                        </div>
                                        <div class="col-sm-8 col-md-7" id="div_paiement">
                                        </div>    
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-5 text-right">
                                            <small><label>Moyen de contact</label></small>
                                        </div>
                                        <div class="col-sm-8 col-md-7" id="div_contact">
                                        </div>    
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4 col-md-5 text-right">
                                            <small><label>Vous êtes</label></small>
                                        </div>
                                        <div class="col-sm-8 col-md-7" id="div_role">
                                        </div>    
                                    </div>
                                    <div class="panel-footer text-right" id="div_modif_profil">
                                         <input type="hidden" name="usernameProp" value="<?=$data["usager"]->getUsername();?>">
                                    </div>     
								</div>
							</div>
                        </form>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" data-animation="false" id="myModal<?=$_SESSION["username"]?>" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-primary">
                            <h3 class="modal-title text-white">Modifier votre profil</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                              <form id="modifierProfil<?=$_SESSION["username"]?>">
                                   <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td>Prénom</td><td><input type="text" name="prenom" id="prenom" value="<?= isset($data['prenom']) ? $data['prenom'] : '' ?>"><small class="form-text text-muted" id="aidePrenom"></small></td>
                                            </tr>

                                            <tr>
                                                <td>Nom</td><td><input type="text" name="nom" id="nom" value="<?= isset($data['nom']) ? $data['nom'] : '' ?>"><small class="form-text text-muted" id="aideNom"></small></td>			
                                            </tr>

                                            <tr>
                                                <td>Adresse</td><td><input type="text" name="adresse" id="adresse" value="<?= isset($data['adresse']) ? $data['adresse'] : '' ?>"><small class="form-text text-muted" id="aideAdresse"></small></td>
                                            </tr>

                                            <tr>
                                                <td>Téléphone</td><td><input type="text" name="telephone" id="telephone" value="<?= isset($data['telephone']) ? $data['telephone'] : '' ?>"><small class="form-text text-muted" id="aideTel"></small></td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label for="paiement" class="form-control-label mr-sm-2">Type de paiement</label>
                                                </td>
                                                <td>
                                                    <select class="" name="paiement" id="modePaiement">
                                                  <?php 
                                                    foreach($data['modePaiementGeneral'] AS $p) {
                                                        if(isset($data['modePaiement'][0]->id)) {
                                                            if($data['modePaiement'][0]->id == $p['id']) { ?>
                                                              <option selected value=<?=  $p['id'] ?>><?= $p['modePaiement'] ?></option>
                                                  <?php     } 
                                                            else { ?>
                                                              <option value=<?= $p['id'] ?>><?= $p['modePaiement'] ?></option>
                                                  <?php     }
                                                        }
                                                        else { ?>
                                                            <option value=<?= $p['id'] ?>><?= $p['modePaiement'] ?></option>
                                                  <?php }
                                                    }
                                                    ?>
                                                    </select>
                                                    <small class="form-text text-muted" id="aideModePaiement"></small>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <label for="moyenComm" class="form-control-label mr-sm-2">Moyen de contact</label>
                                                </td>
                                                <td>
                                                    <select name="moyenComm" class="" id="moyenComm">
                                                        <?php foreach($data['modeCommunicationGeneral'] AS $c) { 
                                                                if(isset($data['modeCommunication'][0]->id )) { 
                                                                  if($data['modeCommunication'][0]->id  == $c['id']) { ?>
                                                                    <option selected value=<?= $c['id'] ?>><?= $c['moyenComm'] ?></option>
                                                        <?php     } 
                                                                  else { ?>
                                                                  <option value=<?= $c['id'] ?>><?= $c['moyenComm'] ?></option>
                                                        <?php     }
                                                                } 
                                                                else { ?>
                                                                  <option value=<?= $c['id'] ?>><?= $c['moyenComm'] ?></option>
                                                        <?php   }
                                                              } ?>
                                                        </select>
                                                    <small class="form-text text-muted" id="aideMoyenComm"></small>
                                                </td>
                                            </tr>							
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="idUser" value="<?=$_SESSION["username"]?>">
                                    <button type="button" id="submit_form<?=$_SESSION["username"]?>" class="btn btn-success sauvegarderForm">Sauvegarder</button>
                                </form>
                          </div>
                          <div class="modal-footer bg-primary">
                              <div class="erreurModif"></div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
			<?php /*
				}
			}*/
		?>
		<!--Juste le proprio du profil qu'est connecte, active et pas banni peut changer son mot de passe		
			-->
		<?php
		if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0 && $_SESSION["username"] == $_REQUEST["idUsager"]) 
		{
		?>
        <div class="mb-3">
            <div class="mb-3">
                <button id="btn-profil" type="button" data-toggle="collapse" data-target="#collapseMDP" aria-expanded="false" aria-controls="collapseMDP">
                Sécurité
                </button>
            </div>
            <div class="collapse" id="collapseMDP">
                <form class="form">
                    <div class="panel">
                        <div class="panel-header">Changer le mot de passe</div>
                        <div class="panel-body">
                            <div class="row mb-2">
                                <div class="col-sm-4 col-md-5 text-right">
                                    <small> <label>Mot de passe</label></small>
                                </div>
                                <div class="col-sm-8 col-md-7">
                                    <input type="password" name="pwd0" id="pwd0" class="col-sm-12 ">
                                    <small class="form-text text-muted" id="aidePwd0"></small>
                                </div>
                            </div>                         

                            <div class="row mb-2">
                                <div class="col-sm-4 col-md-5 text-right">
                                    <small> <label>Confirmer le mot de passe</label></small>
                                </div>
                                <div class="col-sm-8 col-md-7">
                                    <input type="password" name="pwd1" id="pwd1" class="col-sm-12">
                                    <small class="form-text text-muted" id="aidePwd1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <input type="hidden" name="idUserPass" value="<?=$_SESSION["username"]?>">
                            
                            <button type="button" id="submit_form_pass<?=$_SESSION["username"]?>" class="btn btn-success sauvegarderMotDePasse">Sauvegarder</button>
                            <div id="erreur_pass" class="col-sm-12 mt-3"></div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
		<?php 
		}
		?>
    </div>
        <div class="col-md-8" >
			<div class="row  justify-content-end" >
                <ul class="nav menuProfil">
                    <li class="nav-item" id="div_messagerie"></li>
                    <li class="nav-item" id="div_historique"></li>
				    <li class="nav-item" id="div_reservations"></li>
				    <li class="nav-item" id="div_mes_appts"></li>
                </ul>
			</div>
                <div class="row" id="afficheInfoProfil">  
                </div>
		</div>
    </div>
</div>

 <!-- Les gens connectes -->           
            <?php                                    
                if(isset($_SESSION["username"]) && $_SESSION["isActiv"] == 1 && $_SESSION["isBanned"] == 0) 
                {
            ?>

                <p class="nav-link" href="#" id="historique">Voyages</p>

            <?php                                    
                if(isset($_SESSION["username"]) && $_SESSION["username"] == $data["usager"]->getUsername()) 
                {
            ?>
                <p class="nav-link" name="Messagerie" id="messagerie" value="<?=$_SESSION["username"]?>">Messagerie</p>
            <?php                                    
                }
                else
                {
              ?> 
                <p class="nav-link" name="Contacter" id="messagerie" value="<?=$data["usager"]->getUsername()?>" onclick="formulaireNouveauMessage('afficheInfoProfil')">Contacter</p>
            <?php
                }
            ?>
                <!-- S'il y a des appartements en cas de proprio -->
                    <?php 
                        if($data["isProprio"]) {
                    ?>
                       <p class="nav-link" href="#" id="mes_appts">Appartements</p>
                   <?php      
                    }
                    ?>
				
                <!-- Le proprio du profil peux le voir avec toute l'info et Admin et SuperAdmin aussi (connectes, actives, pas bannis)-->  
                <?php

                if(isset($_SESSION["username"])) 
                {

                    if((in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 || in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0) || ($_SESSION["username"] == $_REQUEST["idUsager"] && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0))  
                    {
                    ?>
                        
                       <p id="data_user_nom"><?=$data["usager"]->getUsername();?></p> 
                       <p id="data_adresse"><?=$data["usager"]->getAdresse();?></p> 
                       <p id="data_telephone"><?=$data["usager"]->getTelephone();?></p> 
                       <p id="data_paiement"><?=isset($data["modePaiement"][0]->modePaiement) ? $data["modePaiement"][0]->modePaiement : "" ?></p> 
					   <p id="data_contact"> <?=$data["modeCommunication"][0]->moyenComm;?></p>
					   <p id="data_role">
						<?php
						foreach($data["usager"]->roles as $role)
						{
						?> 
						   <span class="mr-1"><?=$role->nomRole?></span>
						<?php
						}
						?>
						</p>
                     
                        <?php 
                        if($data["isClient"]) 
                        {
                        ?>  

                        <!-- si j'ai des réservations comme client -->
                        <a class="nav-link" href="#" id="reservations">Réservations</a>

                        <?php 
                        }
                    }
					/*Seulement le proprio du profil active, pas banni et connecte peut modifier son profil*/
                    if($_SESSION["username"] == $_REQUEST["idUsager"]) 
                    {
                    ?>
                     <button type="button" class="btn btn-primary btn-modifier" data-toggle="modal" data-target="#myModal<?=$_SESSION["username"]?>"  id="ModifierProfil<?=$_SESSION["username"]?>">Modifier le profil</button>
                     <button type="button" class="btn btn-info mb-2 btn-modifier"><a href="index.php?Usagers&action=afficherFormulaireImageProfil" >Modifier votre photo</a></button>

					<?php
                    }

                }
                
                $etatBann = ($data["usager"]->getBanni()=="0") ? 'Bannir' : 'Réhabiliter';
                $etatActiv = ($data["usager"]->getValideParAdmin()=="0") ? 'Activer' : 'Désactiver';
                $etatAdmin = ($data["isAdmin"]) ? 'Déchoir' : 'Promouvoir';
				?>
				
				<?php
                if(!$data["isSuperAdmin"])
                {
                    if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$data["isAdmin"] && !$data["isSuperAdmin"]))
                    {
                    ?>	  
                        <li class="dropdown nav-item col-md-6" id="div_action_admin">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions Admin
                          </button>
                        </li>
                        <div id="action_admin" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            
                            <li><button class="btn btn-default actionAdmin" name="inversBan" id="<?=$data["usager"]->getUsername()?>"><?=$etatBann?></button></li>
                            <li><button class="btn btn-default actionAdmin" name="inversActiv" id="<?=$data["usager"]->getUsername()?>"><?=$etatActiv?></button> </li>
                            <li><button class="btn btn-default actionAdmin" name="inversAdmin" id="<?=$data["usager"]->getUsername()?>"><?=$etatAdmin?></button> </li>

                        </div>
						
                    <?php
                    }    
                }
            }
        ?> 