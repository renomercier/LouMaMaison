// on s'assure que le document soit pret 
	$(document).ready(function() {

        // div modePaiement: visible ou invisible selon si la case est cochee  
        if($('#client')[0]) {
             $('#client')[0].checked ? $('#divPaiement').show() : $('#divPaiement').hide(); 
        }

        /**
        *   Ecouteur d'evenement ('submit') attache a l'element #formUsager
        */
        $('#formUsager').on( "submit", function(e) {
          
            // recuperation du formulaire
            var form = e.target;

            // on ne soumet pas le formulaire tant que les champs sont pas valides
            e.preventDefault();

            // validation de tous les champs de formulaire avant soumission cote serveur, et affichage des messages d'erreur
            /* Meme formule pour tous les inputs: 
                    - verification de la valeur par l'appel d'une fonction appropriee 
                    - affichage d'un message d'erreur ou suppression selon le cas */  
            
            // validation type d'usager  
            var valTypeUsager = isChecked([ form.client.checked, form.prestataire.checked ]);
            (!valTypeUsager) ? ($('#' + form.client.id).addClass('alert-warning'), $('#checkbox').empty().append('Vous devez choisir au moins un type d\'usager')) : ($('#' + form.client.id).removeClass('alert-warning'), $('#checkbox').empty());
            // validation nom d'utilisateur  
            var valUsername = isUsername(form.username.value);
            (!valUsername) ? ($('#' + form.username.id).addClass('alert-warning'), $('#aideUsername').empty().append('Le nom d\'utilisateur doit contenir entre 8 et 20 caractères ainsi qu\'un minimum d\'une lettre majuscule ou chiffre'))  : ($('#' + form.username.id).removeClass('alert-warning'), $('#aideUsername').empty());
            // validation format nom
            var valNom = isName(form.nom.value);
            (!valNom) ? ($('#' + form.nom.id).addClass('alert-warning'), $('#aideNom').empty().append('Le nom est invalide'))  : ($('#' + form.nom.id).removeClass('alert-warning'), $('#aideNom').empty());
            // validation format nom
            var valPrenom = isName(form.prenom.value);
            (!valPrenom) ? ($('#' + form.prenom.id).addClass('alert-warning'), $('#aidePrenom').empty().append('Le prénom est invalide'))  : ($('#' + form.prenom.id).removeClass('alert-warning'), $('#aidePrenom').empty());
            // validation format texte
            var valAdresse = isText(form.adresse.value);
            (!valAdresse) ? ($('#' + form.adresse.id).addClass('alert-warning'), $('#aideAdresse').empty().append('L\'adresse est invalide'))  : ($('#' + form.adresse.id).removeClass('alert-warning'), $('#aideAdresse').empty());
            // validation format telephone
            var valTelephone = isPhoneNumber(form.telephone.value);
            (!valTelephone) ? ($('#' + form.telephone.id).addClass('alert-warning'), $('#aideTel').empty().append('Le numéro de téléphone est invalide'))  : ($('#' + form.telephone.id).removeClass('alert-warning'), $('#aideTel').empty());
            // validation du mot de passe
            var valPwd0 = isPassword(form.pwd0.value);
            (!valPwd0) ? ($('#' + form.pwd0.id).addClass('alert-warning'), $('#aidePwd0').empty().append('Le mot de passe doit contenir au minimum une lettre majuscule ou un chiffre'))  : ($('#' + form.pwd0.id).removeClass('alert-warning'), $('#aidePwd0').empty());
            // verification si les mots de passe sont identiques
            var valPwd1 = isSamePassword(form, valPwd0);
            (!valPwd1) ? ($('#' + form.pwd1.id).addClass('alert-warning'), $('#aidePwd1').empty().append('Les mots de passe entrés doivent être identiques'))  : ($('#' + form.pwd1.id).removeClass('alert-warning'), $('#aidePwd1').empty());
            // verification si l'id est un int
            var valMoyenComm = isInt(form.moyenComm.value);
            (!valMoyenComm) ? ($('#' + form.moyenComm.id).addClass('alert-warning'), $('#aideMoyenComm').empty().append('Vous devez choisir un moyen de communication'))  : ($('#' + form.moyenComm.id).removeClass('alert-warning'), $('#aideMoyenComm').empty());
            // verification du moyen de communication
            var valCoorMComm = isText(form.coor_moyenComm.value);
            (!valCoorMComm) ? ($('#' + form.coor_moyenComm.id).addClass('alert-warning'), $('#aideCoorMC').empty().append('Veuillez entrer un moyen de communication valide'))  : ($('#' + form.coor_moyenComm.id).removeClass('alert-warning'), $('#aideCoorMC').empty());           
            // verification si l'id est un int
/**/        var valModePaiement = isInt(form.modePaiement.value);
            (!valModePaiement) ? ($('#' + form.modePaiement.id).addClass('alert-warning'), $('#aideModePaiement').empty().append('Vous devez choisir un mode de paiement'))  : ($('#' + form.modePaiement.id).removeClass('alert-warning'), $('#aideModePaiement').empty());
           
            // une fois les validations faites, on soumet le formulaire
            if(valTypeUsager && valUsername && valNom && valPrenom && valAdresse && valTelephone && valPwd0 && valPwd1 && valCoorMComm && (form.client.checked ? valMoyenComm  && valModePaiement : valMoyenComm)) {  
                
                // soumission du formulaire
                $(this).unbind('submit').submit();
            }

        });

        /**
        *   Ecouteur d'evenement ('click') attache a l'element input
        */
		$('#formUsager input').on( "click", function(e) {

            // recuperation de l'id de l'input et de l'objet cible
            var inputId = e.target.id;
            var objet = e.target;

            switch(inputId) {

                case "prestataire" :
                    // specificites du prestataire
                    break;

                case "client" :
                    // Si le checkbox client est coche, on affiche le mode de paiement
                    objet.checked ? $('#divPaiement').show() : $('#divPaiement').hide();
                    break;

                // ... ajout d'autres cases

                default :
            }

		});

        /**
        *   requete json pour affichage des options
        */
        $.getJSON('json/optionsApt.json', function(o) {

            o.options.forEach( function(op) {

                $('#options').append('<div class="form-check option"><label class="form-check-label"><input type="checkbox" name="' + op.option + '" id="' + op.option + '" value="checked" class="form-check-input">&nbsp;' + op.option + '</label></div>');
            })
            
        });

        $('#options').on('click', function(e) {

            var options = $("#formApt input[type='checkbox']" ).serialize();
            var r = $('#optionsSerialises').val(options);
        });

	}); // fin du document.ready