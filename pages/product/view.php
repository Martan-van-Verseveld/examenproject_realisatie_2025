<?php declare(strict_types=1);

use PDO;
use App\class\Product;
use App\Utility\Functions;


$product = new Product();

if (!isset($_GET['id']) && !isset($_GET['ean'])) {
    Functions::jsRedirect(url: '?page=product.overzicht');
} elseif (isset($_GET['id']) && isset($_GET['ean'])) {
    Functions::jsRedirect(url: '?page=product.overzicht');
}

?>


<section class="divider_50px"></section>
<section class="main_content">
    <section>
        <a href="?page=medewerker.overzicht">Terug naar overzicht...</a>
        <?php 
        if (isset($_GET['ean']) && $_GET['ean'] != '') {
            $product->print_products_by_ean($_GET['ean']);
        } else {
            $product->print_product($_GET['id']);
        } ?>
    </section>
</section>