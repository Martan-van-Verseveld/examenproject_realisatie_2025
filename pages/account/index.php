<?php

use App\Utility\Session;


if ($_GET['page'] === 'account.index') {
    header("Location: ?page=account.home");
}

if (!Session::get('loggedIn')) {
    header("Location: ?page=login");
}