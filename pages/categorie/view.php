<?php declare(strict_types=1);

use PDO;
use App\class\Categorie;
use App\Utility\Functions;


$categorie = new Categorie();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <?php $categorie->print_categorie($_GET['id']);?>
    </section>
</section>