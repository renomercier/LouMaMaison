    <!--
    * @file         /AfficheListeUsagers.php
    * @brief        Projet WEB 2
    * @details      Affichage de tous les usagers - vue partielle
    * @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
    * @version      v.1 | fevrier 2018
    -->
        <div class="table-responsive">
              <table class="table mt-5">
                <thead class="thead-inverse">
                  <tr>
                    <th class="pl-2 text-white">Username</th>
                    <th class="pl-2 text-white">Nom</th>
                    <th class="pl-2 text-white">Prenom</th>
                    <th class="pl-2 text-white">Statut</th>
                    <th class="pl-2 text-white"></th>
                  </tr>
                </thead>
                <tbody>
                    <?php

                        foreach($data["usagers"] as $usager)
                        {    
                            if($usager->isSuperAdmin)
                            {
                            ?>
                            <tr class="table-warning">
                               <?php
                            }else{
                                ?>
                                <tr>
                                    <?php
                                    }
                                    ?>
                                        <td><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$usager->getUsername()?>"><?=$usager->getUsername()?></a></td>
                                        <td><?=$usager->getNom()?></td>
                                        <td><?=$usager->getPrenom()?></td>
                                        <td>
                                            <div>
                                        <?php
                                            foreach($usager->roles as $role)
                                            {
                                        ?> 
                                                <span><?=$role->nomRole?></span><br>

                                        <?php
                                            }
                                        ?>
                                            </div>
                                    </td>
                                    <td>
                                    <?php

                            if(!$usager->isSuperAdmin)
                            {
                                    if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1) || (isset($_SESSION["username"]) && in_array(2,$_SESSION["role"]) && $_SESSION["isActiv"] ==1 && $_SESSION["isBanned"] ==0 && !$usager->isAdmin && !$usager->isSuperAdmin))
                                    {
                                    ?>
                                        <h6 class="actionAdmin" onclick="actionAdmin('<?=$usager->getUsername()?>', 'inversBan')" name="inversBan" id="<?=$usager->getUsername()?>"><?=$usager->etatBann?></h6>
                                        <h6 class="actionAdmin" onclick="actionAdmin('<?=$usager->getUsername()?>', 'inversActiv')" name="inversActiv" id="<?=$usager->getUsername()?>"><?=$usager->etatActiv?></h6>
                                    <?php
                                    }
                                    if((isset($_SESSION["username"]) && in_array(1,$_SESSION["role"]) && $_SESSION["isActiv"] ==1))
                                    {
                                    ?>
                                    <h6 class="actionAdmin" onclick="actionAdmin('<?=$usager->getUsername()?>', 'inversAdmin')" name="inversAdmin" id="<?=$usager->getUsername()?>"><?=$usager->etatAdmin?></h6>
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
        </div>
    </div>
</div>