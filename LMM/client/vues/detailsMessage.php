<!--
* @file         /detailMessage.php
* @brief        Projet WEB 2
* @details      Affichage des détails d'un message
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="message">
    <div class="table mt-2">
        <div class="card-block">
            <h4 class="card-title">Objet : <?=$data['message']->getTitre();?></h4>
            <p class="card-text">Message :</p>
            <p class="card-text mt-2 border-top-0 rounded"><?=$data['message']->getSujet();?></p>
        </div>
    </div>
</div>