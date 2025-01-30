<?php declare(strict_types=1);

use PDO;
use App\Class\Admin;
use App\Utility\Functions;
$admin = new Admin();
?>

<html>
    <section class="divider_50px"></section>
    <section class="main_content">
        <section>
            <?php $admin->print_medewerkers();?>
</section>
    </section>
</html>