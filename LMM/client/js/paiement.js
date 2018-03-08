/* Fonction qui initialise et execute un paiement paypal*/
/* SOURCE: https://developer.paypal.com */
    
    /* initialiser la div qui contiendra le bouton paypal*/
    function boutonPaypal(total, idLocation){
         
        paypal.Button.render({

            
            env: 'sandbox', // sandbox | production

            // Specify the style of the button

            style: {
                label: 'paypal',
                size:  'responsive',    // small | medium | large | responsive
                shape: 'rect',     // pill | rect
                color: 'blue',     // gold | blue | silver | black
                tagline: false    
            },
            
            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AUQE73ACf4od5QWzK3sC5ztdkSmYdmLKOt2jour7Z3XK4IJnEAU9eqIzFd4ZryPjySuObHtbTeWc5F2X',
                production: '<insert production client id>'
            },

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: total, currency: 'CAD' }
                            }
                        ]
                    }
                });
            },

            // onAuthorize() is called when the buyer approves the payment
            onAuthorize: function(data, actions) {

                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function() {
                                 
                    // Show a thank-you note
                    
                  return actions.payment.get().then(function(payment) {
                      
                        $.ajax({
                            method: "POST",
                            url: "index.php?Appartements",
                            dataType: "json",
                            data:{
                                action: 'payerLocation',
                                idLocation: idLocation,
                                infoPaiement: payment,
                            },
                    // comportement en cas de success ou d'echec
                          success:function(reponse) {
                           
                                $.ajax({
                                    method: "POST",
                                    url: "index.php?Appartements",
                                    dataType: "json",
                                    data:{
                                        action: 'validerPaiement',
                                        idLocation: idLocation,
                                        infoPaiement: payment,
                                    },
                            // comportement en cas de success ou d'echec
                                  success:function(reponse) {
                                      
                                      $("#recapLocation").html("Votre paiement est enregistré.<br> Profitez de votre séjour.");
                                      setTimeout(function(){$("#modalPaiement").modal('hide');},2000);
                                      setTimeout(function(){$("#mesReservations").click();},2500);
                                      
                                  },
                                  error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                  }
                                });
                              
                          },
                          error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                          }
                        });
                      
                     //validerLocation(payment.idLocation);
                    //setTimeout(function() {$("#myModal"+idLocation).modal('hide')}, 5000);
                      
                      
                });
                   // document.querySelector('#thanksname').innerText = shipping.recipient_name;
                   // document.querySelector('#confirm').style.display = 'none';
                   // document.querySelector('#thanks').style.display = 'block';
                });
            }

        }, '#paypal-button');
        
    }