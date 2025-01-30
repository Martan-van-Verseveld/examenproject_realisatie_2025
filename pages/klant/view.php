<?php declare(strict_types=1);

use PDO;
use App\class\Klant;
use App\Utility\Functions;


$klant = new Klant();

if (!isset($_GET['id']) || $_GET['id'] != '') {
    Functions::jsRedirect(url: '?page=klant.overzicht');
}

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=medewerker.overzicht">Terug naar overzicht...</a>
        <?php $klant->print_klant($_GET['id']);?>
    </section>
</section>