<?php declare(strict_types=1);

use PDO;
use App\class\Product;
use App\Utility\Functions;


$product = new Product();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=product.add">Nieuw product toevoegen...</a>
        <?php $product->print_products();?>
    </section>
</section>