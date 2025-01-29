<?php declare(strict_types=1);

use PDO;
use App\class\Rit;
use App\Utility\Functions;
$rit = new Rit();
?>

<html>
    <section class="divider_50px"></section>
    <section class="main_content">
        <section>
            <?php $rit->print_ritten();?>
        </section>
    </section>
</html>