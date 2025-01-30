<?php declare(strict_types=1);

use PDO;
use App\class\Medewerker;
use App\Utility\Functions;


$medewerker = new Medewerker();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <?php $medewerker->print_medewerker($_GET['id']);?>
    </section>
</section>