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
        SELECT * FROM planning
        LIMIT 100
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$result) {
            $query =
            "
            SELECT naam FROM artikel 
            WHERE id = :id
            ";
            $params = ['id' => $result['artikel_id']];
            $result_name = $this->database->query($query, $params);
            $result_name = $result_name->fetch(PDO::FETCH_ASSOC);
            $result['artikel_id'] = implode(", ", $result_name);
        }

        foreach ($results as &$result) {
            $query =
            "
            SELECT gebruikersnaam FROM gebruiker 
            WHERE id = :id
            ";
            $params = ['id' => $result['gebruiker_id']];
            $result_name = $this->database->query($query, $params);
            $result_name = $result_name->fetch(PDO::FETCH_ASSOC);
            $result['gebruiker_id'] = implode(", ", $result_name);
        }


        Functions::print_p($results);
        // $headers = [
        //     'id', 'naam', 'omschrijving',
        //     'merk', 'kleur', 'afmeting',
        //     'aantal', 'EAN_number', 'acties'
        // ];
        // $results = array_map(function($results) {
        //     $results['acties'] = "
        //         <a href='?page=product.view&id=" . $results['id'] . "'>View</a>
        //         <a href='?page=product.edit&id=" . $results['id'] . "'>Edit</a>
        //         <a href='?page=product.delete&id=" . $results['id'] . "'>Delete</a>
        //     ";
        //     return $results;
        // }, $results);
        // Functions::drawTable($headers, $results);
    }
}