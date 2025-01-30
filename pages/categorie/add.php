<?php

use App\Utility\Functions;
use App\Utility\Session;

Functions::displayError(Session::get('categorie.error'));
Session::delete('categorie.error');

?>

<div class="container">
<h1 class="form-title">Categorie toevoegen</h1>
<form action='?page=formHandler' method='post' enctype="multipart/form-data">
<div class="form-back">
            <h1>
                <a href="?page=categorie.overzicht">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
    <input type='hidden' name='action' value='addCategorie'>
    <label class="form-label" for="categorie">Categorie</label>
    <input class="form-input" type="text" name="categorie" id="categorie" maxlength="255">
    <input class="form-button" type='submit' value='Voeg categorie toe'>
</form>