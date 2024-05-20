<?php

    // Připojení k databázi
    $servername = "kuslu21"; // Název serveru
    $username = "kuslu21"; // Uživatelské jméno pro přihlášení k databázi
    $password = "FbWWL9RP"; // Heslo pro přihlášení k databázi
    $database = "kuslu21"; // Název databáze

    // Vytvoření spojení s databází
    $db = new mysqli($servername, $username, $password, $database);

    // Kontrola spojení
    if ($db->connect_error) {
        die("Spojení s databází selhalo: " . $db->connect_error);
    }

    // Nastavení kódování pro spojení
    $db->set_charset("utf8");

?>