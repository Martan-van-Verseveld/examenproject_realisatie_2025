<?php

use App\Utility\Functions;


if ($_GET['page'] === 'product.index') {
    header("Location: ?page=product.overzicht");
}

if (!Functions::checkPermissions(['admin'])) {
    Functions::jsRedirect(url: '?page=home');
}

?>