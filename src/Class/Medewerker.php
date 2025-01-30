<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;



/**
 * Medewerker Class
 * 
 * @author Roan van Dam, Martan van Verseveld
 */
class Medewerker
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
    

    public function print_medewerkers() {
        $query = "
            SELECT id, gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, rollen, is_geverifieerd
                FROM gebruiker
                WHERE NOT rollen = 'klant';
                ORDER BY id ASC;
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'rollen', 'is_geverifieerd', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=medewerker.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=medewerker.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=medewerker.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results);
    }

    public function print_medewerker($id) {
        $query = "
            SELECT id, gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, rollen, is_geverifieerd
                FROM gebruiker 
                WHERE id = :id AND NOT rollen = 'klant';
        ";

        $params = ['id' => $id];
        $results = $this->database->query($query, $params);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'rollen', 'is_geverifieerd', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=medewerker.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=medewerker.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=medewerker.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results, 'vertical');
    }
}