<!--
* @file         /detailMessage.php
* @brief        Projet WEB 2
* @details      Affichage des détails d'un message
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->
<div class="ecrireMessage">
    <div class="table mt-2">
        <form>
          <div class="form-group">
            <label for="objet">Objet</label>
            <input type="text" class="form-control" id="objet" aria-describedby="objetHelp" value="">
            <small id="objetHelp" class="form-text text-muted">Titre de votre message</small>
          </div>

          <div class="form-group">
            <label for="messageTextarea">Message</label>
            <textarea class="form-control" id="messageTextarea" rows="3"></textarea>
          </div>

          <button type="submit" class="btn btn-success">Envoyer</button>
        </form>
    </div>
</div>