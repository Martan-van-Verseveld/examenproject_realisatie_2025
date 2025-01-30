<?php

use App\Utility\Functions;
use App\Utility\Database;

// Redirect if 'id' is not set in GET parameters
if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=categorie.home');
}

$database = Database::getInstance();
$currentData = $database->query("
    SELECT * FROM categorie
    WHERE id = :id
", [
    'id' => $_GET['id']
])->fetch();

?>

<div class="container">
<h1 class="form-title">Categorie bewerken</h1>
<form action='?page=formHandler' method='post' enctype="multipart/form-data">  
<div class="form-back">
            <h1>
                <a href="?page=medewerker.overzicht">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div> 
    <input type='hidden' name='action' value='editCategorie'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
    <label class="form-label" for="categorie">Categorie</label>
    <input class="form-input" type="text" name="categorie" id="categorie" maxlength="255" value="<?=  $currentData['categorie'] ?>">
    <input class="form-button" type='submit' value='Update categorie'>
</form>