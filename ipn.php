<?php
require_once "IzipayController.php";
require_once "keys.example.php";

$payment = new IzipayController();

if (empty($_POST)) {
    throw new Exception("no post data received!");
}

/* Check the signature */
if (!$payment->checkHash()) {
    throw new Exception("invalid signature");
}

/* I check if it's really paid */
$answer = json_decode($_POST["kr-answer"], true);

if ($answer['orderStatus'] != 'PAID') {
    $title = "Pago No Finalizado !";
} else {
    $title = "Pago Finalizado !";


    /* Retrieve the transaction id from the IPN data */
    $transaction = $answer['transactions'][0];

    /* get some parameters from the answer */
    $orderStatus = $answer['orderStatus'];
    $orderId = $answer['orderDetails']['orderId'];
    $transactionUuid = $transaction['uuid'];

    print 'OK! OrderStatus is ' . $orderStatus;
}
