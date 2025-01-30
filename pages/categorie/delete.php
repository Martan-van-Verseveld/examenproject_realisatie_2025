<?php

use App\Utility\Functions;

if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=categorie.overzicht');
}

?>


<form action="?page=formHandler" method="post" style="display: none;">
    <input type="hidden" name="action" value="deleteCategorie">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
</form>
<script> document.forms[0].submit(); </script>
