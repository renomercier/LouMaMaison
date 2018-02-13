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

      </tr>
    </thead>
    <tbody>
        <?php
       
            foreach($data["usagers"] as $usager)
            {    
                $isAdmin = false;
                $isSuperAdmin = false;
                
                foreach($usager->roles as $role)
                    {
                        if($role->id_nomRole == 1)
                        {
                            $isSuperAdmin = true;
                        }
                        if($role->id_nomRole == 2)
                        {
                            $isAdmin = true;
                        }
                    }
                
                $etatBann = ($usager->getBanni()=="0") ? 'Bannir' : 'Réhabiliter';
                $etatActiv = ($usager->getValideParAdmin()=="0") ? 'Activer' : 'Désactiver';
                $etatAdmin = ($isAdmin) ? 'Déchoir' : 'Promouvoir';
                
                ?>
                    <tr>
                        <td><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$usager->getUsername()?>"><?=$usager->getUsername()?></a></td>
                        <td><?=$usager->getNom()?></td>
                        <td><?=$usager->getPrenom()?></td>
                        <td>
                            <div>
                        <?php
                            foreach($usager->roles as $role)
                            {
                        ?> 
                                <span><?=$role->nomRole?></span><span> / </span>

                        <?php
                            }
                        ?>
                            </div>
                        </td>
                        <?php
                
                if(!$isSuperAdmin)
                {
                        if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$isAdmin && !$isSuperAdmin))
                        {
                        ?>
                            <td><a href="index.php?Usagers&action=inversBan&idUsager=<?=$usager->getUsername()?>"><?=$etatBann?></a></td>
                            <td><a href="index.php?Usagers&action=inversActiv&idUsager=<?=$usager->getUsername()?>"><?=$etatActiv?></a></td>
                            <td><a href="index.php?Usagers&action=inversAdmin&idUsager=<?=$usager->getUsername()?>"><?=$etatAdmin?></a></td>
                        <?php
                        }
                        ?>
                  </tr>
                <?php

                }
            }
        ?>
    </tbody>
  </table>
</div>