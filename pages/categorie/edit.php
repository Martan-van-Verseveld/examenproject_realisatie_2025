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


<form action='?page=formHandler' method='post' enctype="multipart/form-data">
    <input type='hidden' name='action' value='editCategorie'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
    <label for="categorie">Categorie</label>
    <input type="text" name="categorie" id="categorie" maxlength="255" value="<?=  $currentData['categorie'] ?>">
    <input type='submit' value='Update categorie'>
</form>