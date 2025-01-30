<?php

use App\Utility\Functions;


if ($_GET['page'] === 'medewerker.index') {
    header("Location: ?page=medewerker.overzicht");
}

if (!Functions::checkPermissions(['admin'])) {
    Functions::jsRedirect(url: '?page=home');
}

?>