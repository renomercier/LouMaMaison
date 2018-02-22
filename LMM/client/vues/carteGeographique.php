<!--
* @file         /carteGeographique.php
* @brief        Projet WEB 2
* @details      Affichage du resultat de la recherche sur une cate google map
* @author       Bourihane Salim, Massicotte Natasha, Mercier Renaud, Romodina Yuliya - 15612
* @version      v.1 | fevrier 2018
-->

<div id="carte"></div>
  <script>
  
    var carte;
    // initialiser la catrte google
    function initMap() {
      carte = new google.maps.Map(document.getElementById('carte'), {
        zoom: 11.5,
        center: new google.maps.LatLng(45.51,-73.72) 
      });
    }

// boucler dans le tableau des adresses et les placer sur la carte.
window.onload=function() { 
     
    function placerSureCarte(adrAppart) {
        Geocoder = new google.maps.Geocoder();
        /* Récupération de la valeur de l'adresse saisie */
//            var address = '11969 rolland montréal';
        /* Appel au service de geocodage avec l'adresse en paramètre */
         
        Geocoder.geocode( { 'address': adrAppart}, function(results, status) {
        /* Si l'adresse a pu être géolocalisée */
            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
//                    adrAppart['latitude'] = latitude;
//                    adrAppart['longitude'] = longitude;
//                    console.log(adrAppart);
                var latLng = new google.maps.LatLng(latitude,longitude);
                var marker = new google.maps.Marker({
                position: latLng,
                map: carte
              });
            }
        });
   
    }
  
    $("p.adresse").each(function(){
        placerSureCarte($(this).html());
    });
        
}
</script>
