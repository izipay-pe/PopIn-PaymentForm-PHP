<?php
// Identificador de su tienda
define("USERNAME", "~ CHANGE_ME_USER_ID ~");

// Clave de Test o Producción
define("PASSWORD", "~ CHANGE_ME_PASSWORD ~");

// Clave Pública de Test o Producción
define("PUBLIC_KEY","~ CHANGE_ME_PUBLIC_KEY ~");

// Clave HMAC-SHA-256 de Test o Producción
define("HMAC_SHA256","~ CHANGE_ME_HMAC_SHA_256 ~");

function formToken(){
    $body = [
        "amount" => $_POST["amount"] * 100,
        "currency" => $_POST["currency"],
        "orderId" => $_POST["orderId"],
        "customer" => [
        //   "email" => $_POST["email"],
          "billingDetails" => [
            "firstName"=>  $_POST["firstName"],
            "lastName"=>  $_POST["lastName"],
            "phoneNumber"=>  $_POST["phoneNumber"],
            "identityType"=>  $_POST["identityType"],
            "identityCode"=>  $_POST["identityCode"],
            "address"=>  $_POST["address"],
            "country"=>  $_POST["country"],
            "city"=>  $_POST["city"],
            "state"=>  $_POST["state"],
            "zipCode"=>  $_POST["zipCode"],
          ]
        ],
    ];

    $url = "https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment";
    $auth = USERNAME.":".PASSWORD;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_USERPWD, $auth);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $raw_response = curl_exec($curl);
    $response = json_decode($raw_response , true);
    return $response;
}

function checkHash(){
    if ($_POST['kr-hash-key'] == "sha256_hmac") {
        $key = HMAC_SHA256;
    } elseif ($_POST['kr-hash-key'] == "password") {
        $key = PASSWORD;
    } else {
        return false; 
    }  

    $krAnswer = str_replace('\/', '/',  $_POST["kr-answer"]);
    $calculateHash = hash_hmac("sha256", $krAnswer, $key);

    return ($calculateHash == $_POST["kr-hash"]) ;
}
