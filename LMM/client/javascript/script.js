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
    
    /**
	* 	Fonction pour afficher un profil d'usager
	*/
		$("#div_info_plus").append($("#info_plus"));
		
		$("#div_info_contact").append($("#info_contact"));
        
		$("#div_modif_profil").append($(".btn-modifier"));
		
		$("#div_messagerie").append($("#messagerie"));
		
		$("#div_action_admin").append($("#action_admin"));
       
		$(".menuProfil").append($("#div_action_admin"));
		
		$("#div_historique").append($("#historique"));
		
		$("#div_reservations").append($("#reservations"));
		
		$("#div_mes_appts").append($("#mes_appts"));
		
	/**
	* 	Fonction pour Modifier un profil d'usager
	*/	
		$(document).on('click', '.sauvegarderForm', function(e){
            var idUser = $(this).prev().val();	
			
            // une fois les validations js faites, on soumet le formulaire
            if(isName($("#nom").val()) && isName($("#prenom").val()) && isText($("#adresse").val()) && isPhoneNumber($("#telephone").val()) && $("#moyenComm").length &&  $("#moyenComm").length && isPassword($("#pwd0").val()) && valPwdConfirm($("#pwd1").val(), $("#pwd0").val()) ) {  
				// envoie la requête par ajax			
				var queryString1 = $("#modifierProfil"+idUser).serialize(); //recuperer l'info du formulaire
				$.ajax({
					cache: false,
					url: 'index.php?Usagers&action=modifierProfil&'+queryString1,
					method: "POST",
					dataType : 'json',		
					data: {
					dataJson: JSON.stringify({
						"prenom":$('input[name="prenom"]').val(),
						"nom":$('input[name="nom"]').val(),
						"adresse":$('input[name="adresse"]').val(),
						"telephone":$('input[name="telephone"]').val(),
						"moyenComm":$('#moyenComm').val(),
						"paiement":$('#modePaiement').val(),
                        "motdepasse":$("#pwd0").val(),
                        "idUser":$('input[name="idUser"]').val()
						}) 
					}, 
					success: function (response) {                       
						//vérification côté php, s'il y des erreurs
						if(response.messageErreur) {
                            $(".erreurModif").empty().addClass("alert alert-warning col-sm-8").html("<p>"+response.messageErreur + "</p>");
                        } 
                        else if(response[1].messageSucces){ //s'on n'as pas des erreurs côté php
                            $(".succes_erreur").empty().addClass("alert alert-success").html("<p>"+response[1].messageSucces + "</p>");
                            $("#myModal"+idUser).hide();
                            $('.modal-backdrop.fade.show').remove();
                            $("#div_info_nom").empty();
                            $("#div_info_plus").empty();
                            $("#div_info_contact").empty();
                            $("#div_info_nom").html("<h3>" + response[0][0].nom +" "+ response[0][0].prenom + "</h3>");               
                            $("#div_info_plus").html("<div class='form-group row col-sm-12'>Username : " + idUser + "</div><div class='form-group row col-sm-12'>Adresse : " + response[0][0].adresse + "</div><div class='form-group row col-sm-12'>Téléphone : " + response[0][0].telephone + "</div><div class='form-group row col-sm-12 mb-0'>Mode de paiement : " + response[0][0].modePaiement + "</div>");
                            $("#div_info_contact").html("<span id='info_contact'><div  class='form-group row col-sm-12' >Moyen de contact : " + response[0][0].moyenContact + "</div>");  
                        }
                       
					},  
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
				return;	
			}
			else {
			//empecher le comportement normal du bouton
			e.preventDefault();
					
			//validation de modification du profil js		
			var formulaire = $("#modifierProfil"+idUser);
			
			// validation format nom
			var valNom = isName($("#nom").val());
			(!valNom) ? ($("#nom").addClass('alert-warning'), $('#aideNom').empty().append('Le nom est invalide'))  : ($("#nom").removeClass('alert-warning'), $('#aideNom').empty());
			
			// validation format nom
			var valPrenom = isName($("#prenom").val());
			(!valPrenom) ? ($("#prenom").addClass('alert-warning'), $('#aidePrenom').empty().append('Le prénom est invalide'))  : ($("#prenom").removeClass('alert-warning'), $('#aidePrenom').empty());
			
			// validation format texte
			var valAdresse = isText($("#adresse").val());
			(!valAdresse) ? ($("#adresse").addClass('alert-warning'), $('#aideAdresse').empty().append('L\'adresse est invalide'))  : ($("#adresse").removeClass('alert-warning'), $('#aideAdresse').empty());
			
			// validation format telephone
			var valTelephone = isPhoneNumber($("#telephone").val());
			(!valTelephone) ? ($("#telephone").addClass('alert-warning'), $('#aideTel').empty().append('Le numéro de téléphone est invalide'))  : ($("#telephone").removeClass('alert-warning'), $('#aideTel').empty());
			
			// validation du mot de passe
			var valPwd0 = isPassword($("#pwd0").val());
			(!valPwd0) ? ($("#pwd0").addClass('alert-warning'), $('#aidePwd0').empty().append('Le mot de passe doit contenir au minimum une lettre majuscule ou un chiffre'))  : ($("#pwd0").removeClass('alert-warning'), $('#aidePwd0').empty());
			
			var valPwd1 = isPassword($("#pwd1").val());

			// verification si l'option est choisi
			var valMoyenComm = $("#moyenComm").length;
			(valMoyenComm !=1) ? ($("#moyenComm").addClass('alert-warning'), $('#aideMoyenComm').empty().append('Vous devez choisir un moyen de communication'))  : ($("#moyenComm").removeClass('alert-warning'), $('#aideMoyenComm').empty());
			
			// verification si l'id est un int
			var valModePaiement = $("#modePaiement").length;
			(valModePaiement !=1) ? ($("#modePaiement").addClass('alert-warning'), $('#aideModePaiement').empty().append('Vous devez choisir un mode de paiement'))  : ($("#modePaiement").removeClass('alert-warning'), $('#aideModePaiement').empty());
		}	
	});
		
});
		
		
/*----------------- A Ajouter dans le fichier functions!*/

/**
    Fonction pour comparer les mots de pass saisis
*/

 function valPwdConfirm(elm1, elm2) {
    if(elm1 !== elm2) {
        $("#pwd1").addClass('alert-warning'), $('#aidePwd1').empty().append('Les mots de passe entrés doivent être identiques');
        return false;					
    }
    else {
        $("#pwd1").removeClass('alert-warning'), $('#aidePwd1').empty();	
        return true;
    }
};





   
  