<?php declare(strict_types=1);

namespace App\Utility;

use PDO;
use PDOException;
use PDOStatement;
use App\Core\Configuration;
use App\Utility\Session;



/**
 * Class Functions
 *
 * This class contains utility functions used throughout the application.
 * 
 * @author Martan van Verseveld
 */
class Functions
{
    /**
     * Redirects the user to the given URL using JavaScript
     *
     * @param string $url
     * @return void
     */
    public static function jsRedirect(string $url): void
    {
        echo "<script>window.location.href = '" . $url . "'</script>";
        echo "Als je dit ziet, ga je naar: <a href='" . $url . "'>" . $url . "</a>";
        die();
    }

    /**
     * Checks if the user has the given permissions
     *
     * @param array $permissions
     * @return bool
     */
    public static function checkPermissions(array $permissions): bool
    {
        try {
            return in_array(Session::get('user')['rollen'], $permissions);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Converts a string to a title (first letter of each word capitalized)
     *
     * @param string $string
     * @return string
     */
    public static function convertToTitle(string $string): string
    {
        return ucwords(str_replace('.', ' ', implode(' ', preg_split('/(?=[A-Z])/', $string))));
    }

    /**
     * Displays an error message to the user
     *
     * @param string|null $message
     * @return void
     */
    public static function displayError(?string $message): void
    {
        if (empty($message) || $message === null || $message === '') {
            return;
        }

        echo '<span class="error">' . $message . '<p class="close" onclick="this.parentElement.remove();">x</p></span>';
    }

    /**
     * Displays a success message to the user
     *
     * @param string|null $message
     * @return void
     */
    public static function displaySuccess(?string $message): void
    {
        if (empty($message) || $message === null || $message === '') {
            return;
        }

        echo '<span class="success">' . $message . '<p class="close" onclick="this.parentElement.remove();">x</p></span>';
    }

    /**
     * Prints a variable in a readable format for debugging purposes
     *
     * @param mixed $data
     * @return void
     */
    public static function print_p($data): void
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}