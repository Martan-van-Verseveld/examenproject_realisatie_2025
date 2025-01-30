<?php

use App\Utility\Database;
use App\Utility\Functions;
use App\Utility\Session;


$database = Database::getInstance();

$query_categories = $database->query(query: "
SELECT * 
    FROM categorie;
");
$categories = $query_categories->fetchAll(PDO::FETCH_ASSOC);


Functions::displayError(Session::get('product.error'));
Session::delete('product.error');

?>

<div class="container">
    <h2 class="form-title">Product toevoegen</h2>
    <form action='?page=formHandler' method='post' enctype="multipart/form-data">
        <div class="form-back">
            <h1>
                <a href="?page=product.overzicht">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
        <input type='hidden' name='action' value='addProduct'>
        <label class="form-label" for="categorie_id">Categorie</label>
        <select class="form-input" name='categorie_id' required>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?= $categorie['id'] ?>"><?= $categorie['categorie'] ?></option>
            <?php endforeach; ?>
        </select>
        <label class="form-label" for="naam">Naam</label>
        <input class="form-input" type="text" name="naam" value='' maxlength="255" required>
        <label class="form-label" for="omschrijving">Omschrijving</label>
        <textarea class="form-input-textarea" name="omschrijving" required></textarea>
        <label class="form-label" for="merk">Merk</label>
        <input class="form-input" type='text' name='merk' value='' maxlength="255" required>
        <label class="form-label" for="kleur">Kleur</label>
        <input class="form-input" type="text" name="kleur" value='' maxlength="55" required>
        <label class="form-label" for="afmeting">Afmeting</label>
        <input class="form-input" type="text" name="afmeting" value='' maxlength="55" required>
        <label class="form-label" for="aantal">Aantal</label>
        <input class="form-input" type="number" name="aantal" value='' required>
        <label class="form-label" for="prijs_ex_btw">Prijs ex-btw</label>
        <input class="form-input" type="number" name="prijs_ex_btw" value='' step="0.01" min="0" max="9999999999.99" required>
        <label class="form-label" for="ean_number">EAN number</label>
        <input class="form-input" type="text" name="ean_number" value='' required>
        <input class="form-button" type='submit' value='Product toevoegen'>
    </form>