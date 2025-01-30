<?php declare(strict_types=1);

use PDO;
use App\class\Medewerker;
use App\Utility\Functions;


$medewerker = new Medewerker();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=medewerker.add">Nieuw medewerker toevoegen...</a>
        <?php $medewerker->print_medewerkers();?>
    </section>
</section>