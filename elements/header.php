<?php use App\Utility\Functions; use App\Utility\Session; ?>
<header>
<img class="logo" src="websrc/images/centrum_duurzaam_logo.png" alt="logo">
    <p class="header-title">Kringloop centrum</p>
    <ul class="nav">
        <li><a href="?page=home">Home</a></li>
    <?php if (Session::get('loggedIn') && !Functions::checkPermissions(['klant'])): ?>
        <li>
            <div class="dropdown">
            <button class="dropdown_click">Ritten<i class="fa fa-solid fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <a href="?page=rit.view">Ritten planning</a>
                </div>
            </div>
        </li>
        <li><a href="?page=voorraad">Voorraad</a></li>
    <?php endif; ?>
    <?php if (Functions::checkPermissions(['admin'])): ?>
        <li><a href="?page=medewerker.view">Beheer</a></li>
        <li>
        <div class="dropdown">
            <button class="dropdown_click">Admin<i class="fa fa-solid fa-caret-down"></i></button>
                <div class="dropdown-content">
                    <a href="?page=rit.view">Ritten planning</a>
                    <a href="?page=voorraad.overzicht">Voorraadbeheer <i class="fa fa-solid fa-angles-right"></i></a>
                    <a href="?page=admin.home">home</i></a>
                    <a href="?page=klant.view">Klanten</a>
                </div>
            </div>
        </li>
    <?php endif; ?>
    <?php if ($_SESSION['loggedIn'] === true): ?>
        <li><a href="?page=account.home">Account</a></li>
        <li><a href="?page=logout">Logout</a></li>
    <?php else: ?>
        <li><a href="?page=login">Login</a></li>
    <?php endif; ?>
    </ul>
    
        
</header>