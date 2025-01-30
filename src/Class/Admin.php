<?php declare(strict_types=1);

namespace App\Class;

use PDO;
use App\Utility\Database;
use App\Utility\Functions;



/**
 * Admin Class
 * 
 * @author Roan van Dam, Martan van Verseveld
 */
class Admin
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

    public function print_admin_overview() 
    {
        $types = ['medewerker', 'klant', 'product', 'categorie'];
        foreach ($types as $type) {
            ?>
            <section class="category_container">
                <section class="offset_from_border">
                    <h1><?=ucfirst($type)?></h1>
                    <p>Overzicht van alle <?=strtolower($type)?></p>
                    <section class="divider_25px"></section>
                    <a href="?page=<?=$type?>/overzicht" class="blue_button">Ga naar <?=ucfirst($type)?> overzicht</a>
                </section>
            </section>
            <?php
        }
    }

    public function print_category() 
    {
        $query = 
        "
        SELECT * FROM categorie
        LIMIT 100
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $cat) 
        {
            ?>
            <section class="category_container">
                <section class="offset_from_border">
                    <h1><?=$cat['categorie']?></h1>
                    <p>Beschrijving</p>
                    <section class="divider_25px"></section>
                    <a href="?page=category.view&id=<?=$cat['id']?>" class="blue_button">Ga naar <?=$cat["categorie"]?></a>
                </section>
            </section>
            <?php
        }
    }

    public function print_medewerkers() {
        $query = 
        "
        SELECT * FROM gebruiker WHERE NOT rollen = 'klant'
        LIMIT 100
        ";

        $results = $this->database->query($query);
        $results = $results->fetchAll(PDO::FETCH_ASSOC);
        $headers = [
            'id', 'gebruikersnaam', 'voornaam',
            'achternaam', 'adres', 'plaats',
            'telefoonnummer', 'email', 'wachtwoord',
            'rollen', 'is_geverifieerd', 'acties'
        ];
        $results = array_map(function($results) {
            $results['acties'] = "
                <a href='?page=medewerkers.view&id=" . $results['id'] . "'>View</a>
                <a href='?page=medewerkers.edit&id=" . $results['id'] . "'>Edit</a>
                <a href='?page=medewerkers.delete&id=" . $results['id'] . "'>Delete</a>
            ";
            return $results;
        }, $results);    
        Functions::drawTable($headers, $results);
    }
}