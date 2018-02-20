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
	* 	Fonction pour afficher profil d'usager
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
	* 	Fonction pour Modifier le profil d'usager
	*/	
		$(document).on('click', '.sauvegarderForm', function(e){
			
			// une fois les validations faites, on soumet le formulaire
			if(valNom && valPrenom && valAdresse && valTelephone && valPwd0  && valMoyenComm  && valModePaiement) {  //&& valPwdConfirm()
					
				// soumission du formulaire
				//$("#modifierProfil"+idUser).submit();
				var queryString = $("#modifierProfil"+idUser).serialize();
				$.ajax({
					cache: false,
					url: 'index.php?Usagers&action=modifierProfil&'+queryString,
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
						//$(".succes_erreur").addClass("alert alert-success").html("<p>Votre profil a été modifié avec succes!</p>");
						//$(".succes_erreur").addClass("alert alert-success").html(response[0]);
					},  
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
				return;	
			}
			else {
			e.preventDefault();
			
			var idUser = $(this).prev().val();			
			//validation de modification du profil
		
			var formulaire = $("#modifierProfil"+idUser);
			
			// validation format nom
			var valNom = isName($("#nom").val());
			(!valNom) ? ($("#nom").addClass('alert-warning'), $('#aideNom').empty().append('Le nom est invalide'))  : ($("#nom").removeClass('alert-warning'), $('#aideNom').empty());
			
			// validation format nom
			var valPrenom = isName($("#prenom").val());
			(!valPrenom) ? ($("#prenom").addClass('alert-warning'), $('#aidePrenom').empty().append('Le prénom est invalide'))  : ($("#prenom").removeClass('alert-warning'), $('#aidePrenom').empty());
			
			// validation formulaireat texte
			var valAdresse = isText($("#adresse").val());
			(!valAdresse) ? ($("#adresse").addClass('alert-warning'), $('#aideAdresse').empty().append('L\'adresse est invalide'))  : ($("#adresse").removeClass('alert-warning'), $('#aideAdresse').empty());
			
			// validation format telephone
			var valTelephone = isPhoneNumber($("#telephone").val());
			(!valTelephone) ? ($("#telephone").addClass('alert-warning'), $('#aideTel').empty().append('Le numéro de téléphone est invalide'))  : ($("#telephone").removeClass('alert-warning'), $('#aideTel').empty());
			
			// validation du mot de passe
			var valPwd0 = isPassword($("#pwd0").val());
			(!valPwd0) ? ($("#pwd0").addClass('alert-warning'), $('#aidePwd0').empty().append('Le mot de passe doit contenir au minimum une lettre majuscule ou un chiffre'))  : ($("#pwd0").removeClass('alert-warning'), $('#aidePwd0').empty());
			
			// verification si les mots de passe sont identiques
			/*var valPwd1 = isPassword($("#pwd1").val());
			(valPwd1 !== valPwd0) ? ($("#pwd1").addClass('alert-warning'), $('#aidePwd1').empty().append('Les mots de passe entrés doivent être identiques'))  : ($("#pwd1").removeClass('alert-warning'), $('#aidePwd1').empty());*/
			
		/*	var valPwd1 = isPassword($("#pwd1").val());
			
			function valPwdConfirm() {
				if(valPwd0 !== valPwd1) {
					$("#pwd1").addClass('alert-warning'), $('#aidePwd1').empty().append('Les mots de passe entrés doivent être identiques');
					return false;					
				}
				else {
					$("#pwd1").removeClass('alert-warning'), $('#aidePwd1').empty();	
					return true;
				}
			};*/
		
			
			// verification si l'id est un int
			var valMoyenComm = $("#moyenComm").length;
			(valMoyenComm !=1) ? ($("#moyenComm").addClass('alert-warning'), $('#aideMoyenComm').empty().append('Vous devez choisir un moyen de communication'))  : ($("#moyenComm").removeClass('alert-warning'), $('#aideMoyenComm').empty());
			
			// verification si l'id est un int
			var valModePaiement = $("#modePaiement").length;
			(valModePaiement !=1) ? ($("#modePaiement").addClass('alert-warning'), $('#aideModePaiement').empty().append('Vous devez choisir un mode de paiement'))  : ($("#modePaiement").removeClass('alert-warning'), $('#aideModePaiement').empty());
		}	
	});
		
});
		
		
/*  ------------------------------------------------    @fonctions de validation    */
  

    /**
    * @brief    Fonction qui verifie si un champ nom est valide - validation avec RegExp         
    * @param    <string>    elm     valeur de l'input (nom, prenom)          
    * @return   true (le resultat) si le nom est valide, sinon false
    */
    function isName(elm) {

        //  ne tolere aucun espace avant le premier mot ni après le dernier mot
        var regEx = /^\S[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ\-'\s]*\S$/gi;     
        var result = elm.match(regEx); 
        return result ? result : false;
    }    
   
   /**
    * @brief    Fonction qui verifie si un champ texte est valide - validation avec RegExp            
    * @param    <string>    inputValue   valeur du texte de l'input             
    * @return   true (le resultat) si le nom est valide, sinon false
    */
    function isText(elm) {
        
        //  ne tolere aucun espace avant le premier mot ni après le dernier mot
        var regEx = /^\S[0-9a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ@"$%#*&=+;:\/\)\(?!_.,\-'\s]*\S$/gi;     
        var result = elm.match(regEx); 
        return result ? result : false;       
    } 

    /**
    * @brief    Fonction qui verifie si un champ mot de passe est au bon format
    * @details  Fonction qui cible la valeur de l'input 'mot de passe' d'un formulaire et verifie son format avec une RegExp
    * @param    <objet>    form      le formulaire             
    * @return   true (le resultat) si le format est bon, sinon null
    */
    function isPassword(elm) {    
        
        //	var regEx =	/^(?!.*\s).*[a-z]+.*[\d]+.*$/g; 
        // positive lookahead: au moins une lettre maj. ou un chiffre | negative lookahead: pas d'espaces permis                   
        var regEx = /^(?=.*[A-Z\d])(?!.*\s).{8,20}$/g;              
        var result = elm.match(regEx);
        return result;
    }

   

    /**
    * @brief    Fonction qui verifie si un champ telephone est valide
    * @details  Fonction qui cible la valeur phone (telephone) de l'input d'un formulaire et verifie sa validite avec une RegExp         
    * @param    <value>     elm     valeur l'input telephone             
    * @return   true ou null (le resultat) 
    */
    function isPhoneNumber(elm) {

        var regEx = /^1?[-\s.]?(\d{3})[-\s.]?(\d{3})[-\s.](\d{4})$/g;
        var result = elm.match(regEx);
        
        return result ? result : false;
    }

  