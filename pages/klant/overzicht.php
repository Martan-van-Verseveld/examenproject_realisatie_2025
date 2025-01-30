<?php declare(strict_types=1);

use PDO;
use App\class\Klant;
use App\Utility\Functions;


$klant = new Klant();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <?php $klant->print_klanten();?>
    </section>
</section>