'use strict';

  var form = jQuery( '.flw-simple-pay-now-form' ),
      redirectUrl, flw_rave_options;

  if ( form ) {
    form.on( 'submit', function(evt) {
      evt.preventDefault();

      var config = buildConfigObj( this );
      getpaidSetup( config );
    } );
  }

  /**
   * Builds config object to be sent to GetPaid
   *
   * @return object - The config object
   */
  var buildConfigObj = function( form ) {
    var formData = jQuery( form ).data();
    var amount  = formData.amount || jQuery( form ).find( '#flw-amount' ).val();
    var email   = formData.email  || jQuery( form ).find( '#flw-customer-email' ).val();
    var txref   = 'JRF_' + form.id.toUpperCase() + '_' + new Date().valueOf();

    return {
      amount: amount,
      country: flw_rave_options.country,
      currency: flw_rave_options.currency,
      custom_description: flw_rave_options.desc,
      custom_logo: flw_rave_options.logo,
      custom_title: flw_rave_options.title,
      customer_email: email,
      PBFPubKey: flw_rave_options.pbkey,
      txref: txref,
      onclose: function() {
        redirectTo( redirectUrl );
      },
      callback: function(res) {
        sendPaymentRequestResponse( res );
      }
    };
  };

  /**
   * Sends payment response from GetPaid to the endpoint that saves the record
   * Through saveResponse function in mod_rave_payment_forms.php
   *
   * @param object Response object from GetPaid
   *
   * @return void
   */
  var sendPaymentRequestResponse = function(res) {
    saveResponse(res.tx, function(response, error) {
      if(error) return console.log('error: ', error);
      redirectUrl   = response.redirect_url;
      console.log('res', response);

      if (!redirectUrl) {
        var responseMsg  = ( res.tx.paymentType === 'account' ) ? res.tx.acctvalrespmsg  : res.tx.vbvrespmessage;
        jQuery( form )
          .find( '#notice' )
          .text( responseMsg )
          .removeClass( function() {
            return jQuery( form ).find( '#notice' ).attr( 'class' );
          } )
          .addClass( response.status );
      } else {
        setTimeout( redirectTo, 5000, redirectUrl );
      }
    });
  };

  /**
   * Redirect to set url
   *
   * @param string url - The link to redirect to
   *
   * @return void
   */
  var redirectTo = function( url ) {
    if (url) {
      // location.href = url;
    }
  };
