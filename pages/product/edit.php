<?php

use App\Utility\Functions;
use App\Utility\Database;

// Redirect if 'id' is not set in GET parameters
if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=categorie.home');
}

$database = Database::getInstance();
$currentData = $database->query("
    SELECT * FROM artikel
        WHERE id = :id
", [
    'id' => $_GET['id']
])->fetch();

$query_categories = $database->query(query: "
SELECT * 
    FROM categorie;
");
$categories = $query_categories->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <h1 class="form-title">Product bewerken</h1>
    <form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <div class="form-back">
            <h1>
                <a href="?page=product.overzicht">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </h1>
        </div>
        <input type='hidden' name='action' value='editProduct'>
        <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
        <label class="form-label" for="categorie_id">Categorie</label>
        <select class="form-input" name='categorie_id' required>
            <?php foreach ($categories as $categorie): ?>
                <option value="<?= $categorie['id'] ?>" <?= $categorie['id'] == $currentData['categorie_id'] ? 'selected' : '' ?>><?= $categorie['categorie'] ?></option>
            <?php endforeach; ?>
        </select>
        <label class="form-label" for="naam">Naam</label>
        <input class="form-input" type="text" name="naam" value='<?= $currentData['naam'] ?>' maxlength="255" required>
        <label class="form-label" for="omschrijving">Omschrijving</label>
        <textarea class="form-input-textarea" name="omschrijving" required><?= $currentData['omschrijving'] ?></textarea>
        <label class="form-label" for="merk">Merk</label>
        <input class="form-input" type='text' name='merk' value='<?= $currentData['merk'] ?>' maxlength="255" required>
        <label class="form-label" for="kleur">Kleur</label>
        <input class="form-input" type="text" name="kleur" value='<?= $currentData['kleur'] ?>' maxlength="55" required>
        <label class="form-label" for="afmeting">Afmeting</label>
        <input class="form-input" type="text" name="afmeting" value='<?= $currentData['afmeting'] ?>' maxlength="55" required>
        <label class="form-label" for="aantal">Aantal</label>
        <input class="form-input" type="number" name="aantal" value='<?= $currentData['aantal'] ?>' required>
        <label class="form-label" for="prijs_ex_btw">Prijs ex-btw</label>
        <input class="form-input" type="number" name="prijs_ex_btw" value='<?= $currentData['prijs_ex_btw'] ?>' step="0.01" min="0" max="9999999999.99" required>
        <label class="form-label" for="ean_number">EAN number</label>
        <input class="form-input" type="text" name="ean_number" value='<?= $currentData['EAN_number'] ?>' required>
        <input class="form-button" type='submit' value='Update product'>
    </form>