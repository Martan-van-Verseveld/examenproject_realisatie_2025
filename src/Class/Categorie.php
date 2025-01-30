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
class Categorie
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
    

    public function print_categories() {
        $query = "
            SELECT * 
                FROM categorie
                ORDER BY id ASC;
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'categorie', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=categorie.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=categorie.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=categorie.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results);
    }

    public function print_categorie($id) {
        $query = "
            SELECT * 
                FROM categorie 
                WHERE id = :id;
        ";

        $params = ['id' => $id];
        $results = $this->database->query($query, $params);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'categorie', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=categorie.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=categorie.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=categorie.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results, 'vertical');
    }
}