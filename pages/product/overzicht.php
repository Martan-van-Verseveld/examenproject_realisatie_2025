<?php

declare(strict_types=1);

use PDO;
use App\class\Product;
use App\Utility\Functions;

$product = new Product();

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=product.add">Nieuw product toevoegen...</a>
        <div class="container">
            <h2 class="form-title">Producten zoeken</h2>
            <form action="?page=product.overzicht" method="get">
                <label class="form-label" for="ean">Zoek op EAN:</label>
                <input  type="hidden" name="page" value="product.view">
                <input class="form-input" type="text" id="ean" name="ean">
                <input class="form-button" type="submit" value="Zoeken">
            </form>
        </div>
        <?php
        $product->print_products();
        ?>
    </section>
</section>