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
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            $query = "
            SELECT *
                FROM gebruiker
                WHERE gebruikersnaam = :username 
                LIMIT 1;
            ";
            $params = ['username' => $sanitizedPOST['username']];

            $result = $this->database->query($query, $params);

            if ($result->rowCount() <= 0) {
                Session::set('login.error', 'Username and password do not match!');
                header("Location: ?page=login");
                exit();
            }

            $row = $result->fetch(PDO::FETCH_ASSOC);
            if (!DataProcessor::checkPassword($sanitizedPOST['password'], $row['wachtwoord'])) {
                Session::set('login.error', 'Username and password do not match!');
                header("Location: ?page=login");
                exit();
            }

            unset($row['wachtwoord']);
            Session::set('user', $row);
            Session::set('loggedIn', true);

            header("Location: ?page=home");
            exit();
        } catch (\Exception $e) {
            Session::set('login.error', 'Username and password do not match!');
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
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['username', 'firstname', 'lastname', 'adres', 'city', 'phone', 'email', 'password'])) {
                Session::set('register.error', 'Required fields not found.');
                header("Location: ?page=home");
                exit();
            }

            if (!DataProcessor::validateType([$sanitizedPOST['email'] => FILTER_VALIDATE_EMAIL])) {
                Session::set('register.error', 'Invalid email format.');
                header("Location: ?page=home");
                exit();
            }

            $query = "
                INSERT INTO gebruiker (gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, wachtwoord, rollen, is_geverifieerd)
                VALUES (:gebruikersnaam, :voornaam, :achternaam, :adres, :plaats, :telefoon, :email, :wachtwoord, :rollen, :is_geverifieerd);
            ";

            $params = [
                'gebruikersnaam' => $sanitizedPOST['username'],
                'voornaam' => $sanitizedPOST['firstname'],
                'achternaam' => $sanitizedPOST['lastname'],
                'adres' => $sanitizedPOST['adres'],
                'plaats' => $sanitizedPOST['city'],
                'telefoon' => $sanitizedPOST['phone'],
                'email' => $sanitizedPOST['email'],
                'wachtwoord' => DataProcessor::hashPassword($sanitizedPOST['password']),
                'rollen' => 'klant',
                'is_geverifieerd' => 0
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('register.error', "Er was een probleem bij het aanmaken van dit account, probeer het later opnieuw.");
                header("Location: ?page=login");
                exit();
            }

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
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateType([$sanitizedPOST['email'] => FILTER_VALIDATE_EMAIL])) {
                Session::set('reset.error', 'Invalid email format.');
                header("Location: ?page=home");
                exit();
            }

            $query = "
                SELECT email, telefoon, wachtwoord FROM gebruiker WHERE email = :email LIMIT 1;
            ";

            $params = ['email' => $sanitizedPOST['email']];

            $result = $this->database->query($query, $params);

            if ($result->rowCount() <= 0) {
                Session::set('reset.error', value: 'Email not found.');
                header("Location: ?page=home");
                exit();
            }

            $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($row['email'] !== $sanitizedPOST['email'] && $row['telefoon'] !== $sanitizedPOST['phone']) {
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
                'wachtwoord' => DataProcessor::hashPassword($sanitizedPOST['password']),
                'email' => $sanitizedPOST['email']
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
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['categorie'])) {
                Session::set('categorie.error', 'Required fields not found.');
                header("Location: ?page=categorie.add");
                exit();
            }

            $query = "    
                INSERT INTO categorie (categorie)
                    VALUES (:categorie);
            ";
            $params = [
                'categorie' => $sanitizedPOST['categorie']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet worden toegevoegd.");
                header("Location: ?page=categorie.add");
                exit();
            }

            Session::set('categorie.success', "De categorie is toegevoegd.");
            header("Location: ?page=categorie.overzicht");
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.add");
        }
    }

    public function editCategorie() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['id', 'categorie'])) {
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
                'categorie' => $sanitizedPOST['categorie'],
                'id' => $sanitizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet geupdate worden.");
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            Session::set('categorie.success', "De categorie is gewijzigd.");
            header("Location: ?page=categorie.view&id=" . $sanitizedPOST['id']);
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.view&id=" . $sanitizedPOST['id']);
        }
    }

    public function deleteCategorie() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['id'])) {
                Session::set('categorie.error', 'Required fields not found.');
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            $query = "
                DELETE FROM categorie
                WHERE id = :id;
            ";
            $params = [
                'id' => $sanitizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('categorie.error', "De categorie kon niet worden verwijderd.");
                header("Location: ?page=categorie.overzicht");
                exit();
            }

            Session::set('categorie.success', "De categorie is verwijderd.");
            header("Location: ?page=categorie.overzicht");
        } catch (\Exception $e) {
            Session::set('categorie.error', $e->getMessage());
            header("Location: ?page=categorie.overzicht");
        }
    }

    public function addProduct() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['categorie_id', 'naam', 'omschrijving', 'merk', 'kleur', 'afmeting', 'aantal', 'prijs_ex_btw', 'ean_number'])) {
                Session::set('product.error', 'Required fields not found.');
                header("Location: ?page=product.add");
                exit();
            }

            $query = "    
                INSERT INTO artikel (categorie_id, naam, omschrijving, merk, kleur, afmeting, aantal, prijs_ex_btw, EAN_number)
                    VALUES (:categorie_id, :naam, :omschrijving, :merk, :kleur, :afmeting, :aantal, :prijs_ex_btw, :EAN_number);
            ";
            $params = [
                'categorie_id' => $sanitizedPOST['categorie_id'],
                'naam' => $sanitizedPOST['naam'],
                'omschrijving' => $sanitizedPOST['omschrijving'],
                'merk' => $sanitizedPOST['merk'],
                'kleur' => $sanitizedPOST['kleur'],
                'afmeting' => $sanitizedPOST['afmeting'],
                'aantal' => $sanitizedPOST['aantal'],
                'prijs_ex_btw' => sprintf('%.2f', (float) $sanitizedPOST['prijs_ex_btw']),
                'EAN_number' => $sanitizedPOST['ean_number']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('product.error', "Het product kon niet worden toegevoegd.");
                header("Location: ?page=product.add");
                exit();
            }

            Session::set('product.success', "Het product is toegevoegd.");
            header("Location: ?page=product.overzicht");
        } catch (\Exception $e) {
            Session::set('product.error', $e->getMessage());
            header("Location: ?page=product.add");
        }
    }

    public function editProduct() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['id', 'categorie_id', 'naam', 'omschrijving', 'merk', 'kleur', 'afmeting', 'aantal', 'prijs_ex_btw', 'ean_number'])) {
                Session::set('product.error', 'Required fields not found.');
                header("Location: ?page=product.overzicht");
                exit();
            }
            $query = "
                UPDATE artikel
                    SET categorie_id = :categorie_id, naam = :naam, omschrijving = :omschrijving, merk = :merk, kleur = :kleur, afmeting = :afmeting, aantal = :aantal, prijs_ex_btw = :prijs_ex_btw, EAN_number = :EAN_number
                    WHERE id = :id;
            ";
            $params = [
                'categorie_id' => $sanitizedPOST['categorie_id'],
                'naam' => $sanitizedPOST['naam'],
                'omschrijving' => $sanitizedPOST['omschrijving'],
                'merk' => $sanitizedPOST['merk'],
                'kleur' => $sanitizedPOST['kleur'],
                'afmeting' => $sanitizedPOST['afmeting'],
                'aantal' => $sanitizedPOST['aantal'],
                'prijs_ex_btw' => sprintf('%.2f', (float) $sanitizedPOST['prijs_ex_btw']),
                'EAN_number' => $sanitizedPOST['ean_number'],
                'id' => $sanitizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('product.error', "Het product kon niet worden geupdate.");
                header("Location: ?page=product.view&id=". $sanitizedPOST['id']);
                exit();
            }

            Session::set('product.success', "Het product is geupdate.");
            header("Location: ?page=product.view&id=". $sanitizedPOST['id']);
        } catch (\Exception $e) {
            Session::set('product.error', $e->getMessage());
            header("Location: ?page=product.view&id=". $sanitizedPOST['id']);
        }
    }

    public function deleteProduct() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['id'])) {
                Session::set('product.error', 'Required fields not found.');
                header("Location: ?page=product.overzicht");
                exit();
            }

            $query = "
                DELETE FROM artikel
                    WHERE id = :id;
            ";
            $params = [
                'id' => $sanitizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('product.error', "Het product kon niet worden verwijderd.");
                header("Location: ?page=product.overzicht");
                exit();
            }

            Session::set('product.success', "Het product is verwijderd.");
            header("Location: ?page=product.overzicht");
        } catch (\Exception $e) {
            Session::set('product.error', $e->getMessage());
            header("Location: ?page=product.overzicht");
        }
    }

    public function addMedewerker() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'wachtwoord', 'rollen', 'is_geverifieerd'])) {
                Session::set('product.error', 'Required fields not found.');
                header("Location: ?page=product.add");
                exit();
            }

            $query = "    
                INSERT INTO gebruiker (gebruikersnaam, voornaam, achternaam, adres, plaats, telefoon, email, wachtwoord, rollen, is_geverifieerd)
                    VALUES (:gebruikersnaam, :voornaam, :achternaam, :adres, :plaats, :telefoon, :email, :wachtwoord, :rollen, :is_geverifieerd);
            ";
            $params = [
                'gebruikersnaam' => $sanitizedPOST['gebruikersnaam'],
                'voornaam' => $sanitizedPOST['voornaam'],
                'achternaam' => $sanitizedPOST['achternaam'],
                'adres' => $sanitizedPOST['adres'],
                'plaats' => $sanitizedPOST['plaats'],
                'telefoon' => $sanitizedPOST['telefoon'],
                'email' => $sanitizedPOST['email'],
                'wachtwoord' => DataProcessor::hashPassword($sanitizedPOST['wachtwoord']),
                'rollen' => $sanitizedPOST['rollen'],
                'is_geverifieerd' => $sanitizedPOST['is_geverifieerd']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('medewerker.error', "De medewerker kon niet worden toegevoegd.");
                header("Location: ?page=medewerker.add");
                exit();
            }

            Session::set('medewerker.success', "De medewerker is toegevoegd.");
            header("Location: ?page=medewerker.overzicht");
        } catch (\Exception $e) {
            Session::set('medewerker.error', $e->getMessage());
            header("Location: ?page=medewerker.add");
        }
    }

    public function editMedewerker() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['id', 'gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email', 'rollen', 'is_geverifieerd'])) {
                Session::set('product.error', 'Required fields not found.');
                header("Location: ?page=product.overzicht");
                exit();
            }

            $query = "    
                UPDATE gebruiker
                    SET gebruikersnaam = :gebruikersnaam, voornaam = :voornaam, achternaam = :achternaam, adres = :adres, plaats = :plaats, telefoon = :telefoon, email = :email, rollen = :rollen, is_geverifieerd = :is_geverifieerd
                    WHERE id = :id AND NOT rollen = 'klant';
            ";
            $params = [
                'gebruikersnaam' => $sanitizedPOST['gebruikersnaam'],
                'voornaam' => $sanitizedPOST['voornaam'],
                'achternaam' => $sanitizedPOST['achternaam'],
                'adres' => $sanitizedPOST['adres'],
                'plaats' => $sanitizedPOST['plaats'],
                'telefoon' => $sanitizedPOST['telefoon'],
                'email' => $sanitizedPOST['email'],
                'rollen' => $sanitizedPOST['rollen'],
                'is_geverifieerd' => $sanitizedPOST['is_geverifieerd'],
                'id' => $sanitizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('medewerker.error', "De medewerker kon niet worden geupdate.");
                header("Location: ?page=medewerker.view&id=" . $sanitizedPOST['id']);
                exit();
            }

            Session::set('medewerker.success', "De medewerker is geupdate.");
            header("Location: ?page=medewerker.view&id=" . $sanitizedPOST['id']);
        } catch (\Exception $e) {
            Session::set('medewerker.error', $e->getMessage());
            header("Location: ?page=medewerker.view&id=" . $sanitizedPOST['id']);
        }
    }

    public function deleteMedewerker() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['id'])) {
                Session::set('medewerker.error', 'Required fields not found.');
                header("Location: ?page=medewerker.overzicht");
                exit();
            }

            $query = "
                DELETE FROM gebruiker
                    WHERE id = :id AND NOT rollen = 'klant';
            ";
            $params = [
                'id' => $sanitizedPOST['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('medewerker.error', "De medewerker kon niet worden verwijderd.");
                header("Location: ?page=medewerker.overzicht");
                exit();
            }

            Session::set('medewerker.success', "De medewerker is verwijderd.");
            header("Location: ?page=medewerker.overzicht");
        } catch (\Exception $e) {
            Session::set('medewerker.error', $e->getMessage());
            header("Location: ?page=medewerker.overzicht");
        }
    }

    public function editAccount() 
    {
        try {
            $sanitizedPOST = DataProcessor::sanitizeData($_POST);

            if (!DataProcessor::validateFields($sanitizedPOST, ['gebruikersnaam', 'voornaam', 'achternaam', 'adres', 'plaats', 'telefoon', 'email'])) {
                Session::set('account.error', 'Required fields not found.');
                header("Location: ?page=account.overzicht");
                exit();
            }

            $query = "    
                UPDATE gebruiker
                    SET gebruikersnaam = :gebruikersnaam, voornaam = :voornaam, achternaam = :achternaam, adres = :adres, plaats = :plaats, telefoon = :telefoon, email = :email
                    WHERE id = :id;
            ";
            $params = [
                'gebruikersnaam' => $sanitizedPOST['gebruikersnaam'],
                'voornaam' => $sanitizedPOST['voornaam'],
                'achternaam' => $sanitizedPOST['achternaam'],
                'adres' => $sanitizedPOST['adres'],
                'plaats' => $sanitizedPOST['plaats'],
                'telefoon' => $sanitizedPOST['telefoon'],
                'email' => $sanitizedPOST['email'],
                'id' => Session::get('user')['id']
            ];

            $result = $this->database->query($query, $params);
            if ($result->rowCount() <= 0) {
                Session::set('medewerker.error', "Uw account kon niet worden geupdate.");
                header("Location: ?page=account.home");
                exit();
            }

            Session::set('medewerker.success', "Uw account is geupdate.");
            header("Location: ?page=account.home");
        } catch (\Exception $e) {
            Session::set('medewerker.error', $e->getMessage());
            header("Location: ?page=account.home");
        }
    }
}
