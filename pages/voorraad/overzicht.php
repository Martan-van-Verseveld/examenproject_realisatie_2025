<?php declare(strict_types=1);

use PDO;
use App\class\Voorraad;
use App\Utility\Functions;


$voorraad = new Voorraad();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=voorraad.add">Nieuwe voorraad toevoegen...</a>
        <?php $voorraad->print_voorraad();?>
    </section>
</section>