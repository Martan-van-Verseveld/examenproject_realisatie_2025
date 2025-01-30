<?php

use App\Utility\Functions;

if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=medewerker.overzicht');
}
?>

<form action='?page=formHandler' method='post' enctype="multipart/form-data" style="display: none;">
    <input type='hidden' name='action' value='deleteMedewerker'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
</form>
<script> document.forms[0].submit(); </script>