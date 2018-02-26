$(document).ready(function() {
 
    /*chercher les apparts avec les filtres remplis*/

    $( "#filtrer" ).on( "click", function( e ) {
        event.preventDefault();
        var url = $('#formFiltrer').serialize();
        filtrerAppart(url);
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
	
    /* definir la class active a la categorie d'usagers visitée */
    $('.filtre_usager .nav-link').on( "click", function( e ) {
        event.preventDefault();
        $('.filtre_usager .nav-link').each(function(){
            $(this).removeClass('active');
        })
        $(this).addClass('active');
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

/*////////////////////////////////////////////////////////////////*/
/* filtrer le resultat de la recherche selon des critéres donnés*/

    function filtrerAppart(url){
        
           $.ajax({
            method: "POST",
            url: "index.php?Appartements&action=filtrer",
           data: url,
            dataType:"html",
           // comportement en cas de success ou d'echec
          success:function(reponse) {
              $('.accueil .col-md-6').html('');
              $('.accueil .col-md-6').append(reponse);
              
              //effacer les marqueurs existant
              clearMarkers();
              //placer les nouveaux marqueurs
                $("div.appart").each(function(){
                    placerSureCarte($(this).attr('name'));
                });
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
    }

/* naviguer vers la page suivante ou precedente des resultats */

function naviguer(appartParPage, page) {
    event.preventDefault();
    var url = $('#formFiltrer').serialize();
        url+="&appartParPage="+appartParPage+"&page="+page+"";
        filtrerAppart(url);
}

/* ============================  function pour initialiser la google map ============================================== */

/* sila div #carte estchargée, inclure le script de la carte google */

$(document).ready(function() {
       if($('#carte').length)
        {
            var scriptGoogle = '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACwL7adHNKo6veif0FtD6axaWGx23TTLw&callback=initMap"></script>';
            $('body').append(scriptGoogle);
        } 
});


    // initialiser la catrte google
    var carte;
    var marqueurs = [];
    function initMap() {
      carte = new google.maps.Map(document.getElementById('carte'), {
        zoom: 11.5,
        center: new google.maps.LatLng(45.51,-73.72) 
      });
    }

// fonction pour placer un marqueur sur la carte.

    function placerSureCarte(adrAppart, miniature) {
        Geocoder = new google.maps.Geocoder(); 
        Geocoder.geocode( { 'address': adrAppart}, function(results, status) {
            
        /* Si l'adresse a pu être géolocalisée */
            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                var latLng = new google.maps.LatLng(latitude,longitude);
                
                // initialisation d'un setTimeOut pour animer les marqueur
                window.setTimeout(function() {
                    var marker = new google.maps.Marker({
                    position: latLng,
                    map: carte,
                    animation: google.maps.Animation.DROP
                  });
                    
                     // creation de l'info bulle
                  var infowindow = new google.maps.InfoWindow({
                            content: miniature,
                            maxWidth: 200
                              
                          });
                    
                    // ouvrir l'info bulle
                    google.maps.event.addListener(marker,'mouseover',function() {
                          infowindow.open(carte,marker);
                    });
                    
                     // fermer l'info bulle
                    google.maps.event.addListener(carte,'click',function() {
                          setTimeout(function () { infowindow.close(); }, 200);
                    });
                    
                    // ajout du marqueur au tableau
                    marqueurs.push(marker);
                }, 300);
                
            }
        });
    }

// fonction pour supprimer les marqueurs de la carte
    function clearMarkers() {
        for(var i=0; i< marqueurs.length; i++)
        {
            marqueurs[i].setMap(null);
        }
    }

// boucler dans le tableau des adresses et les placer sur la carte.
     window.onload=function() {    
        $("div.appart").each(function(){
            var miniature = $('<div class="miniature">').append($(this).html());
            placerSureCarte($(this).attr('name'), miniature.html());
        });
     }
     
     
/*//////////////////// fonctions pour gerer les usagers ///////////////////////////*/

/* fonction pour filtrer les usagers selon des criteres d'affichage*/

function filtrerUsagers(colonne, valeur){
    
               $.ajax({
                method: "POST",
                url: "index.php?Usagers&action=filtrerUsagers&"+colonne+"="+valeur,
                dataType:"html",
        // comportement en cas de success ou d'echec
              success:function(reponse) {
                    $('.content .usagers').html('');
                    $('.content .usagers').html(reponse);
                  console.log(reponse);
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
            });
}

/**
  fonction pour faire les action d'administration sur un usager.
  (bannir/réhabiliter, promouvoir/déchoire, activer/désactiver).
*/

function actionAdmin(idUser, action) {

       $.ajax({
            method: "POST",
            url: "index.php?Usagers&action="+action+"&idUsager="+idUser,
            dataType:"html",
    // comportement en cas de success ou d'echec
          success:function(reponse) {
              //  $('.content .usagers').html('');
              //  $('.content .usagers').html(reponse);
                  var filtreColonne = $('.filtre_usager .nav-link.active').attr('name');
                  var filtreValeur = $('.filtre_usager .nav-link.active').attr('value');
                  filtrerUsagers(filtreColonne, filtreValeur);
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
}