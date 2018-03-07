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
		$("#div_reservations").append($("#mesReservations"));		
		$("#div_demandes_reservations").append($("#demandesReservations"));		
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
				//return;	
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
			var idUserProprio =$('input[name="idUser"]').val();
			//var idUserProprio = $("#userNom")[0].innerHTML;
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=afficheAptsProprio&idProprio="+idUserProprio,
				dataType:"html",
				success:function(reponse) {
					$('#afficheInfoProfil').empty();

					$('.resultat .row div.col-md-3').removeClass("col-md-3").addClass("col-md-6");                  
					$('#afficheInfoProfil').html(reponse);                 
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
    

	/**
		Fonction pour afficher demandes de reservation Proprio
	*/
		$(document).on('click', '#demandesReservations', function(e){
			var idUserProprio = $("#userNom")[0].innerHTML;
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=afficheDemandesReservations&idProprio="+idUserProprio,
				dataType:"html",
				success:function(reponse) {
					$('#afficheInfoProfil').empty();
					$('#afficheInfoProfil').html(reponse); 
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
	/**
		Fonction pour afficher demandes de reservation Client
	*/
		$(document).on('click', '#mesReservations', function(e){
			var idClient = $("#userNom")[0].innerHTML;
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=afficheDemandesReservations&idClient="+idClient,
				dataType:"html",
				success:function(reponse) {
					$('#afficheInfoProfil').empty();
					$('#afficheInfoProfil').html(reponse); 
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

	/**
		Fonction pour valider une demande de reservation
	*/
		$(document).on('click', '.confirmerReservation', function(e){
			var idLocation = $(this).val();
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=validerDemande&idLocation="+idLocation,

				success:function(reponse) {
					//vérification côté php, s'il y des erreurs
					if(reponse){
                        $('#demandesReservations').click();
					}
                    else if(reponse.messageErreur) {
						$("#erreur_demande").empty().addClass("alert alert-warning").html(reponse.messageErreur);
						
					}
					
					
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
	/**
		Fonction pour refuser une demande de reservation
	*/
		$(document).on('click', '#refuserReservation', function(e){
			var idLocation = $(this).val();
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=refuserDemande&idLocation="+idLocation,
				dataType:"json",
				success:function(reponse) {
					if(reponse.messageErreur) {
						$("#erreur_demande"+idLocation).empty().addClass("alert alert-warning").html(reponse.messageErreur);
					}
					else if(reponse[0].messageSucces)
					{
						 $('#demandesReservations').click();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		
	/**
		Fonction pour valider paiement et créer location finale 
	*/
		$(document).on('click', '#validerLocation', function(e){
			alert("allo");
			var idLocation = $(this).val();
			$.ajax({
				method: "GET",
				url: "index.php?Appartements&action=validerPaiement&idLocation="+idLocation,
				dataType:"json",
				success:function(reponse) {
					if(reponse.messageErreur) {
						$("#erreur_demande"+idLocation).empty().addClass("alert alert-warning").html(reponse.messageErreur);
					}
					else if(reponse[0].messageSucces)
					{
						$("#erreur_demande"+idLocation).empty().removeClass("alert alert-warning").addClass("alert alert-success").html(reponse[0].messageSucces);
						
					}
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
	$(document).on('click', $(".btnAjouterDispo"), function(){
		$(".btnAjouterDispo").one('click', funcAjouteDispo);
	});
	
	/**
		Action demande d'une reservation d'un appartement
	*/
	$(document).on('click', $("#demandeReservation"), function(){
		$("#demandeReservation").one('click', funcDemandeReservation);
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

/**
	Fonction pour faire une demande de reservation d'un appartement
*/
	var funcDemandeReservation = function(e){
		var id_apt = $('input[name="id_appart"]').val();
		var dateDebut = $('input[name="dateDebut"]').val();
		var dateFin = $('input[name="dateFin"]').val();
		var id_userClient = $('input[name="id_userClient"]').val();
        var idProprio = $('input[name="idProprio"]').val();
		var nbPersonnes = $('option:selected').val();
        var objetClient = "Accusé reception";
        var texteClient = "Nous avons enregistré votre demande de location pour la période du: "+dateDebut+" au "+dateFin+" pour "+nbPersonnes+" personnes.<br> Le proprietaire va vous donner ou non son approbation dans les heures qui suiveront.<br><a class='text-primary' href='#' id='mesReservations'>Veuillez consulter ce lien pour suivre l'évolution de votre demande</a>";
        var objetProprio = "Demande de location";
        var texteProprio = "Vous venez de recevoir une demande de réservation pour un de vos appartements. <br><a class='text-primary' href='#' id='demandesReservations'>Veuillez consulter ce lien pour l'approuver</a>";

		$.ajax({
			cache: false,
			url: 'index.php?Appartements&action=demandeReservation',
			method: 'POST',
			dataType : 'json',		
			data: {
				id_appart : id_apt,
				dateDebut : dateDebut,
				dateFin : dateFin,
				id_userClient : id_userClient,
				nbPersonnes : nbPersonnes
			},
			success:function(reponse) {
				if(reponse.messageErreur) 
				{ 
					$("#erreurReservation").empty().css("display", "block").addClass("alert alert-warning").html("<p>"+reponse.messageErreur + "</p>");
				} 
				else if(reponse.messageSucces){ //s'on n'as pas des erreurs côté php
					$("#erreurReservation").empty().css("display", "block").removeClass("alert alert-warning").addClass("alert alert-success").html("<p>"+reponse.messageSucces + "</p>");
                    
                    ecrireMessage(id_userClient, objetClient, texteClient);
                    ecrireMessage(idProprio, objetProprio, texteProprio);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
    e.stopImmediatePropagation();	
	}

    
    /* ============================  function pour le datepicker des disponibilites ============================================== */


    $(function() { 
        /*var todayDate = new Date().getDate();
        var endD= new Date(new Date().setDate(todayDate - 15));*/
        var currDate = moment().add(1, 'days');
        
        
        $('input[name="daterange"]').daterangepicker({
        
            format: 'YYYY/MM/DD',
            minDate: moment().add(1, 'days'),
            //maxDate: "03/19/2018", 
            showDropdowns: true,
            alwaysShowCalendars: true,
            //startDate: "02/26/2018",
           // endDate: "03/19/2018",
            opens: "left"
            
        });
    }); 


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
    
    // charger le script de la carte google
   if($('#carte').length)
    {
        var scriptGoogle = '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACwL7adHNKo6veif0FtD6axaWGx23TTLw&callback=initMap"></script>';
        $('body').append(scriptGoogle);
    } 

    var carte = $("#carte");

    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        if (scroll >= window.innerHeight-300) {
            carte.addClass("carte_fixe");
            carte.removeClass("absolut");
        
        } else {
            carte.removeClass("carte_fixe");
            carte.addClass("absolut");
        }
    });
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

/*//////////////////////////////////////////////////////////////////////////////////////////////*/

/* //////////////////////////////  ACTIONS SUR LES MESSAGES ////////////////////////////////////*/

$(document).ready(function() {
    
    var idUsager = $('input[name="idUser"]').val();
    //var idUsager = $("#userNom")[0].innerHTML;
    
    /* faire une test pour verifier la provenace de la requete*/
    $.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if(results)	return results[1]; else return 0;
    }
    
    // appel de la fonction d'affichage de tous les messages
    
        if($.urlParam('messages') == 'ok'){
            // afficher la liste des messages
            afficheListeMessages(idUsager, 'afficherListeMessages');
        }
        
    $('p[name="Messagerie"]').click( function(e){
        
        // afficher la liste des messages
        afficheListeMessages(idUsager, 'afficherListeMessages');
        e.stopImmediatePropagation();
        });

        // appel de la fonction pour verifier l'existance de nouveaux message
        // setInterval(notificationMessage, 5000);
        notificationMessage();
});

/* recuperer les notification pour les nouveaux messages non lus*/
function notificationMessage(){
    
           $.ajax({
            method: "POST",
            url: "index.php?Messages",
            //dataType:"html",
            data:{
                action: 'notification',
            },
    // comportement en cas de success ou d'echec
          success:function(reponse) {
            $('.badge-notify').html(reponse);
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
}

/* fonction pour afficher tout les messages reçus par un usagers */
function afficheListeMessages(idUser, action){
    
           $.ajax({
            method: "POST",
            url: "index.php?Messages",
            dataType:"html",
            data:{
                action: action,
                idUsager: idUser
            },
    // comportement en cas de success ou d'echec
          success:function(reponse) {
              
                $('#afficheInfoProfil').html(reponse);
              
            if(action == 'afficheMessagesEnvoyes')
              {
                $('#afficheInfoProfil').html(reponse);
                afficheMessEnvoyes();
              }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
}


/* fonction pour afficher tout les details d'un message */
function afficheDetailsMessage(idMessage){
    
           $.ajax({
            method: "POST",
            url: "index.php?Messages",
            dataType:"html",
           data:{
               action: 'detailsMessage',
               idMessage:idMessage
               },
    // comportement en cas de success ou d'echec
          success:function(reponse) {
                $.each($('td[name="contenuMessage"]'), function(){$(this).html('');});
                $('#contenuMessage'+idMessage).html(reponse);
                $('.iconEnveloppe'+idMessage).html('<i class="fa fa-envelope-open text-muted"></i>');
                $('.iconEnveloppe'+idMessage).parent().removeClass('non_lu');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
}

/* fonction pour supprimer un message */
function supprimeMessage(idMessage, action){
    
           $.ajax({
            method: "POST",
            url: "index.php?Messages",
            dataType:"html",
            data: {
                action: action,
                idMessage: idMessage
            },
    // comportement en cas de success ou d'echec
          success:function(reponse) {
               // $('#contenuMessage'+idMessage).html(reponse);
              $('#afficheInfoProfil').html(reponse);
               
              if(action == 'archiverMessage')
                  {
                      afficheMessEnvoyes();
                  }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
}

/* ouvrire le formulaire de reponse à un message*/
function formulaireMessage(idDestination, idMessage ='', objet='')
{
    $.each($('td[name="contenuMessage"]'), function(){$(this).html('');});
    $('#contenuMessage'+idMessage).load('vues/ecrireMessage.php');
    setTimeout(function () { 
        $('#contenuMessage'+idMessage+' #objet').val('re: '+objet);
        $('#contenuMessage'+idMessage+' #destination').val(idDestination);
        
        // appel de la fonction ecrireMessage()
        $('button#envoiMessage').click(function(e){
            e.preventDefault();
            var objet = $('#objet').val();
            var texte = $('#messageTextarea').val();
            ecrireMessage(idDestination, objet, texte);
            e.stopImmediatePropagation();
        });
    }, 100);
}

/* ouvrire le formulaire de redaction d'un nouveau  message*/
function formulaireNouveauMessage(selecteur)
{
    $('#'+selecteur).load('vues/ecrireMessage.php');
    setTimeout(function () {

        var destinatair = $('#profilUser input[name="idProprio"]').val();

        $('#destination').val(destinatair);
        // appel de la fonction ecrireMessage()
        $('button#envoiMessage').click(function(e){
            e.preventDefault();
            var idDestination = $('#destination').val();
            var objet = $('#objet').val();
            var texte = $('#messageTextarea').val();
            ecrireMessage(idDestination, objet, texte);
            e.stopImmediatePropagation();
        });
    }, 100);
}

/* fonction pour ecrire un message */
function ecrireMessage(idDestination, objet, texte){
    
           $.ajax({
            method: "POST",
            url: "index.php?Messages",
            dataType:"html",
            data:{
                action: 'ecrireMessage',
                idDestination : idDestination,
                objet: objet,
                texte: texte,
            },
    // comportement en cas de success ou d'echec
          success:function(reponse) {
              $(".ecrireMessage").hide( "slide", {times:4}, 1000 );
              $.each($('.tab-pane'), function(){$(this).removeClass('active');}); 
              $.each($('.nav-tabs .nav-link'), function(){$(this).removeClass('active');});
              $('#envoyes').addClass('active');
              $('a[href="#envoyes"]').addClass('active');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
}

// fonction pour afficher les message envoyés
function afficheMessEnvoyes(){
    $.each($('.tab-pane'), function(){$(this).removeClass('active');}); 
    $.each($('.nav-tabs .nav-link'), function(){$(this).removeClass('active');});
    $('#envoyes').addClass('active');
    $('a[href="#envoyes"]').addClass('active');
    $('h6[name="repondreMessage"]').remove();
    $('#envoyes').append($('div.table-responsive'));
    $('#recus').html('');
}




function CalculerdonneePaiement(idLocation){

       $.ajax({
        method: "POST",
        url: "index.php?Appartements",
           dataType: "json",
        data:{
            action: 'payerLocation',
            idLocation : idLocation,
        },
// comportement en cas de success ou d'echec
      success:function(reponse) {
        
          
      $("#recapLocation").load("./vues/recapLocation.php");

        setTimeout(function () {

            $(".recap .arrivee span").html(reponse.dateDebut);
            $(".recap .depart span").html(reponse.dateFin);
            $(".recap .nbrJours span").html(reponse.nbrJours);
            $(".recap .prixJour span").html(reponse.prixJour);
            $(".recap .total span").html(reponse.totalLocation);
            $(".modal-header").css({color: "#ffffff", backgroundColor: "#585759"});
            $(".modal-footer").css({color: "#585759", backgroundColor: "#ffffff"});
            
             boutonPaypal(reponse.totalLocation, idLocation); 
            
            $("#modalPaiement").modal('show');
            
        }, 200);
          
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
}