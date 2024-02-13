<?php

// Identificador de su tienda
IzipayController::setDefaultUsername("~ CHANGE_ME_USER_ID ~");

// Clave de Test o Producción
IzipayController::setDefaultPassword("~ CHANGE_ME_PASSWORD ~");

// Clave Pública de Test o Producción
IzipayController::setDefaultPublicKey("~ CHANGE_ME_PUBLIC_KEY ~");

// Clave HMAC-SHA-256 de Test o Producción
IzipayController::setDefaultHmacSha256("~ CHANGE_ME_HMAC_SHA_256 ~");

// URL del servidor de Izipay
IzipayController::setDefaultEndpointApiRest("https://api.micuentaweb.pe");
