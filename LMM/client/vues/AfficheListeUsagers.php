<h1>Liste de tous les usagers</h1>
<div class="container">          
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Username</th>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Statut</th>

      </tr>
    </thead>
    <tbody>
		<?php
       
			foreach($data["usagers"] as $usager)
			{    
                $isAdmin = false;
				$etatBann = ($usager->getBanni()=="0") ? 'Bannir' : 'Réhabiliter';
                $etatActiv = ($usager->getValideParAdmin()=="0") ? 'Activer' : 'Désactiver';
		?>
			<tr>
				<td><a href="index.php?Usagers&action=affiche&idUsager=<?=$usager->getUsername()?>"><?=$usager->getUsername()?></a></td>
				<td><?=$usager->getNom()?></td>
				<td><?=$usager->getPrenom()?></td>
                <td>
                    <div>
				<?php
                    foreach($usager->roles as $role)
                    {
                        if($role->id_nomRole == 1 || $role->id_nomRole == 2)
                        {
                            $isAdmin = true;
                        }
                ?> 
                    <span><?=$role->nomRole?></span><span> / </span>
                
                <?php
                    }
                ?>
                    </div>
                </td>
                <?php
				if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$isAdmin))
				{
				?>
					<td><a href="index.php?Usagers&action=inversBan&idUsager=<?=$usager->getUsername()?>"><?=$etatBann?></a></td>
                    <td><a href="index.php?Usagers&action=inversActiv&idUsager=<?=$usager->getUsername()?>"><?=$etatActiv?></a></td>
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