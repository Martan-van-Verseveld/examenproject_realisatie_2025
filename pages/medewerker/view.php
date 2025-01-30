<?php declare(strict_types=1);

use PDO;
use App\class\Medewerker;
use App\Utility\Functions;


$medewerker = new Medewerker();

if (!isset($_GET['id']) || $_GET['id'] != '') {
    Functions::jsRedirect(url: '?page=medewerker.overzicht');
}

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=medewerker.overzicht">Terug naar overzicht...</a>
        <?php $medewerker->print_medewerker($_GET['id']);?>
    </section>
</section>