<?php

use App\Utility\Functions;

if (!isset($_GET['id'])) {
    Functions::jsRedirect(url: '?page=product.overzicht');
}
?>

<form action='?page=formHandler' method='post' enctype="multipart/form-data" style="display: none;">
    <input type='hidden' name='action' value='deleteProduct'>
    <input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
</form>
<script> document.forms[0].submit(); </script>