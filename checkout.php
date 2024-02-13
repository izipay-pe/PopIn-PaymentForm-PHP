<?php
require_once "IzipayController.php";
require_once "keys.example.php";

$payment = new IzipayController();

$error = "";
$datos = array(
  "amount" => $_POST["amount"]*100,
  "currency" => "PEN",
  "customer" => array(
    "email"=>$_POST["email"],
  ),
  "orderId" => uniqid("MyOrderId"),
);

  $response = $payment->post("V4/Charge/CreatePayment",$datos);
  $formToken = $response["answer"]["formToken"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Redirect Form Izipay</title> 

  <!-- Javascript library. Should be loaded in head section -->
  <script 
   src="<?= $payment->getEndpointApiRest() ?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
   kr-public-key="<?= $payment->getPublicKey() ?>" 
   kr-post-url-success="paid.php"
   >
  </script>
  <!-- theme and plugins. should be loaded after the javascript library -->
  <!-- not mandatory but helps to have a nice payment form out of the box -->
  <link rel="stylesheet" 
  href="<?= $payment->getEndpointApiRest() ?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
 <script 
  src="<?= $payment->getEndpointApiRest() ?>/static/js/krypton-client/V4.0/ext/classic.js">
 </script> 
  
  
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />

  
</head>
<body>
  <div class="root">
    <div><?=$error ?></div>
    <div class="App">
      <h2>Confirmar compra <img src="https://iziweb001.s3.amazonaws.com/webresources/img/logo.png" alt="Logo de Izipay"></h2>
      <div class="content-checkout">
        <div class='cart'>
          <div class='Product'>
              <h4><?=$_POST["product"]?></h4><img src="<?=$_POST['image']?>" alt="<?=$_POST['image']?>">
              <p><span>S/</span><?=$_POST['amount']?></p>
          </div>
        </div>
        <div class='checkout'>
          <h3>Datos del cliente</h3>
          <form action="" method="post">
              <div class='control-group'>
                  <input type="text" name="name" value="<?=$_POST["firstName"] ?>" disabled>
              </div>
              <div class='control-group'>
                  <input type="text" value="<?=$_POST["lastName"] ?>" disabled>
              </div>
              <div class='control-group'>
                  <input type='email' value="<?=$_POST["email"] ?>" disabled>
              </div>

              <button  type="submit" name="pagar">Confirmar</button>
          </form>

            <!-- payment form -->
          <div class="kr-embedded" style="display: none;" kr-form-token="<?= $formToken ?>">

            <!-- payment form fields -->
            <div class="kr-pan"></div>
            <div class="kr-expiry"></div>
            <div class="kr-security-code"></div>  

            <!-- payment form submit button -->
            <button class="kr-payment-button" style="background-color: #00A09D;"></button>

            <!-- error zone -->
            <div class="kr-form-error"></div>
          </div>  

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
  <script>
    
    window.onload = function() {
      document.querySelector(".checkout > form").addEventListener("submit", (e)=>{
        e.preventDefault();
        handleDisplay(".checkout > form","none");
        handleDisplay(".checkout > div","block")

      })
      const handleDisplay = (element,display)=>{
        document.querySelector(element).style.display = display;
      }
    }

      
      
  </script>
</body>
</html>