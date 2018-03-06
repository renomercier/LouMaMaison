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
					<th>Hôte</th>
					<th>Date d'arrivée</th>
					<th>Date de départ</th>
					<th>Nombre personnes</th>
					<th>Confirmation</th>
					<th>Paiement</th>
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
						//client ne peut pas payer si le proprio n'a pas encore valide la demande/s'il déjà paié/si la demande est refusé
						if($appartement->getValideParPrestataire() == 0 || $appartement->getValidePaiement() == 1 || $appartement->getRefuse() == 1) {
							$disabled='disabled';
						}
						else {
							$disabled='';
						}
						
						if($appartement->getValideParPrestataire() == 0) {
							$confirmation = "En attente de confirmation";
						}
						else {
							$confirmation = "Confirmé";
						}
						
						if($appartement->getRefuse() == 1) {
							$confirmation = "Refusé";
						}
												
					?> 
							
						<tr>
							<td id="apt"><a href="index.php?Appartements&action=afficherAppartement&id_appart=<?=$appartement->getIdAppartement() ?>" >
			<!--<img src="<?=$photoApt?>" class="img" width="20%">--><?=$appartement->titre?>
			</a></td>
							<td id="username"><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$appartement->id_userProprio?>"><?=$appartement->id_userProprio?></a></td>
							<td id="dateDebut"><?=$appartement->getDateDebut();?></td>
							<td id="dateFin"><?=$appartement->getDateFin();?></td>
							<td id="nbPersonnes"><?=$appartement->getNbPersonnes();?></td>
							<td><?=$confirmation ?></td>
							<td><?=$appartement->getValidePaiement();?></td>
							<td><button id="payer" type="button" onclick="CalculerdonneePaiement(<?=$appartement->getId();?>)" class="btn btn-success" <?=$disabled?>>Payer</button></td>
						</tr>
								

				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
    
     <!-- Afficher lerésumé d'une location avant de passer au paiement -->
    <!-- Modal -->
    <div class="modal fade" data-animation="false" id="myModal<?=$appartement->getId();?>" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title text-white">Résumé de la location</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
              <div id="recapLocation"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">annuler</button>
          </div>
        </div>
      </div>
    </div>
</div>
