<?php declare(strict_types=1);

use PDO;
use App\class\Categorie;
use App\Utility\Functions;


$categorie = new Categorie();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=categorie.add">Nieuwe categorie toevoegen...</a>
        <?php $categorie->print_categories();?>
    </section>
</section>