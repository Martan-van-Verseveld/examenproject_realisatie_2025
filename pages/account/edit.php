<?php

use App\Utility\Functions;
use App\Utility\Database;
use App\Utility\Session;


$database = Database::getInstance();
$currentData = $database->query("
    SELECT * 
        FROM gebruiker
        WHERE id = :id;
", [
    'id' => Session::get('user')['id']
])->fetch();

?>


<form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <input type='hidden' name='action' value='editAccount'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
    <label for="gebruikersnaam">Gebruikersnaam</label>
    <input type="text" name="gebruikersnaam" value='<?= $currentData['gebruikersnaam'] ?>' maxlength="255" required>
    <label for="voornaam">Voornaam</label>
    <input type='text' name='voornaam' value='<?= $currentData['voornaam'] ?>' maxlength="32" required>
    <label for="achternaam">Achternaam</label>
    <input type="text" name="achternaam" value='<?= $currentData['achternaam'] ?>' maxlength="64" required>
    <label for="adres">Adres</label>
    <input type="text" name="adres" value='<?= $currentData['adres'] ?>' maxlength="64" required>
    <label for="plaats">Plaats</label>
    <input type="text" name="plaats" value='<?= $currentData['plaats'] ?>' maxlength="32" required>
    <label for="telefoon">telefoon</label>
    <input type="phone" name="telefoon" value='<?= $currentData['telefoon'] ?>' maxlength="15" required>
    <label for="email">EMail</label>
    <input type="text" name="email" value='<?= $currentData['email'] ?>' maxlength="128" required>
    <input type='submit' value='Account updaten'>
</form>
