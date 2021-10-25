<?php

require 'vendor/autoload.php';

$stripe = new \Stripe\StripeClient(getenv('STRIPEKEY'));
$stripe->checkout->sessions->create([
  'success_url' => 'https://example.com/success',
  'cancel_url' => 'https://example.com/cancel',
  'payment_method_types' => ['card'],
  'line_items' => [
    [
      'price' => 'price_H5ggYwtDq4fbrJ',
      'quantity' => 2,
    ],
  ],
  'mode' => 'payment',
]);