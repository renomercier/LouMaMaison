<!--
* @file         /AfficheReservationsProprio.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de demande de reservations chex profil du proprio
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div class="resultat">
    <div class="row">
		<div class="text-warning"><?=isset($data['demande']) ? $data['demande'] : ""?></div>
		<?php
		if(!isset($data['demande']))
		{
		?>
        <div id="erreur_demande"></div>
		<table class="table table-sm table-responsive-sm table-bordered">
			<thead class="thead-default">
				<tr>
					<th class="th-sm tabDetail">Logement</th>
					<th class="th-sm tabDetail">Usager</th>
					<th class="th-sm tabDetail tabToHide">Arrivée</th>
					<th class="th-sm tabDetail tabToHide">Départ</th>
					<th class="th-sm tabDetail tabToHide">Hôtes</th>
					<th class="th-sm tabDetail">Status</th>
					<th class="th-sm tabDetail"></th>				
					<th class="th-sm tabDetail"></th>
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
									
						if($appartement->getValideParPrestataire() == 0 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 0) {
							$confirmation = "En attente";
						}
						else if ($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 0){
							$confirmation = "Confirmé";
						}
						else if($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 1) {
							$confirmation = "Payé";
						}
						else if($appartement->getValideParPrestataire() == 0 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 1) {
							$confirmation = "Refusé";
						}
						else if($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 1) {
							$confirmation = "Annulé";
						}
												
					?> 
							
						<tr id="apt<?=$appartement->getId()?>">
							<td id="apt" class="tabDetail"><a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getIdAppartement() ?>" target="_blank"><?=$appartement->titre?></a></td>
							<td id="username"  class="tabDetail" name="<?=$appartement->getIdUserClient()?>"><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->getIdUserClient()?>" target="_blank"><?=$appartement->getIdUserClient()?></a></td>
							<td id="dateDebut" class="tabDetail tabToHide"><?=$appartement->getDateDebut();?></td>
							<td id="dateFin" class="tabDetail tabToHide"><?=$appartement->getDateFin();?></td>
							<td id="nbPersonnes" class="tabDetail tabToHide"><?=$appartement->getNbPersonnes();?></td>
							<td class="tabDetail"><?=$confirmation?></td>
							<td class="tabDetail">
								<?php
									if($appartement->getValideParPrestataire() == 0 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 0) 
									{
								?>
										<button id="" type="button" value="<?=$appartement->getId()?>" class="tabDetail btn btn-success btn-sm confirmerReservation">Confirmer</button>                                          
									<button  id="" type="button" value="<?=$appartement->getId()?>" class="tabDetail btn btn-danger btn-sm refuserReservation">Refuser</button>

								<?php
									}

									if($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 0) 
									{
								?>
									<button  id="" type="button" value="<?=$appartement->getId()?>" class="tabDetail btn btn-danger btn-sm annulerReservation">Annuler</button>
								<?php
									}
								?>
							</td>
						</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
		<?php
		}
		?>
	</div>
</div>