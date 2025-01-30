<?php

use App\Utility\Functions;
use App\Utility\Session;


Functions::displayError(Session::get('medewerker.error'));
Session::delete('medewerker.error');

?>

<div class="container">
    <h1 class="form-title">Medewerker toevoegen</h1>

    <form action='?page=formHandler' method='post' enctype="multipart/form-data">
        <div class="form-back">
            <h1>
                <a href="?page=medewerker.overzicht">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
        <input type='hidden' name='action' value='addMedewerker'>
        <label class="form-label" for="gebruikersnaam">Gebruikersnaam</label>
        <input class="form-input" type="text" name="gebruikersnaam" value='' maxlength="255" required>
        <label class="form-label" for="voornaam">Voornaam</label>
        <input class="form-input" type='text' name='voornaam' value='' maxlength="32" required>
        <label class="form-label" for="achternaam">Achternaam</label>
        <input class="form-input" type="text" name="achternaam" value='' maxlength="64" required>
        <label class="form-label" for="adres">Adres</label>
        <input class="form-input" type="text" name="adres" value='' maxlength="64" required>
        <label class="form-label" for="plaats">Plaats</label>
        <input class="form-input" type="text" name="plaats" value='' maxlength="32" required>
        <label class="form-label" for="telefoon">telefoon</label>
        <input class="form-input" type="phone" name="telefoon" value='' maxlength="15" required>
        <label class="form-label" for="email">Email</label>
        <input class="form-input" type="text" name="email" value='' maxlength="128" required>
        <label class="form-label" for="wachtwoord">Wachtwoord (Nieuwe Medewerker)</label>
        <input class="form-input" type="password" name="wachtwoord" value='' maxlength="255" required>
        <label class="form-label" for="rollen">Rollen</label>
        <input class="form-input" type="text" name="rollen" value='' maxlength="255" required>
        <label class="form-label" for="is_geverifieerd">Geverifieerd? (1/0)</label>
        <input class="form-input" type="number" name="is_geverifieerd" value='' maxlength="1" required>
        <input class="form-button" type='submit' value='Medewerker toevoegen'>
    </form>
</div>