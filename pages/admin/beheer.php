<?php declare(strict_types=1);

use PDO;
use App\class\Admin;
$admin = new Admin();
?>

<html>
    <section class="divider_50px"></section>
    <section class="main_content">
        <section class="category_grid">
            <?php $admin->print_medewerkers(); ?>
        </section>
    </section>
</html>