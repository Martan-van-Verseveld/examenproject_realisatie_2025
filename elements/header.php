<?php use App\Utility\Functions; ?>
<header>
    <p class="header-title">Kringloop centrum</p>
    <ul class="nav">
        <li><a href="?page=home">Home</a></li>
        <li>Ritten</a></li>
        <li><a href="?page=voorraad">Voorraad</a></li>
    <?php if (Functions::checkPermissions(['admin'])): ?>
        <li><a href="?page=medewerkers.beheer">Beheer</a></li>
        <li>Admin</li>
    <?php endif; ?>
    <?php if ($_SESSION['loggedIn'] === true): ?>
        <li><a href="?page=logout">Logout</a></li>
    <?php else: ?>
        <li><a href="?page=login">Login</a></li>
    <?php endif; ?>
    </ul>
</header>