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

<div class="container">
<h1 class="form-title">Account bewerken</h1>
<form action='?page=formHandler' method='post' enctype="multipart/form-data">
<div class="form-back">
            <h1>
                <a href="?page=account.index">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div> 
    <input type='hidden' name='action' value='editAccount'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
    <label class="form-label" for="gebruikersnaam">Gebruikersnaam</label>
    <input class="form-input" type="text" name="gebruikersnaam" value='<?= $currentData['gebruikersnaam'] ?>' maxlength="255" required>
    <label class="form-label" for="voornaam">Voornaam</label>
    <input class="form-input" type='text' name='voornaam' value='<?= $currentData['voornaam'] ?>' maxlength="32" required>
    <label class="form-label" for="achternaam">Achternaam</label>
    <input class="form-input" type="text" name="achternaam" value='<?= $currentData['achternaam'] ?>' maxlength="64" required>
    <label class="form-label" for="adres">Adres</label>
    <input class="form-input" type="text" name="adres" value='<?= $currentData['adres'] ?>' maxlength="64" required>
    <label class="form-label" for="plaats">Plaats</label>
    <input class="form-input" type="text" name="plaats" value='<?= $currentData['plaats'] ?>' maxlength="32" required>
    <label class="form-label" for="telefoon">telefoon</label>
    <input class="form-input" type="phone" name="telefoon" value='<?= $currentData['telefoon'] ?>' maxlength="15" required>
    <label class="form-label" for="email">Email</label>
    <input class="form-input" type="text" name="email" value='<?= $currentData['email'] ?>' maxlength="128" required>
    <input class="form-button" type='submit' value='Account updaten'>
</form>
</div>
