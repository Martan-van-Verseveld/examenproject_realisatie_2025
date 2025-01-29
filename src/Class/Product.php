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
class Product
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

    public function print_product() {
        $query = 
        "
        SELECT * FROM artikel WHERE id = :id
        LIMIT 100
        ";

        $params = ['id' => $_GET['id']];
        $results = $this->database->query($query, $params);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = [
            'id', 'naam', 'omschrijving',
            'merk', 'kleur', 'afmeting',
            'aantal', 'EAN_number', 'acties'
        ];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=product.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=product.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=product.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results);
    }
}