<?php

use App\Utility\Functions;
use App\Utility\Session;
use App\Utility\Database;


Functions::displayError(Session::get('categorie.error'));
Session::delete('categorie.error');


if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=voorraad.overzicht');
}

$database = Database::getInstance();

$query_artikels = $database->query(query: "
    SELECT id, naam
        FROM artikel;
");
$artikels = $query_artikels->fetchAll(PDO::FETCH_ASSOC);

$query_statuss = $database->query(query: "
    SELECT id, status AS naam
        FROM status;
");
$statuss = $query_statuss->fetchAll(PDO::FETCH_ASSOC);

$query_voorraad = $database->query(query: "
    SELECT * 
        FROM voorraad
        WHERE id = :id;
", params: [
    'id' => $_GET['id']
]);
$voorraad = $query_voorraad->fetch(PDO::FETCH_ASSOC);

?>


<div class="container">
<h1 class="form-title">Voorraad entry bewerken</h1>
<form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <div class="form-back">
        <h1>
            <a href="?page=voorraad.overzicht">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </h1>
    </div>
    <input type='hidden' name='action' value='editVoorraad'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
    <label class="form-label" for="artikel_id">Artikel / Product</label>
    <select class="form-input" name='artikel_id' required>
        <?php foreach ($artikels as $artikel): ?>
            <option value="<?= $artikel['id'] ?>" <?= $artikel['id'] == $voorraad['artikel_id'] ? 'selected' : '' ?>><?= $artikel['naam'] ?></option>
        <?php endforeach; ?>
    </select>
    <label class="form-label" for="locatie">Locatie</label>
    <input class="form-input" type="text" name="locatie" id="locatie" value="<?= $voorraad['locatie'] ?>" maxlength="255">
    <label class="form-label" for="status_id">Artikel / Product</label>
    <select class="form-input" name='status_id' required>
        <?php foreach ($statuss as $status): ?>
            <option value="<?= $status['id'] ?>" <?= $status['id'] == $voorraad['status_id'] ? 'selected' : '' ?>><?= $status['naam'] ?></option>
        <?php endforeach; ?>
    </select>
    <label class="form-label" for="ingeboekt_op">Ingeboekt op</label>
    <input class="form-input" type="datetime-local" name="ingeboekt_op" id="ingeboekt_op" value="<?= $voorraad['ingeboekt_op'] ?>" required>
    <input class="form-button" type='submit' value='Bewerk categorie'>
</form>
