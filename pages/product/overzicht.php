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
        <form action="?page=product.overzicht" method="get">
            <label for="ean">Zoek op EAN:</label>
            <input type="hidden" name="page" value="product.view">
            <input type="text" id="ean" name="ean">
            <input type="submit" value="Zoeken">
        </form>
        <?php
            $product->print_products();
        ?>
    </section>
</section>
