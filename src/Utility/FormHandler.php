<?php

declare(strict_types=1);

namespace App\Utility;

use PDO;
use App\Utility\Database;
use App\Utility\DataProcessor;
use App\Utility\Session;



/**
 * FormHandler
 * 
 * @author Martan van Verseveld, Yorrick de Vries
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

    public function register()
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanatizedPOST, ['username', 'firstname', 'lastname', 'adres', 'city', 'phone', 'email', 'password'])) {
                Session::set('register.error', 'Required fields not found.');
                header("Location: ?page=register.view&id=" . $sanatizedPOST['id']);
                exit();
            }

            $query = "
                INSERT INTO gebruiker (gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, wachtwoord, rollen, is_geverifieerd)
                VALUES (:gebruikersnaam, :voornaam, :achternaam, :adres, :plaats, :telefoon, :email, :wachtwoord, :rollen, :is_geverifieerd);
            ";

            $params = [
                'gebruikersnaam' => $sanatizedPOST['username'],
                'voornaam' => $sanatizedPOST['firstname'],
                'achternaam' => $sanatizedPOST['lastname'],
                'adres' => $sanatizedPOST['adres'],
                'plaats' => $sanatizedPOST['city'],
                'telefoon' => $sanatizedPOST['phone'],
                'email' => $sanatizedPOST['email'],
                'wachtwoord' => DataProcessor::hashPassword($sanatizedPOST['password']),
                'rollen' => 'klant',
                'is_geverifieerd' => 0
            ];

            $this->database->query($query, $params);

            header("Location: ?page=login");
            exit();
        } catch (\Exception $e) {
            Session::set('register.error', $e->getMessage());
            header("Location: ?page=home");
        }
    }
}
