<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "sk_test_mL68e80wLPvBiOPOJ6Yep1m700XpLkiXX8",
  "publishable_key" => "pk_test_mjHic5Ah5DZZrGvZkOnSj5nQ00g5Uvl7EJ",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>