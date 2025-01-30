<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;



/**
 * Product Class
 * 
 * @author Roan van Dam, Martan van Verseveld
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

    public function print_products() {
        $query = "
            SELECT * 
                FROM artikel
                ORDER BY id ASC;
        ";

        $results = $this->database->query($query);
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

    public function print_product($id) {
        $query = "
            SELECT * 
                FROM artikel 
                WHERE id = :id
        ";

        $params = ['id' => $id];
        $results = $this->database->query($query, $params);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = [
            'id', 'naam', 'omschrijving',
            'merk', 'kleur', 'afmeting',
            'aantal', 'EAN_number', 'acties'
        ];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=product.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=product.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results, 'vertical');
    }
}