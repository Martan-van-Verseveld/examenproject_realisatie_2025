<?php declare(strict_types=1);

use PDO;
use App\class\Rit;
use App\Utility\Functions;
$rit = new Rit();

// get the week number with their start date and end date
function get_weeks_from_year($year) {
    $year = (int) $year;
    $weeks = [];
    
    // check if the year has 52 or 53 weeks
    $totalWeeks = (new DateTime())->setISODate($year, 53)->format("W") === "53" ? 53 : 52;

    for ($week = 1; $week <= $totalWeeks; $week++) {
        $dto = new DateTime();
        // set to monday of the given week
        $dto->setISODate($year, $week);
        $startOfWeek = $dto->format('Y-m-d');

        // get all the days within the given week
        $dto->modify('+6 days');
        $endOfWeek = $dto->format('Y-m-d');

        $weeks[$week] = ["start" => $startOfWeek, "end" => $endOfWeek];
    }

    return $weeks;
}

// Example: Get all weeks for the current year
$year = (int) date("Y");
$weeks = get_weeks_from_year($year);
$months = [
    "januari" => 1,
    "februari" => 2,
    "maart" => 3,
    "april" => 4,
    "mei" => 5,
    "juni" => 6,
    "juli" => 7,
    "augustus" => 8,
    "september" => 9,
    "oktober" => 10,
    "november" => 11,
    "december" => 12
];



?>

<html>
    <section class="divider_50px"></section>
    <!-- Filter system -->
    <h2>Filter:</h2>
    <section>
        Week
        <div class="dropdown">
            <?php
            if (isset($_GET['week'])) {
                ?>
                <button class="dropdown_click">Week <?=$_GET['week']?></button>
                <?php
            }
            else {
                ?>
                <button class="dropdown_click">Selecteer week</button>
                <?php
            }
            ?>
            <div class="dropdown-content">
                <?php
                foreach ($weeks as $week_num => $week) {
                    ?>
                    <a href="?page=rit.view&week=<?=$week_num?>">Week <?=$week_num?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <section>
        Maand
        <div class="dropdown">
        <?php
            if (isset($_GET['month'])) {
                foreach ($months as $month => $month_num) {
                    if ($month_num == intval($_GET['month'])) {
                        ?>
                        <button class="dropdown_click"><?=$month?></button>
                        <?php
                    }
                }
                ?>
                <?php
            }
            else {
                ?>
                <button class="dropdown_click">Selecteer maand</button>
                <?php
            }
            ?>
            <div class="dropdown-content">
                <?php
                foreach ($months as $month => $month_num) {
                    ?>
                    <a href="?page=rit.view&month=<?=$month_num?>"><?=$month?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <section class="main_content">
        <section>
            <?php $rit->print_ritten();?>
        </section>
    </section>
</html>