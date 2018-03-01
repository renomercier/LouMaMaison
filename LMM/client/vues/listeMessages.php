<!--
* @file         /listeMessages.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de messages recus
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="messages col-md-12">
    <?php
    if(count($data["messages"]) != 0)
    {
    ?>
        <table class="table mt-5">
            <thead>
              <tr>
                <th></th>
                <th>Emetteur</th>
                <th>Titre</th>
                <th>Date</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php
                        foreach($data["messages"] as $message)
                        {   
                            $enveloppe = $message->statut == 0 ? '<i class="fa fa-envelope text-warning"></i>' : '<i class="fa fa-envelope-open text-muted"></i>';
                            ?>
                                <tr>
                                        <td><?=$enveloppe?></td>
                                        <td><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$message->getId_userEmetteur()?>"><?=$message->getId_userEmetteur()?></a></td>
                                        <td><p name="detailMessage" value="<?=$message->id_message?>"><?=$message->getTitre()?></p></td>
                                        <td class="text-muted"><?=$message->getDateHeure()?></td>
                                        <td><h6 class="actionMessage" name="supprimeMessage" value="<?=$message->id_message?>" onclick="supprimeMessage(<?=$message->id_message?>)"><i class="fa fa-reply"></i></h6></td>
                                        <td><h6 class="actionMessage" name="supprimeMessage" value="<?=$message->id_message?>" onclick="supprimeMessage(<?=$message->id_message?>)"><i class="fa fa-trash" aria-hidden="true"></i></h6></td>
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
                    <div class="col-md-12 mx-auto mt-5">
                        <div class="error-template text-center">
                            <h3>Oops!</h3>
                            <p>Votre boite de reception est vide!</p>
                        </div>
                    </div>
                <?php
                }
            ?>
</div>