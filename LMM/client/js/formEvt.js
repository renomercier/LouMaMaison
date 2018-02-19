
// (function() {

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
            // verification si l'id est un int
/**/        var valModePaiement = isInt(form.modePaiement.value);
            (!valModePaiement) ? ($('#' + form.modePaiement.id).addClass('alert-warning'), $('#aideModePaiement').empty().append('Vous devez choisir un mode de paiement'))  : ($('#' + form.modePaiement.id).removeClass('alert-warning'), $('#aideModePaiement').empty());
           
            // une fois les validations faites, on soumet le formulaire
            if(valTypeUsager && valUsername && valNom && valPrenom && valAdresse && valTelephone && valPwd0 && valPwd1 && (form.client.checked ? valMoyenComm  && valModePaiement : valMoyenComm)) {  
                
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

	});

// })();


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