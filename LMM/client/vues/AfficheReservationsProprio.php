<!--
* @file         /AfficheReservationsProprio.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de demande de reservations chex profil du proprio
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div class="resultat">
    <div class="row">
		<div><?=isset($data['demande']) ? $data['demande'] : ""?></div>
		<?php
		if(!isset($data['demande']))
		{
		?>
		<table class="table table-responsive table-bordered">
			<thead class="thead-default">
				<tr>
					<th>Appartement</th>
					<th>Usager</th>
					<th>Date d'arrivée</th>
					<th>Date de départ</th>
					<th>Nombre hôtes</th>
					<th>Status Validation</th>
					<th>Confirmer demande</th>				
					<th>Status Refus</th>
					<th>Refuser demande</th>
					<th>Status Paiement</th>	
					<th>Valider paiement</th>	
					<th>Annuler réservation</th>	
					<th>Avis</th>
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
						
						if($appartement->getValideParPrestataire() == 1 || $appartement->getValidePaiement() == 1 || $appartement->getRefuse() == 1) {
							$disabled='disabled';
						}
						else {
							$disabled='';
						}
						
						if($appartement->getValidePaiement() == 1 || $appartement->getValideParPrestataire() == 0 || $appartement->getRefuse() == 1) {
							$disabledAnnuler='disabled';
						}
						else {
							$disabledAnnuler='';
						}
						
						if($appartement->getValidePaiement() == 0) {
							$disabledValider='disabled';
						}
						else {
							$disabledValider='';
						}
						
						if($appartement->getValideParPrestataire() == 0) {
							$confirmation = "En attente";
						}
						else {
							$confirmation = "Confirmé";
						}
						
						if($appartement->getValidePaiement() == 0) {
							$paiement = "Non";
						}
						else {
							$paiement = "Oui";
						}
						
						if($appartement->getRefuse() == 1) {
							$refus = "Refusé";
						}
						else
						{
							$refus = "";
						}
												
					?> 
							
									<tr>
										<td id="apt"><a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getIdAppartement() ?>" target="_blank">
						<!--<img src="<?=$photoApt?>" class="img" width="20%">--><?=$appartement->titre?>
						</a></td>
										<td id="username"><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->getIdUserClient()?>" target="_blank"><img src="<?=$appartement->photo?>" class="aptPhotoProprio rounded-circle img-fluid"></a></td>
										<td id="dateDebut"><?=$appartement->getDateDebut();?></td>
										<td id="dateFin"><?=$appartement->getDateFin();?></td>
										<td id="nbPersonnes"><?=$appartement->getNbPersonnes();?></td>
										<td><?=$confirmation?></td>
										<td><button id="confirmerReservation" type="button" value="<?=$appartement->getId()?>" class="btn btn-success" <?=$disabled?>>Confirmer</button></td>
										<td><?=$refus?></td>
										<td><button  id="refuserReservation" type="button" value="<?=$appartement->getId()?>" <?=$disabled?> class="btn btn-danger">Refuser</button></td>
										<td><?=$paiement?></td>
										<td><button  id="validerLocation" type="button" value="<?=$appartement->getId()?>" <?=$disabledValider?> class="btn btn-success">Valider</button></td>
										<td><button  id="annulerReservation" type="button" value="<?=$appartement->getId()?>" <?=$disabledAnnuler?> class="btn btn-danger">Annuler</button></td>
										
										<td id="erreur_demande<?=$appartement->getId()?>"></td>
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
