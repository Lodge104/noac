<?php

require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('pk_test_4a2mJNxlDhoAzjPi9gcZZ8T1');

header('Content-Type: application/json');

$YOUR_DOMAIN = $_SERVER['SERVER_NAME'];

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    'price' => 'price_1JoYrbEEVK7xotm1yyl6JMVL',
    'quantity' => 1,
  ]],
  'payment_method_types' => [
    'card',
  ],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/participant/index.php?sucess=2',
  'cancel_url' => $YOUR_DOMAIN . 'participant/index.php?sucess=3',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);