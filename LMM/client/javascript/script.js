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
		$(document).on('click', '.sauvegarder', function(e){
			e.preventDefault();
			var idUser = $(this).prev().val();			
			//validation de modification du profil
			 $("#submit_form"+idUser).on( "click", function(e) {
				 e.preventDefault();
				// une fois les validations faites, on soumet le formulaire
				if(valNom && valPrenom && valAdresse && valTelephone && valPwd0 && valPwd1 && (form.client.checked ? valMoyenComm  && valModePaiement : valMoyenComm)) {  
					// recuperation du formulaire
			var formulaire = $("#modifierProfil"+idUser);

			// validation format nom
			var valNom = isName(formulaire.nom.value);
			(!valNom) ? ($('#' + formulaire.nom.id).addClass('alert-warning'), $('#aideNom').empty().append('Le nom est invalide'))  : ($('#' + formulaire.nom.id).removeClass('alert-warning'), $('#aideNom').empty());
			
			// validation format nom
			var valPrenom = isName(formulaire.prenom.value);
			(!valPrenom) ? ($('#' + formulaire.prenom.id).addClass('alert-warning'), $('#aidePrenom').empty().append('Le prénom est invalide'))  : ($('#' + formulaire.prenom.id).removeClass('alert-warning'), $('#aidePrenom').empty());
			
			// validation formulaireat texte
			var valAdresse = isText(formulaire.adresse.value);
			(!valAdresse) ? ($('#' + formulaire.adresse.id).addClass('alert-warning'), $('#aideAdresse').empty().append('L\'adresse est invalide'))  : ($('#' + formulaire.adresse.id).removeClass('alert-warning'), $('#aideAdresse').empty());
			
			// validation format telephone
			var valTelephone = isPhoneNumber(formulaire.telephone.value);
			(!valTelephone) ? ($('#' + formulaire.telephone.id).addClass('alert-warning'), $('#aideTel').empty().append('Le numéro de téléphone est invalide'))  : ($('#' + formulaire.telephone.id).removeClass('alert-warning'), $('#aideTel').empty());
			
			// validation du mot de passe
			var valPwd0 = isPassword(formulaire.pwd0.value);
			(!valPwd0) ? ($('#' + formulaire.pwd0.id).addClass('alert-warning'), $('#aidePwd0').empty().append('Le mot de passe doit contenir au minimum une lettre majuscule ou un chiffre'))  : ($('#' + formulaire.pwd0.id).removeClass('alert-warning'), $('#aidePwd0').empty());
			
			// verification si les mots de passe sont identiques
			var valPwd1 = isSamePassword(formulaire, valPwd0);
			(!valPwd1) ? ($('#' + formulaire.pwd1.id).addClass('alert-warning'), $('#aidePwd1').empty().append('Les mots de passe entrés doivent être identiques'))  : ($('#' + formulaire.pwd1.id).removeClass('alert-warning'), $('#aidePwd1').empty());
			
			// verification si l'id est un int
			var valMoyenComm = isInt(formulaire.moyenComm.value);
			(!valMoyenComm) ? ($('#' + formulaire.moyenComm.id).addClass('alert-warning'), $('#aideMoyenComm').empty().append('Vous devez choisir un moyen de communication'))  : ($('#' + formulaire.moyenComm.id).removeClass('alert-warning'), $('#aideMoyenComm').empty());
			
			// verification si l'id est un int
/**/        var valModePaiement = isInt(formulaire.paiement.value);
			(!valModePaiement) ? ($('#' + formulaire.paiement.id).addClass('alert-warning'), $('#aideModePaiement').empty().append('Vous devez choisir un mode de paiement'))  : ($('#' + formulaire.paiement.id).removeClass('alert-warning'), $('#aideModePaiement').empty());	
					// soumission du formulaire
					$("#modifierProfil"+idUser).submit();
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
							$(".succes_erreur").addClass("alert alert-success").html(response[0]);
						},  
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
			 });
			
		});		
});		
		
