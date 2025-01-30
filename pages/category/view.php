<?php declare(strict_types=1);

use PDO;
use App\class\Category;
use App\Utility\Functions;
$category = new Category();
?>

<html>
    <section class="divider_50px"></section>
    <section class="main_content">
        <section>
            <?php $category->print_products();?>
        </section>
    </section>
</html>