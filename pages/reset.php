<?php

use App\Utility\Functions;
use App\Utility\Session;

Functions::displayError(Session::get('reset.error'));
Session::delete('reset.error');


?>

<div class="container">
    <h1 class="form-title">Reset wachtwoord</h1>
    <div class="form-back">
            <h1>
                <a href="?page=login">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
    <form action="?page=formHandler" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="reset">
        <label class="form-label" for="email">Email:</label>
        <input class="form-input" type="text" name="email" placeholder="Email">
        <label class="form-label" for="phone">Phone:</label>
        <input class="form-input" type="phone" name="phone" placeholder="phone">
        <label class="form-label" for="password">Password:</label>
        <input class="form-input" type="password" name="password" placeholder="Password">
        <input class="form-button" type="submit" name="reset" value="Reset">
    </form>
</div>