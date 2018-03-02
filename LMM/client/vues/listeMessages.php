<!--
* @file         /listeMessages.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de messages recus
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

    <?php
    if(count($data["messages"]) != 0)
    {
    ?>


<div class="messages col-md-12">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
                <th></th>
                <th>De</th>
                <th>Objet</th>
                <th>Date</th>
                <th></th>
                <th></th>
            </tr>
          </thead>
                <?php
                    foreach($data["messages"] as $message)
                    {   
                        $enveloppe = $message->statut == 0 ? '<i class="fa fa-envelope text-warning"></i>' : '<i class="fa fa-envelope-open text-muted"></i>';
                        $apercu = substr($message->getTitre(),0,20);
                        ?>

                        <tr>
                            <td class="iconEnveloppe<?=$message->id_message?>"><?=$enveloppe?></td>
                            <td><a href="index.php?Usagers&action=afficheUsager&idUsager=<?=$message->getId_userEmetteur()?>"><?=$message->getId_userEmetteur()?></a></td>
                            <td><p name="detailMessage" onclick="afficheDetailsMessage(<?=$message->id_message?>)"><?=$apercu?>...</p></td>
                            <td class="text-muted dateMessage"><?=$message->getDateHeure()?></td>
                            <td><h6 class="actionMessage" name="repondreMessage" value="<?=$message->id_message?>" onclick="formulaireMessage(<?=$message->id_message?>, <?=$apercu?>)"><i class="fa fa-reply"></i></h6></td>
                            <td><h6 class="actionMessage" name="supprimeMessage" value="<?=$message->id_message?>" onclick="supprimeMessage(<?=$message->id_message?>)"><i class="fa fa-trash" aria-hidden="true"></i></h6></td>
                        </tr>
                
                            <td colspan="6" name="contenuMessage" id="contenuMessage<?=$message->id_message?>"></td>
                      

                        <?php    
                    }
                ?>
        </table>
      </div><!--end of .table-responsive-->

</div>

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
