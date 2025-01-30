<?php declare(strict_types=1);

use PDO;
use App\class\Categorie;
use App\Utility\Functions;


$categorie = new Categorie();

if (!isset($_GET['id']) || $_GET['id'] == '') {
    Functions::jsRedirect(url: '?page=categorie.overzicht');
}

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=medewerker.overzicht">Terug naar overzicht...</a>
        <?php $categorie->print_categorie($_GET['id']);?>
    </section>
</section>