/*  ------------------------------------------------    @fonctions de validation    */
  

    /**
    * @brief    Fonction qui verifie si un des checkbox est coché
    * @details  La fonction boucle dans le tableau jusqu'a ce qu'un input 'checked' (selectionne) soit detecte 
    *           On verifie la valeur de l'attribut checked         
    * @param    <array>    tabCheckBox      Un tableau de checbox             
    * @return   true si un input est coché, sinon false
    */
    function isChecked(tabCheckBox) {

        for(var i=0; i<tabCheckBox.length; i++) {
            console.log(tabCheckBox[i]);
            if(tabCheckBox[i] == true) {
                return true;
            }
        }
        return false;
    }

    /**
    * @brief    Fonction qui verifie si un champ nom d'utilisateur (username) est au bon format
    * @details  La fonction cible la valeur username de l'input d'un formulaire et verifie son format avec une RegExp
    * @param    <string>    elm      valeur de l'input username            
    * @return   true (le resultat) si le format est bon, sinon false
    */
    function isUsername(elm) {  

        // ne tolere aucun espace ni avant ni après ni au milieu du pseudo 
        var regEx = /^(?=.*[A-Z])(?!.*\s).{8,40}$/gi;                  
    //  var regEx = /^[\da-záàâäãåçéèêëíìîïñóòôöõúùûüýÿ]{6,}$/gi;     
        var result = elm.match(regEx);
        return result ? result : false;;
    }

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
    * @brief    Fonction qui verifie si les deux mots de passe entres sont identiques 
    * @details  Fonction qui compare deux mots de passe
    * @param    <objet>         form            le formulaire             
    * @param    <value>         pwd0Checked     la valeur du mot de passe au format valide           
    * @return   true (le resultat) si les deux mots de passe sont identiques, sinon false
    */
    function isSamePassword(form, pwd0Checked) {

        // on verifie si le mot de passe avec lequel comparer celui-ci est conforme et valide (a true)
        if(pwd0Checked) {
            var result = (form.pwd1.value == form.pwd0.value) ? true : false;
            return result;
        } else {
            return false;
        }  
    }

    /**
    * @brief    Fonction qui verifie si un champ time est valide - validation avec RegExp            
    * @param    <string>    inputValue   valeur time de l'input             
    * @return   true (le resultat) si l'heure est valide, sinon false
    */
    function isTime(inputValue) { 
       
        var regEx = /^(([0-1][0-9])|([2][0-3]))[:]([0-5][0-9])(:00)?$/g;
        var result = inputValue.match(regEx);

        return result ? result : false;  
    }

    /**
    * @brief    Fonction qui verifie si un champ date est valide - validation avec RegExp            
    * @param    <date>    inputValue   valeur date de l'input             
    * @return   true (le resultat) si la date est valide, sinon false
    */
    function isDate(inputValue) { 

        var regEx = /^(\d{4})[-](\d{2})[-](\d{2})$/g;
        var result = inputValue.match(regEx);
        
        if(result) {
            // on s'assure que la date est > ou = que celle d'aujourd'hui
            var dateNow = formatDate(Date.now());

            return (result >= dateNow) ? true : false; 
        } 
        else {
            return false;
        }   
    }

    /**
    * @brief    Fonction qui formate une date          
    * @param    <date>    la date            
    * @return   la date reformatee
    */
    // ref: https://stackoverflow.com/questions/23593052/format-javascript-date-to-yyyy-mm-dd
    function formatDate(date) {

        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
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

    /**
    * @brief    Fonction qui verifie si une valeur est un entier         
    * @param    <value>     elm     valeur de l'id           
    * @return   True si c'est  un entier, sinon false
    */
    function isInt(elm) {

        return (elm == parseInt(elm, 10) && elm != 0) ? true : false;
    }

