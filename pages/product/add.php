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


<form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <input type='hidden' name='action' value='addProduct'>
    <label for="categorie_id">Categorie</label>
    <select name='categorie_id' required>
        <?php foreach ($categories as $categorie): ?>
            <option value="<?= $categorie['id'] ?>"><?= $categorie['categorie'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="naam">Naam</label>
    <input type="text" name="naam" value='' maxlength="255" required>
    <label for="omschrijving">Omschrijving</label>
    <textarea name="omschrijving" required></textarea>
    <label for="merk">Merk</label>
    <input type='text' name='merk' value='' maxlength="255" required>
    <label for="kleur">Kleur</label>
    <input type="text" name="kleur" value='' maxlength="55" required>
    <label for="afmeting">Afmeting</label>
    <input type="text" name="afmeting" value='' maxlength="55" required>
    <label for="aantal">Aantal</label>
    <input type="number" name="aantal" value='' required>
    <label for="prijs_ex_btw">Prijs ex-btw</label>
    <input type="number" name="prijs_ex_btw" value='' step="0.01" min="0" max="9999999999.99" required>
    <label for="ean_number">EAN number</label>
    <input type="text" name="ean_number" value='' required>
    <input type='submit' value='Product toevoegen'>
</form>