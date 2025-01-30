<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;



/**
 * Klant Class
 * 
 * @author Roan van Dam, Martan van Verseveld
 */
class Klant
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
    

    public function print_klanten() {
        $query = "
            SELECT id, gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, rollen, is_geverifieerd
                FROM gebruiker
                WHERE rollen = 'klant';
                ORDER BY id ASC;
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'rollen', 'is_geverifieerd', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=klant.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=klant.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=klant.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results);
    }

    public function print_klant($id) {
        $query = "
            SELECT id, gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, rollen, is_geverifieerd
                FROM gebruiker 
                WHERE id = :id AND rollen = 'klant';
        ";

        $params = ['id' => $id];
        $results = $this->database->query($query, $params);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'rollen', 'is_geverifieerd', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=klant.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=klant.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=klant.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results, 'vertical');
    }
}