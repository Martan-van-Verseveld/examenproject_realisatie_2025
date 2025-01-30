<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;
use \Datetime;


/**
 * FormHandler
 * 
 * @author Roan van Dam
 */
class Rit
{
    
    /**
     * @var Database The database instance used for querying.
     */
    private Database $database;

    /**
     * Constructor initializes the database instance.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function print_ritten() {
        $query = 
        "
        SELECT planning.*,
        artikel.naam AS artikel_naam,
        gebruiker.*
        FROM planning
        INNER JOIN artikel ON planning.artikel_id = artikel.id
        INNER JOIN gebruiker ON planning.gebruiker_id = gebruiker.id
        WHERE planning.ophalen_of_bezorgen = 'bezorgen'
        ";
        // Check if "month" is set
        if (isset($_GET['month']) && is_numeric($_GET['month'])) {
            $query .= " AND MONTH(planning.afspraak_op) = :month";
            $params = ['month' => $_GET['month']];
            $results = $this->database->query($query, $params);
        }
        elseif (isset($_GET['week']) && is_numeric($_GET['week'])) {
            $year = (int) date("Y"); // Default to current year
            if (isset($_GET['year']) && is_numeric($_GET['year'])) {
                $year = $_GET['year']; // Allow custom year input
            }

            $week = (int) $_GET['week'];
            // Get the start and end dates of the given week
            $dto = new DateTime();
            $dto->setISODate($year, $week); // Set to the first day of the week (Monday)
            $start_of_week = $dto->format('Y-m-d 00:00:00'); // Convert to full DATETIME

            $dto->modify('+6 days');
            // convert to datetime
            $end_of_week = $dto->format('Y-m-d 23:59:59');

            $query .= " AND planning.afspraak_op BETWEEN :start_of_week AND :end_of_week";

            // Ensure params is formatted as an associative array
            $params = ['start_of_week' => $start_of_week, 'end_of_week' => $end_of_week];
            $results = $this->database->query($query, $params);
        }
        else {
            $results = $this->database->query($query);
        }

        $results = $results->fetchAll(PDO::FETCH_ASSOC);

        $headers = [
            'id', 'kenteken', 'artikel_id',
            'artikel_naam', 'voornaam',
            'achternaam', 'adres', 'plaats',
            'afspraak_op', 'acties'
        ];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=rit.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=rit.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results);
    }
}
