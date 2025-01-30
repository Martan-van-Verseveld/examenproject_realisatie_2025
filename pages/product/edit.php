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


<form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <input type='hidden' name='action' value='editProduct'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
    <label for="categorie_id">Categorie</label>
    <select name='categorie_id' required>
        <?php foreach ($categories as $categorie): ?>
            <option value="<?= $categorie['id'] ?>" <?= $categorie['id'] == $currentData['categorie_id'] ? 'selected' : '' ?>><?= $categorie['categorie'] ?></option>
        <?php endforeach; ?>
    </select>
    <label for="naam">Naam</label>
    <input type="text" name="naam" value='<?= $currentData['naam'] ?>' maxlength="255" required>
    <label for="omschrijving">Omschrijving</label>
    <textarea name="omschrijving" required><?= $currentData['omschrijving'] ?></textarea>
    <label for="merk">Merk</label>
    <input type='text' name='merk' value='<?= $currentData['merk'] ?>' maxlength="255" required>
    <label for="kleur">Kleur</label>
    <input type="text" name="kleur" value='<?= $currentData['kleur'] ?>' maxlength="55" required>
    <label for="afmeting">Afmeting</label>
    <input type="text" name="afmeting" value='<?= $currentData['afmeting'] ?>' maxlength="55" required>
    <label for="aantal">Aantal</label>
    <input type="number" name="aantal" value='<?= $currentData['aantal'] ?>' required>
    <label for="prijs_ex_btw">Prijs ex-btw</label>
    <input type="number" name="prijs_ex_btw" value='<?= $currentData['prijs_ex_btw'] ?>' step="0.01" min="0" max="9999999999.99" required>
    <label for="ean_number">EAN number</label>
    <input type="text" name="ean_number" value='<?= $currentData['EAN_number'] ?>' required>
    <input type='submit' value='Update product'>
</form>