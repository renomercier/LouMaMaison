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
        $("#div_user_nom").append($("#data_user_nom"));		
		$("#div_adresse").append($("#data_adresse"));
		$("#div_telephone").append($("#data_telephone"));
		$("#div_paiement").append($("#data_paiement"));
		$("#div_contact").append($("#data_contact"));
		$("#div_role").append($("#data_role"));
		$("#div_modif_profil").append($(".btn-modifier"));
		
		$("#div_messagerie").append($("#messagerie"));		
		$("#div_action_admin").append($("#action_admin"));       
		$(".menuProfil").append($("#div_action_admin"));		
		$("#div_historique").append($("#historique"));		
		$("#div_reservations").append($("#reservations"));		
		$("#div_mes_appts").append($("#mes_appts"))
    
		
	/**
	* 	Fonction pour Modifier un profil d'usager
	*/	
		$(document).on('click', '.sauvegarderForm', function(e){
            var idUser = $(this).prev().val();	
			
            // une fois les validations js faites, on soumet le formulaire
            if(isName($("#nom").val()) && isName($("#prenom").val()) && isText($("#adresse").val()) && isPhoneNumber($("#telephone").val()) && $("#moyenComm").length &&  $("#moyenComm").length ) {  
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
                        "idUser":$('input[name="idUser"]').val()
						}) 
					}, 
					success: function (response) {                       
						//vérification côté php, s'il y des erreurs
						if(response.messageErreur) {
                            $(".erreurModif").empty().addClass("alert alert-warning col-sm-8").html("<p>"+response.messageErreur + "</p>");
                        } 
                        else if(response[1].messageSucces){ //s'on n'as pas des erreurs côté php
                           $(".succes_erreur").empty().css("display", "block").addClass("alert alert-success").html("<p>"+response[1].messageSucces + "</p>").fadeOut( 5000, "linear");                     
                            //$("#myModal"+idUser).toggle();
                            $("#myModal"+idUser).hide();
                            $('.modal-backdrop.fade.show').remove();
                            $('body').removeClass("modal-open");
                            $("#div_info_nom").empty();
                            $("#div_user_nom").empty();
                            $("#div_adresse").empty();
                            $("#div_telephone").empty();
                            $("#div_paiment").empty();
                            $("#div_contact").empty();
                            $("#div_info_nom").html("<h3>" + response[0][0].nom +" "+ response[0][0].prenom + "</h3>");               
                            $("#div_user_nom").html(idUser); 
                            $("#div_adresse").html(response[0][0].adresse);
                            $("#div_telephone").html(response[0][0].telephone);
                            $("#div_paiement").html(response[0][0].modePaiement);
                            $("#div_contact").html(response[0][0].moyenContact);  
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
    
    /************/
    /**
    * Fonction pour modifier le mot de passe
    */
    	$(document).on('click', '.sauvegarderMotDePasse', function(e){
            var idUserPass = $('input[name="idUserPass"]').val();	
			
            // une fois les validations js faites, on soumet le formulaire
            if(isPassword($("#pwd0").val()) && valPwdConfirm($("#pwd1").val(), $("#pwd0").val()) ) {  
				// envoie la requête par ajax			
				$.ajax({
					cache: false,
					url: 'index.php?Usagers&action=modifierMotDePasse',
					method: "POST",
					dataType : 'json',		
					data: {
                        pwd0:$("#pwd0").val(),
                        idUser:idUserPass
						
					}, 
					success: function (response) {                       
						//vérification côté php, s'il y des erreurs
						if(response.messageErreur) {
                            $("#erreur_pass").empty().css("display", "block").addClass("alert alert-warning").text(response.messageErreur);
                        } 
                        else if(response[0].messageSucces){ //s'on n'as pas des erreurs côté php
                           $("#erreur_pass").empty().css("display", "block").addClass("alert alert-success").text(response[0].messageSucces).fadeOut( 5000, "linear");
                            $('#pwd0').empty();    
                            $('#pwd0').val("*****");
							$('#pwd0')[0].type="text";						
							setTimeout(function() {$('#pwd0')[0].type="password"}, 2000);						
                            $('#pwd1').empty();    
                            $('#pwd1').val("*****");
							$('#pwd1')[0].type="text";								
							setTimeout(function() {$('#pwd1')[0].type="password"}, 2000);
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
					
			// validation du mot de passe
			var valPwd0 = isPassword($("#pwd0").val());
			(!valPwd0) ? ($("#pwd0").addClass('alert-warning'), $('#aidePwd0').empty().append('Le mot de passe doit contenir au minimum une lettre majuscule ou un chiffre'))  : ($("#pwd0").removeClass('alert-warning'), $('#aidePwd0').empty());
			
			var valPwd1 = isPassword($("#pwd1").val());
			
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
		
/*----------------- A Ajouter dans le fichier functions!*/

	/**
		Fonction pour afficher des apts du proprio
	*/	
		$(document).on('click', '#mes_appts', function(e){
			var idUserProprio = $("input[name='usernameProp']").val(); 
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=afficheAptsProprio&idProprio="+idUserProprio,
				dataType:"html",
				success:function(reponse) {
					$('#afficheInfoProfil').empty();
					$('#afficheInfoProfil').html(reponse);
					$('.resultat .row div.col-md-3').removeClass("col-md-3").addClass("col-md-6");
					$('#afficheInfoProfil nav').remove();
					$('#afficheInfoProfil .alert').remove();
					$('#afficheInfoProfil footer').remove();
					$('#afficheInfoProfil script').remove();
					$('#afficheInfoProfil #carte').remove();
                   // var idApt = $('.btn-modal')[0].id;
                    
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
    
        

	/**
		Action supprimer une disponibilite d'un apprtement
	*/
    $(document).on('click', $(".btnSupprimerDispo"), function(){
		$(".btnSupprimerDispo").one('click', funcSupprimeDispo);
	});

	/**
		Action ajouter une disponibilite d'un apprtement
	*/ 
	//$(".btnAjouterDispo").one('click', funcAjouteDispo);
	$(document).on('click', $(".btnAjouterDispo"), function(){
		$(".btnAjouterDispo").one('click', funcAjouteDispo);
	});
});	


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


/**
	Fonction pour supprimer une disponibilite d'un apprtement
*/
var funcSupprimeDispo = function(e){
	var idDispo = $(this).val();
	var tr = $(this).parent().parent(); 
	var id_apt = $('input[name="id_apt"]').val()
	$.ajax({
			method: "GET",
			url: "index.php?Appartements&action=supprimeDisponibilite&id_dispo="+idDispo,
			dataType:"json",
			success:function(reponse) {
				//$('.btnSupprimerDispo').one('click', funcSupprimeDispo);
				if(reponse.messageSucces){ //s'on n'as pas des erreurs côté php
					$("#erreurDispo"+id_apt).empty().css("display", "block").addClass("alert alert-success").html("<p>"+reponse.messageSucces + "</p>").fadeOut( 1000, "linear");
					tr.remove();
				}
				else if(reponse.messageErreur) {
					$("#erreurDispo"+id_apt).empty().css("display", "block").addClass("alert alert-warning").html("<p>"+reponse.messageErreur + "</p>");
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
    e.stopImmediatePropagation();
    //return false;
}

/**
       Fonction pour ajouter disponibilite d'un apprtement
*/
var funcAjouteDispo = function(e){
	var id_apt =  $(this).val(); 
    console.log(id_apt);
	var dateDebut = $('#dateDebut'+id_apt).val();
	var dateFin = $('#dateFin'+id_apt).val();
	$.ajax({
      url:  "index.php?Appartements&action=ajouteDisponibilite&id_apt="+id_apt+"&dateDebut="+dateDebut+"&dateFin="+dateFin,
      method: 'GET',
      async: true,
      dataType: 'json',
      enctype: 'multipart/form-data',
      cache: false,
	  data: {
		dataJson: JSON.stringify({
			"dateDebut":dateDebut,
			"dateFin":dateFin,
			"id_apt":id_apt
			}) 
		}, 
      success: function(reponse){
       // $('.btnAjouterDispo').one('click', funcAjouteDispo);
		if(reponse.messageErreur) 
		{ 
			$("#erreurDispo"+id_apt).empty().css("display", "block").addClass("alert alert-warning").html("<p>"+reponse.messageErreur + "</p>");
		} 
		else if(reponse[1].messageSucces){ //s'on n'as pas des erreurs côté php
			$("#erreurDispo"+id_apt).empty().css("display", "block").addClass("alert alert-success").html("<p>"+reponse[1].messageSucces + "</p>").fadeOut( 1000, "linear");
			var repPos = reponse[0][0].length-1;
			for(i=0; i<=reponse[0][0].length; i++) 
			{
				var newDispo = reponse[0][0][repPos];
				var oldDispo = reponse[0][0][repPos-1];
			}
			$("<tr id='ajoutDispoRes"+newDispo.id+"'><td id='dateDebut"+newDispo.id+"'>"+newDispo.dateDebut+"</td><td id='dateFin"+newDispo.id+"'>"+newDispo.dateFin+"</td><td><button type='button' class='btn btn-warning btnSupprimerDispo' id='btnSupprimerDispo"+newDispo.id+ "'value='"+newDispo.id+"'>Supprimer</button></td></tr>").insertAfter($('#dispoRes'+id_apt));
			
			if($('#ajoutDispoRes'+oldDispo.id))
            {
                $('#ajoutDispoRes'+oldDispo.id).removeClass("alert alert-success");
            }
			$('#ajoutDispoRes'+newDispo.id).addClass("alert alert-success");
		}
				
      },
      error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
    });
    e.stopImmediatePropagation();
   // return false;
}


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
                    var miniature = $('<div class="miniature">').append($(this).html());
                    placerSureCarte($(this).attr('name'), miniature.html());
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