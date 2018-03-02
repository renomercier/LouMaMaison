
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
                - affichage d'un message d'erreur selon le cas */  
        
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
        var valModePaiement = isInt(form.modePaiement.value);
        (!valModePaiement) ? ($('#' + form.modePaiement.id).addClass('alert-warning'), $('#aideModePaiement').empty().append('Vous devez choisir un mode de paiement'))  : ($('#' + form.modePaiement.id).removeClass('alert-warning'), $('#aideModePaiement').empty());
       
        // une fois les validations faites, on soumet le formulaire
        if(valTypeUsager && valUsername && valNom && valPrenom && valAdresse && valTelephone && valPwd0 && valPwd1 && valCoorMComm && (form.client.checked ? valMoyenComm  && valModePaiement : valMoyenComm)) {  
            
            // soumission du formulaire
            $(this).unbind('submit').submit();
        }

    });

    /**
    *   Ecouteur d'evenement ('click') attache a un element input du formulaire d.inscription d'un usager
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
    *   requete pour affichage des options choisies si un id d'appartement est detecte
    */
    if($('#idApt')[0]) {
        if($('#idApt')[0].value != "") {

            var idApt = $('#idApt')[0].value;
            // requete afin de populer le select des quartiers de Mtl
            $.ajax({
                url: 'index.php?Appartements&action=getOptionsApt&id='+idApt, 
                type: 'POST', 
                dataType : 'json',
                success : function(result, statut) {

                    // on boucle dans le tableau d'options de l'appartement
                    result.o.forEach( function(r) {

                        var input = $("#formApt input[type^='checkbox']");
                        // on boucle dans chq option pour voir si elle est a cocher
                        for(var i=0; i<input.length; i++) {
                            if(input[i].id == r) {
                                input[i].setAttribute('checked', 'checked')
                            }
                        }
                    })
                },
                error : function(resultat, statut, erreur){

                },
                complete : function(resultat, statut){
            
                }
            });
        }
    }

    /**
    *   requete json pour affichage des options d'un appartement
    */
    if($('#idApt')[0]) {
        $.getJSON('json/optionsApt.json', function(o) {

            $('#option').empty();
            o.options.forEach( function(op) {
                $('#option').append('<div class="form-check option"><label class="form-check-label"><input type="checkbox" name="' + op.id + '" id="' + op.id + '" value="checked" class="form-check-input">&nbsp;' + op.option + '</label></div>');
            }) 
        }); 
    }

    /**
    *   serialisation des options choisies a chaque click,
    *   et ajout de la nouvelle valeur dans le champ optionsSerialises du formulaire
    */
    $('#option').on('change', function(e) {

        // serialisation de tous les inputs et ajout de la 'string' serialisee au formulaire (input hidden) 
        var options = $("#formApt input[type='checkbox']" ).serialize();
        var valeurOptions = $('#optionsSerialises').val(options);
        console.log(options);
    });

    /**
    *   Ecouteur d'evenement ('submit') attache a l'element #formApt 
    *   (formulaire d'ajout et de modification d'un appartement)
    */
    $('#formApt').on( "submit", function(e) {

        // recuperation du formulaire
        var form = e.target;
        // on ne soumet pas le formulaire tant que les champs sont pas valides
        e.preventDefault();

        // validation de tous les champs de formulaire avant soumission cote serveur, et affichage des messages d'erreur
        /* Meme formule pour tous les inputs: 
                - verification de la valeur par l'appel d'une fonction appropriee 
                - affichage d'un message d'erreur selon le cas */ 

        // validation format texte (titre)
        var valTitre = isText(form.titre.value);
        (!valTitre) ? ($('#' + form.titreApt.id).addClass('alert-warning'), $('#aideTitreApt').empty().append('Le titre de l\'annonce est invalide'))  : ($('#' + form.titreApt.id).removeClass('alert-warning'), $('#aideTitreApt').empty());
        // validation format texte (descriptif)
        var valDescriptif = isText(form.descriptif.value);
        (!valDescriptif) ? ($('#' + form.descriptif.id).addClass('alert-warning'), $('#aideDescriptifApt').empty().append('Le descriptif est invalide'))  : ($('#' + form.descriptif.id).removeClass('alert-warning'), $('#aideDescriptifApt').empty());
        // verification si le type d'appartement est un int (sa valeur)
        var valTypeApt = isInt(form.id_typeApt.value);
        (!valTypeApt) ? ($('#' + form.id_typeApt.id).addClass('alert-warning'), $('#aideTypeApt').empty().append('Vous devez choisir un type d\'appartement'))  : ($('#' + form.id_typeApt.id).removeClass('alert-warning'), $('#aideTypeApt').empty());
        // verification si le numero civique est un int
        var valNoCivique = isInt(form.noCivique.value);
        (!valNoCivique) ? ($('#' + form.noCivique.id).addClass('alert-warning'), $('#aideNoCivique').empty().append('Le numéro civique est invalide, veillez à n\'inscrire que des chiffres'))  : ($('#' + form.noCivique.id).removeClass('alert-warning'), $('#aideNoCivique').empty());
        // validation format nom (nom de rue)
        var valRue = isText(form.rue.value);
        (!valRue) ? ($('#' + form.rue.id).addClass('alert-warning'), $('#aideNomRue').empty().append('Le nom de rue est invalide'))  : ($('#' + form.rue.id).removeClass('alert-warning'), $('#aideNomRue').empty());
        // s'il y a une valeur dans le champ no d'appartement (il est facultatif)
        if(form.noApt.value != "") {
            // validation format texte
            var valNoApt = isText(form.noApt.value);
            (!valNoApt) ? ($('#' + form.noApt.id).addClass('alert-warning'), $('#aideNoApt').empty().append('Le numéro d\'appartement est invalide')) : ($('#' + form.noApt.id).removeClass('alert-warning'), $('#aideNoApt').empty());
        } else {
            $('#' + form.noApt.id).removeClass('alert-warning'), $('#aideNoApt').empty()
        }
        // validation format code postal
        var valCodePostal = isZipCode(form.codePostal.value);
        (!valCodePostal) ? ($('#' + form.codePostal.id).addClass('alert-warning'), $('#aideCP').empty().append('Le code postal est invalide'))  : ($('#' + form.codePostal.id).removeClass('alert-warning'), $('#aideCP').empty());
        // verification si le quartier est un int (sa valeur)
        var valNomQuartier = isInt(form.id_nomQuartier.value);
        (!valNomQuartier) ? ($('#' + form.id_nomQuartier.id).addClass('alert-warning'), $('#aideQuartier').empty().append('Vous devez choisir le quartier où se situe l\'appartement'))  : ($('#' + form.id_nomQuartier.id).removeClass('alert-warning'), $('#aideQuartier').empty());
        // verification si le quartier est un int (sa valeur)
        var valNbPersonnes = isInt(form.nbPersonnes.value);
        (!valNbPersonnes) ? ($('#' + form.nbPersonnes.id).addClass('alert-warning'), $('#aideNbPersonnes').empty().append('Nombre invalide. Veuillez entrer le nombre de personnes en chiffre seulement'))  : ($('#' + form.nbPersonnes.id).removeClass('alert-warning'), $('#aideNbPersonnes').empty());
        // verification si le quartier est un int (sa valeur)
        var valNbChambres = isInt(form.nbChambres.value);
        (!valNbChambres) ? ($('#' + form.nbChambres.id).addClass('alert-warning'), $('#aideNbChambres').empty().append('Nombre invalide. Veuillez entrer le nombre de chambres en chiffre seulement'))  : ($('#' + form.nbChambres.id).removeClass('alert-warning'), $('#aideNbChambres').empty());
        // verification si le quartier est un int (sa valeur)
        var valNbLits = isInt(form.nbLits.value);
        (!valNbLits) ? ($('#' + form.nbLits.id).addClass('alert-warning'), $('#aideNbLits').empty().append('Nombre invalide. Veuillez entrer le nombre de lits en chiffre seulement'))  : ($('#' + form.nbLits.id).removeClass('alert-warning'), $('#aideNbLits').empty());
        // validation format float ou int
        var valMontantParJour = isFloat(form.montantParJour.value);
        (!valMontantParJour) ? ($('#' + form.montantParJour.id).addClass('alert-warning'), $('#aideMontant').empty().append('Montant invalide. Veuillez entrer le montant en chiffre seulement'))  : (setAttributes($('#montantParJour')[0], { "value" : valMontantParJour }), $('#' + form.montantParJour.id).removeClass('alert-warning'), $('#aideMontant').empty());
        // verification si l'usager a selectionne des options (facultatives)
        if(form.optionsSerialises.value != "") {
            // validation format texte (string serialisee)
            var valOptions = isText(form.options.value);
            (!valOptions) ? ($('#option').addClass('alert-warning'), $('#checkbox').empty().append('Les options sont invalides'))  : ($('#option').removeClass('alert-warning'), $('#checkbox').empty());
        } else {
            $('#checkbox').empty()
        }

        console.log(valMontantParJour);
        console.log($('#montantParJour')[0]);

        if(valTitre  && valDescriptif && valTypeApt && valNoCivique && valRue && ((valNoApt != undefined) ? valNoApt : (valNoApt == undefined)) && valCodePostal 
            && valNomQuartier && valNbPersonnes && valNbChambres && valNbLits && valMontantParJour && ((valOptions) ? valOptions : (!valOptions)) ) {

            // soumission du formulaire
            $(this).unbind('submit').submit();
        } 
    });

    // declaration du tableau de 'files' (pour les images)
    var tabFiles = [];

    // ref: https://www.formget.com/ajax-image-upload-php/
    $("#uploadimage").on('submit',(function(e) {
//        console.log(tabFiles);
//        var tab = JSON.stringify(tabFiles);

        e.preventDefault();
        $("#message").empty();
        $('#loading').show();

        // instanciation du tableau a envoyer par ajax
        var ajaxData = new FormData();
//          console.log(tabFiles);
        // on ajoute l'id de l'apt dans le tableau (tableau idApt) 
        ajaxData.append('idApt', $('#idApt')[0].value);
        // ensuite on ajoute chaque files d'image dans le tableau (tableau 'file')
        for(var i=0; i<tabFiles.length; i++) {
//          console.log(tabFiles[i]);
            ajaxData.append('file['+i+']', tabFiles[i]);
        }
        // envoi de la requete 
        $.ajax({
            url: "index.php?Appartements&action=ajouterPhoto", 
            type: "POST", 
            data: ajaxData,
            contentType: false,       
            cache: false,             
            processData:false,        
            success: function(data)   
            {
                $('#loading').hide();
                $("#message").html(data);
            }
        });
    }));
  
    /**
    *   Evenement click attache au bouton 'Ajouter une image'
    *       - Ajoute un nouvel input de type file, une div ainsi que les balises img 
    *       (visualisation de l'image) et small (affichage du nom)
    *       * Cette zone creee ne servira qu'a pre-visualiser les diverses photos ajoutees *   
    */
    $("#btnAjoutImage").on('click',(function(e) {
        // creation de la div principale pour la nouvelle image
        var divPrincipale = document.getElementById('ajoutImage');
        // creation de la divImg
        var div = addElement("div", ["img"]);
        var divImg = divPrincipale.appendChild(div);
        // creation de la balise Img
        var img = addElement("img", ["previwing"]);
        var nouvelleImg = divImg.appendChild(img);
        // creation de la balise small
        var small = addElement("small", ["previwing"]);
        var divSmall = divImg.appendChild(small);
        // creation de l'input de type file
        var input = addElement("input", ["file"]);
            setAttributes(input, { "type" : "file", "name" : "file[]" });
        var divInput = divPrincipale.appendChild(input); 
        // appel de la fonction qui affichera
        ajouterNouvelleImage();
    }));

    /**
    *   Fonction pour pre-visualiser les images supplementaires a telecharger
    */
    // ref: https://www.formget.com/ajax-image-upload-php/
    var ajouterNouvelleImage = function() {

        $(".file").change(function(e) {

            $("#message").empty(); // To remove the previous error message
            var file = this.files[0];
            var nomFile = file.name;
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))) {

                $('#previewing').attr('src','noimage.png');
                $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                return false;
            }
            else {

                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                tabFiles.push(this.files[0]);
//              console.log(tabFiles);
                var input = $(".file:last")[0];
                addText(input.previousElementSibling.childNodes[1], nomFile); 
            }
        });
        function imageIsLoaded(e) {
            var input = $(".file:last")[0];
            input.previousElementSibling.childNodes[0].setAttribute('src', e.target.result);
            input.previousElementSibling.childNodes[0].setAttribute('height', '100px');  
        };
    } // fin fonction ajouterNouvelleImage

    /**
    *   Fonction pour pre-visualiser l'image principale a telecharger
    */
    // ref: https://www.formget.com/ajax-image-upload-php/
    $(function() {
        $("#file").change(function(e) {

            $("#message").empty(); 
            var file = this.files[0];
//          console.log(file)
            var nomFile = file.name;
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))) {
                $('#previewing').attr('src','noimage.png');
                $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                return false;
            }
            else {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                tabFiles.push(this.files[0]);
//              console.log(tabFiles);
                $('#image_preview small').text(nomFile);
            }
        });
        function imageIsLoaded(e) {
            $('#image_preview').css("display", "block");
            $('#previewing').attr('src', e.target.result);
            $('#previewing').attr('height', '100px');
            
        };
    });

}); // fin du document.ready