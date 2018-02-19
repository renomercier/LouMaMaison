$(document).ready(function() {
    
    /**
  fonction pour afficher la liste des présentations
  par categorie.
  defini les styles css des elements et leurs effets.
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
    
    
    //Afficher profil d'usager
		$("#div_info_plus").append($("#info_plus"));
		
		$("#div_info_contact").append($("#info_contact"));
        
		$("#div_modif_profil").append($(".btn-modifier"));
		
		$("#div_messagerie").append($("#messagerie"));
		
		$("#div_action_admin").append($("#action_admin"));
       
		$(".menuProfil").append($("#div_action_admin"));
		
		$("#div_historique").append($("#historique"));
		
		$("#div_reservations").append($("#reservations"));
		
		$("#div_mes_appts").append($("#mes_appts"));
		
    //Action: Modifier le profil d'usager
	$(document).on('click', '.sauvegarder', function(e){
	e.preventDefault();
	var idUser = $(this).prev().val();
	
	var formulaire = $("#modifierProfil"+idUser).serialize();

	$.ajax({
        cache: false,
		url: 'index.php?Usagers&action=modifierProfil&'+formulaire,
		method: "POST",
		dataType : 'json',		
		data: {
		dataJson: JSON.stringify({
			"prenom":$('input[name="prenom"]').val(),
			"nom":$('input[name="nom"]').val(),
			"adresse":$('input[name="adresse"]').val(),
			"telephone":$('input[name="telephone"]').val(),
			"moyenComm":$('#moyenComm').val(),
			"paiement":$('#modePaiement').val()
			}) 
		}, 
		success: function (response) {
		
        $("#myModal"+idUser).hide();
        $('.modal-backdrop.fade.show').remove();
		$("#div_info_nom").empty();
        $("#div_info_plus").empty();
        $("#div_info_contact").empty();
		$("#div_info_nom").html("<h3>" + response.nom +" "+ response.prenom + "</h3>");                 
        $("#div_info_plus").html("<div class='form-group row col-sm-12'>Username : " + idUser + "</div><div class='form-group row col-sm-12'>Adresse : " + response.adresse + "</div><div class='form-group row col-sm-12'>Téléphone : " + response.telephone + "</div><div class='form-group row col-sm-12 mb-0'>Mode de paiement : " + response.modePaiement + "</div>");
        $("#div_info_contact").html("<span id='info_contact'><div  class='form-group row col-sm-12' >Moyen de contact : " + response.moyenContact + "</div>");   
		},  
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
});
			

        
        
});
        
    });

