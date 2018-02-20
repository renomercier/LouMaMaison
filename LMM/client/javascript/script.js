/**
  fonction pour se connecter ou se deconnecter du site.
*/
if($(".connextion a").text() == "logout")
{    
    $(".connextion").click(function(e) {
        $(this).each(function() {
        // envoi de la requete
            e.preventDefault();
           $.ajax({
                method: "GET",
                url: "index.php?Usagers&action=logout",
                dataType:"html",
        // comportement en cas de success ou d'echec
              success:function(reponse) {
                window.location.assign(window.location.pathname+"?Appartements");
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
            });
        });
    });
}
/**
  fonction pour faire les action d'administration sur un usager.
  (bannir/réhabiliter, promouvoir/déchoire, activer/désactiver).
*/
    $(".actionAdmin").click(function(e) {
        $(this).each(function() {
        // envoi de la requete
            e.preventDefault();
            idUser = $(this).attr('id');
            var action = $(this).attr('name');
            var text = $(this).html();
            var newText ='';

            if(action=='inversBan')
                 newText = (text == 'Bannir')? "Réhabiliter":"Bannir";
            if(action=='inversActiv')
                 newText = (text == 'Activer')? "Désactiver":"Activer";
            if(action=='inversAdmin')
                 newText = (text == 'Déchoir')? "Promouvoir":"Déchoir";
            
           $.ajax({
                method: "GET",
                url: "index.php?Usagers&action="+action+"&idUsager="+idUser,
                dataType:"html",
        // comportement en cas de success ou d'echec
              success:function(reponse) {
                $('#'+idUser+'[name='+action+']').html(newText);
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
            });

        });

    });



