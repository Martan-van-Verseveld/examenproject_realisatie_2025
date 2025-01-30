<?php

use App\Utility\Functions;
use App\Utility\Session;

Functions::displayError(Session::get('login.error'));
Session::delete('login.error');

?>


<div class="containerlogin">
    <h1 class="form-title">Login</h1>
    <form action="?page=formHandler" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="login">
        <div class="form-back">
            <h1>
                <a href="?page=home">
                <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
        <label class="form-label" for="username">Gebruikersnaam</label>
        <input class="form-input" type="text" name="username" placeholder="Username" max="255" min="255">
        <label class="form-label" for="password">Wachtwoord</label>
        <input class="form-input" type="password" name="password" placeholder="Password" max="255" min="255">
        <section class="flex_row">
            <input class="form-button" type="submit" name="login" value="Login">
            <a href="?page=register">
                <button class="form-button" type="button">Register</button>
            </a>
            <a href="?page=reset">
                <button class="form-button" type="button">Reset</button>
            </a>
        </section>
    </form>
</div>