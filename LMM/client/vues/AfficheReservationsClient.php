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
		<table class="table table-responsive table-bordered">
			<thead class="thead-default">
				<tr>
					<th>Logement</th>
					<th>Hôte</th>
					<th>Arrivée</th>
					<th>Départ</th>
					<th>Hôtes</th>
					<th>Statut</th>
					<th>Payer</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if($data["appartements"]){
					foreach($data["appartements"] as $appartement)
					{ 
									
						if ($appartement->photoPrincipale != "") {
							$photoApt = $appartement->photoPrincipale;
						} else {
							$photoApt = "./images/profil_resize.jpg";
						}
												
						if($appartement->getValideParPrestataire() == 0 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 0) {
							$confirmation = "En attente";
						}
						else if ($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 0){
							$confirmation = "Confirmé";
						}
						else if($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 1) {
							$confirmation = "Payé";
						}
						else if($appartement->getValideParPrestataire() == 0 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 1) {
							$confirmation = "Refusé";
						}							
					?> 
							
						<tr>
							<td id="apt"><a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getIdAppartement() ?>" >
			<!--<img src="<?=$photoApt?>" class="img" width="20%">--><?=$appartement->titre?>
			</a></td>
							<td id="username"><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->id_userProprio?>" target="_blank"><?=$appartement->id_userProprio?></a></td>
							<td id="dateDebut"><?=$appartement->getDateDebut();?></td>
							<td id="dateFin"><?=$appartement->getDateFin();?></td>
							<td id="nbPersonnes"><?=$appartement->getNbPersonnes();?></td>
							<td><?=$confirmation ?></td>
                            <!--client ne peut pas payer si le proprio n'a pas encore valide la demande/s'il déjà paié/si la demande est refusé-->
                            <td>
						<?php
                        if($appartement->getValideParPrestataire() == 1 && $appartement->getValidePaiement() == 0 && $appartement->getRefuse() == 0) 
                        {
                        ?>
							<button type="button" value="" class="btn btn-success">Payer</button>
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
