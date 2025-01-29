<?php declare(strict_types=1);

namespace App\Utility;

use PDO;
use App\Utility\Database;
use App\Utility\DataProcessor;
use App\Utility\Session;



/**
 * FormHandler
 * 
 * @author Martan van Verseveld
 */
class FormHandler
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

    public function login()
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            $query = "
            SELECT *
                FROM gebruiker
                WHERE gebruikersnaam = :username 
                LIMIT 1;
            ";
            $params = ['username' => $sanatizedPOST['username']];
            
            $result = $this->database->query($query, $params);

            if ($result->rowCount() <= 0) {
                // Session::set('error', 'Username and password do not match!');
                header("Location: ?page=login");
                exit();
            }

            $row = $result->fetch(PDO::FETCH_ASSOC);
            // if (!DataProcessor::checkPassword($sanatizedPOST['password'], $row['wachtwoord'])) {
            //     // Session::set('error', 'Username and password do not match!');
            //     header("Location: ?page=login");
            //     exit();
            // }

            unset($row['wachtwoord']);
            Session::set('user', $row);
            Session::set('loggedIn', true);
            
            header("Location: ?page=home");
            exit();
        } catch (\Exception $e) {
            // Session::set('error', 'Username and password do not match!');
            header("Location: ?page=login");
        }
    }

    public function logout()
    {
        Session::delete('user');
        Session::set('loggedIn', false);
        header("Location: ?page=login");
    }
}
