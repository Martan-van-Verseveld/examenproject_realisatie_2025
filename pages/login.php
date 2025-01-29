<div class="containerlogin">
    <h1 class="form-title-login">Login</h1>
    <form action="?page=formHandler" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="login">
        
        <label class="form-label" for="username">Gebruikersnaam</label>
        <input class="form-input" type="text" name="username" placeholder="Username" max="255" min="255">
        <label class="form-label" for="password">Wachtwoord</label>
        <input class="form-input" type="password" name="password" placeholder="Password" max="255" min="255">
        <input class="form-button" type="submit" name="login" value="Login">
        <a href="?page=register">
            <button class="form-button" type="button">Register</button>
        </a>
        <input class="form-button" type="submit" name="reset" value="Reset">

    </form>
</div>