<?php

use App\Utility\Functions;
use App\Utility\Session;

use App\Class\Account;

$account = new Account();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <h1>Account</h1>
        <p>Account pagina voor gebruiker: <b><?= Session::get('user')['voornaam'] . ' ' . Session::get('user')['achternaam'] ?></b></p>
        <?php $account->print_account_info();?>
    </section>
</section>