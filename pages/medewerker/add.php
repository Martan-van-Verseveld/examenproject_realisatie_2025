<?php

use App\Utility\Functions;
use App\Utility\Session;


Functions::displayError(Session::get('medewerker.error'));
Session::delete('medewerker.error');

?>


<form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <input type='hidden' name='action' value='addMedewerker'>
    <label for="gebruikersnaam">Gebruikersnaam</label>
    <input type="text" name="gebruikersnaam" value='' maxlength="255" required>
    <label for="voornaam">Voornaam</label>
    <input type='text' name='voornaam' value='' maxlength="32" required>
    <label for="achternaam">Achternaam</label>
    <input type="text" name="achternaam" value='' maxlength="64" required>
    <label for="adres">Adres</label>
    <input type="text" name="adres" value='' maxlength="64" required>
    <label for="plaats">Plaats</label>
    <input type="text" name="plaats" value='' maxlength="32" required>
    <label for="telefoon">telefoon</label>
    <input type="phone" name="telefoon" value='' maxlength="15" required>
    <label for="email">EMail</label>
    <input type="text" name="email" value='' maxlength="128" required>
    <label for="wachtwoord">Wachtwoord (Nieuwe Medewerker)</label>
    <input type="password" name="wachtwoord" value='' maxlength="255" required>
    <label for="rollen">Rollen</label>
    <input type="text" name="rollen" value='' maxlength="255" required>
    <label for="is_geverifieerd">Geverifieerd? (1/0)</label>
    <input type="number" name="is_geverifieerd" value='' maxlength="1" required>
    <input type='submit' value='Medewerker toevoegen'>
</form>