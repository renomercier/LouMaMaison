<!--
* @file         /listeMessages.php
* @brief        Projet WEB 2
* @details      Affichage d'une liste de messages recus
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="messages col-md-12">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#recus" role="tab" onclick="afficheListeMessages('<?=$_SESSION['username']?>', 'afficherListeMessages')">Boite de reception</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#envoyes" role="tab" onclick="afficheListeMessages('<?=$_SESSION['username']?>', 'afficheMessagesEnvoyes')">Messages envoyés</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nouveau" role="tab" onclick="formulaireNouveauMessage('nouveau')">Nouveau message</a>
      </li>
    </ul>
        <?php
            $DirectioMessage = $data['recus'] == true ? 'De' : 'À';
        ?>
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="recus" role="tabpanel">
              <div class="table-responsive">
                <table class="table">
                    <?php
                        if(count($data["messages"]) == 0)
                        {
                          ?>
                            <div class="col-md-12 mx-auto mt-5">
                                <div class="error-template text-center">
                                    <h3>Oops!</h3>
                                    <p>Votre boite est vide!</p>
                                </div>
                            </div>
                        <?php
                        }
                    else
                    {
                    ?>
                  <thead>
                    <tr>
                        <th></th>
                        <th><?=$DirectioMessage?></th>
                        <th>Objet</th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                  </thead>
                        <?php
                                foreach($data["messages"] as $message)
                                {   
                                    $action = $data['recus'] == true ? 'supprimerMessage' : 'archiverMessage';
                                    $expediteur = $data['recus'] == true ? $message->getId_userEmetteur() : $message->id_username;
                                    $idMessage = $message->id_message == null ? $message->getId() : $message->id_message;
                                    $enveloppe = $message->statut == 0 ? '<i class="fa fa-envelope text-warning"></i>' : '<i class="fa fa-envelope-open text-muted"></i>';
                                    $classeNonLu = $message->statut == 0 ? 'non_lu' : 'lu';
                                    $apercu = substr($message->getTitre(),0,20);
                                    ?>

                                    <tr class="<?=$classeNonLu?>">
                                        <td class="iconEnveloppe<?=$idMessage?>"><?=$enveloppe?></td>
                                        <td><a name="emetteur" href="index.php?Usagers&action=afficheUsager&idUsager=<?=$expediteur?>"><?=$expediteur?></a></td>
                                        <td><p name="detailMessage" onclick="afficheDetailsMessage(<?=$idMessage?>)"><?=$apercu?>...</p></td>
                                        <td class="text-muted dateMessage"><?=$message->getDateHeure()?></td>
                                        <td><h6 class="actionMessage" name="repondreMessage" value="<?=$idMessage?>" onclick="formulaireMessage('<?=$message->getId_userEmetteur()?>', <?=$idMessage?>, '<?=$apercu?>')"><i class="fa fa-reply text-muted"></i></h6></td>
                                        <td><h6 class="actionMessage" name="supprimeMessage" value="<?=$idMessage?>" onclick="supprimeMessage(<?=$idMessage?>, '<?=$action?>')"><i class="fa fa-trash text-danger" aria-hidden="true"></i></h6></td>
                                    </tr>
                                        <td colspan="6" name="contenuMessage" id="contenuMessage<?=$idMessage?>"></td>
                                    <?php    
                                }
                            }
                        ?>
                </table>
              </div><!--end of .table-responsive-->

            </div>
          <div class="tab-pane" id="envoyes" role="tabpanel"></div>
          <div class="tab-pane" id="nouveau" role="tabpanel"></div>
        </div>
</div>