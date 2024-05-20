<!-- script.php -->
<?php

require_once 'php-jwt-main/src/JWT.php';


$key = 'BZilneQpAQKQUHEfHlvP7XkfuslEioQRhvE7gfpK3Lnqqvwi5sB8yxEadKkbtWJ3';  // zmenit na vlastni klic, minimalne 64 znaku
$currentTime = time();
$payload = [  // sdili metadata, ne informace jako takove (expirace, odesilatel, prijemnce) 
    'user_id' => $_POST['user_id'],  // user ID, muze si vygenerovat nove
    'token_id' => $_POST['token_id'],  // token ID, vygeneruje se automaticky 
    'time_create' => $currentTime,  // cas vytvoreni tokenu
    'time_exp' => $currentTime + 3600,  // cas expirace tokenu
];

$jwt = 'xxxxxxxx';  // token ktery chci verifikovat
$jwt = JWT::encode($payload, $key, 'HS256');

try {
    $decoded = JWT::decode($jwt, $key, ['HS256']);  // dulezita je specifikace konkretniho algoritmu ('puvodne HS526')
    print_r($decoded);
} catch (\Firebase\JWT\ExpiredException $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} catch (\Firebase\JWT\SignatureInvalidException $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} catch (\Firebase\JWT\BeforeValidException $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
} catch (\UnexpectedValueException $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$decoded_array = (array) $decoded;
printf("Decoded: %s\n", $decoded_array['iss']);

/*
 DŮLEŽITÉ:
 Musíte specifikovat podporované algoritmy pro vaši aplikaci. Viz
 https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 pro seznam algoritmů dle specifikace.

    Typek prijde na muj endpoint ktery vydava tokeny, kazdej uzivatel si muze v dashboardu vygenerovat svoje ID a musi ho poslat na verifikacni soubor.
    DULEZITA VEC token == zasifrovany string
             JWT token == zasifrovany json (json je pouze format stringu)
    To se zkontroluje tak, ze se zkontroluje aktualni cas a cas odeslani.
*/