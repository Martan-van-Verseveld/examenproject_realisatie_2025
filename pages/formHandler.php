<?php

use App\Utility\FormHandler;
use App\Utility\Functions;
use App\Utility\Session;

// Instantiate the FormHandler class
$formHandler = new FormHandler();

// Redirect to home if no action is specified
if (!isset($_POST['action'])) {
    header("Location: ?page=home");
}

// Handle different form actions based on the 'action' parameter in POST
switch ($_POST['action']) {
    case 'login':
        // Handle login action
        $formHandler->login();
        break;

    case 'logout':
        // Handle logout action
        $formHandler->logout();
        break;

    case 'register':
        // Handle register action
        $formHandler->register();
        break;

    case 'reset':
        // Handle reset action
        $formHandler->reset();
        break;
        

    case 'addCategorie':
        // Handle add-categorie action
        Functions::checkPermissions(['admin']) && 
            $formHandler->addCategorie();
        break;

    case 'editCategorie':
        // Handle edit-categorie action
        Functions::checkPermissions(['admin']) && 
            $formHandler->editCategorie();
        break;

    case 'deleteCategorie':
        // Handle delete-categorie action
        Functions::checkPermissions(['admin']) && 
            $formHandler->deleteCategorie();
        break;
    

    case 'addProduct':
        // Handle add-product action
        Functions::checkPermissions(['admin']) && 
            $formHandler->addProduct();
        break;

    case 'editProduct':
        // Handle edit-product action
        Functions::checkPermissions(['admin']) && 
            $formHandler->editProduct();
        break;

    case 'deleteProduct':
        // Handle delete-product action
        Functions::checkPermissions(['admin']) && 
            $formHandler->deleteProduct();
        break;
    

    case 'addMedewerker':
        // Handle add-mroduct action
        Functions::checkPermissions(['admin']) && 
            $formHandler->addMedewerker();
        break;

    case 'editMedewerker':
        // Handle edit-medewerker action
        Functions::checkPermissions(['admin']) && 
            $formHandler->editMedewerker();
        break;

    case 'deleteMedewerker':
        // Handle delete-medewerker action
        Functions::checkPermissions(['admin']) && 
            $formHandler->deleteMedewerker();
        break;
        

    case 'editAccount':
        // Handle delete-medewerker action
        Session::get('loggedIn') && 
            $formHandler->editAccount();
        break;


    default:
        // Handle unknown action
        header("Location: ?page=home");
        break;
}
