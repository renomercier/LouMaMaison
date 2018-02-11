<!--
* @file         /AfficheListeUsagers.php
* @brief        Projet WEB 2
* @details      Affichage de tous les usagers - vue partielle
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<h1>Liste de tous les usagers</h1>
<div class="container">          
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Username</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Statut</th>
        <th>Etat</th>
      </tr>
    </thead>
    <tbody>
		<?php
       
			foreach($data["usagers"] as $usager)
			{         
				$etat = ($usager->getBanni()=="0") ? 'Bannir' : 'Réhabiliter'; 
		?>
			<tr>
				<td><a href="index.php?Usagers&action=affiche&idUsager=<?=$usager->getUsername()?>"><?=$usager->getUsername()?></a></td>
				<td><?=$usager->getNom()?></td>
				<td><?=$usager->getPrenom()?></td>
                <td><div>
				<?php
                    foreach($usager->roles as $role)
                    {
                ?> 
                    <p><?=$role->nomRole?></p>
                
                <?php
                    }
				if(isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isBanned"] ==0)
				{
				?>
                    </div></td>
					<td><a href="index.php?Usagers&action=inversBan&idUsager=<?=$usager->getUsername()?>"><?=$etat?></a></td>
				<?php
				}
				?>
	      </tr>
		<?php
		      
            }
		?>
    </tbody>
  </table>
</div>