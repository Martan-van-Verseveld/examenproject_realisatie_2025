<?php declare(strict_types=1);

use PDO;
use App\class\Product;
use App\Utility\Functions;
$product = new Product();
?>

<html>
    <section class="divider_50px"></section>
    <section class="main_content">
        <section>
            <?php $product->print_product();?>
        </section>
    </section>
</html>