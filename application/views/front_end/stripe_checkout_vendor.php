<?php

        ## Stripe Payemnt Getway start 18/07/2025 
        $stripeSecretKey = $stripe['key'];
        $amount = $plan_data['plan_ammount'];
        $unit_amount = intval($amount * 100); // Convert dollars to cents
        $currency = strtolower($plan_data['currency_code']);
        $planName = $plan_data['business_name'];
        $redirect = base_url() . 'vendor-stripe-response' . '?session_id={CHECKOUT_SESSION_ID}';

        $data = [
          'payment_method_types[]' => 'card',
          'line_items[0][price_data][currency]' => $currency,
          'line_items[0][price_data][product_data][name]' => $planName,
          'line_items[0][price_data][unit_amount]' => $unit_amount,
          'line_items[0][quantity]' => 1,
          'mode' => 'payment',
          'success_url' => $redirect,
          'cancel_url' => base_url('vendor-payment-cancel-stripe'),
        ];

        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecretKey . ':');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        $response = curl_exec($ch);
        curl_close($ch);

        $session = json_decode($response, true);

        if (isset($session['url'])) {
          redirect($session['url']);
        } else {
          echo "Stripe Error: " . ($session['error']['message'] ?? 'Unknown error');
        }
              
?>