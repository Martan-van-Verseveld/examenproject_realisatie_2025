<?php

use App\Utility\FormHandler;
use App\Utility\Functions;

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
        
    case 'addCategorie':
        // Handle register action
        $formHandler->addCategorie();
        break;
}