<?php

use App\Utility\Functions;


if ($_GET['page'] === 'klant.index') {
    header("Location: ?page=klant.overzicht");
}

if (!Functions::checkPermissions(['admin'])) {
    Functions::jsRedirect(url: '?page=home');
}

?>