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
$answer = json_decode($_POST["kr-answer"],true);
if ($answer['orderStatus'] != 'PAID' ) {
    $title = "Pago No Finalizado !";
} else {
    $title = "Pago Finalizado !";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Embedded Payment Form</title> 


  <!-- theme and plugins. should be loaded after the javascript library -->
  <!-- not mandatory but helps to have a nice payment form out of the box -->
  <link rel="stylesheet" 
  href="<?= $payment->getEndpointApiRest() ?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
 <script 
  src="<?= $payment->getEndpointApiRest() ?>/static/js/krypton-client/V4.0/ext/classic.js">
 </script> 
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />

  <style>
    .groupKr{
        text-align: start;
        margin-bottom: 0.25rem;    
    }
    .groupKr > span{
        color: #0dcaf0;
        margin-right: 0.25rem;
    }
  </style>
</head>
<body>
  <div class="root">
    <div class="App">
      <h2><?= $title?> <img src="https://iziweb001.s3.amazonaws.com/webresources/img/logo.png" alt="Logo de Izipay"></h2>
      <div class="content-checkout" style="display: block; margin: 0; padding: 10px;width:auto;    background-color: #343a40;color: white;">
        <p class="groupKr"><span>kr-hash :  </span><?= $_POST["kr-hash"] ?></p>
        <p class="groupKr"><span>kr-hash-algorithm :  </span><?= $_POST["kr-hash-algorithm"] ?></p>
        <p class="groupKr"><span>kr-answer-type :  </span><?= $_POST["kr-answer-type"] ?></p>
        <p class="groupKr"><span>kr-answer :  </span><br><?= print_r($_POST["kr-answer"],true) ?></p>


        </div>
      </div>
    </div>
  </div>

 

  <footer class="Soporte-Ecommerce">
    <figure><img src="https://iziweb001.s3.amazonaws.com/webresources/img/img-ico-call.png" alt="imagen de call center"></figure>
    <div>
        <h4><a href="tel:012130808">(01) 213-0808</a><a href="tel:010801-18181">0801-18181</a><a href="mailto:soporteecommerce@izipay.pe" style="color: rgb(0, 160, 157);">SoporteEcommerce@izipay.pe</a></h4>
        <p>Estaremos felices de ayudarte.</p>
    </div>
  </footer>

  
</body>
</html>