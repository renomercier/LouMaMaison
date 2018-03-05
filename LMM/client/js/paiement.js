
 
    /* paypal*/
    
    /* initialiser la div qui contiendra le bouton paypal*/
    function boutonPaypal(){
        
        /* creation du bouton paypal */
//       paypal.Button.render({
//          env: 'sandbox', // Or 'production',
//
//          commit: true, // Show a 'Pay Now' button
//
//          style: {
//            color: 'gold',
//            size: 'small'
//          },
//
//          payment: function(data, actions) {
//            /* 
//             * Set up the payment here 
//             */
//          },
//
//          onAuthorize: function(data, actions) {
//            /* 
//             * Execute the payment here 
//             */
//          },
//
//          onCancel: function(data, actions) {
//            /* 
//             * Buyer cancelled the payment 
//             */
//          },
//
//          onError: function(err) {
//            /* 
//             * An error occurred during the transaction 
//             */
//          }
//        }, '#paypal-button');
        
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
                                amount: { total: '0.01', currency: 'CAD' }
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
                    $("#erreurReservation").empty().css("display", "block").addClass("alert alert-success").html("<p>Détail du paiement: "+payment+ "</p>");
                      console.log(payment);
                });
                   // document.querySelector('#thanksname').innerText = shipping.recipient_name;
                   // document.querySelector('#confirm').style.display = 'none';
                   // document.querySelector('#thanks').style.display = 'block';
                });
            }

        }, '#paypal-button');
        
        
//            // Render the PayPal button
//
//        paypal.Button.render({
//
//            // Pass in the Braintree SDK
//
//            braintree: braintree,
//
//            // Pass in your Braintree authorization key
//
//            client: {
//                sandbox: paypal.request.get('/demo/checkout/api/braintree/client-token/'),
//                production: '<insert production auth key>'
//            },
//
//            // Set your environment
//
//            env: 'sandbox', // sandbox | production
//
//            // Wait for the PayPal button to be clicked
//
//            payment: function(data, actions) {
//
//                // Make a call to create the payment
//
//                return actions.payment.create({
//                    payment: {
//                        transactions: [
//                            {
//                                amount: { total: '0.01', currency: 'CAD' }
//                            }
//                        ]
//                    }
//                });
//            },
//
//            // Wait for the payment to be authorized by the customer
//
//            onAuthorize: function(data, actions) {
//
//                // Call your server with data.nonce to finalize the payment
//
//                console.log('Braintree nonce:', data.nonce);
//
//                // Get the payment and buyer details
//
//                return actions.payment.get().then(function(payment) {
//                    console.log('Payment details:', payment);
//                });
//            }
//
//        }, '#paypal-button-container');
        
    }

