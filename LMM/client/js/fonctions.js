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
        var regEx = /^(?=.*[A-Z\d])(?!.*\s).{8,20}$/g;                  
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
        var regEx = /^\S[a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ.\-'\s]*\S$/gi;     
        var result = elm.match(regEx); 
        return result ? result : false;
    }    
   
   /**
    * @brief    Fonction qui verifie si un champ texte est valide - validation avec RegExp            
    * @param    <string>    inputValue   valeur du texte de l'input             
    * @return   true (le resultat) si le nom est valide, sinon false
    */
    function isText(elm) {
        
        //  ne tolere aucun espace avant le premier mot 
        var regEx = /^\S[0-9a-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ@"$%#*&=+;:\/\)\(?!_.,\-'\s]*$/gi;     
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
        
        //	var regEx =	/^(?!.*\s).*$/g; // pour tests --- accepte tout sauf les espaces
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
    * @brief    Fonction qui verifie si un champ code postal est au bon format
    * @details  Fonction qui cible la valeur zipCode (code postal) de l'input d'un formulaire et verifie son format avec une RegExp
    * @param    <valeur>    elm      la valeur de l'input codePostal             
    * @return   true (le resultat) si le format est bon, sinon null
    */
    function isZipCode(elm) {                        
        var regEx = /^[a-z][\d][a-z]\s?[\d][a-z][\d]$/gi;
        var result = elm.match(regEx);
        return result;
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

        // prend tout caractere sauf les lettres (entre 10 et 20 - 9+1 et 19+1)
        var regEx = /^\S(?!.*[A-Z]).*.{8,19}\S$/gi;
    //  var regEx = /^1?[-\s.]?(\d{3})[-\s.]?(\d{3})[-\s.](\d{4})$/g;
        var result = elm.match(regEx);
        
        return result ? result : false;
    }

    /**
    * @brief    Fonction qui verifie si une valeur est un entier         
    * @param    <value>     elm     valeur de l'id           
    * @return   True si c'est  un entier, sinon false
    */
    function isInt(elm) {

        return (elm == parseInt(elm, 10) && elm >= 1) ? true : false;
    }

    /**
    * @brief    Fonction qui verifie si une valeur est un float (accepte egalement les entiers)        
    * @param    <value>     elm     valeur de l'id           
    * @return   True si c'est  un float (ou entier), sinon false
    */
    function isFloat(elm) {
        
        // on remplace la virgule si tel est le cas
        var regEx = /,/g;
        var floatElm = elm.replace(regEx, '.');
        return (floatElm == parseFloat(floatElm, 10) && floatElm >= 1) ? floatElm : false;
    }

    /**
    * @brief    Fonction qui attribut une evaluation (entre 0 et 5 étoiles) sur un appartement 
    * @details  La fonction affiche le nb d'etoiles attribuees par l'usager
    * @param    <int>       valeur      valeur de l'evaluation (entre 0 et 10)            
    * @return   le nombre d'étoiles à afficher  
    */
    function setNbEtoiles(valeur) {

        // declaration de la string d'affichage des etoiles
        var resultat = '';
        // on verifie si on a une demi-etoile a afficher
        var mi_etoile = valeur % 2;
        // si la valeur est 0, on affiche 5 etoiles grises
        if(valeur == 0) {
            for(var i=0; i<5; i++) {
                resultat += '<i class="fa fa-star fa_custom"></i>&nbsp;';
            }  
        }
        // sinon, on calcule le nb d'étoiles a afficher incluant la demi s'il y a lieu
        else {
            for(var i=2; i<=valeur; i+=2) {
                resultat += '<i class="fa fa-star"></i>&nbsp;';
            }
            if(mi_etoile != 0) {
                resultat += '<i class="fa fa-star-half"></i>';
            }
        }
        return resultat;
    }

    /**
    * @brief    Cree un element 
    * @details  Fonction appelee pour creer des elements a inserer dans le DOM            
    * @param    <string>    elmName     nom de l'element a creer (localName)  
    * @param    <array>     classData   tableau contenant toutes les classes a ajouter a l'element
    * @param    <string>    text        texte a ajouter a l'element via la @f addText | ce param peut etre omis
    * @return   <object>    l'element cree
    */
    function addElement(elmName, classData, text) {
        var elm = document.createElement(elmName);
        for(var i = 0; i < classData.length; i++) {
            elm.classList.add(classData[i]);
        }
        if(text) {
            addText(elm, text);
        }
        return elm;
    }

    /**
    * @brief    Applique un ou plusieurs attribut(s) a un element
    * @details  Fonction appelee pour appliquer divers attributs a un element
    * @param    <object>    elm         nom de l'element auquel appliquer un attribut   
    * @param    <array>     attributes  tableau contenant touts les attributs a ajouter a l'element
    * @return   <object>    l'element avec attributs ajoutes
    */
    function setAttributes(elm, attributes) {
        for(var a in attributes) {
            elm.setAttribute(a, attributes[a]);
        }
        return elm;
    }

    /**
    * @brief    Ajoute du texte a un element 
    * @details  Fonction appelee pour ajouter un noeud texte a un element
    * @param    <object>    elm         nom de l'element auquel ajouter du texte   
    * @param    <string>    text        texte a ajouter a l'element (param facultatif)
    * @return   <object>    l'element avec texte ajoute
    */
    function addText(elm, textNode) {
        var text = document.createTextNode(textNode);
        elm.appendChild(text); 
        return elm;
    }