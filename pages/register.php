<?php

use App\Utility\Functions;
use App\Utility\Session;

Functions::displayError(Session::get('register.error'));
Session::delete('register.error');

?>


<div class="containerregister">
    <h1 class="form-title">Registeren</h1>
    <form action="?page=formHandler" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="register">
        <div class="form-back">
            <h1>
                <a href="?page=login">
                <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
        <label class="form-label" for="username">Gebruikersnaam:</label>
        <input class="form-input" type="text" name="username" placeholder="Username">
        <label class="form-label" for="firstname">Voornaam:</label>
        <input class="form-input" type="text" name="firstname" placeholder="voornaam">
        <label class="form-label" for="lastname">Achternaam:</label>
        <input class="form-input" type="text" name="lastname" placeholder="achternaam">
        <label class="form-label" for="adres">Adres:</label>
        <input class="form-input" type="text" name="adres" placeholder="adres">
        <label class="form-label" for="city">Plaats:</label>
        <input class="form-input" type="text" name="city" placeholder="plaats">
        <label class="form-label" for="phone">Telefoon:</label>
        <input class="form-input" type="phone" name="phone" placeholder="telefoon">
        <label class="form-label" for="email">Email:</label>
        <input class="form-input" type="email" name="email" placeholder="email">
        <label class="form-label" for="password">Wachtwoord:</label>
        <input class="form-input" type="password" name="password" placeholder="Password">
        <input class="form-button" type="submit" name="register" value="Registeren">
    </form>
</div>