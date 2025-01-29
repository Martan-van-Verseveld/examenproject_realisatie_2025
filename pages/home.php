<h1>Welkom!</h1>
<?php

use App\Utility\Functions;
use App\Utility\Session;
?>
<?php Functions::print_p(data: $_SESSION);
Session::delete('register.error'); ?>