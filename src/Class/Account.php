<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;
use App\Utility\Session;



/**
 * Account Class
 * 
 * @author Martan van Verseveld
 */
class Account
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
    

    public function print_account_info() {
        $query = "
            SELECT id, gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, rollen, is_geverifieerd
                FROM gebruiker
                WHERE id = :id;
        ";

        $params = ['id' => Session::get('user')['id']];
        $results = $this->database->query($query, $params);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = ['id', 'gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'rollen', 'is_geverifieerd', 'acties'];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=account.edit'>Edit</a>
            ";
            return $results;
        }, $results);
        Functions::drawTable($headers, $results, 'vertical');
    }
}