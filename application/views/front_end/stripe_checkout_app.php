<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stripe Payment</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h3>Enter Your Card Details</h3>
        </div>
      </div>
      <!-- Better Bootstrap payment form starts here -->
      <!-- Use Jquery in this example -->
      <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
      <!-- Font Awesome for prettier icons -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
      <!-- Bootstrap JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
      <!-- Stripe.js to collect payment details -->
      <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      <!-- Jquery payment library for nicer formatting -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.4.1/jquery.payment.js"></script>
      
      <script>
        // Set your Stripe publishable API key here 
        Stripe.setPublishableKey('<?php echo $this->config->item('stripe_publishable_key'); ?>');
        
        $(function() {
          var $form = $('#payment-form');
          $form.submit(function(event) {
            // Clear any errors
            $form.find('.has-error').removeClass('has-error')

            // Validate the form isn't empty before requesting a token
            invalidForm = false;
            $('#payment-form input').each(function() {
              if ($(this).val() == '') { 
                $('#'+this.id).parent('.form-group').addClass('has-error');
                invalidForm = true;
              }
            });
            if (invalidForm){
              return false;
            }

            // Disable the submit button to prevent repeated clicks:
            $form.find('.submit').prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> Making payment...");

            // Request a token from Stripe:
            Stripe.card.createToken($form, stripeResponseHandler);
            
            // Prevent the form from being submitted:
            return false;
          });

          // Formatting
          $('#number').payment('formatCardNumber');
          $('#cc_exp').payment('formatCardExpiry');

          // Determine & display the card brand
          $('#number').keyup(function() {
            card_type = $.payment.cardType($('#number').val());
            card_type ? $('#card_type').html("<i class='text-success fa fa-cc-"+card_type+"'></i>") : $('#card_type').html("");
          });
        });

        function stripeResponseHandler(status, response) {
          var $form = $('#payment-form');   
          if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message).addClass('alert alert-danger');
            $form.find('#' + response.error.param).parent('.form-group').addClass('has-error');
            $form.find('button').prop('disabled', false).text('Pay <?php echo $plan_data['plan_amount_type'] ?> <?php echo $plan_data['total_pay'] ?>'); // Re-enable submission
          } 
          else { // Token was created!
            $form.find('.submit').html("<i class='fa fa-check'></i> Payment accepted");
            // Get the token ID:
            var token = response.id;  
            // Insert the token and name into the form so it gets submitted to the server:
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));

            // Submit the form:
            $form.get(0).submit();
          }
        }
      </script>
      <style>
        .payment-errors{
          word-break: break-all;
        }
      </style>
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              <h4><span id="card_type"></span> Make a <?php echo $plan_data['plan_amount_type'] ?> <?php echo $plan_data['total_pay'] ?> payment</h4>
            </div>
            <div class="panel-body">
              <form action="<?php echo $base_url;?>products/purchaseApp" method="POST" id="payment-form">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="plan_id" value="<?php echo $plan_data['id']; ?>">
                <input type="hidden" name="price" value="<?php echo $plan_data['total_pay'] ?>">
                <input type="hidden" name="currency" value="<?php echo $plan_data['plan_amount_type'] ?>">
                <input type="hidden" name="name" value="<?php echo $plan_data['plan_name'] ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                <div class="payment-errors"></div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Card Holder's Name</label>
                      <input class="form-control input-lg" id="name" type="text" data-stripe="name" placeholder="Card Holder's Name">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Card Number</label>
                      <input class="form-control input-lg" id="number" type="tel" size="20" data-stripe="number" placeholder="Card Number">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-7">
                    <div class="form-group">
                      <label>Expiry</label>
                      <input class="form-control input-lg" id="cc_exp" type="tel" size="2" data-stripe="exp" placeholder="MM/YY">
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label>CVV</label>
                      <input class="form-control input-lg" id="cvc" type="tel" size="4" data-stripe="cvc" placeholder="CVV" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-lg btn-block btn-success submit" type="submit">Pay <?php echo $plan_data['plan_amount_type'] ?> <?php echo $plan_data['total_pay'] ?></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Better Bootstrap payment form ends here -->
    </div>
  </body>
</html>