<?php

use App\Utility\Functions;


if ($_GET['page'] === 'categorie.index') {
    header("Location: ?page=categorie.home");
}

if (!Functions::checkPermissions(['admin'])) {
    Functions::jsRedirect(url: '?page=home');
}

?>