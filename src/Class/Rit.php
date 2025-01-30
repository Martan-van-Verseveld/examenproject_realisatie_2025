<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;


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
        LIMIT 100
        ";
        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);

        $headers = [
            'id', 'kenteken', 'artikel_id',
            'artikel_naam', 'voornaam',
            'achternaam', 'adres', 'plaats', 'acties'
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

