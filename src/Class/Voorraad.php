<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;



/**
 * Categorie Class
 * 
 * @author Roan van Dam, Martan van Verseveld
 */
class Voorraad
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
    

    public function print_voorraad() {
        $query = "
            SELECT v.id, a.naam AS artikel_naam, s.status AS status_naam, v.locatie, v.ingeboekt_op
                FROM voorraad v
                JOIN artikel a ON v.artikel_id = a.id
                JOIN status s ON v.status_id = s.id
                ORDER BY v.id ASC;
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'artikel_naam', 'locatie', 'ingeboekt_op', 'status_naam', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=voorraad.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=voorraad.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results);
    }
}