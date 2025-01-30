<?php use App\Utility\Functions; use App\Utility\Session; ?>
<header>
    <p class="header-title">Kringloop centrum</p>
    <ul class="nav">
        <li><a href="?page=home">Home</a></li>
    <?php if (Session::get('loggedIn') && !Functions::checkPermissions(['klant'])): ?>
        <li>Ritten</a></li>
        <li><a href="?page=voorraad">Voorraad</a></li>
    <?php endif; ?>
    <?php if (Functions::checkPermissions(['admin'])): ?>
        <li><a href="?page=medewerkers.beheer">Beheer</a></li>
        <li><a href="?page=admin.home">Admin</a></li>
    <?php endif; ?>
    <?php if ($_SESSION['loggedIn'] === true): ?>
        <li><a href="?page=account.home">Account</a></li>
        <li><a href="?page=logout">Logout</a></li>
    <?php else: ?>
        <li><a href="?page=login">Login</a></li>
    <?php endif; ?>
    </ul>
</header>