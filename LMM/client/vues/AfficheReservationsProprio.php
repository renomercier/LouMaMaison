<!--
* @file         /AfficheReservationsProprio.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de demande de reservations chex profil du proprio
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div class="resultat">
    <div class="row">
		<table class="table">
			<thead>
				<tr>
					<th>Appartement</th>
					<th>Usager</th>
					<th>Date d'arrivée</th>
					<th>Date de départ</th>
					<th>Nombre personnes</th>
					<th>Validation</th>
					<th>Paiement</th>
					<th>Confirmer</th>
					<th>Annuler</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if($data["apts"]){
					foreach($data["apts"] as $appartement)
					{ 
									
						if ($appartement->photoPrincipale != "") {
							$photoApt = $appartement->photoPrincipale;
						} else {
							$photoApt = "./images/profil_resize.jpg";
						}
						
						if($appartement->getValideParPrestataire() == 1 || $appartement->getValidePaiement() == 1) {
							$disabled='disabled';
						}
						else {
							$disabled='';
						}
												
					?> 
							
									<tr>
										<td id="apt"><a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getIdAppartement() ?>" >
						<!--<img src="<?=$photoApt?>" class="img" width="20%">--><?=$appartement->titre?>
						</a></td>
										<td id="username"><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->getIdUserClient()?>"><img src="<?=$appartement->photo?>" class="aptPhotoProprio rounded-circle img-fluid"></a></td>
										<td id="dateDebut"><?=$appartement->getDateDebut();?></td>
										<td id="dateFin"><?=$appartement->getDateFin();?></td>
										<td id="nbPersonnes"><?=$appartement->getNbPersonnes();?></td>
										<td><?=$appartement->getValideParPrestataire();?></td>
										<td><?=$appartement->getValidePaiement();?></td>
										<td><button id="confirmerReservation" type="button" value="<?=$appartement->getId()?>" class="btn btn-success" <?=$disabled?>>Confirmer</button><span id="messageConfirm"></span></td>
										<td id="annuler"><button type="button" value="" <?=$disabled?> class="btn btn-danger">Réfuser</button></td>
									</tr>
								

				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
