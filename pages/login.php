<div class="containerlogin">
    <h1 class="form-title-login">Login</h1>
    <form action="?page=formHandler" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="login">
        <label class="form-label" for="username">Gebruikersnaam</label>
        <input class="form-input" type="text" name="username" placeholder="Username">
        <label class="form-label" for="password">Wachtwoord</label>
        <input class="form-input" type="password" name="password" placeholder="Password">
        <input class="form-button" type="submit" name="login" value="Login">
        <input class="form-button" type="submit" name="reset" value="Reset">
        <input class="form-button" type="submit" name="register" value="Register">
    </form>
</div>