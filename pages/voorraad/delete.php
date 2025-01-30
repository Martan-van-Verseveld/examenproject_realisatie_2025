<?php

use App\Utility\Functions;

if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=voorraad.overzicht');
}

?>


<form action="?page=formHandler" method="post" style="display: none;">
    <input type="hidden" name="action" value="deleteVoorraad">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
</form>
<script> document.forms[0].submit(); </script>
