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
            if (!DataProcessor::checkPassword($sanatizedPOST['password'], $row['wachtwoord'])) {
                // Session::set('error', 'Username and password do not match!');
                header("Location: ?page=login");
                exit();
            }

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
                header("Location: ?page=home");
                exit();
            }

            if (!DataProcessor::validateType([$sanatizedPOST['email'] => FILTER_VALIDATE_EMAIL])) {
                Session::set('register.error', 'Invalid email format.');
                header("Location: ?page=home");
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

    public function reset()
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateType([$sanatizedPOST['email'] => FILTER_VALIDATE_EMAIL])) {
                Session::set('reset.error', 'Invalid email format.');
                header("Location: ?page=home");
                exit();
            }

            $query = "
                SELECT email, telefoon, wachtwoord FROM gebruiker WHERE email = :email LIMIT 1;
            ";

            $params = ['email' => $sanatizedPOST['email']];

            $result = $this->database->query($query, $params);

            if ($result->rowCount() <= 0) {
                Session::set('reset.error', value: 'Email not found.');
                header("Location: ?page=home");
                exit();
            }

            $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($row['email'] !== $sanatizedPOST['email'] && $row['telefoon'] !== $sanatizedPOST['phone']) {
                Session::set('reset.error', 'Your address and/or phone number do not match our records.');
                header("Location: ?page=home");
                exit();
            }

            $query = "
                UPDATE gebruiker
                SET wachtwoord = :wachtwoord
                WHERE email = :email;
            ";

            $params = [
                'wachtwoord' => DataProcessor::hashPassword($sanatizedPOST['password']),
                'email' => $sanatizedPOST['email']
            ];

            $this->database->query($query, $params);

            header("Location: ?page=login");
            exit();
        } catch (\Exception $e) {
            Session::set('reset.error', $e->getMessage());
            header("Location: ?page=reset");
        }
    }
    
    public function addCategorie() 
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanatizedPOST, ['categorie'])) {
                Session::set('categorie.error', 'Required fields not found.');
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            $query = "    
                INSERT INTO categorie (categorie)
                    VALUES (:categorie);
            ";
            $params = [
                'categorie' => $sanatizedPOST['categorie']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet worden toegevoegd.");
                header("Location: ?page=categorie.home");
                exit();
            }

            Session::set('categorie.success', "De categorie is toegevoegd.");
            header("Location: ?page=categorie.home");
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.home");
        }
    }

    public function editCategorie() 
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanatizedPOST, ['id', 'categorie'])) {
                Session::set('categorie.error', 'Required fields not found.');
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            $query = "
                UPDATE categorie
                    SET categorie = :categorie
                    WHERE id = :id;
            ";
            $params = [
                'categorie' => $sanatizedPOST['categorie'],
                'id' => $sanatizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet geupdate worden.");
                header("Location: ?page=categorie.home");
                exit();
            }

            Session::set('categorie.success', "De categorie is gewijzigd.");
            header("Location: ?page=categorie.view&id=" . $sanatizedPOST['id']);
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.view&id=" . $sanatizedPOST['id']);
        }
    public function addCategorie() 
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanatizedPOST, ['categorie'])) {
                Session::set('categorie.error', 'Required fields not found.');
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            $query = "    
                INSERT INTO categorie (categorie)
                    VALUES (:categorie);
            ";
            $params = [
                'categorie' => $sanatizedPOST['categorie']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet worden toegevoegd.");
                header("Location: ?page=categorie.home");
                exit();
            }

            Session::set('categorie.success', "De categorie is toegevoegd.");
            header("Location: ?page=categorie.home");
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.home");
        }
    }

    public function editCategorie() 
    {
        try {
            $sanatizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanatizedPOST, ['id', 'categorie'])) {
                Session::set('categorie.error', 'Required fields not found.');
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            $query = "
                UPDATE categorie
                    SET categorie = :categorie
                    WHERE id = :id;
            ";
            $params = [
                'categorie' => $sanatizedPOST['categorie'],
                'id' => $sanatizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet geupdate worden.");
                header("Location: ?page=categorie.home");
                exit();
            }

            Session::set('categorie.success', "De categorie is gewijzigd.");
            header("Location: ?page=categorie.view&id=" . $sanatizedPOST['id']);
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.view&id=" . $sanatizedPOST['id']);
        }
    }
}
