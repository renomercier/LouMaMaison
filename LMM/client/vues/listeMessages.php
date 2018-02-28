<!--
* @file         /listeMessages.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de messages recus
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="messages">
    <?php
    if(count($data["messages"]) != 0)
    {
    ?>
        <table class="table mt-5">
            <thead>
              <tr>
                <th>Emetteur</th>
                <th>Titre</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php
                        foreach($data["messages"] as $message)
                        {    
                            ?>
                                <tr>
                                        <td><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$message->getId_userEmetteur()?>"><?=$message->getId_userEmetteur()?></a></td>
                                        <td><h7 name="detailMessage" value="<?=$message->id_message?>"><?=$message->getTitre()?></h7></td>
                                        <td class="text-muted"><?=$message->getDateHeure()?></td>
                                        <td><h6 class="actionMessage" name="supprimeMessage" value="<?=$message->id_message?>" onclick="supprimeMessage(<?=$message->id_message?>)">Supprimer</h6></td>
                                </tr>
                                <tr name="contenuMessage" id="contenuMessage<?=$message->id_message?>"></tr>
                            <?php    
                        }

                ?>
            </tbody>
        </table>
            <?php
                }else
                {
                  ?>
                        <p>rien</p>
                <?php
                }
            ?>
</div>